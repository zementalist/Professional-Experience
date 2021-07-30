<template>
  <div>
    <div id="all" style="padding-top:20px;">
      <section class="row">
        <div class="col-md-12">
          <div class="header" v-if="this.window.width >= 768">
            <section class="row">
              <div class="col-md-2" v-if="this.window.width < 992"> <p></p> </div>
              <div class="col-lg-6 col-md-4 col-sm-6 col-6">
                <h3 @click="changeSkillsSection('skills')"> <a :class="!this.profileOpened ? 'active skillItem' : 'skillItem'">Skills</a> </h3>
                <hr :class="this.profileOpened ? '' : 'active'">
              </div>
              <div class="col-lg-6 col-md-4 col-sm-6 col-6">
                <h3 @click="changeSkillsSection('profile')"> <a :class="this.profileOpened ? 'active skillItem' : 'skillItem'">Profile</a> </h3>
                <hr :class="this.profileOpened ? 'active' : ''">
              </div>
            </section>
          </div>
          <div :class="this.window.width < 992 ? 'container-fluid' : 'container'">
            <div class="skillsSection" id="skillsSection">
              <div class="row" v-if="this.window.width < 768">
                <div :class="this.window.width > 870 ? 'col-lg-5 col-md-5 col-sm-12 col-12' : 'col-md-12 col-sm-12 col-12'">
                  <div class="author">
                      <img class="lazyload" style="width:350px;" data-src="http://zeyad.rf.gd/static/img/zeyad.a79d317.jpg" src="../../dist/images/Optimized-zeyad.jpg" alt="Author photo when he was 17 years old!">
                  </div>
                </div>
              </div>
              <div class="header" v-if="this.window.width < 768">
                <div class="container-fluid">
                  <section class="row">
                    <div v-if="this.window.width <=355" :class="this.window.width <= 355 ? 'col-sm-1 col-1' : 'col-sm-2 col-2'">
                      <p></p>
                    </div>
                    <div :class="this.window.width <= 410 && this.window.width > 336 ? '' : ''">
                      <p></p>
                    </div>
                    <div v-if="this.window.width > 465 && this.window.width < 768" :class="this.window.width > 465 && this.window.width < 768 ? 'col-sm-2 col-2' : ''">
                      <p></p>
                    </div>
                    <div v-if="this.window.width < 465 && this.window.width > 395" :class="this.window.width < 465 && this.window.width > 395 ? 'col-sm-2 col-2' : ''">
                      <p></p>
                    </div>
                    <div :class="this.window.width > 465 && this.window.width < 768 ? 'col-sm-4 col-4' : 'col-lg-6 col-md-4 col-sm-3 col-3'">
                      <h3 @click="changeSkillsSection('skills')"> <a :class="!this.profileOpened ? 'active skillItem' : 'skillItem'">Skills</a> </h3>
                      <hr :class="this.profileOpened ? '' : 'active'" style="width:85px;">
                    </div>
                    <div v-if="this.window.width <= 394" :class="this.window.width <= 394 ? 'col-sm-2 col-2' :'col-sm-4 col-4'">
                      <p></p>
                    </div>
                    <div :class="this.window.width > 465 && this.window.width < 768 ? 'col-sm-4 col-4' : 'col-md-4 col-sm-3 col-3'" :style="this.window.width < 465 && this.window.width > 395 ? 'margin-left:1rem;'  : ''">
                      <h3 @click="changeSkillsSection('profile')"> <a :class="this.profileOpened ? 'active skillItem' : 'skillItem'">Profile</a> </h3>
                      <hr :class="this.profileOpened ? 'active' : ''" style="width:105px;">
                    </div>
                  </section>
                </div>
              </div>
              <div class="row">
                <div v-if="this.window.width >= 768" :class="this.window.width > 870 ? 'col-lg-5 col-md-5 col-sm-12 col-12' : 'col-md-12 col-sm-12 col-12'">
                  <div class="author">
                      <img class="lazyload" style="width:350px;" data-src="http://zeyad.rf.gd/static/img/zeyad.a79d317.jpg" src="../../dist/images/Optimized-zeyad.jpg" alt="Author photo when he was 17 years old!">
                  </div>
                </div>
                <div :class="this.window.width > 870 ? 'col-lg-7 col-md-7 col-sm-12 col-12' : 'col-md-12 col-sm-12 col-12'">
                  <div class="skillsData">
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-6 progresses">
                        <div class="progress-component wow fadeInUp" data-wow-duration="2s">
                          <ul type="none">
                            <li class="skillText"> <h4 style="color:white;">HTML</h4> </li>
                            <li class="circle">
                              <div class="progress blue">
                                 <span class="progress-left html">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <span class="progress-right">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <div class="progress-value">90%</div>
                             </div>
                            </li>
                         </ul>
                        </div>
                        <div class="">
                          <div class="progress-component wow fadeInUp" data-wow-duration="2s">
                            <ul type="none">
                              <li class="skillText"> <h4 style="color:white;">CSS</h4> </li>
                              <li class="circle">
                                <div class="progress blue">
                                   <span class="progress-left css">
                                       <span class="progress-bar"></span>
                                   </span>
                                   <span class="progress-right">
                                       <span class="progress-bar"></span>
                                   </span>
                                   <div class="progress-value">85%</div>
                               </div>
                              </li>
                           </ul>
                          </div>
                        </div>

                        <div class="progress-component wow fadeInUp" data-wow-duration="2s">
                          <ul type="none">
                            <li class="skillText"> <h4 style="color:white;">Sass</h4> </li>
                            <li class="circle">
                              <div class="progress blue">
                                 <span class="progress-left sass">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <span class="progress-right">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <div class="progress-value">85%</div>
                             </div>
                            </li>
                         </ul>
                        </div>
                        <div class="progress-component wow fadeInUp" data-wow-duration="2s">
                          <ul type="none">
                            <li class="skillText"> <h4 style="color:white;">Bootstrap</h4> </li>
                            <li class="circle">
                              <div class="progress blue">
                                 <span class="progress-left bootstrap">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <span class="progress-right">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <div class="progress-value">85%</div>
                             </div>
                            </li>
                         </ul>
                        </div>
                        <div class="progress-component wow fadeInUp" data-wow-duration="2s">
                          <ul type="none">
                            <li class="skillText"> <h4 style="color:white;">Javascript</h4> </li>
                            <li class="circle">
                              <div class="progress blue">
                                 <span class="progress-left javascript">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <span class="progress-right">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <div class="progress-value">95%</div>
                             </div>
                            </li>
                         </ul>
                        </div>
                        <div class="progress-component wow fadeInUp" data-wow-duration="2s">
                          <ul type="none">
                            <li class="skillText"> <h4 style="color:white;">Vue JS</h4> </li>
                            <li class="circle">
                              <div class="progress blue">
                                 <span class="progress-left vue">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <span class="progress-right">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <div class="progress-value">90%</div>
                             </div>
                            </li>
                         </ul>
                        </div>
                        <div class="progress-component wow fadeInUp" data-wow-duration="2s">
                          <ul type="none">
                            <li class="skillText"> <h4 style="color:white;">jQuery</h4> </li>
                            <li class="circle">
                              <div class="progress blue">
                                 <span class="progress-left jquery">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <span class="progress-right">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <div class="progress-value">90%</div>
                             </div>
                            </li>
                         </ul>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-6 progresses">
                        <div class="progress-component wow fadeInUp" data-wow-duration="2s">
                          <ul type="none">
                            <li class="skillText"> <h4 style="color:white;">Laravel</h4> </li>
                            <li class="circle">
                              <div class="progress blue">
                                 <span class="progress-left laravel">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <span class="progress-right">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <div class="progress-value">80%</div>
                             </div>
                            </li>
                         </ul>
                        </div>
                        <div class="progress-component wow fadeInUp" data-wow-duration="2s">
                          <ul type="none">
                            <li class="skillText"> <h4 style="color:white;">PHP</h4> </li>
                            <li class="circle">
                              <div class="progress blue">
                                 <span class="progress-left php">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <span class="progress-right">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <div class="progress-value">80%</div>
                             </div>
                            </li>
                         </ul>
                        </div>
                        <div class="progress-component wow fadeInUp" data-wow-duration="2s">
                          <ul type="none">
                            <li class="skillText"> <h4 style="color:white;">MySQL</h4> </li>
                            <li class="circle">
                              <div class="progress blue">
                                 <span class="progress-left mysql">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <span class="progress-right">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <div class="progress-value">90%</div>
                             </div>
                            </li>
                         </ul>
                        </div>
                        <div class="progress-component wow fadeInUp" data-wow-duration="2s">
                          <ul type="none">
                            <li class="skillText"> <h4 style="color:white;">AJAX</h4> </li>
                            <li class="circle">
                              <div class="progress blue">
                                 <span class="progress-left ajax">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <span class="progress-right">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <div class="progress-value">85%</div>
                             </div>
                            </li>
                         </ul>
                        </div>
                        <div class="progress-component wow fadeInUp" data-wow-duration="2s">
                          <ul type="none">
                            <li class="skillText"> <h4 style="color:white;">GIT</h4> </li>
                            <li class="circle">
                              <div class="progress blue">
                                 <span class="progress-left git">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <span class="progress-right">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <div class="progress-value">75%</div>
                             </div>
                            </li>
                         </ul>
                        </div>
                        <div class="progress-component wow fadeInUp" data-wow-duration="2s">
                          <ul type="none">
                            <li class="skillText"> <h4 style="color:white;">GSAP</h4> </li>
                            <li class="circle">
                              <div class="progress blue">
                                 <span class="progress-left gsap">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <span class="progress-right">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <div class="progress-value">70%</div>
                             </div>
                            </li>
                         </ul>
                        </div>
                        <div class="progress-component wow fadeInUp" data-wow-duration="2s">
                          <ul type="none">
                            <li class="skillText"> <h4 style="color:white;">Webpack</h4> </li>
                            <li class="circle">
                              <div class="progress blue">
                                 <span class="progress-left webpack">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <span class="progress-right">
                                     <span class="progress-bar"></span>
                                 </span>
                                 <div class="progress-value">80%</div>
                             </div>
                            </li>
                         </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="profileSection" :style="this.profileOpened ? '' : 'display:none;'">
                    <div class="profileData">
                      <div class="row">
                        <div class="col-sm-12 col-md-12">
                          <h3 id="profileHeader" class="quote" style="font-weight: 700;font-size:1.1rem;text-align:center;">ZEYAD KHALID : I'M <span id="myAge"></span> YEARS OLD <span style="color:#18ba60;">JUNIOR FULL STACK WEB DEVELOPER</span></h3>
                          <br>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-1"> <p></p> </div>
                        <div class="col-sm-10">
                          <h5 style="text-align:center;" class="quote">I'm studying computer science in Misr University For Science and Technology.<br>

                            I'm motivated to improve the existing technologies by connecting
                            <span style="color:#18ba60;">Psychology</span> with <span style="color:#18ba60;">Software</span> to produce a Highly smart reliable
                            software programs.
                          </h5>
                          <br>
                          <h5 style="text-align:center;" class="quote">
                            I've built Web-Applications & Games using Vanilla <span style="color:#18ba60;">Javascript</span> depending on my experience in complex <span style="color:#18ba60;">Algorithms</span> & <span style="color:#18ba60;">Data Structures</span>.
                            E-mail me to schedule an interview. I have enclosed my resume and looking forward for a meeting.
                          </h5>
                        </div>
                        <div class="col-sm-1"> <p></p> </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-1 col-md-1 col-1">
                  <p></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>

