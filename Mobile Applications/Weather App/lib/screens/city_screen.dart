import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

import 'loading_screen.dart';

class CityScreen extends StatefulWidget {
  @override
  _CityScreenState createState() => _CityScreenState();
}

class _CityScreenState extends State<CityScreen> {
  String cityNameInput;

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
      ),
      body: SafeArea(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          children: [
            Expanded(
              child: Container(
                decoration: BoxDecoration(
                  image: DecorationImage(
                    image: AssetImage('images/city_background.jpg'),
                    fit: BoxFit.cover,
                  ),
                ),
                child: Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Column(
                    children: [
                      TextField(
                        style: TextStyle(
                          fontSize: 15.0,
                          color: Colors.black,
                        ),
                        decoration: InputDecoration(
                          icon: Icon(
                            Icons.location_city,
                            color: Colors.white,
                          ),
                          filled: true,
                          fillColor: Colors.white,
                          hintText: 'Enter City name',
                          hintStyle: TextStyle(
                              color: Colors.grey.shade500, fontSize: 15.0),
                          border: OutlineInputBorder(
                            borderRadius:
                                BorderRadius.all(Radius.circular(10.0)),
                            borderSide: BorderSide.none,
                          ),
                        ),
                        onChanged: (value) {
                          setState(() {
                            cityNameInput = value;
                          });
                        },
                      ),
                      SizedBox(
                        height: 30.0,
                      ),
                      FlatButton(
                        onPressed: () {
                          print(cityNameInput);
                          if (cityNameInput != '' && cityNameInput != null)
                            Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) => LoadingScreen(
                                  cityName: cityNameInput.trim(),
                                ),
                              ),
                            );
                        },
                        child: Text(
                          'Get Weather',
                          style: TextStyle(
                            fontSize: 20.0,
                            color: Colors.white,
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
