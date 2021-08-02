import 'package:chat/components/AuthButton.dart';
import 'package:chat/components/AuthTextInput.dart';
import 'package:flutter/material.dart';

class RegistrationScreen extends StatefulWidget {
  static const String id = 'registration_screen';
  @override
  _RegistrationScreenState createState() => _RegistrationScreenState();
}

class _RegistrationScreenState extends State<RegistrationScreen> {
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();

  String _username;
  String _email;
  String _password;
  String _confirmPassword;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Center(
            child: Image(
              image: AssetImage('images/logo.png'),
              height: 100.0,
            ),
          ),
          Form(
            key: _formKey,
            child: Column(
              children: [
                AuthTextInput(
                  labelText: 'Username',
                  keyboardType: TextInputType.name,
                  onSaved: (value) {
                    // YOU CAN't HAVE ONSAVED & ONCHANGED TOGETHER
                    setState(() {
                      _username = value;
                    });
                  },
                  validator: (value) {
                    if (value.isEmpty) {
                      return 'Invalid username!';
                    }
                  },
                ),
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
                  obscureText: true,
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
                AuthTextInput(
                  labelText: 'Confirm Password',
                  obscureText: true,
                  onSaved: (value) {
                    setState(() {
                      _password = value;
                    });
                  },
                  validator: (value) {
                    if (value.length < 8) {
                      return 'Password must be at least 8 characters';
                    }
                    if (value != _password)
                      return 'Password doesn\'t match confirmation';
                  },
                ),
                SizedBox(
                  height: 30,
                ),
                AuthButton(
                    text: 'Register',
                    backgroundColor: Colors.blue.shade400,
                    onPressed: () {
                      if (!_formKey.currentState.validate())
                        return false;
                      else if (_email == 'zeyad@gmail.com' &&
                          _password == '123')
                        Navigator.pushNamed(context, '/chat');
                    }),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