export default {
  data(){
    return {
    window: {
      width: 0,
      height: 0
    },
    profileOpened:false
  }
  },
  mounted() {
    document.getElementById("myAge").innerHTML = (new Date().getFullYear()) - 1999;
  },
  created() {
    window.addEventListener('resize', this.handleResize)
    this.handleResize();
  },
  destroyed() {
    window.removeEventListener('resize', this.handleResize)
  },
  methods: {
    handleResize() {
      this.window.width = window.innerWidth;
      this.window.height = window.innerHeight;
    },
    animate() {
      var tl = new TimelineLite,
          mySplitText = new SplitText(".quote", {type:"words,chars"}),
          chars = mySplitText.chars; //an array of all the divs that wrap each character

      TweenLite.set(".quote", {perspective:400});
      tl.staggerFrom(chars, 0.8, {opacity:0, scale:0, y:80, rotationX:180, transformOrigin:"0% 50% -50",  ease:Back.easeOut}, 0.01, "+=0");

    },
    changeSkillsSection(section) {
      var tl = new TimelineLite();
      var skillsData = document.getElementsByClassName('skillsData')[0];
      var profileSection = document.getElementsByClassName('profileSection')[0];
      if(!this.profileOpened && section == 'profile') {
        tl.to(skillsData, 0.6, {'opacity':'0', 'display':'none'});
        tl.to(profileSection, 0.6, {'opacity':'1','display':'block'}, '-=0.1');
        this.profileOpened = !this.profileOpened;
      }
      else if(section == 'skills' && this.profileOpened) {
        tl.to(profileSection, 0.6, {'opacity':'0','display':'none'});
        tl.to(skillsData, 0.6, {'opacity':'1','display':'block'}, '-=0.1');
        this.profileOpened = !this.profileOpened;
      }
      this.animate();
    }
  }
}
</script>

