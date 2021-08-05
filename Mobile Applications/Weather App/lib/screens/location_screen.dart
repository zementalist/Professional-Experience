import 'package:clima/services/weather.dart';
import 'package:flutter/material.dart';

import 'city_screen.dart';
import 'loading_screen.dart';

class LocationScreen extends StatelessWidget {
  final WeatherModel weatherObject;

  LocationScreen({@required this.weatherObject});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        automaticallyImplyLeading: false,
        centerTitle: true,
        title: Text('Weather'),
        leading: IconButton(
          icon: Icon(
            Icons.navigation,
            color: Colors.white,
          ),
          onPressed: () {
            Navigator.pushReplacement(context,
                MaterialPageRoute(builder: (context) => LoadingScreen()));
          },
        ),
        actions: [
          IconButton(
            icon: Icon(
              Icons.location_city,
              color: Colors.white,
            ),
            onPressed: () {
              Navigator.push(
                context,
                MaterialPageRoute(
                  builder: (context) => CityScreen(),
                ),
              );
            },
          ),
        ],
      ),
      body: SafeArea(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          children: [
            Expanded(
              child: Container(
                decoration: BoxDecoration(
                  image: DecorationImage(
                    image: AssetImage(
                        'images/${weatherObject.backgroundImageName}'),
                    fit: BoxFit.cover,
                  ),
                ),
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.spaceAround,
                  children: [
                    Text(
                      "${weatherObject.temperature.toInt()}° ${weatherObject.icon}",
                      style: TextStyle(
                          color: Colors.white,
                          fontSize: 70.0,
                          fontWeight: FontWeight.bold),
                    ),
                    Text(
                      weatherObject.description,
                      textAlign: TextAlign.center,
                      style: TextStyle(
                          color: Colors.white,
                          fontSize: 50.0,
                          fontWeight: FontWeight.bold),
                    ),
                    Text(
                      "${weatherObject.message} in ${weatherObject.city}",
                      textAlign: TextAlign.center,
                      style: TextStyle(
                          color: Colors.white,
                          fontSize: 50.0,
                          fontWeight: FontWeight.bold),
                    ),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
