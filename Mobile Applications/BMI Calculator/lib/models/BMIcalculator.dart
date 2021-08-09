import 'package:flutter/material.dart';
import 'dart:math';
import '../constants.dart';

class BMIcalculator {
  final int height;
  final int weight;

  final Map<double, String> bmiClasses = {
    18.5: 'UNDERWEIGHT',
    24.9: 'HEALTHY',
    29.9: 'OVERWEIGHT',
    double.infinity: 'OBESE',
  };

  BMIcalculator({@required this.height, @required this.weight});

  double calcBMI() {
    double result = weight / pow(height / 100, 2);
    return result;
  }

  String classifyBMI(double bmi) {
    if (bmi == null) double bmi = calcBMI();
    for (double key in bmiClasses.keys) {
      if (bmi < key) {
        return bmiClasses[key];
      }
    }
    return 'UNDEFINED';
  }
}
