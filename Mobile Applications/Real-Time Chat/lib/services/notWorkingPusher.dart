// import 'package:pusher_client/pusher_client.dart';
//
// class Pusher {
//   PusherClient pusher;
//   final String appKey = '550e330b9283050b4c09';
//   final String host = 'https://zementalist.azurewebsites.net';
//   final String authEndpoint =
//       'https://zementalist.azurewebsites.net/broadcasting/auth';
//
//   Future<PusherClient> init({String token}) async {
//     PusherOptions options = PusherOptions(
//         auth: PusherAuth(
//           authEndpoint,
//           headers: {'Authorization': 'Bearer $token'},
//         ),
//         cluster: 'mt1',
//         encrypted: true);
//
//     pusher = PusherClient(appKey, options, autoConnect: false);
//
// // connect at a later time than at instantiation.
//     await pusher.connect();
//     pusher.onConnectionStateChange((state) {
//       print(
//           "previousState: ${state.previousState}, currentState: ${state.currentState}");
//     });
//
//     pusher.onConnectionError((error) {
//       print("error: ${error.message}");
//     });
//
//     return pusher;
//   }
// }
