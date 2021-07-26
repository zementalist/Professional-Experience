<template>
    <div>
        <div class="file-card" @click="submitForm()">
            <div class="icon-container" style="width:100%;height:100%">
                <i :class="iconClass + ' icon'"></i>
            </div>
            <div class="typeName">
                <p id="textType">{{type}}</p>
            </div>
        </div>
    </div>    
</template>

<script>
import VueFontAwesomeCss from 'vue-fontawesome-css'

Vue.use(VueFontAwesomeCss)
export default {
    props:['iconClass', 'type'],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            backcolors: ['darkred', 'rebeccapurple', 'cornflowerblue', 'green', 'hotpink', 'teal']
        }
    },
    mounted() {
        document.getElementsByClassName('icon')[0].style.color = this.backcolors[Math.round(Math.random() * this.backcolors.length)];
        document.getElementsByClassName('icon')[1].style.color = this.backcolors[Math.round(Math.random() * this.backcolors.length)];
        document.getElementsByClassName('icon')[2].style.color = this.backcolors[Math.round(Math.random() * this.backcolors.length)];
        document.getElementsByClassName('icon')[3].style.color = this.backcolors[Math.round(Math.random() * this.backcolors.length)];
        document.getElementsByClassName('icon')[4].style.color = this.backcolors[Math.round(Math.random() * this.backcolors.length)];
        document.getElementsByClassName('icon')[5].style.color = this.backcolors[Math.round(Math.random() * this.backcolors.length)];
    },
    methods: {
        submitForm() {
            var type = this.$props.type;
            if(type === "Other") {
                return ;
            }
            var urlUpload = '/upload/' + type;
            document.getElementById('form').innerHTML = ('<form id="form2" action="' + urlUpload +'" name="upload" method="GET" style="display:none;"><input type="hidden" name="_token" value="'+this.csrf+'"><input type="text" name="type" value="' + type + '" /></form>');
            document.getElementById('form2').submit();
        }
    }

}
</script>

<style scoped>
.file-card {
    background-color: whitesmoke;
    border: 5px solid lightgray;
    max-width: 25vw;
    border-radius: 28px;
    position: relative;
    margin-top: 15px;
    text-align: center;
    cursor: pointer;
    overflow: hidden;
    -webkit-box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.75);
    box-shadow: 0px 0px 15px 0px #444;
}
.file-card:hover #textType {
    -webkit-mask-image: -webkit-gradient(linear, left top, left bottom, from(rgb(10, 120, 148)), color-stop(50%, rgba(46, 25, 235, 0.7)), to(rgba(0,0,0,1)));
    text-shadow: 0 2px 0 #e04646;
    -webkit-transition: all .5s;
    -moz-transition: all .5s;
    transition: all .5s;
    text-shadow: 2px 3px 3px #ff0000;
    -webkit-text-stroke: 1px rgb(20, 109, 182);
}
.icon-container {
    text-align: center;
    align-content: center;
}
.icon {
    position: relative;
    font-size: 13vw;
    object-fit: cover;
    text-align: center;
    align-self: center;
    padding: 5px 0px 10px 0px;
}
.typeName {
    border-top: 5px solid black;
    border-radius: 58px;
}
#textType {
    transition: 1s;
    font-family: 'Titan One', cursive;
    text-align: center;
    font-weight: 900;
    font-size: 4.2vw;
    color: rgb(7, 0, 0);
	text-decoration: none;
    -webkit-mask-image: -webkit-gradient(linear, left top, left bottom, from(rgb(0, 0, 0)), color-stop(50%, rgba(0,0,0,0.7)), to(rgba(0,0,0,1)));
    text-shadow: 0 2px 0 #e9e9e9;
    -webkit-transition: all .5s;
    -moz-transition: all .5s;
    transition: all .5s;
    text-shadow: 2px 3px 3px #d15454;
    -webkit-text-stroke: 1px rgb(20, 109, 182);
}


@media screen and (max-width:575px) {
    #textType {
        font-size: 3.2vw;
    }
    .icon {
        font-size: 15vw;
    }
}

</style>
