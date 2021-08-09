import 'package:flutter/material.dart';

import 'screens/InputPage.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'BMI Calculator',
      theme: ThemeData.dark().copyWith(
        scaffoldBackgroundColor: Color.fromARGB(255, 13, 16, 31),
        primaryColor: Color.fromARGB(255, 13, 16, 31),
      ),
      home: Scaffold(
        appBar: AppBar(
          shadowColor: Colors.greenAccent,
          title: Text('BMI Calculator'),
          centerTitle: true,
        ),
        body: SafeArea(
          child: InputPage(),
        ),
      ),
    );
  }
}