<style lang="css" scoped>
html,body {
  overflow-x: hidden !important;
  margin: 0;
  padding: 0;
}
hr {
  width: 50%;
  background-color: grey;
  border:none;
  height: 2px;
  transition: 0.5s;
}
h5 {
  font-size: 1rem;
  line-height: 1.5;
  text-align: center;
}
ul li {
  display: inline-block;
}
.header {
  margin-top: 3%;
  text-align: center;
}
.skillItem {
  text-transform: uppercase;
}
.active {
  color: #18ba60;
}
.skillsSection {
  margin-top: 5%;
}
.profileSection {
  opacity: 0;
}
a:not([href]):not([tabindex]).active:hover {
  color: #18ba60;
}
a.active {
  color: #18ba60;
  transition: 0.5s;
}
a:hover {
  cursor: pointer;
}
hr.active {
  background-color: #18ba60;
  transition: 0.5s;
}
h4 {
  text-shadow: 1px 1px #18ba60;
}
@media all and (max-width:3000px) and (min-width:870px) {
  .profileData {
    margin-top:10rem;
  }
}
@media all and (max-width:870px) and (min-width:0px) {
  .profileData {
    margin-top:3rem;
  }
}
@media all and (max-width:520px) and (min-width:0px) {

  hr {
    width: 50%;
  }
  hr.active {
    width: 50%;
  }
  .progresses {
    margin-left: 0;
  }
  h4 {
    font-size: 18px;
    margin-top: 0.3rem;
    margin-left: -1rem;
  }
  img {
    margin-left: 2.5vw;
  }
  .skillsSection {
    margin-left: 2vw;
  }
  .skillsData {
    margin-top: 1rem;
  }


}
@media all and (max-width:360px) and (min-width:0px)  {
  h4 {
    font-size: 14px;
  }
}
@media all and (max-width:375px) and (min-width:360px) {
  .header {
    margin-left: 2.5rem;
  }

}
@media all and (max-width:375px) and (min-width:321px) {
  h4 {
    font-size: 14px;
  }
  img {
    margin-left: -2vw;
  }
}
@media all and (max-width:320px) and (min-width:0px)  {
  h4 {
    font-size: 13px;
  }
  .skillsData {
    margin-left: 2vw;
  }
  img {
    margin-left: -5vw
  }
}
.progresses {
  margin-top: -4%;
}


