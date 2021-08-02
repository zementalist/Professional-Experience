import 'package:flutter/material.dart';

class Message {
  int userId;
  String username;
  String text;

  Message({this.userId, @required this.username, @required this.text});

  factory Message.fromJson(Map<String, dynamic> json) {
    return Message(
      userId: json['user_id'],
      username: json['user']['name'],
      text: json['message'],
    );
  }
}
