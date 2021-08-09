import 'package:flutter/material.dart';

class NavigationButton extends StatelessWidget {
  final String textContent;
  final Function onPressed;

  NavigationButton({@required this.textContent, this.onPressed});

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onPressed,
      child: Container(
        color: Colors.pink.shade400,
        margin: EdgeInsets.only(top: 10.0),
        width: double.infinity,
        height: 40.0,
        child: Center(
          child: Text(
            textContent,
            style: TextStyle(fontSize: 20.0),
          ),
        ),
      ),
    );
  }
}
