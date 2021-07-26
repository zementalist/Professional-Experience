<template>
    <div class="mail-container">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10 col-sm-10 col-10 col-lg-10">
                    <div class="wrap">
                        <form id="findForm" @change="find()">
                            <input type="hidden" value="" name="_token" id="csrf">
                            <label for="type">Show:</label>
                            <input type="radio" checked name="type" value="all">All
                            <input type="radio" name="type" value="message">Messages
                            <input type="radio" name="type" value="report">Reports
                            <input type="radio" name="type" value="unseen">Unseen
                        </form>
                        <form id="seenForm" style="display:none">
                            <input type="hidden" name="mailid" value="">
                            <input type="hidden" value="" name="_token" id="csrf2">
                        </form>
                        <form id="deleteForm"  style="display:none">
                            <input type="hidden" name="mailid" value="">
                            <input type="hidden" value="" name="_token" id="csrf3">
                        </form>
                        <br>
                        <input type="text" readonly id="link" value="" style="display:none;">
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-sm-8 col-10 col-lg-6">
                            <div class="msg-list">
                                <ul type="none">
                                    <li class="msg" v-for="msg in this.data">
                                        <div class="mail" :id="msg.id">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-12 col-lg-12">
                                                    <h4 class="subjectHeader" > <span class="float-left" style="cursor:pointer;" @click="copyLink($event)">©</span> <span class="subjectText" >{{msg.subject}}</span> <span v-if="!msg.seen" :seen="msg.seen" style="color:red; font-size:15px;">●</span> <span class="float-right" style="padding-right:10px;color:red;cursor:pointer;" @click="remove($event)" >X</span> </h4> 
                                                    <div class="personal-data" @click="viewMsg($event)">
                                                        <p class="from" style="word-break:break-word;">Sent by:   {{msg.email}}</p>
                                                        <small>Date: {{msg.created_at}}</small>
                                                        <p style="display:none;font-size:2vw;">{{msg.message}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 col-sm-10 col-10 col-lg-10">
                <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="find()"></pagination>
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
            pagination: {
                'current_page': 1
            },
            showMessage:false,
            type:'all' 
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
        this.find();
  },
  methods: {
    handleResize() {
      this.window.width = window.innerWidth;
      this.window.height = window.innerHeight;
    },
    copyLink: function(event) {
        var text = event.currentTarget.nextSibling.nextSibling.innerHTML;
        var link = document.getElementById('link');
        link.value = text;
        link.style.display = 'block';
        link.select();
        document.execCommand("copy");
        link.style.display = 'none';
        event.currentTarget.style.color = "blue";
        var el = event.currentTarget;
        setTimeout(function() {
            el.style.color = "white";
        }, 1000);
    },
    viewMsg(event) {
        var msg = event.currentTarget.childNodes[4];
        var mailid = event.currentTarget.parentNode.parentNode.parentNode.getAttribute('id');
        var seenSymbol = event.currentTarget.previousSibling.previousSibling.childNodes[4];
        if(this.showMessage == false){
            msg.style.display = 'block';
        }
        else {
            msg.style.display = 'none';
        }
        if(seenSymbol && seenSymbol.innerHTML == "●") {
            var url = window.location.hostname + "/owner/control/find/mail/seen";
            var form = document.getElementById('seenForm'); 
            form.firstChild.value = mailid
            document.getElementById('csrf2').value = document.getElementsByTagName('meta')[2].getAttribute('content');
                var query = url;
                fetch(query, {
                    method: 'post',
                    credentials: "same-origin",
                    body: new FormData(form)
                });
                seenSymbol.parentNode.removeChild(seenSymbol);
        }
        this.showMessage = !this.showMessage;
    },
    find: function() {
        var url = window.location.hostname +"/owner/control/find/mail?page=" + this.pagination.current_page;
        var form = document.getElementById('findForm');
        document.getElementById('csrf').value = document.getElementsByTagName('meta')[2].getAttribute('content');
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
                if(document.querySelector('input[name="type"]:checked').value != this.type) {
                    this.pagination.current_page = "1";
                    this.type = document.querySelector('input[name="type"]:checked').value;
                    this.find();
                    console.log(jsonResponse.current_page);
                }
                this.data = jsonResponse.data;
                this.pagination.last_page = jsonResponse.last_page;
            })
    },
    remove: function(event) {
        var confirmed = confirm("Are you sure you want to delete this mail ?");
        if(confirmed) {
            var url = window.location.hostname + "/owner/control/del/mail";
            var form = document.getElementById('deleteForm');
            // set input(mail) id
            form.firstChild.value = event.currentTarget.parentNode.parentNode.parentNode.parentNode.getAttribute('id');
            document.getElementById('csrf3').value = document.getElementsByTagName('meta')[2].getAttribute('content');
                var query = url;
                fetch(query, {
                    method: 'post',
                    credentials: "same-origin",
                    body: new FormData(form)
                });
                this.find();
        }
    }
  }
}
</script>

<style scoped>
.mail-container {
    margin-bottom: 5rem;
}

.identity {
    vertical-align: middle;
    background: blueviolet;
    border-right: 3px solid purple;
    border-left: 0px solid white;
    border-radius: 25%;
    text-align: center;
    width: 5vw;
    font-size: 3rem;
    display: inline-block;
}
.subjectHeader {
    font-weight: 900;
    background: #5c5c5c;
    border: 1px solid rgb(0, 0, 0);
    border-radius: 20px;
    border-top: 3px solid rgb(0, 0, 0);
    text-align: center;
    width: 100%;
    color: white;
}
.subjectText {
    word-break: break-word;
}
p {
    margin-bottom: 0px;
}
.msg {
    background: white;
    margin-bottom: 2rem;
    transition: 1s;
    border-radius: 20px;
    -webkit-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.75);
    box-shadow: 0px 0px 20px 0px #444;
}
.personal-data {
    padding: 0px 10px 10px 10px;
}
#findForm {
    text-align:center;
}
input {
    margin-left: 10px;
}
</style>
