<template>
  <div class="wow fadeInUp" data-wow-duration="2s">
    <div class="card" @mouseenter="updateHoverState(true)" @mouseleave="updateHoverState(false)">
      <a>
        <div id="cover" :style="showElements ? 'background-color:black;opacity:0.7;transition:1s;height:175px;width:100%;position:absolute;z-index:1;' : 'background-color:n;opacity:0;transition:1s;height:175px;width:100%;position:absolute;z-index:1;'">
        </div>
        <div class="item">
          <img class="cardImage lazyload" :data-src="source" alt="Achievment Card">
        </div>
        <i class="fas fa-eye detailIcon" v-if="showElements" v-on:click="updateClickState(true)"></i>
        <div class="titleContainer">
          <h2 class="title">{{title}}</h2>
          <h6>{{type}}</h6>
        </div>
      </a>
    </div>
    <transition name="slide-fade">
      <div class="modal" v-if="showBox">
        <div class="modal-content">
          <ul type="none" style="margin-bottom:0rem;display:inline;">
            <li>
              <h2 id="modal-header">{{title}}</h2>
              <hr style="align-self:left;width:50%;">
            </li>
            <li id="li-exit">
              <i class="fa fa-window-close exitIcon" @click="updateClickState(false)"></i>
            </li>
          </ul>
          <img :src="source" class="modal-cardImage" :alt="title">
          <a :href="link" target="_blank" style="text-align:center;margin-top:0.5%"> <button type="button" class="btn btn-primary" :disabled='link == "" ' :title="link == '' ? 'Available Soon' : title">View</button> </a>

          <h3 class="modal-title">Idea:</h3>
          <p id="modal-p">{{idea}}</p>
          <hr style="align-self:center;position:relative;width:50%;">
          <h3 id="modal-header">Technologies</h3>
          <ul type="none" style="width:100%;" id="tech-ul">
            <li class="technos" v-for="item in technology">{{item}}</li>
          </ul>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  props: ['title', 'type', 'idea', 'technology', 'src', 'url'],
  name: 'work-card',
  data() {
    return {
      hoverState:false,
      cardClicked:false
    }
  },
  computed: {
    source() {
      return this.src ? this.src : 'https://dummyimage.com/500%20x%20500/cccccc/ffffff.png&text=288+x+175';
    },
    link() {
      return this.url ? this.url : "";
    },
    showElements() {
      if(this.hoverState) {
        return true;
      }
      else {
        return false;
      }
    },
    showBox() {
      if(this.cardClicked) {
        return true;
      }
      else {
        return false;
      }
    }
  },
  methods: {
    updateHoverState(state) {
      this.hoverState = state;
    },
    updateClickState(state) {
      this.cardClicked = state;
      if(state) {
        setTimeout(function(){document.body.style.overflowY = 'hidden';document.body.scroll = "no";}, 800);
      }
      else {
        setTimeout(function(){document.body.style.overflowY = 'scroll';document.body.scroll = "no";}, 800);
      }
    }
  }
}
</script>

<style scoped>
.slide-fade-enter-active {
  transition: all .3s ease;
}
.slide-fade-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
ul, li, h4{
  display: inline-block;
}
#tech-ul {
  display: inline-block;
}
#li-exit {
  left:-1rem;text-align:right;float:right;top:0.01rem;position:relative;cursor:pointer;
}
hr {
  width: 30%;
  background-color: rgb(76, 230, 254);
  border:none;
  height: 1px;
  position: absolute;
  margin-top: 0rem;
}
.card {
  margin-top: 10%;
  max-height: 260px;
  position: relative;
  text-align: center;
  cursor: pointer;
  overflow: hidden;
  border: 0.5px solid inherit;
  border-radius: 12.5%;
  -webkit-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
  -moz-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
  box-shadow: 0px 0px 10px 0px #444;
  transition: all .2s ease-in-out;
}

