import 'dart:convert';

class User {
  final int id;
  final String name;
  final String email;
  final String token;

  User({this.id, this.name, this.email, this.token});

  factory User.fromJson(Map<String, dynamic> jsonData) {
    return User(
      id: jsonData['user']['id'] as int,
      name: jsonData['user']['name'] as String,
      email: jsonData['user']['email'],
      token: 'Bearer ' + jsonData['access_token'],
    );
  }
}
