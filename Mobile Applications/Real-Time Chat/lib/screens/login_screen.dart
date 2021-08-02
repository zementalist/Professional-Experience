import 'package:chat/components/AuthButton.dart';
import 'package:chat/components/AuthTextInput.dart';
import 'package:chat/models/User.dart';
import 'package:chat/screens/chat_screen.dart';
import 'package:chat/services/Authentication.dart';
import 'package:chat/services/NetworkClient.dart';
import 'package:chat/services/Pusher.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';

// import 'package:pusher_client/pusher_client.dart';

class LoginScreen extends StatefulWidget {
  static const String id = 'login_screen';
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();

  String _email;
  String _password;
  bool passwordHidden = true;
  String lastConnectionState;
  // Channel channel;
  // PusherClient pusher;
  // PusherEvent ev;

  // Future<void> initPusher() async {
  //   PusherOptions options = PusherOptions(
  //     // host: 'http://zementalist.azurewebsites.net/',
  //     encrypted: false,
  //     // auth: PusherAuth(
  //     //   'https://zementalist.azurewebsites.net/broadcasting/auth',
  //     //   headers: {
  //     //     'Authorization':
  //     //         'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvemVtZW50YWxpc3QuYXp1cmV3ZWJzaXRlcy5uZXRcL2xvZ2luQVBJIiwiaWF0IjoxNjE2MDE1MTIxLCJleHAiOjE2MTYwMTg3MjEsIm5iZiI6MTYxNjAxNTEyMSwianRpIjoiVzlCbkt3dVBuaTZNMkVOTyIsInN1YiI6OCwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.B_83l08mxvXRjXfND_GbSSXkbINg41FQiwydRoj9DlA',
  //     //   },
  //     // ),
  //   );
  //   try {
  //     await Pusher.init("550e330b9283050b4c09", options, enableLogging: true);
  //   } on PlatformException catch (e) {
  //     print(e.message);
  //   }
  //   await Pusher.connect(onConnectionStateChange: (x) async {
  //     if (mounted)
  //       setState(() {
  //         lastConnectionState = x.currentState;
  //       });
  //   }, onError: (x) {
  //     debugPrint("Error: ${x.message}");
  //   });
  //   Channel channel = await Pusher.subscribe('testa');
  //   channel.bind('testevent', (Event event) {
  //     setState(() {
  //       lastEvent = event;
  //     });
  //     print('Hi');
  //     print(event);
  //     print(lastEvent);
  //   });
  //   print(lastConnectionState);
  //   print(lastEvent);
  // }

//   void initPusher() async {
//     pusher = await Pusher().init(token: '');
// // Subscribe to a private channel
//     Channel channel = pusher.subscribe("presence-mylolchannel");
// // Bind to listen for events called "order-status-updated" sent to "private-orders" channel
//     channel.bind("pusher:subscription_succeeded", (PusherEvent event) {
//       print(event.data);
//       print('shit');
//     });
//
//     Channel channel2 = pusher.subscribe("private-chat");
//
// // Bind to listen for events called "order-status-updated" sent to "private-orders" channel
//     channel2.bind("MessageSent", (PusherEvent event) {
//       print(event.data);
//       setState(() {
//         ev = event;
//       });
//     });
//   }

  @override
  void initState() {
    // TODO: implement initState
    super.initState();
    //initPusher();
// connect at a later time than at instantiation.
  }

  @override
  void dispose() {
    // TODO: implement dispose
    super.dispose();
    // pusher.unsubscribe('presence-mylolchannel');
    // pusher.unsubscribe('private-chat');
    // pusher.disconnect();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Center(
            child: Hero(
              tag: 'logo',
              child: Image(
                image: AssetImage('images/logo.png'),
                height: 100.0,
              ),
            ),
          ),
          SizedBox(
            height: 30,
          ),
          Form(
            key: _formKey,
            child: Column(
              children: [
                AuthTextInput(
                  labelText: 'Email',
                  keyboardType: TextInputType.emailAddress,
                  onSaved: (value) {
                    // YOU CAN't HAVE ONSAVED & ONCHANGED TOGETHER
                    setState(() {
                      _email = value;
                    });
                  },
                  validator: (value) {
                    if (value.isEmpty) {
                      return 'Invalid email!';
                    }
                  },
                ),
                AuthTextInput(
                  labelText: 'Password',
                  obscureText: passwordHidden,
                  suffixIcon: GestureDetector(
                    onTap: () {
                      setState(() {
                        passwordHidden = !passwordHidden;
                      });
                    },
                    child: Icon(
                      Icons.remove_red_eye,
                      color: Colors.grey,
                    ),
                  ),
                  onSaved: (value) {
                    setState(() {
                      _password = value;
                    });
                  },
                  validator: (value) {
                    if (value.length < 8) {
                      return 'Password must be at least 8 characters';
                    }
                  },
                ),
                SizedBox(
                  height: 30,
                ),
                AuthButton(
                    text: 'Log In',
                    backgroundColor: Colors.lightBlue.shade300,
                    onPressed: () async {
                      if (_formKey.currentState.validate()) {
                        _formKey.currentState.save();
                        Authentication auth = Authentication();
                        User user = await auth.login(_email, _password);
                        if (user != null) {
                          Navigator.pushNamed(context, ChatScreen.id,
                              arguments: {'user': user});
                        }
                      } else {
                        print('Error');
                        return false;
                      }
                    }),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
