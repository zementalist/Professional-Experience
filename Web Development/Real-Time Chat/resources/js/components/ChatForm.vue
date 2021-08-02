<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <ul class="chat" id="chatBox" style="height:75vh;overflow-y:scroll;">
                    <li class="left clearfix" v-for="message in messages">
                        <div class="chat-body clearfix">
                            <div class="header">
                                <strong class="primary-font">
                                    {{ message.user.name }}
                                </strong>
                            </div>
                            <p style="margin-bottom:0;">
                                {{ message.message }}
                            </p>
                            <p style="font-size:10px;">{{ formatDates(new Date(message.created_at)) }}</p>
                        </div>
                    </li>
                </ul>

                <div class="input-group">
                    <input id="btn-input" type="text" name="message" class="form-control input-sm"
                        placeholder="Type your message here..." v-model="newMessage" @keyup.enter="sendMessage">

                    <span class="input-group-btn">
                        <button class="btn btn-primary btn-sm" id="btn-chat" @click="addMessage">
                            Send
                        </button>
                    </span>
                </div>

            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Online Users</div>
                    <div v-for="user in users">
                        {{user.name}} <span v-if="$props.user.id == user.id">(you)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Echo from 'laravel-echo';

    window.Pusher = require('pusher-js');


    export default {
        props: ['user', 'token'],
        data() {
            return {
                users: [],
                message: '',
                newMessage: '',
                messages: [],
                Echo: null,

            }
        },
        created() {
            this.Echo = new Echo({
                broadcaster: 'pusher',
                key: process.env.MIX_PUSHER_APP_KEY,
                cluster: process.env.MIX_PUSHER_APP_CLUSTER,
                wsHost: window.location.hostname,
                wsPort: 6001,
                wssPort: 6001,
                forceTLS: false,
                disableStats: true,
                encrypted: true

            });
            this.Echo.private('chat')
                .listen('MessageSent', (e) => {
                    console.log(e)
                    this.messages.push({
                        message: e.message.message,
                        user: e.user,
                        created_at: new Date()
                    });
                    this.scrollChat()
                });
            this.Echo.join("mylolchannel")
                .here(users => {
                    this.users = users;
                })
                .joining(user => {
                    this.users.push(user);
                    console.log("USER " + user.name + " JOINED");
                })
                .leaving(user => {
                    this.users.splice(this.users.indexOf(user));
                    console.log("USER " + user.name + " LEFT");
                })
        },
        mounted: function () {
            console.log('Component mounted.')
            this.fetchMessages();

        },
        methods: {
            fetchMessages() {
                axios.get('/messages', {
                    headers: {
                        "Authorization": `Bearer ` + this.$props.token
                    }
                }).then(response => {
                    this.messages = response.data;
                });
            },
            scrollChat() {
                setTimeout(function () {
                    var chatBox = document.getElementById("chatBox");
                    chatBox.scrollTop = chatBox.scrollHeight - chatBox.clientHeight;
                    document.getElementById("btn-input").focus();
                }, 50)
            },
            addMessage() {
                let message = {
                    user: this.user,
                    message: this.newMessage,
                    created_at: new Date()
                };
                this.messages.push(message);
                axios.post('/messages', message,{
                    headers: {
                        "Authorization": `Bearer ` + this.$props.token
                    }
                }).then(response => {
                    console.log(response.data);
                });
                this.newMessage = '';
                this.scrollChat();
            },

            
            formatDates(date) {
                let result = "";
                result += (date.getHours() + 24) % 12 || 12;
                result += ":" + date.getMinutes();
                return result
            }
        }
    }

</script>
