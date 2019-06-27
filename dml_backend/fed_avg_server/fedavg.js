const tf = require("@tensorflow/tfjs-node");
const fs = require("fs");

module.exports = async function(model_path, update_paths, callback) {
    var weightsList = [];

    // make sandbox
    if (!fs.existsSync("sandbox")) {
        fs.mkdirSync("sandbox");
    } else {
        deleteFolderR("sandbox");
        fs.mkdirSync("sandbox");
    }

    // copy model and initial weight to sandbox
    fs.copyFileSync(
        `../public/storage/models/${model_path}/${model_path}.json`,
        `./sandbox/${model_path}.json`
    );
    fs.copyFileSync(
        `../public/storage/models/${model_path}/weights.bin`,
        `./sandbox/weights.bin`
    );

    // load initial weights
    model = await tf.loadLayersModel(
        "file://./sandbox/" + model_path + ".json"
    );
    weightsList.push(model.getWeights());
    fs.unlinkSync("./sandbox/weights.bin");

    // load each weight updates
    for (let i = 0; i < update_paths.length; i++) {
        const update = update_paths[i];
        fs.copyFileSync(
            `../public/storage/updates/${update}`,
            `./sandbox/weights.bin`
        );
        model = await tf.loadLayersModel(
            "file://./sandbox/" + model_path + ".json"
        );
        weightsList.push(model.getWeights());
        fs.unlinkSync("./sandbox/weights.bin");
    }

    // load model and initial weight, to restore it to initial point
    fs.copyFileSync(
        `../public/storage/models/${model_path}/weights.bin`,
        `./sandbox/weights.bin`
    );
    model = await tf.loadLayersModel(
        "file://./sandbox/" + model_path + ".json"
    );
    fs.unlinkSync("./sandbox/weights.bin");

    // average the weights
    var length = weightsList[0].length;
    var meanWeights = [];
    for (var j = 0; j < length; j++) {
        var collection = [];
        for (var i = 0; i < weightsList.length; i++) {
            collection.push(weightsList[i][j]);
        }
        meanWeights.push(tf.stack(collection).mean((axis = 0)));
    }

    // set averaged weights
    model.setWeights(meanWeights);

    // get the model
    fs.unlinkSync(`./sandbox/${model_path}.json`);
    await model.save(`file://./sandbox`);

    // save updated weight to public directory
    fs.copyFileSync(
        `./sandbox/weights.bin`,
        `../public/storage/models/${model_path}/weights.bin`
    );

    console.log("Federated Averaging successful.");
    callback();
};

function deleteFolderR(path) {
    if (fs.existsSync(path)) {
        fs.readdirSync(path).forEach(function(file, index) {
            var curPath = path + "/" + file;
            if (fs.lstatSync(curPath).isDirectory()) {
                // recurse
                deleteFolderR(curPath);
            } else {
                // delete file
                fs.unlinkSync(curPath);
            }
        });
        fs.rmdirSync(path);
    }
}
