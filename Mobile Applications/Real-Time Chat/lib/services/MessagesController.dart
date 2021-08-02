import 'package:flutter/material.dart';

import 'package:chat/models/Message.dart';
import 'package:chat/services/NetworkClient.dart';

class MessagesController {
  final String accessToken;
  final NetworkClient http = NetworkClient();

  MessagesController({this.accessToken});

  Future<List<Message>> fetchAll() async {
    dynamic jsonResponse =
        await http.get('messages', {'Authorization': "$accessToken"});
    List<Message> messages;
    if (jsonResponse != null) {
      messages = [];
      for (var item in jsonResponse) {
        Message msg = Message.fromJson(item);
        messages.add(msg);
      }
    }
    return messages;
  }

  Future<bool> send(Message message) async {
    Map<String, dynamic> data = {
      'message': message.text,
      'user_id': message.userId
    };
    dynamic jsonResponse =
        await http.post('messages', data, {'Authorization': "$accessToken"});
    if (jsonResponse != null) {
      print(jsonResponse);
      return true;
    }
    return false;
  }
}
