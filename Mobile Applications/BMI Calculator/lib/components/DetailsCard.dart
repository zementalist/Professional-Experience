import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';

import 'package:bmi_calculator/constants.dart';

class DetailsCard extends StatelessWidget {
  final String cardTitle;
  final int digit;
  final String measurementUnit;
  final bool useSlider;
  final List<String> twoUniqueHeroTags;
  final Function onPlusPressed;
  final Function onMinusPressed;
  final Function onChange;

  DetailsCard({
    @required this.cardTitle,
    @required this.digit,
    @required this.twoUniqueHeroTags,
    this.measurementUnit = '',
    this.useSlider = false,
    this.onPlusPressed,
    this.onMinusPressed,
    this.onChange,
  });

  Widget createInputWidget() {
    if (useSlider) {
      return Slider(
        value: digit.toDouble(),
        min: kMinHeight.toDouble(),
        max: kMaxHeight.toDouble(),
        activeColor: kCardBorderColor,
        inactiveColor: kCardTitleColor,
        onChanged: onChange,
      );
    } else {
      return Padding(
        padding: const EdgeInsets.only(top: 10.0),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceEvenly,
          children: [
            FloatingActionButton(
              heroTag: twoUniqueHeroTags[0],
              onPressed: onMinusPressed,
              child: Icon(FontAwesomeIcons.minus),
            ),
            FloatingActionButton(
              heroTag: twoUniqueHeroTags[1],
              onPressed: onPlusPressed,
              child: Icon(FontAwesomeIcons.plus),
            ),
          ],
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Text(
          cardTitle,
          textAlign: TextAlign.center,
          style: TextStyle(
            fontSize: 28.0,
            color: kCardTitleColor,
          ),
        ),
        Row(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.baseline,
          children: [
            Text(
              digit.toString(),
              style: kCardDigitStyle,
            ),
            Text(
              measurementUnit,
              style: kMeasureTextStyle,
            )
          ],
        ),
        createInputWidget(),
      ],
    );
  }
}
