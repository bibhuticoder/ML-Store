var express = require("express");
var cookieParser = require("cookie-parser");
var logger = require("morgan");
var cors = require("cors");
var fedAvg = require("./fedavg.js");
const axios = require("axios");

var app = express();
app.use(logger("dev"));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());

// enable CORS
app.use(cors());

app.post("/fed-average", function(req, res) {
    let model_path = req.body.model_path.replace(".json", "");
    fedAvg(model_path, JSON.parse(req.body.update_paths), () => {
        var server_url = "http://127.0.0.1:8000/api/verify-update";
        axios
            .post(server_url, {
                model_id: req.body.model_id,
                update_paths: req.body.update_paths
            })
            .then(res => {
                console.log("==========================================");
                console.log("Federated Averaging completed");
                console.log(res.data.message);
                console.log("==========================================");
            })
            .catch(e => console.error(e));
    });
    res.json("Averaging");
});

app.listen(3000, "0.0.0.0", function() {
    console.log("Listening to port " + 3000);
});
