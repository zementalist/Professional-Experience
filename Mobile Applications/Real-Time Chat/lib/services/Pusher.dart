import 'package:chat/models/Message.dart';
import 'package:chat/services/MessagesController.dart';
import 'package:pusher_client/pusher_client.dart';

class Pusher {
  static PusherClient pusher;
  static const String appKey = '550e330b9283050b4c09';
  static const String authEndpoint =
      'https://zementalist.azurewebsites.net/broadcasting/auth';

  static Future<PusherClient> init({String token}) async {
    PusherOptions options = PusherOptions(
      cluster: 'mt1',
      encrypted: true,
      auth: PusherAuth(
        authEndpoint,
        headers: {
          'Authorization': token // includes Bearer
        },
      ),
    );

    pusher = PusherClient(appKey, options, autoConnect: false);

// connect at a later time than at instantiation.
    await pusher.connect();
    pusher.onConnectionStateChange((state) {
      print(
          "previousState: ${state.previousState}, currentState: ${state.currentState}");
    });

    pusher.onConnectionError((error) {
      print("error: ${error.message}");
    });

    return pusher;
  }
}
