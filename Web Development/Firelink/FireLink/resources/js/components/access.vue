<template>
    <div>
        <div>
            
        </div>
        <div class="header">
            <section class="row">
                <div class="col-md-2" v-if="this.window.width < 992"> <p></p> </div>
                <div class="col-lg-6 col-md-4 col-sm-6 col-6">
                    <h3 @click="changeSearchSection('searchs')"> <router-link to="search" id="searchBtn"><a :class="!this.messagesOpened ? 'active searchItem' : 'searchItem'">Search</a></router-link> </h3>
                    <hr :class="this.messagesOpened ? '' : 'active'">
                </div>
                <div class="col-lg-6 col-md-4 col-sm-6 col-6">
                    <h3 @click="changeSearchSection('messages')"> <router-link to="messages"><a :class="this.messagesOpened ? 'active searchItem' : 'searchItem'">Messages</a></router-link> </h3>
                    <hr :class="this.messagesOpened ? 'active' : ''">
                </div>
            </section>
        </div>
        <br>
        <router-view></router-view>
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
            messagesOpened:false,
            data:[]
    }
  },
  created() {
    window.addEventListener('resize', this.handleResize)
    this.handleResize();
  },
  destroyed() {
    window.removeEventListener('resize', this.handleResize)
  },
  mounted() {
  },
  methods: {
    handleResize() {
      this.window.width = window.innerWidth;
      this.window.height = window.innerHeight;
    },
    changeSearchSection(section) {
      var searchsData = document.getElementsByClassName('searchsData')[0];
      var messagesSection = document.getElementsByClassName('messagesSection')[0];
      if(!this.messagesOpened && section == 'messages') {
        //searchsData.style.display = 'none';
       // messagesSection.style.display = 'block';
        this.messagesOpened = !this.messagesOpened;
      }
      else if(section == 'searchs' && this.messagesOpened) {
       // messagesSection.style.display = 'none';
        //searchsData.style.display = 'block';
        this.messagesOpened = !this.messagesOpened;
      }
    }
  }
}
</script>

<style scoped>
ul li {
  display: inline-block;
}
a {
    color: grey;
}
.header {
  margin-top: 3%;
  text-align: center;
}
.searchItem {
  text-transform: uppercase;
}
.active {
  color: #18ba60;
}

hr {
  width: 50%;
  background-color: grey;
  border:none;
  height: 5px;
  border-radius: 50px;
  transition: 0.5s;
}
a:not([href]):not([tabindex]).active {
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


</style>
