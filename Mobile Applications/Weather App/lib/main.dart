import 'package:flutter/material.dart';
import 'package:clima/screens/loading_screen.dart';

void main() {
  runApp(MyApp());
}

// Weather API KEY: b53184fbda40620bd22ddbc3f761dbdf
// api.openweathermap.org/data/2.5/weather
class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      theme: ThemeData.dark(),
      home: LoadingScreen(),
    );
  }
}
