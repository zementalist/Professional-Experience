<template>
<div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10 col-sm-10 col-10 col-lg-10">
                    <div class="wrap">
                        <div class="search">
                            <form id="form" @change="find()">
                                <input type="hidden" value="" name="_token" id="csrf">
                                <input type="hidden" id="sortInput" readonly style="display:none" name="sort" :value="this.getSort">
                                <input type="text" @keyup="find()" class="searchTerm form-control" name="search" placeholder="What are you looking for?">
                                <label for="type" style="font-weight:bold;">Type: </label>
                                <input type="radio" checked name="type" value="Image">Image
                                <input type="radio" name="type" value="Audio">Audio
                                <input type="radio" name="type" value="Video">Video
                                <input type="radio" name="type" value="Document">Document
                                <input type="radio" name="type" value="Compressed">Compressed
                                <br>
                                <label for="method" style="font-weight:bold;">Search By: </label>
                                <input type="radio" checked name="method" value="username">Username
                                <input type="radio" name="method" value="filename">Filename
                                <input type="radio" name="method" value="fileid">File ID
                            </form>
                        </div>
                    </div>
                    <br>
                    <br>
                </div>
            </div>
                <div class="row justify-content-center">
                    <div class="col-md-10 col-11 col-sm-11 col-lg-10">
                        <div class="content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Size</th>
                                        <th>Extension</th>
                                        <th>Username</th>
                                        <th @click="changeSort();" style="cursor:pointer;">Created<i id="sortIcon" class="fas fa-sort-down"></i>at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in this.data">
                                        <td v-for="value in item">{{value}}</td>
                                        <td>
                                            <form class="form2" :id="item.ID" v-if="item">
                                                <input type="hidden" name="_token" id="csrf2" value="">
                                                <input type="hidden" name="fileid" :value="item.ID" id="fileid">
                                                <input @click="remove($event)" type="button" value="Delete" class="btn btn-danger">
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
            data:[],
            sort:"DESC"
    }
  },
  created() {
    window.addEventListener('resize', this.handleResize)
    this.handleResize();
  },
  destroyed() {
    window.removeEventListener('resize', this.handleResize)
  },
  computed: {
      getSort: function() {
          return this.sort;
      }
  },
  methods: {
    handleResize() {
      this.window.width = window.innerWidth;
      this.window.height = window.innerHeight;
    },
    find: function() {
        var url = window.location.hostname + "/owner/control/find/file";
        var form = document.getElementById('form');
        document.getElementById('csrf').value = document.getElementsByTagName('meta')[2].getAttribute('content');
        var value = document.getElementsByClassName('searchTerm')[0].value;
        if(value.length > 0) {
            var query = url;
            fetch(query, {
                method: 'post',
                credentials: "same-origin",
                body: new FormData(form)
            }).then(response=>{
                if(response.ok) {
                    return response.json();
                }
                throw new Error("Request Failed!");
            }, networkError=> {
                console.log(networkError.message);
            }).then(jsonResponse=>{
                this.data = jsonResponse;
                console.log(jsonResponse);
            })
        }
    },
    changeSort: function() {
        if(this.sort == "DESC") {
            this.sort = "ASC";
            document.getElementById('sortIcon').setAttribute('class', 'fas fa-sort-up');
        }
        else {
            this.sort = "DESC";
            document.getElementById('sortIcon').setAttribute('class', 'fas fa-sort-down');
        }
        document.getElementById('sortInput').value = this.sort;
        this.find();
    },
    remove: function(event) {
        var url = window.location.hostname + "/owner/control/del/file";
        var form = event.currentTarget.parentNode;
        alert(document.getElementsByTagName('meta')[2].getAttribute('content'));
        form.firstElementChild.value = document.getElementsByTagName('meta')[2].getAttribute('content');
        var id = event.currentTarget.parentNode.getAttribute('id');
        var confirmed = confirm("Are you sure you want to delete this file ?");
        if(id.length > 0 && confirmed) {
            var query = url;
            fetch(query, {
                method: 'post',
                credentials: "same-origin",
                body: new FormData(form)
            }).then(response=>{
                if(response.ok) {
                    return response.json();
                }
                throw new Error("Request Failed!");
            }, networkError=> {
                console.log(networkError.message);
            }).then(jsonResponse=>{
                this.find();
            })
        }
    }
  }
}
</script>

<style scoped>
.searchsSection {
  margin-top: 5%;
}
.messagesSection {
  opacity: 0;
  display: none;
}
.table {
    table-layout: fixed;
    word-wrap: break-word;
    margin-bottom: 3rem;
}

h4 {
  text-shadow: 1px 1px #18ba60;
}
@import url(https://fonts.googleapis.com/css?family=Open+Sans);

body{
  background: #f2f2f2;
  font-family: 'Open Sans', sans-serif;
}

td, tr, th {
    text-align: center;
}
/*Resize the wrap to see the search bar change!*/
#form {
    text-align: center;
}

/* +++++++++++++++++++++++++++++++++++++++++++++ */
table {
  border-spacing: 1;
  border-collapse: collapse;
  background: white;
  border-radius: 10px;
  overflow: hidden;
  width: 100%;
  margin: 0 auto;
  position: relative;
}
table * {
  position: relative;
}

table thead tr {
  background: #5c5c5c;
  color: white;
}
.table thead th {
    vertical-align: middle;
}
table tbody tr {
  max-height: 50px;
}
table tbody tr:last-child {
  border: 0;
}
.table td, .table th {
  text-align: center;
  padding: 0.1vw 0.5vw 0.1vw 0.5vw;
  vertical-align: middle;
}


tbody tr:nth-child(even) {
  background-color: #f5f5f5;
}

tbody tr {
  font-family: OpenSans-Regular;
  color: #808080;
  font-weight: unset;
}

tbody tr:hover {
  color: #555555;
  background-color: #f5f5f5;
  cursor: pointer;
}
</style>