.cardImage {
  height: 175px;
  width: 100%;
  position: relative;
  transition: 0.5s;
  object-fit: cover;
}
.title {
  font-family: 'Titan One', cursive;
  text-align: center;
  margin-top: 180px;
}
#modal-header {
  color: #18ba60;
  font-family: 'Titan One', cursive;
}
.modal-title {
  color: #18ba60;
  font-family: 'Titan One', cursive;
}
#modal-p {
  color: #444;
  font-size: 20px;
  text-align: center;
  font-family: 'Ubuntu', sans-serif;
}
.technos {
  background-color: rgba(70, 70, 70, 0.8);
  border: 0.5px solid inherit;
  border-radius: 12.5%;
  margin-right: 1.5%;
  margin-top: 1%;
  font-weight: 600;
  padding: 2px 4px 2px 4px;
}
.playIcon {
  text-align: center;
  color: #18ba60;
  font-size: 2rem;
  line-height: 0;
}
h6 {
  color: gray;
}
.exitIcon {
  font-size:36px;color:red;border:0.5px solid inherit; border-radius:100%;
}
.detailIcon {
  position: absolute;
  top: 40%;
  left: 50%;
  transform: translate(-50%, -50%) rotateY(180deg);
  font-size: 50px;
  height: 50px;
  color: #b1f3db;
  z-index: 3;
}
.item {
 position: absolute;
 top: 0;
 left: 0;
}
.item .cardImage {
 -webkit-transition: 0.6s ease;
 transition: 0.6s ease;
}
.card:hover .item .cardImage {
  -webkit-transform: scale(1.2);
  height: 160px;
  transform: scale(1.2);
}
.card:hover {
  transform:scale(1.05);
  margin-top: 5.0%;
  transition: 0.5s;
  -webkit-box-shadow: 5px 20px 10px -5px rgb(54, 54, 54);
  -moz-box-shadow: 5px 20px 10px -5px rgb(54, 54, 54);
  box-shadow: 5px 20px 10px -5px rgb(54, 54, 54);
}
.modal {
    display: block; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 4; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: hidden;; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.6); /* Black w/ opacity */
}
.modal-content {
    border: 0.5px solid inherit;
    border-radius: 12.5%;
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    margin-top: 3rem;
    padding: 20px;
    border: 1px solid #888;
    width: 60%; /* Could be more or less, depending on screen size */
    height: 90vh;
}
.modal-cardImage {
  margin-top: 2%;
  max-width: 20vw;
  max-height: 20vw;
  position: relative;
  align-self: center;
  border: 0.5px solid inherit;
  border-radius: 5%;
  -webkit-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
  -moz-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
  box-shadow: 0px 0px 10px 0px #444;
}
@media screen and (min-width:727px) {
  #modal-p {
    max-width: 75%;
    align-self: center;
  }
}
@media screen and (max-width:991px) and (min-width:522px){
  h2 {
    font-size: 1.4rem;
  }
  h3 {
    font-size: 1.2rem;
  }
  .modal-content {
    max-height: 100%;
  }
}

@media screen and (min-height:700px) {
  .modal-title {
    margin-top: 8vh;
  }
  .modal-title, #modal-header, .modal-content {
    font-size: 120%;
  }
}
@media screen and (max-width:521px) {
  h2 {
    font-size: 2rem;
  }
  h6 {
    margin-top: 2%;
  }
  .modal-content {
    width: 80%;
    height: 90%;
  }
  .modal {
    overflow-y: scroll;
  }
  .exitIcon {
    font-size: 160%;
  }
  #li-exit {
    top:0rem;
  }
  .modal-title, #modal-header {
    font-size: 110%;
  }
  .modal-cardImage {
    max-width: 50vw;
    max-height: 18vh;
    margin-top: 1%;
    overflow: inherit;
  }
  .technos {
    font-size: 80%;
  }
  .playIcon {
    top:45%;
  }
  #modal-p {
    font-size: 95%;
  }
  ul {
    margin-left: -2.1rem;
  }
  hr {
    width: 75%;
  }
}
</style>