@media all and (max-width:870px) and (min-width:440px) {
  .skillsData {
    margin-top: 2vh;
  }
  .author {
    text-align: center;
  }
  h5 {
    text-align: center;
  }
}

.circle {
  float: right;
  margin-right: 10%;
}
.skillText {
  margin-top: 15px;
  margin-left: -1rem;
}
.progress{
    width: 60px;
    height: 60px;
    line-height: 0px;
    background: none;
    margin: 0 auto;
    box-shadow: none;
    position: relative;
}
.progress-component {
  margin-top: 10%;
  background: -moz-linear-gradient(left,  #42b5da 0%, #9ce7ff 40%, #05abe0 100%); /* FF3.6-15 */
  background: -webkit-linear-gradient(left,  #42b5da 0%,#9ce7ff 40%,#05abe0 100%); /* Chrome10-25,Safari5.1-6 */
  /* background: linear-gradient(right,  #42b5da 0%,#9ce7ff 40%,#05abe0 100%); W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
  -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
  -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
  box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
  border: 0.5px solid white;
  height: 62px;
  transition: 0.5s;
}
.progress-component:hover{
  /*background: #ECACFD;*/
  background: #7f0ee9;
  
  transition: all 0.5s;
}
.progress:after{
    content: "";
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 8px solid #fff;
    position: absolute;
    top: 0;
    left: 0;
}
.progress > span{
    width: 50%;
    height: 100%;
    overflow: hidden;
    position: absolute;
    top: 0;
    z-index: 1;
}
.progress .progress-left{
    left: 0;
}
.progress .progress-bar{
    width: 100%;
    height: 100%;
    background: none;
    border-width: 7px;
    border-style: solid;
    position: absolute;
    top: 0;
}
.progress .progress-left .progress-bar{
    left: 100%;
    border-top-right-radius: 80px;
    border-bottom-right-radius: 80px;
    border-left: 0;
    -webkit-transform-origin: center left;
    transform-origin: center left;
}
.progress .progress-right{
    right: 0;
}
.progress .progress-right .progress-bar{
    left: -100%;
    border-top-left-radius: 80px;
    border-bottom-left-radius: 80px;
    border-right: 0;
    -webkit-transform-origin: center right;
    transform-origin: center right;
    animation: loading-1 3s linear forwards;
}
.progress .progress-value{
    width: 90%;
    height: 90%;
    border-radius: 50%;
    background: #44484b;
    font-size: 18px;
    color: #fff;
    line-height: 55px;
    text-align: center;
    position: absolute;
    top: 5%;
    left: 5%;
}
@media screen and (max-width: 415px) {
  .progress .progress-value {
    font-size:11px;
    line-height: 35px;
  }
  .progress {
    width: 40px;
    height: 40px;
  }
  .circle {
    margin-top: 0.75rem;
  }
}
.progress.blue .progress-bar{
    border-color: #007bff;
}
.progress-left.html .progress-bar{
    animation: loading-4 3s linear forwards 3s;
}
.progress-left.css .progress-bar{
    animation: loading-4 3s linear forwards 3s;
}
.progress-left.sass .progress-bar{
    animation: loading-4 3s linear forwards 3s;
}
.progress-left.bootstrap .progress-bar{
    animation: loading-4 3s linear forwards 3s;
}
.progress-left.javascript .progress-bar{
    animation: loading-6 3s linear forwards 3s;
}
.progress-left.vue .progress-bar{
    animation: loading-5 3s linear forwards 3s;
}
.progress-left.jquery .progress-bar{
    animation: loading-5 3s linear forwards 3s;
}
.progress-left.php .progress-bar{
    animation: loading-3 3s linear forwards 3s;
}
.progress-left.mysql .progress-bar{
    animation: loading-5 3s linear forwards 3s;
}
.progress-left.ajax .progress-bar{
    animation: loading-4 3s linear forwards 3s;
}
.progress-left.git .progress-bar{
    animation: loading-2 3s linear forwards 3s;
}
.progress-left.gsap .progress-bar{
    animation: loading-7 3s linear forwards 3s;
}
.progress-left.webpack .progress-bar{
    animation: loading-3 3s linear forwards 3s;
}
.progress-left.laravel .progress-bar{
    animation: loading-3 3s linear forwards 3s;
}

@keyframes loading-1{
    0%{
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100%{
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
    }
}

@keyframes loading-2{
    0%{
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100%{
        -webkit-transform: rotate(90deg);
        transform: rotate(90deg);
    }
}
@keyframes loading-3{
    0%{
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100%{
        -webkit-transform: rotate(108deg);
        transform: rotate(108deg);
    }
}
@keyframes loading-4{
    0%{
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100%{
        -webkit-transform: rotate(126deg);
        transform: rotate(126deg);
    }
}
@keyframes loading-5{
    0%{
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100%{
        -webkit-transform: rotate(144deg);
        transform: rotate(144deg);
    }
}
@keyframes loading-6{
    0%{
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100%{
        -webkit-transform: rotate(162deg);
        transform: rotate(162deg);
    }
}
@keyframes loading-7{
    0%{
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100%{
        -webkit-transform: rotate(72deg);
        transform: rotate(72deg);
    }
}
* {
  font-display: swap;
}
</style>
