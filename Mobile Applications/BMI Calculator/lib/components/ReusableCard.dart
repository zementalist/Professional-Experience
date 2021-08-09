import 'package:flutter/material.dart';
import 'package:bmi_calculator/constants.dart';

class ReusableCard extends StatelessWidget {
  final Color colour;
  final Widget cardChild;
  final bool coloredBorder;
  final Function onPress;

  ReusableCard(
      {@required this.colour,
      this.cardChild,
      this.coloredBorder = true,
      this.onPress});

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onPress,
      child: Container(
        child: cardChild,
        margin: EdgeInsets.fromLTRB(10.0, 10.0, 10.0, 10.0),
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(10),
          color: colour,
          boxShadow: [
            BoxShadow(
                color:
                    (coloredBorder ? kCardBorderColor : kCardForegroundColor),
                spreadRadius: 1),
          ],
        ),
      ),
    );
  }
}
