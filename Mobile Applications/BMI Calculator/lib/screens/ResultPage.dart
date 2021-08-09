import 'file:///C:/Users/Zeyad/AndroidStudioProjects/bmi_calculator/lib/models/BMIcalculator.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

import 'package:bmi_calculator/components/NavigationButton.dart';
import 'package:bmi_calculator/components/ReusableCard.dart';
import 'package:bmi_calculator/constants.dart';

class ResultPage extends StatelessWidget {
  final int weight;
  final int height;

  ResultPage({@required this.weight, @required this.height});

  @override
  Widget build(BuildContext context) {
    BMIcalculator bmiCalculator = BMIcalculator(height: height, weight: weight);
    double bmi = bmiCalculator.calcBMI();
    String bmiClass = bmiCalculator.classifyBMI(bmi);
    String bmiTip = kBMIclassesTips[bmiClass];

    return Scaffold(
      appBar: AppBar(
        shadowColor: Colors.greenAccent,
        title: Text('BMI Calculator'),
        centerTitle: true,
      ),
      body: SafeArea(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          children: [
            Expanded(
              //flex: 3,
              child: ReusableCard(
                colour: kCardForegroundColor,
                cardChild: Column(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                  children: [
                    Text(
                      'Your Result:',
                      style: TextStyle(fontSize: 32.0),
                    ),
                    Text(
                      bmiClass,
                      style: TextStyle(
                          fontSize: 20.0,
                          color: kBMIclassesColors[bmiClass],
                          fontWeight: FontWeight.bold),
                    ),
                    Text(
                      bmi.toStringAsFixed(1),
                      style: kCardDigitStyle.copyWith(fontSize: 62.0),
                    ),
                    Padding(
                      padding: const EdgeInsets.symmetric(
                          vertical: 0.0, horizontal: 20.0),
                      child: Text(
                        bmiTip,
                        textAlign: TextAlign.center,
                        style: TextStyle(
                          fontSize: 16.0,
                          fontWeight: FontWeight.w500,
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            ),
            NavigationButton(
              textContent: 'Recalculate',
              onPressed: () {
                Navigator.pop(context);
              },
            ),
          ],
        ),
      ),
    );
  }
}
