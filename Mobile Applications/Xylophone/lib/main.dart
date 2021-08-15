import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:audioplayers/audio_cache.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatefulWidget {
  @override
  _MyAppState createState() => _MyAppState();
}

class _MyAppState extends State<MyApp> {
  Expanded createButton({Color color, int soundNumber}) {
    return Expanded(
      child: FlatButton(
        color: color,
        onPressed: () {
          final player = AudioCache(prefix: 'audio/');
          player.play('note$soundNumber.wav', stayAwake: true);
        },
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: Scaffold(
        backgroundColor: Colors.black,
        body: SafeArea(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
              createButton(color: Colors.teal.shade700, soundNumber: 1),
              createButton(color: Colors.teal.shade600, soundNumber: 2),
              createButton(color: Colors.teal.shade500, soundNumber: 3),
              createButton(color: Colors.teal.shade400, soundNumber: 4),
              createButton(color: Colors.teal.shade300, soundNumber: 5),
              createButton(color: Colors.teal.shade200, soundNumber: 6),
              createButton(color: Colors.teal.shade100, soundNumber: 7),
            ],
          ),
        ),
      ),
    );
  }
}
