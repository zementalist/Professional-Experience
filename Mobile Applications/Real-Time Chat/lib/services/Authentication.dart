import 'NetworkClient.dart';
import 'package:chat/models/User.dart';

class Authentication {
  Future<User> login(String _email, String _password) async {
    Map<String, dynamic> data = {'email': _email, 'password': _password};
    NetworkClient http = NetworkClient();
    dynamic response = await http.post('loginAPI', data);
    User user;
    if (response != null) {
      try {
        user = User.fromJson(response);
      } on Exception catch (e) {
        throw Exception(response['errors']);
      }
    }
    return user; // if failed/incorrect -> null
  }
}
