<template>
  <div v-if="model">
    <!-- Model Details -->
    <v-card>
      <v-img src="https://miro.medium.com/max/854/1*60gs-SFYyooZZBxatuoNJw.jpeg" height="200px"></v-img>

      <v-card-title primary-title>
        <div>
          <div class="headline">{{model.title}}</div>

          <span class="grey--text">
            <v-icon size="16" color="#607D8B">fa-chart-bar</v-icon>
            Version {{model.version}}
          </span>
          <br>
          <span class="grey--text">
            <v-icon size="16" color="#607D8B">fa-calendar-alt</v-icon>
            {{model.created_at}}
          </span>
          <br>
          <span class="grey--text">
            <v-icon size="16" color="#607D8B">fa-server</v-icon>
            {{model.trainings_remaining}} Trainings Remaining
          </span>
          <br>
          <span class="grey--text">
            <v-icon size="16" color="green">fa-dollar-sign</v-icon>
            &nbsp; {{model.credits_per_training}} credits/training
          </span>
          <br>
          <br>

          <div class="subheading" v-show="!showDetails" v-html="minifiedDescription"></div>

          <!-- More Details -->
          <v-slide-y-transition>
            <v-card-text v-show="showDetails" v-html="model.description"></v-card-text>
          </v-slide-y-transition>
        </div>
      </v-card-title>

      <v-card-actions>
        <v-btn flat color="#607D8B" @click="showDetails = !showDetails">
          {{ showDetails ? 'Less' : 'More' }}
          <v-icon>{{ showDetails ? 'keyboard_arrow_up' : 'keyboard_arrow_down' }}</v-icon>
        </v-btn>
        <v-spacer></v-spacer>
        <v-btn flat color="green" @click="trainModel(model.id)">
          <v-icon size="16" color="green">fa-sync-alt</v-icon>&nbsp; Train Model
        </v-btn>
      </v-card-actions>
    </v-card>

    <br>

    <!-- Model Reviews -->
    <v-card>
      <div class="text-xs-center" primary-title>
        <v-card-text class="subheading">Rate this ML Model</v-card-text>
        <div class="rating" @click.stop="ratingDialog = true">
          <v-icon color="#FDD835">star</v-icon>
          <v-icon color="#FDD835">star</v-icon>
          <v-icon color="#FDD835">star</v-icon>
          <v-icon color="#FDD835">star</v-icon>
          <v-icon color="#FDD835">star</v-icon>
        </div>
      </div>

      <v-divider></v-divider>

      <!-- Rating Input Dialog -->
      <v-dialog width="500" v-model="ratingDialog" persistent>
        <v-card class="text-xs-center">
          <v-container>
            <v-card-text class="headline">Tell us what you think</v-card-text>
            <v-rating v-model="input_rating" color="#FDD835" large half-increments hover></v-rating>
            <v-textarea outline auto-grow v-model="input_review"></v-textarea>
          </v-container>
          <v-card-actions class="justify-center">
            <v-spacer></v-spacer>
            <v-btn flat @click="ratingDialog = false">Cancel</v-btn>
            <v-btn color="success" flat @click="submitReview">Submit</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Review Detail Dialog -->
      <v-dialog width="500" v-model="showReviewDetail">
        <v-card class="text-xs-center">
          <template v-if="selectedReview === 'loading'">
            <v-progress-circular :size="50" color="green" indeterminate></v-progress-circular>
          </template>
          <template v-else>
            <v-container>
              <v-card-text class="headline">{{selectedReview.username}}</v-card-text>
              <v-avatar size="100" color="grey lighten-4">
                <img
                  src="https://cdn4.iconfinder.com/data/icons/avatars-21/512/avatar-circle-human-male-3-512.png"
                  alt="avatar"
                >
              </v-avatar>
              <v-rating :value="selectedReview.rating" color="#FDD835" large readonly></v-rating>
              <v-card-text class="subheading">{{selectedReview.content}}</v-card-text>
            </v-container>
            <v-card-actions class="justify-center">
              <v-spacer></v-spacer>
              <v-btn flat @click="showReviewDetail = false">Cancel</v-btn>
            </v-card-actions>
          </template>
        </v-card>
      </v-dialog>

      <!-- Rating List -->
      <v-list two-line>
        <div v-for="(review, index) in model.reviews" :key="index">
          <ReviewListItem :review="review" @moreClicked="selectReview(review.id)"/>
        </div>
      </v-list>
    </v-card>
  </div>
</template>

<script>
import axios from "axios";
import Model from "@/Components/Model.vue";
import ReviewListItem from "@/Components/ReviewListItem.vue";

export default {
  name: "ModelDetail",
  components: { ReviewListItem },
  data() {
    return {
      // model related data
      model: null,

      // more button at model detail
      showDetails: false,

      // rating input dialog
      ratingDialog: false,
      input_rating: 0,
      input_review: "",

      // review detail dialog
      showReviewDetail: false,
      selectedReview: false
    };
  },

  methods: {
    selectReview(review_id) {
      this.selectedReview = "loading";
      this.showReviewDetail = true;
      this.$store.dispatch("getReviewDetail", {
        review_id: review_id,
        callback: review => (this.selectedReview = review)
      });
    },

    submitReview() {
      this.$store.dispatch("submitReview", {
        model_id: this.model.id,
        review: {
          content: this.input_review,
          rating: this.input_rating
        },
        callback: review => {
          this.model.reviews.push({
            content: this.input_review
          });
          this.ratingDialog = false;
        }
      });
    },

    trainModel(model_id) {
      this.$router.push({
        name: "Run",
        params: {
          id: model_id
        }
      });
    }
  },

  created() {
    this.$store.dispatch("getModelDetail", {
      id: this.$route.params.id,
      callback: model => (this.model = model)
    });
  },

  computed: {
    minifiedDescription() {
      let max_len = 200;
      return this.model.description && this.model.description.length > max_len
        ? this.model.description.substring(0, max_len) + "..."
        : this.model.description;
    }
  }
};
</script>

<style scoped>
.models-container {
  float: left;
  width: 100%;
  /* min-width: 100%; */
  /* max-width: 100%; */
  overflow-x: auto;
  margin-bottom: 10px;
}

.rating {
  cursor: pointer;
  margin-bottom: 10px;
}
</style>
