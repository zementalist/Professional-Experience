import 'package:flutter/material.dart';
import '../constants.dart';

class CardListTile extends StatelessWidget {
  final Icon icon;
  final String textContent;

  CardListTile({this.icon, this.textContent});

  @override
  Widget build(BuildContext context) {
    return Column(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        icon,
        SizedBox(
          height: 20.0,
        ),
        Text(
          textContent,
          style: kCardTitleStyle,
        )
      ],
    );
  }
}
