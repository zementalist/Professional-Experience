<template>
  <div>
    <div id="contactSection" style="overflow-y:hidden; overflow-x:hidden;">
      <section class="row">
        <div class="col-md-12">
          <section class="row">
            <div class="col-md-12">
              <h1>Contact me</h1>
              <div class="contactBoxCirc wow zoomIn">
                <div class="contentPsych">
                  <h3 style="font-family:'Lobster', helvetica, arial;">Let's Work Together !</h3>
                </div>
              </div>
            </div>
          </section>
          <section class="row" style="margin:0px 15px 0px 15px;">
            <div class="col-md-4"></div>
            <div class="col-md-4">
              <div class="contactBox wow fadeInUp" data-wow-duration="2s">
                <i class="fas fa-envelope Icon"></i>
                <div class="content">
                  <h3>E-mail:</h3>
                  <h5 id="email">zeyadpro99@gmail.com</h5>
                </div>
              </div>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
              <div class="contactBox wow fadeInRight" data-wow-duration="2s">
                <i class="fas fa-phone Icon"></i>
                <div class="content">
                  <h3>Phone Number:</h3>
                  <h5>+20 109 846 2503</h5>
                </div>
              </div>
            </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
              <div class="contactBox wow fadeInLeft" data-wow-duration="2s">
                <i class="fas fa-map-marker-alt Icon" style="transform: rotateY(360deg);"></i>
                <div class="content">
                  <h3>Location:</h3>
                  <h5>6th Of October City, 12th District</h5>
                </div>
              </div>
            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
              <div class="contactBox wow fadeInDown" data-wow-duration="2s">
                <div class="icons">
                  <ul>
                    <li> <a target="_blank" href="https://www.facebook.com/profile.php?id=100009945691574"><i class="fab fa-facebook fIcon"></i></a></li>
                    <li> <a target="_blank" href="https://linkedin.com/in/zeyad-khalid-641958185/"><i class="fab fa-linkedin-in lIcon"></i></a></li>
                    <li> <a target="_blank" ><i class="fab fa-google gIcon"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-4"></div>
          </section>
        </div>
      </section>
      <section class="row" style="margin-bottom:1rem; padding-bottom:-1rem;">
        <div class="col-md-12" style="margin-bottom:-1rem; padding-bottom:-1rem;">
          <div class="footer">
            <h2>©{{new Date().getFullYear()}} <span style="font-weight:700">Zeyad Khalid</span>. All Rights Reserved</h2>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
export default {
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
  letter-spacing: 2px;
  text-shadow: 0 1px 0 #ccc,
               0 2px 0 #c9c9c9,
               0 3px 0 #bbb,
               0 4px 0 #b9b9b9,
               0 5px 0 #aaa,
               0 6px 1px rgba(0,0,0,.1),
               0 0 5px rgba(0,0,0,.1),
               0 1px 3px rgba(0,0,0,.3),
               0 3px 5px rgba(0,0,0,.2),
               0 5px 10px rgba(0,0,0,.25),
               0 10px 10px rgba(0,0,0,.2),
               0 20px 20px rgba(0,0,0,.15);
}

