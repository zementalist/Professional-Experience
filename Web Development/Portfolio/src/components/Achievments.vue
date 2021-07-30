<template>
  <div>
    <div class="ach" id="achievmentsSection">
      <div class="container">
        <section class="row">
          <div class="col-md-12">
            <section class="row">
              <div class="col-md-12 wow zoomIn">
                <h1 class="shine wow">Achievments</h1>
                <h5 style="text-align:center;"><a target="_blank" href="http://www.zeyad.rf.gd/certificates.pdf">(Certificates)</a></h5>
              </div>
            </section>
            <section class="row" style="margin-top:3%;">
              <div class="col-md-4 col-sm-6">
                <work-card
                 title="Firelink" type="Web Application" src="https://www.mediafire.com/convkey/b330/6hfb631chl84gypzg.jpg"
                 idea="Firelink is a web application for file uploading management system. Firelink provides uploading various types of files and some smart features such deleting the file using a secure code or auto-deletion after a period of time, and other new features."
                 :technology="['Laravel', 'Vue JS', 'Bootstrap', 'MySQL', 'PHP', 'Ajax']"
                 :url="'http://firelnk.rf.gd/'"
                 ></work-card>
              </div>
              <div class="col-md-4 col-sm-6">
                <work-card
                title="Persnoal CV" type="Web Design" src="https://www.mediafire.com/convkey/a399/exrk39zmjg07mfz7g.jpg"
                idea="My first own web design, it represents my skills and recent work\projects."
                :technology="['HTML', 'CSS', 'Bootstrap', 'JS', 'Vue Js', 'jQuery', 'GSAP', 'Webpack', 'others']" :url="'#'"
                ></work-card>
              </div>
              <div class="col-md-4 col-sm-6">
                <work-card
                title="Chat Application" type="Web Application" src="https://www.mediafire.com/convkey/56d3/kgsnhjeajemir1a7g.jpg"
                idea="Chat Web Application, Online chat for friends with an online game -Tic Tac Toe-."
                :technology="['HTML', 'CSS', 'JS', 'Bootstrap', 'MySQL', 'PHP', 'Ajax']"
                ></work-card>
              </div>
              <div class="col-md-4 col-sm-6">
                <work-card title="Similar Cards" type="Game" src="https://www.mediafire.com/convkey/c8ca/tciidgt1d9ibzy47g.jpg"
                idea="Try to find the similar cards and win the 3 levels!"
                :technology="['HTML', 'CSS', 'JS', 'GSAP']" :url="'http://www.zeyad.rf.gd/similarcards.html'"
                ></work-card>
              </div>
              <div class="col-md-4 col-sm-6">
                <work-card
                 title="Tic Tac Toe" type="Web Application\Game" src="https://www.mediafire.com/convkey/8bda/elwodebtk1qwrbczg.jpg"
                 idea="Tic Tac Toe is a 2 players game. It depends on AI of computers and fortunately there are an offline version (vs computer) and online version (vs 2nd player)."
                 :technology="['HTML', 'CSS', 'JS', 'Bootstrap', 'MySQL', 'PHP', 'Ajax']" :url="'http://www.zeyad.rf.gd/tictactoe.html'"
                 ></work-card>
              </div>
              <div class="col-md-4 col-sm-6">
                <work-card title="Guessing Numbers" type="Game" src="https://www.mediafire.com/convkey/7d74/k8b4gnaq1mif5z37g.jpg"
                idea="Entertaining smart game. Choose a number and your computer will guess it, or guess the computer's number!"
                :technology="['HTML', 'CSS', 'JS', 'Bootstrap']" :url="'https://aigamess.000webhostapp.com'"
                ></work-card>
              </div>
              <div class="col-md-4 col-sm-6">
                <work-card title="Bouncing Ball" type="Game" src="https://www.mediafire.com/convkey/b7e4/2af8sagu09c4aw37g.jpg"
                idea="Very familiar game with no additional technologies!"
                :technology="['HTML', 'CSS', 'JS']" :url="'http://www.zeyad.rf.gd/Ruler.html'"
                ></work-card>
              </div>
              <div class="col-md-4 col-sm-6">
                <work-card title="A Different Face" type="Game" src="https://www.mediafire.com/convkey/0275/0p2qzbpi83e46017g.jpg"
                idea="The faces on the right side are identical to the faces on the left side, except 1 face. Find it, easy!"
                :technology="['HTML', 'CSS', 'JS']" :url="'http://www.zeyad.rf.gd/faces.html'"
                ></work-card>
              </div>
              <div class="col-md-4 col-sm-6">
                <work-card title="The Lucky Square" type="Game" src="https://www.mediafire.com/convkey/bfac/rbl33d67d05k39n7g.jpg"
                idea="My first game , try to pass the lines to get a high score!"
                :technology="['HTML', 'CSS', 'JS']" :url="'http://www.zeyad.rf.gd/Gaming.html'"
                ></work-card>
              </div>
            </section>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import Card from './achCard';
Vue.component('work-card', Card);
export default {
  name: 'Achievments'
}
</script>

<style scoped>
h1 {
  color: black;
  font-weight: 900;
  text-transform: uppercase;
  font-family: 'Titan One', cursive;
  font-size: 50px;
  text-align: center;
  letter-spacing: 5px;
}

h1.shine
{
    background: #222 -webkit-gradient(linear, left top, right top, from(#222), to(#222), color-stop(0.5, #fff)) 0 0 no-repeat;
    background-size: 100px;

    color: rgba(255, 255, 255, 0.1);
    -webkit-background-clip: text;

    animation-name: shine;
    animation-duration: 3s;
    animation-iteration-count: infinite;
}

@keyframes shine
{
    0%
    {
        background-position: top left;
    }
    100%
    {
        background-position: top right;
    }
}
@media screen and (max-width: 521px) {
  h1 {
    font-size: 10vw;
  }
}


.ach {
  margin-top: 2%;
  padding-bottom: 10vh;
  padding-top: 2%;
  background-color: #F4F4F4;
}
</style>
