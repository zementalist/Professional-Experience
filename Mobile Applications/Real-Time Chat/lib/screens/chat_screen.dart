import 'dart:convert';

import 'package:chat/components/MessageContainer.dart';
import 'package:chat/models/Message.dart';
import 'package:chat/models/User.dart';
import 'package:chat/services/MessagesController.dart';
import 'package:chat/services/Pusher.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:chat/extensions/StringExtension.dart';
import 'package:flutter/services.dart';
import 'package:pusher_client/pusher_client.dart';

class ChatScreen extends StatefulWidget {
  static const String id = 'chat_screen';
  @override
  _ChatScreenState createState() => _ChatScreenState();
}

class _ChatScreenState extends State<ChatScreen> {
  User user;
  MessageContainer messagesContainer;
  List<Message> messages;
  String typedMessage;
  MessagesController msgCtrl;
  TextEditingController textMessageController;

  PusherClient pusher;

  @override
  void initState() {
    // TODO: implement initState
    super.initState();
  }

  @override
  void dispose() {
    // TODO: implement dispose
    super.dispose();
    pusher.disconnect();
  }

  void getMessages() async {
    messages = await msgCtrl.fetchAll();
    setState(() {
      messagesContainer =
          MessageContainer(messages: messages, clientID: user.id);
    });
  }

  void initPusher() async {
    pusher = await Pusher.init(token: user.token);

    Channel ch = pusher.subscribe('private-chat');
    ch.bind('App\\Events\\MessageSent', (event) {
      dynamic data = jsonDecode(event.data);

      // Receive messages from others, not self. (this should be solved by backend
      if (data['message']['user_id'] != user.id) {
        Message receivedMsg = Message(
            username: data['user']['name'],
            text: data['message']['message'],
            userId: data['message']['user_id']);

        setState(() {
          messages = List.of(messages)..add(receivedMsg);
          messagesContainer =
              MessageContainer(messages: messages, clientID: user.id);
        });
      }
    });
  }

  Channel connectChannel(String channelName) {
    return pusher.subscribe(channelName);
  }

  void bindEvent(Channel channel, String eventName, Function callback) {
    channel.bind(eventName, callback);
  }

  void initData() {
    // Get user's data & chat messages
    dynamic args = ModalRoute.of(context).settings.arguments;
    user = args['user'];
    msgCtrl = MessagesController(accessToken: user.token);
    textMessageController = TextEditingController();
    getMessages();
    initPusher();
  }

  @override
  void didChangeDependencies() {
    // TODO: implement didChangeDependencies
    super.didChangeDependencies();
    if (user == null) {
      initData();
    }
  }

  void sendMessage() {
    // Create new Message object
    Message newMessage =
        Message(userId: user.id, username: user.name, text: typedMessage);

    // Send message to backend & clear input widget
    msgCtrl.send(newMessage);
    textMessageController.clear();

    // Update messages list & their container (widget)
    setState(() {
      messages = List.of(messages)..add(newMessage);
      messagesContainer =
          MessageContainer(messages: messages, clientID: user.id);
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(
          user.name.capitalize(),
        ),
        centerTitle: true,
        backgroundColor: Colors.lightBlueAccent,
      ),
      backgroundColor: Colors.white,
      body: Container(
        width: double.infinity,
        child: Column(
          children: [
            Expanded(
              child: Column(
                children: [messagesContainer ?? Text('Loading')],
              ),
            ),
            Divider(
              color: Colors.blue.shade300,
              thickness: 2,
            ),
            Row(
              children: [
                Expanded(
                  child: TextField(
                    controller: textMessageController,
                    style: TextStyle(fontSize: 16, color: Colors.black),
                    decoration: InputDecoration(
                      contentPadding: EdgeInsets.symmetric(horizontal: 15),
                      hintText: 'Type your message here..',
                      hintStyle: TextStyle(color: Colors.grey.shade400),
                    ),
                    onChanged: (value) {
                      setState(() {
                        typedMessage = value;
                      });
                    },
                  ),
                ),
                FlatButton(
                  onPressed: () {
                    sendMessage();
                  },
                  child: Text(
                    'Send',
                    style: TextStyle(color: Colors.blue.shade300, fontSize: 18),
                  ),
                ),
              ],
            )
          ],
        ),
      ),
    );
  }
}