h6 {
  text-align: center;
}
h3 {
  font-weight: 700;
}
#contactSection {
  margin-top: 2%;
  padding-top: 2%;
  /*background-color: #F4F4F4;*/

}
.contactBox {
  transition: 0.5s;
  -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
  -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
  box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
  border: 0.5px solid white;
  margin-top: 2vh;
  border: 0.5px solid gray;
  max-height: 150px;
  background: #ECACFD; /* Old browsers */
  background: -moz-linear-gradient(left,  #87e0fd 0%, #9ce7ff 40%, #05abe0 100%); /* FF3.6-15 */
  background: -webkit-linear-gradient(left,  #87e0fd 0%,#9ce7ff 40%,#05abe0 100%); /* Chrome10-25,Safari5.1-6 */
  background: linear-gradient(to right,  #87e0fd 0%,#9ce7ff 40%,#05abe0 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#87e0fd', endColorstr='#05abe0',GradientType=1 ); /* IE6-9 */
  /*background-color:#ECACFD;*/
}
.contactBox:hover {
  transition: 0.5s;
  -webkit-box-shadow: 0px 0px 5px 0px #FAFFFF;
  -moz-box-shadow: 0px 0px 5px 0px #FAFFFF;
  box-shadow: 0px 0px 5px 0px #FAFFFF;
}
.content {
  padding: 25px 30px;
  margin-left: 5vw;
  max-width: 90%;
  position: relative;
}

.contentPsych {
  padding: 25px 30px;
  max-width: 100%;
  position: relative;
  text-align:center;
  font-size: 1rem;
}

.icons {
  padding: 10px 10px;
  max-width: 90%;
  position: relative;
}
.Icon {
  display: table-cell;
  transform: rotateY(180deg);
  font-size: 40px;
  background-color: rgb(12, 112, 183);
  color:white;
  padding: 7px 7px;
  position: absolute;
  border: 1px solid inherit;
  vertical-align: middle;
  border-radius: 50%;
  position: absolute;
  top: 45px;
  left: 30px;
}

@media screen and (max-width: 521px) {
  h1 {
    font-size: 10vw;
  }
  .icons {
    text-align: center;
    margin-left: -13vw;
  }
  .fab {
    margin: 5vw;
  }
}

ul li {
  display: inline-block;
  padding-top: 2vh;
  text-align: center;
  margin-left: 1rem;
}
li {
  margin-right: 0.5rem;
}
.footer {
  background-color: #222;
  margin-top: 5vh;
  height: 70%;
}
h2 {
  color: white;
  font-size: 16px;
  padding-top: 0.5rem;
  text-align: center;
  vertical-align: center;
}
.fIcon, .lIcon, .gIcon {
  padding: 7px 7px;
  color: white;
  font-size: 60px;
  border: 1px solid inherit;
  border-radius: 50%;
}
.fIcon {
  color: #2b569b;
}
.lIcon {
  /* background-color: gray; */
  border-radius: 0%;

  background-color:#0077B5;
}
.gIcon {
  color: gray;
}
@media screen and (max-width:1125px) and (min-width:931px) {
  * {
    font-size: 100%;
  }
  ul li{
    margin-left: 0rem;
  }
  .fIcon, .gIcon, .lIcon {
    text-align: center;
    margin-left: 0rem;
    font-size: 35px;
  }
}
@media screen and (max-width:930px) {
  * {
    font-size: 98%;
  }
  .fIcon, .gIcon, .lIcon {
    margin-left: 0.2rem;
    display: inline;
    font-size: 30px;
  }
  ul li {
    margin-left: -3rem;
  }
  ul {
    margin-left: 1rem;
    width: 150%;
  }
  li {
    margin-right: 3.5rem;
  }
  .content {
    margin-left: 5vw;
  }
  .Icon {
    top:35px;
  }
}

@media screen and (max-width:860px) {
  * {
    font-size: 96%;
  }
  .Icon {
    top:35px;
  }
}
@media screen and (max-width:767px) {
  .content {
    margin-left: 3rem;
  }
  * {
    font-size: 105%;
  }
  .fIcon, .gIcon, .lIcon {
    margin-left: 3.5rem;
  }
}
@media screen and (max-width:521px) {
  #email {
    font-size: 80%;
  }
  .fIcon, .gIcon, .lIcon {
    margin-left: 0.2rem;
    display: inline;
    font-size: 30px;
  }
  ul li {
    margin-left: -2rem;
  }
  li {
    margin-right: 2.5rem;
  }
  .icons {
    align-items: center;
    align-content: center;
    align-self: center;
  }
}
@media screen and (max-width:521px) {
  * {
    font-size: 98%;
  }
  ul li {
    margin-left: -2rem;
  }
  li {
    margin-right: 2rem;
  }
}
</style>
