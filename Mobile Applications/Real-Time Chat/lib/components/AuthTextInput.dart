import 'package:flutter/material.dart';
import 'package:flutter/widgets.dart';

class AuthTextInput extends StatelessWidget {
  final String labelText;
  final TextInputType keyboardType;
  final bool obscureText;
  final Widget suffixIcon;
  final Function onChanged;
  final Function onSaved;
  final Function validator;

  AuthTextInput(
      {@required this.labelText,
      this.keyboardType,
      this.obscureText = false,
      this.suffixIcon,
      this.onChanged,
      this.onSaved,
      this.validator});

  InputBorder buildBorder({@required Color color, double width = 1}) {
    return OutlineInputBorder(
      borderSide: BorderSide(color: color, width: width),
      borderRadius: BorderRadius.circular(50.0),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8.0, horizontal: 16.0),
      child: TextFormField(
        decoration: InputDecoration(
          contentPadding: EdgeInsets.all(16),
          labelText: labelText,
          labelStyle: TextStyle(color: Colors.black26),
          enabledBorder: buildBorder(color: Colors.black26),
          focusedBorder: buildBorder(color: Colors.lightBlueAccent, width: 2),
          errorBorder: buildBorder(color: Colors.red, width: 2),
          focusedErrorBorder: buildBorder(color: Colors.red, width: 2),
          suffixIcon: suffixIcon,
        ),
        style: TextStyle(
          color: Colors.black,
        ),
        keyboardType: keyboardType,
        obscureText: obscureText,
        onChanged: onChanged,
        onSaved: onSaved,
        validator: validator,
      ),
    );
  }
}
