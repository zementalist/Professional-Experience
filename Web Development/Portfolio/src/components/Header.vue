<template>
  <div>
    <!-- Cover -->
    <div class="opening-cover-left">
      <!--<img id="blackH" class="ying" src="../../dist/images\blackhalf.png" alt="">-->
      <h1 id="blackH">&lt;co</h1>
    </div>
    <div class="opening-cover-right" dir="rtl">
      <!--<img id="whiteH" class="ying" src="../../dist/images\whitehalf.png" alt="">-->
      <h1 id="whiteH"><span>&lt;/de</span></h1>
    </div>
    <!-- Cover_End -->


    <div id="header" style="overflow-y:hidden;overflow-x:hidden;">
      <section class="row">
        <div class="col-md-12">
          <section class="row">
            <div class="col-md-12">
              <div class="_headerBar" id="headerBar"></div>
              <div class="_headBar pcNav" style="position: fixed;z-index: 4;" v-if="this.window.width > 521">
                <ul type="none" class="pc">
                  <li class="headItem logo">Z</li>
                  <li><a href="#" class="headItem active">Home</a></li>
                  <li><a href="#" class="headItem">Skills</a></li>
                  <li><a href="#" class="headItem">Achievments</a></li>
                  <li><a href="#" class="headItem">Contact</a></li>
                </ul>
              </div>
              <div class="_headBar mobNav" style="position:fixed;z-index:4;margin-top:0%;" v-else>
                <ul type="none" class="ul-mob">
                  <div class="row">
                <div  class="col-3" style=" padding-top: 0px; margin-top:-0.4rem;">
                  <li class="logo-mob">Z</li>
                </div>
                <div class="col-6"> <p></p> </div>
                <div class="col-3" style="margin-top:1.5rem;">
                  <li class="menu">
                    <i class="fas fa-bars" style="color:#566C70;font-size:35px;"></i>
                  </li>
                </div>
              </div>
                  <div class="mobileMenu" style="margin-top:5%;display:none;">
                    <li class="mob"><a href="#" class="mobileItem active">Home</a></li>
                    <li class="mob"><a href="#" class="mobileItem">Skills</a></li>
                    <li class="mob"><a href="#" class="mobileItem">Achievments</a></li>
                    <li class="mob"><a href="#" class="mobileItem">Contact</a></li>
                  </div>
                </ul>
              </div>
            </div>
          </section>
          <section class="row">
            <div class="col-md-12" style="padding-right:0px;">
              <div class="header-container" :style="{'height':String(this.window.height+20) + 'px', 'position':'relative'}">
                <div id="imageSection" class="background-infrastructure" :style="{'height':String(this.window.height) + 'px'}"></div>
                <img class="background "

                     alt=""
                     style="width: 100%;z-index: 0; margin-top: -0%; position: relative; ;object-fit:cover"
                     :style="{'height':String(this.window.height) + 'px'}"
                  />
                  <div class="textBox">
                    <h1 id="text" class="split shine"></h1>
                  </div>
                  <div id="arrowDown" style="position:absolute;left:50%;top:100vh;">
                    <i  class="fas fa-angle-double-down" style="position: relative; left: -50%;font-size:2rem;overflow-y:hidden;"></i>
                  </div>
                </div>
              </div>
          </section>
        </div>
      </section>
      <div id="app2">

      </div>
      <div id="app3">

      </div>
      <div id="app4">

      </div>
    </div>
  </div>
</template>

