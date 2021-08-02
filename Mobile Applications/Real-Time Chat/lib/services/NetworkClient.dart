import 'dart:convert';
import 'dart:io';

import 'package:http/http.dart' as http;

class NetworkClient {
  final String hostname;
  final Map<String, String> defaultHeaders = {
    'Content-Type': 'application/json'
  };

  NetworkClient({this.hostname = 'https://zementalist.azurewebsites.net/'});

  Future<dynamic> get(String endpoint, [Map<String, String> headers]) async {
    var jsonResponse;

    headers == null ? headers = defaultHeaders : headers.addAll(defaultHeaders);

    try {
      final response = await http.get(hostname + endpoint, headers: headers);
      jsonResponse = jsonDecode(response.body);
    } on SocketException catch (e) {
      throw SocketException('Error: No Internet Connection');
    }
    return jsonResponse;
  }

  Future<dynamic> post(String endpoint, Map<String, dynamic> data,
      [Map<String, String> headers]) async {
    var jsonResponse;
    headers == null ? headers = defaultHeaders : headers.addAll(defaultHeaders);

    try {
      final response = await http.post(
        hostname + endpoint,
        body: jsonEncode(data),
        headers: headers,
      );
      if (response.statusCode != 500)
        jsonResponse = jsonDecode(response.body);
      else
        throw Exception('Error: Something went wrong, please try later!');
    } on SocketException catch (e) {
      throw SocketException('Error: No Internet Connection');
    }
    return jsonResponse;
  }
}
