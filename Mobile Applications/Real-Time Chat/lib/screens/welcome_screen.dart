import 'package:chat/components/AuthButton.dart';
import 'package:chat/screens/login_screen.dart';
import 'package:chat/screens/registration_screen.dart';
import 'package:chat/services/Pusher.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:http/http.dart';

class WelcomeScreen extends StatefulWidget {
  static const String id = 'welcome_screen';
  @override
  _WelcomeScreenState createState() => _WelcomeScreenState();
}

class _WelcomeScreenState extends State<WelcomeScreen>
    with TickerProviderStateMixin {
  String header; // Header title to be displayed
  AnimationController typingAnimator; // Type chracters of header
  AnimationController
      cursorAnimator; // Toggle show/hide cursor when finished typing/deleting characters of header
  @override
  void initState() {
    // TODO: implement initState
    super.initState();
    header = 'Onism';
    typingAnimator = AnimationController(
        duration: Duration(seconds: 1),
        vsync: this,
        lowerBound: 0,
        upperBound: header.length.toDouble());

    // Automatically start typing
    typingAnimator.forward();
    typingAnimator.addListener(() {
      setState(() {});
    });

    // Handle timing logic
    typingAnimator.addStatusListener((status) async {
      // Typing finished
      if (status == AnimationStatus.completed) {
        cursorAnimator.forward();
        await Future.delayed(Duration(seconds: 3));
        cursorAnimator.stop();
        typingAnimator.reverse(); // start deleting characters
      }
      // Deleting finished
      else if (status == AnimationStatus.dismissed) {
        cursorAnimator.forward();
        await Future.delayed(Duration(seconds: 1));
        cursorAnimator.stop();
        typingAnimator.forward(); // start typing characters
      }
    });

    // Initialize cursor
    cursorAnimator =
        AnimationController(duration: Duration(milliseconds: 400), vsync: this);
    cursorAnimator.addListener(() {
      setState(() {});
    });

    // Loop toggling cursor
    cursorAnimator.addStatusListener((status) {
      if (status == AnimationStatus.completed) {
        cursorAnimator.reverse();
      } else if (status == AnimationStatus.dismissed) {
        cursorAnimator.forward();
      }
    });
  }

  @override
  void dispose() {
    // TODO: implement dispose
    super.dispose();
    typingAnimator.dispose();
    cursorAnimator.dispose();
  }

  @override
  Widget build(BuildContext context) {
    // Modify text
    String titleToShow = header.substring(0, typingAnimator.value.toInt());
    // show/hide cursor based on cursorAnimator value: if (value >= 0.5) {show cursor} else {hide}
    bool typingFinished = cursorAnimator.value.round() == 1;
    titleToShow += typingFinished ? '' : '|';
    titleToShow += titleToShow.contains('|') ? '' : ' ';

    return Scaffold(
      backgroundColor: Colors.white,
      body: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Hero(
                tag: 'logo',
                child: Image(
                  image: AssetImage('images/logo.png'),
                  width: 50,
                  fit: BoxFit.scaleDown,
                  alignment: Alignment.center,
                ),
              ),
              SizedBox(
                width: 15.0,
              ),
              Text(
                titleToShow,
                style: TextStyle(fontSize: 50, fontWeight: FontWeight.bold),
              ),
            ],
          ),
          SizedBox(height: 50.0),
          Column(
            children: [
              AuthButton(
                text: 'Log In',
                backgroundColor: Colors.lightBlue.shade300,
                onPressed: () {
                  Navigator.pushNamed(context, LoginScreen.id);
                },
              ),
              SizedBox(
                height: 20.0,
              ),
              AuthButton(
                text: 'Register',
                backgroundColor: Colors.blue.shade400,
                onPressed: () {
                  Navigator.pushNamed(context, RegistrationScreen.id);
                },
              ),
            ],
          ),
        ],
      ),
    );
  }
}
