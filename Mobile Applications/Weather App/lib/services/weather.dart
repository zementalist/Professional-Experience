import 'location.dart';
import 'networking.dart';

class WeatherModel {
  final String apiKey = 'b53184fbda40620bd22ddbc3f761dbdf';
  final String endpoint = 'http://api.openweathermap.org/data/2.5/weather';
  final List<String> availableImages = [
    'Thunderstorms',
    'Drizzle',
    'Rain',
    'Snow',
    'Mist',
    'Fog',
    'Clear',
    'Clouds',
  ];

  var condition;
  var temperature;
  String city;
  String description;
  String icon;
  String message;
  String backgroundImageName;

  Future getLocationWeather([Location location]) async {
    if (location == null) {
      location = Location();
      await location.getCurrentLocation();
    }
    String url =
        '$endpoint?lat=${location.latitude}&lon=${location.longitude}&appid=$apiKey&units=metric';
    dynamic weatherData = await Network(endpoint: url).getData();
    initializeProperties(weatherData);
  }

  Future getCityWeather(String cityName) async {
    String url = '$endpoint?q=$cityName&appid=$apiKey&units=metric';
    dynamic weatherData = await Network(endpoint: url).getData();
    initializeProperties(weatherData);
  }

  void initializeProperties(weatherData) {
    if (weatherData != null) {
      condition = weatherData['weather'][0]['id'];
      description = weatherData['weather'][0]['description'];
      temperature = weatherData['main']['temp'];
      city = weatherData['name'];
      icon = getWeatherIcon(condition);
      message = getMessage(temperature.toInt());
      backgroundImageName = getBackgroundImg(weatherData['weather'][0]['main']);
    }
  }

  String getWeatherIcon(int condition) {
    if (condition < 300) {
      return '🌩';
    } else if (condition < 400) {
      return '🌧';
    } else if (condition < 600) {
      return '☔️';
    } else if (condition < 700) {
      return '☃️';
    } else if (condition < 800) {
      return '🌫';
    } else if (condition == 800) {
      return '☀️';
    } else if (condition <= 804) {
      return '☁️';
    } else {
      return '🤷‍';
    }
  }

  String getMessage(int temp) {
    if (temp > 25) {
      return 'It\'s 🍦 time';
    } else if (temp > 20) {
      return 'Time for shorts and 👕';
    } else if (temp < 10) {
      return 'You\'ll need 🧣 and 🧤';
    } else {
      return 'Bring a 🧥 just in case';
    }
  }

  String getBackgroundImg(String category) {
    String imageName =
        availableImages.contains(category) ? '$category.jpg' : 'default.jpg';
    return imageName;
  }
}
