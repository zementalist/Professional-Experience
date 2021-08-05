import 'package:flutter/cupertino.dart';
import 'dart:convert';
import 'package:http/http.dart' as http;

class Network {
  final String endpoint;
  Network({@required this.endpoint});

  dynamic getData() async {
    http.Response response = await http.get(endpoint);
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      print(response.statusCode);
      return null;
    }
  }
}
