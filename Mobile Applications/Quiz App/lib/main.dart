import 'package:flutter/material.dart';
import 'package:quizzler/QuizBrain.dart';

import 'Question.dart';

void main() {
  runApp(Quizzler());
}

class Quizzler extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: Scaffold(
        backgroundColor: Colors.black,
        body: SafeArea(
          child: MyApp(),
        ),
      ),
    );
  }
}

class MyApp extends StatefulWidget {
  @override
  _MyAppState createState() => _MyAppState();
}

class _MyAppState extends State<MyApp> {
  List<Icon> scoreKeeper = [];
  QuizBrain quiz = QuizBrain();
  int correctIconNumber = 58956;
  int wrongIconNumber = 58974;

  void addCorrectIcon() {
    setState(() {
      scoreKeeper.add(
        Icon(
          Icons.check,
          color: Colors.green,
        ),
      );
      if (!quiz.isFinished) {
        print(quiz.nextQuestion());
      }
    });
  }

  void addWrongIcon() {
    setState(() {
      scoreKeeper.add(
        Icon(
          Icons.close,
          color: Colors.red,
        ),
      );
      if (!quiz.isFinished) {
        print(quiz.nextQuestion());
      }
    });
  }

  void evaluateAnswers(BuildContext context) {
    int correctAnswersCount = scoreKeeper
        .where((element) => element.icon.codePoint == correctIconNumber)
        .length;

    int numOfQuestions = quiz.countQuestions();

    AlertDialog alert = AlertDialog(
      title: Text("Score"),
      content: Text("Your result: $correctAnswersCount/$numOfQuestions"),
      actions: [
        FlatButton(
          child: Text("Reset"),
          onPressed: () {
            Navigator.pop(context);
            setState(() {
              quiz.reset();
              scoreKeeper.clear();
            });
          },
        ),
        FlatButton(
          child: Text("OK"),
          onPressed: () {
            Navigator.pop(context);
          },
        ),
      ],
    );
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return alert;
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.stretch,
      children: [
        Expanded(
          flex: 8,
          child: Center(
            child: Text(
              quiz.getQuestion(),
              textAlign: TextAlign.center,
              style: TextStyle(
                color: Colors.white,
                fontSize: 20.0,
                fontWeight: FontWeight.w600,
              ),
            ),
          ),
        ),
        Expanded(
          child: Padding(
            padding:
                const EdgeInsets.symmetric(vertical: 10.0, horizontal: 15.0),
            child: FlatButton(
              color: Colors.green,
              textColor: Colors.white,
              onPressed: () {
                if (!quiz.isFinished) {
                  bool correctAnswer = quiz.getAnswer();
                  bool userAnswer = true;

                  if (userAnswer == correctAnswer) {
                    addCorrectIcon();
                  } else {
                    addWrongIcon();
                  }

                  if (quiz.isFinished) {
                    evaluateAnswers(context);
                  }
                }
              },
              child: Text(
                'True',
                textAlign: TextAlign.center,
                style: TextStyle(
                  color: Colors.white,
                ),
              ),
            ),
          ),
        ),
        Expanded(
          child: Padding(
            padding:
                const EdgeInsets.symmetric(vertical: 10.0, horizontal: 15.0),
            child: FlatButton(
              color: Colors.red,
              textColor: Colors.white,
              onPressed: () {
                if (!quiz.isFinished) {
                  bool correctAnswer = quiz.getAnswer();
                  bool userAnswer = false;

                  if (userAnswer == correctAnswer) {
                    addCorrectIcon();
                  } else {
                    addWrongIcon();
                  }

                  if (quiz.isFinished) {
                    evaluateAnswers(context);
                  }
                }
              },
              child: Text(
                'False',
                textAlign: TextAlign.center,
                style: TextStyle(
                  color: Colors.white,
                ),
              ),
            ),
          ),
        ),
        Row(
          children: scoreKeeper,
        ),
      ],
    );
  }
}