<script>
import exportedDataa from '../App.vue'
export default {
  data(){
    return {
    window: {
      width: window.innerWidth,
      height: window.innerWidth
    }
  }
  },
  created() {
    window.addEventListener('resize', this.handleResize)
    this.handleResize();
  },
  destroyed() {
    window.removeEventListener('resize', this.handleResize);
  },
  mounted() {

  }
  ,
  methods: {
    handleResize() {
      this.window.width = window.innerWidth;
      this.window.height = window.innerHeight;
    }
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
html,body {
  overflow-x: hidden !important;
  margin: 0;
  padding: 0;
}
ul.pc li {
  display: inline;
}
ul {
  margin-top: 25px;
  text-align: left;
}

.opening-cover-left {
  background-color: #FAFFFF;
  width: 50vw;
  height: 100vh;
  position: absolute;
  transition: 1s;
  z-index: 999;
}
.opening-cover-right {
  float: right;
  margin-left: 50vw;
  background-color: black;
  width: 50vw;
  height: 100vh;
  position: absolute;
  transition: 1s;
  z-index: 999;
}

.headItem, .mobileItem {
  margin-right: 4.5%;
  font-size: 16px;
  padding-bottom: 5px;
  text-transform: uppercase;
  color: white;
  font-weight: 900;
  margin-top: -1%;
  background-image: linear-gradient(#4CE6FE, #4CE6FE), linear-gradient(transparent, transparent);
  background-size: 0px 3px, auto;
  background-repeat: no-repeat;
  background-position: center bottom;
  transition: all .2s ease-out;
  transition: 0.5s;
}
.mobileItem {
  color:black;
}
.logo:hover {
  background: none;
}
li.mob {
  margin-top: 7%;
  margin-left: 4vw;
}
.mobileMenu {
  opacity: 0;
}
.headItem:hover {
  text-decoration-line: none;
  transition: 0.5s;
  background-size: 100% 3px, auto;
}
.logo {
  padding: 0.7%;
  font-size: 36px;
  margin-right: 4.5%;
  text-transform: uppercase;
  /* color: #4CE6FE; */
  font-weight: 900;
}

.logo-mob {
  font-size:50px;
  text-transform: uppercase;
  /* color: #4CE6FE; */
  font-weight: 900;
  text-align: center;
  align-content: center;
  width: 60px;
}
.logo, .logo-mob {
  font-family: 'Great Vibes', cursive;
}
.menu {
  position:absolute;margin-top:1%;
}
#headerBar {
  width: 100%;
  height: 0%;
  background-color: #FAFFFF;
  position: fixed;
  z-index: 3;
      -webkit-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
-moz-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
box-shadow: 0px 0px 10px 0px #fff;
}
._headBar {
  height: 2vw;
  width: 100%;
  background-color: inherit;
}
.textBox {
  position: absolute;left: 50%;
}
#text {
  z-index: 2;
  position: relative;
  left: -50%;
  color: rgb(57, 172, 190);
  font-size: 3rem;
  text-align: center;
  margin-top: -50vh;
  font-family: 'Courgette', cursive;
  font-weight: 700;
  letter-spacing: 0.2rem;
  word-spacing: 0.1rem;
  -o-text-overflow: clip;
  text-overflow: clip;
  text-shadow: 1px 1px 0 rgb(77,162,252) , -1px -1px 0 rgb(77,162,252) , 1px -1px 0 rgb(77,162,252) , -1px 1px 0 rgb(77,162,252) , 4px 4px 8px rgb(44,88,137) , -4px 4px 8px rgb(44,88,137) , 4px -4px 8px rgb(44,88,137) , -4px -4px 8px rgb(44,88,137) ;
  -webkit-transition: all 500ms cubic-bezier(0.42, 0, 0.58, 1);
  -moz-transition: all 500ms cubic-bezier(0.42, 0, 0.58, 1);
  -o-transition: all 500ms cubic-bezier(0.42, 0, 0.58, 1);
  transition: all 500ms cubic-bezier(0.42, 0, 0.58, 1);
}
#text:hover {
  text-shadow: 1px 1px 0 rgb(77,162,252) , -1px -1px 0 rgb(77,162,252) , 1px -1px 0 rgb(77,162,252) , -1px 1px 0 rgb(77,162,252) ;
-webkit-transition: all 300ms cubic-bezier(0.42, 0, 0.58, 1);
-moz-transition: all 300ms cubic-bezier(0.42, 0, 0.58, 1);
-o-transition: all 300ms cubic-bezier(0.42, 0, 0.58, 1);
transition: all 300ms cubic-bezier(0.42, 0, 0.58, 1);
}
@media screen and (max-device-width:521px) {
  .textBox {
    margin-top:-20vh;
    width: 100vw;
  }
  #text {
    letter-spacing: 0rem;
    font-size: 1rem;
    max-width: 100vw;
  }
}
.active {
  /* color: #f939ee; */
}
.backImage {
  width:105vw ;height: 115vh; position: relative;z-index: 0; margin-top: -6%;
  -webkit-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
-moz-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
}
.background-infrastructure {
  position: absolute;width: 100%;background-color: black;opacity: 0.5;z-index: 1;
}
@media all and (max-width:520px) and (min-width:0px) {
  .headItem {
    font-size: 14px;
    margin-right: 4%;
  }
  .logo-mob {
    font-size: 35px;
  }
  ul {
    margin-left: -9.5%;
    margin-top: 5.7%;
  }
  .menu {
    margin-top:-1.5rem;
    margin-left: 5vw;
  }
  #headerBar {
    height: 4.5rem;
    box-shadow: 0px 0px 10px #fff;
  }
  #text {
    margin-top: -40vh;
    font-size: 40px;
  }
}
@media all and(max-width: 1024px) {
  .backImage {
    height: 500px;
  }
}

#blackH {
  position: relative;
  float: right;
  font-size: 4rem;
  font-weight: bold;
  top:50%;
}
#whiteH {
  position: relative;
  float: left;
  top:50%;
  font-size: 4rem;
  color: white;

}
.fa-angle-double-down {
  color: rgb(0, 231, 255);
  opacity: 1;
  top:-20vh;
}

</style>
