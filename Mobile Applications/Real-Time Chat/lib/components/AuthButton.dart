import 'package:flutter/material.dart';

class AuthButton extends StatelessWidget {
  final String text;
  final Color backgroundColor;
  final Function onPressed;

  AuthButton(
      {@required this.text,
      @required this.onPressed,
      this.backgroundColor = Colors.blue});

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(8.0),
      child: FlatButton(
        onPressed: onPressed,
        color: backgroundColor,
        child: Text(text),
        minWidth: double.infinity,
        height: 50.0,
        shape:
            RoundedRectangleBorder(borderRadius: BorderRadius.circular(50.0)),
      ),
    );
  }
}
// Container(
// margin: EdgeInsets.symmetric(vertical: 15.0, horizontal: 0.0),
// alignment: Alignment.center,
// decoration: BoxDecoration(
// color: backgroundColor, borderRadius: BorderRadius.circular(15.0)),
// padding: EdgeInsets.symmetric(vertical: 10.0, horizontal: 0.0),
// child: Text(text),
// ),
