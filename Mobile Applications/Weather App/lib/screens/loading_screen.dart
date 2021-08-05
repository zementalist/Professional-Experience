import 'package:clima/screens/city_screen.dart';
import 'package:flutter/material.dart';
import 'package:clima/services/weather.dart';
import 'package:clima/services/location.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';

import 'failed_screen.dart';
import 'location_screen.dart';

class LoadingScreen extends StatefulWidget {
  final String cityName; // optional
  LoadingScreen({this.cityName});

  @override
  _LoadingScreenState createState() => _LoadingScreenState();
}

class _LoadingScreenState extends State<LoadingScreen> {
  String statusMessage;
  String cityName;

  void fetchLocationWeather() async {
    Location location = Location();
    WeatherModel weather = WeatherModel();

    setState(() {
      statusMessage = 'Fetching Location';
    });
    await location.getCurrentLocation();

    setState(() {
      statusMessage = 'Fetching Weather Data';
    });

    await weather.getLocationWeather(location);
    if (weather.condition != null)
      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (context) => LocationScreen(
            weatherObject: weather,
          ),
        ),
      );
  }

  void fetchWeatherByCity(cityName) async {
    setState(() {
      statusMessage = 'Fetching Weather of $cityName';
    });

    WeatherModel weather = WeatherModel();

    await weather.getCityWeather(cityName);

    if (weather.condition != null)
      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (context) => LocationScreen(
            weatherObject: weather,
          ),
        ),
      );
    else {
      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (context) => FailedScreen(),
        ),
      );
    }
  }

  @override
  void initState() {
    super.initState();
    if (widget.cityName == null)
      fetchLocationWeather();
    else
      fetchWeatherByCity(widget.cityName);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [
          Text(
            statusMessage,
            style: TextStyle(fontSize: 30.0, color: Colors.white),
          ),
          SpinKitRipple(
            color: Colors.white,
            size: 200.0,
          ),
        ],
      ),
    );
  }
}
