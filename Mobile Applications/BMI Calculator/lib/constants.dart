import 'package:flutter/material.dart';

int kDefaultWeight = 70, kDefaultHeight = 170, kDefaultAge = 25;
int kMinWeight = 5, kMaxWeight = 200;
int kMinHeight = 120, kMaxHeight = 220;
int kMinAge = 1, kMaxAge = 110;

const Color kCardForegroundColor = Color.fromARGB(255, 27, 28, 44);
const Color kActiveCardColor = Color.fromARGB(255, 27, 28, 44);
const Color kCardBorderColor = Colors.greenAccent;
const Color kCardTitleColor = Color(0xFFFF757575);
const Color kCardDigitColor = Colors.white;

const kMeasureTextStyle = TextStyle(
  fontWeight: FontWeight.bold,
);
const kCardTitleStyle = TextStyle(
  color: kCardTitleColor,
  fontSize: 20.0,
);
const kCardDigitStyle = TextStyle(
  fontSize: 28.0,
  fontWeight: FontWeight.bold,
);

const kResultTitleStyle =
    TextStyle(fontSize: 20.0, fontWeight: FontWeight.bold);

const Map<String, Color> kBMIclassesColors = {
  'UNDERWEIGHT': Colors.yellowAccent,
  'HEALTHY': Color(0xFFFF00E676),
  'OVERWEIGHT': Colors.yellowAccent,
  'OBESE': Colors.red,
};

const Map<String, String> kBMIclassesTips = {
  'UNDERWEIGHT':
      'You have a lower than normal body weight. You can eat a bit more.',
  'HEALTHY': 'You have a normal body weight. Good job!',
  'OVERWEIGHT':
      'You have a higher than normal body weight. Try to exercise more.',
  'OBESE': 'You have a higher than normal body weight. Try to exercise more.',
};
