import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:bmi_calculator/components/CardListTile.dart';
import 'package:bmi_calculator/components/DetailsCard.dart';
import 'package:bmi_calculator/components/NavigationButton.dart';
import 'ResultPage.dart';
import 'package:bmi_calculator/components/ReusableCard.dart';
import 'package:bmi_calculator/constants.dart';

enum Gender { male, female }

class InputPage extends StatefulWidget {
  @override
  _InputPageState createState() => _InputPageState();
}

class _InputPageState extends State<InputPage> {
  bool maleCardSelected = false;
  bool femaleCardSelected = false;

  void switchCardState({@required Gender selectedGender}) {
    if (selectedGender == Gender.male) {
      maleCardSelected = !maleCardSelected;
      femaleCardSelected = false;
    } else {
      femaleCardSelected = !femaleCardSelected;
      maleCardSelected = false;
    }
  }

  int height = kDefaultHeight, weight = kDefaultWeight, age = kDefaultAge;

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Expanded(
          //flex: 2,
          child: Row(
            children: [
              Expanded(
                child: ReusableCard(
                  onPress: () {
                    setState(() {
                      switchCardState(selectedGender: Gender.male);
                    });
                  },
                  colour: kCardForegroundColor,
                  coloredBorder: maleCardSelected,
                  cardChild: CardListTile(
                    icon: Icon(
                      FontAwesomeIcons.mars,
                      size: 80.0,
                    ),
                    textContent: 'MALE',
                  ),
                ),
              ),
              Expanded(
                child: ReusableCard(
                  onPress: () {
                    setState(() {
                      switchCardState(selectedGender: Gender.female);
                    });
                  },
                  colour: kCardForegroundColor,
                  coloredBorder: femaleCardSelected,
                  cardChild: CardListTile(
                    icon: Icon(
                      FontAwesomeIcons.venus,
                      size: 80.0,
                    ),
                    textContent: 'FEMALE',
                  ),
                ),
              ),
            ],
          ),
        ),
        Expanded(
          //flex: 3,
          child: ReusableCard(
            colour: kCardForegroundColor,
            cardChild: DetailsCard(
              cardTitle: 'HEIGHT',
              digit: height,
              measurementUnit: 'CM',
              useSlider: true,
              twoUniqueHeroTags: ['a', 'b'],
              onChange: (double newValue) {
                setState(() {
                  height = newValue.round();
                });
              },
            ),
          ),
        ),
        Expanded(
          //flex: 2,
          child: Row(
            children: [
              Expanded(
                child: ReusableCard(
                  colour: kCardForegroundColor,
                  cardChild: DetailsCard(
                    cardTitle: 'Weight',
                    digit: weight,
                    measurementUnit: 'KG',
                    twoUniqueHeroTags: ['c', 'd'],
                    onPlusPressed: () {
                      if (weight < kMaxWeight)
                        setState(() {
                          weight++;
                        });
                    },
                    onMinusPressed: () {
                      if (weight > kMinWeight)
                        setState(() {
                          weight--;
                        });
                    },
                  ),
                ),
              ),
              Expanded(
                child: ReusableCard(
                  colour: kCardForegroundColor,
                  cardChild: DetailsCard(
                    cardTitle: 'Age',
                    digit: age,
                    twoUniqueHeroTags: ['e', 'f'],
                    onPlusPressed: () {
                      if (age < kMaxAge)
                        setState(() {
                          age++;
                        });
                    },
                    onMinusPressed: () {
                      if (age > kMinAge)
                        setState(() {
                          age--;
                        });
                    },
                  ),
                ),
              ),
            ],
          ),
        ),
        NavigationButton(
          textContent: 'Calculate BMI',
          onPressed: () {
            Navigator.push(
                context,
                MaterialPageRoute(
                    builder: (context) => ResultPage(
                          height: height,
                          weight: weight,
                        )));
          },
        ),
      ],
    );
  }
}
