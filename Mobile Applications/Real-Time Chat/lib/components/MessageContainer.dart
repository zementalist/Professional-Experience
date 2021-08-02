import 'dart:async';

import 'package:chat/models/Message.dart';
import 'package:flutter/material.dart';
import 'package:chat/extensions/StringExtension.dart';

class MessageContainer extends StatelessWidget {
  final List<Message> messages;
  final int clientID;

  const MessageContainer({@required this.messages, @required this.clientID});

  Widget buildContainer(Message message) {
    Color fontColor;
    Color backgroundColor;
    EdgeInsets containerPadding;
    CrossAxisAlignment containerAlignment;
    BorderRadius containerBorderRadius;
    Offset boxShadowOffset;
    if (clientID == message.userId) {
      fontColor = Colors.white;
      backgroundColor = Colors.lightBlueAccent.shade100;
      containerPadding = EdgeInsets.only(right: 8.0, top: 8.0);
      containerAlignment = CrossAxisAlignment.end;
      containerBorderRadius = BorderRadius.only(
          topLeft: Radius.circular(15.0),
          bottomLeft: Radius.circular(15.0),
          bottomRight: Radius.circular(15.0));
      boxShadowOffset = Offset(-1, 2);
    } else {
      fontColor = Colors.black;
      backgroundColor = Colors.white;
      containerPadding = EdgeInsets.only(left: 8.0, top: 8.0);
      containerAlignment = CrossAxisAlignment.start;
      containerBorderRadius = BorderRadius.only(
          topRight: Radius.circular(15.0),
          bottomLeft: Radius.circular(15.0),
          bottomRight: Radius.circular(15.0));
      boxShadowOffset = Offset(1, 2);
    }

    return Container(
      width: double.infinity,
      child: Padding(
        padding: containerPadding,
        child: Column(
          crossAxisAlignment: containerAlignment,
          children: [
            Text(message.username.capitalize()),
            Container(
              padding: EdgeInsets.all(8.0),
              decoration: BoxDecoration(
                  color: backgroundColor,
                  borderRadius: containerBorderRadius,
                  boxShadow: [
                    BoxShadow(
                      color: Colors.grey.shade300,
                      spreadRadius: 1,
                      blurRadius: 2,
                      offset: boxShadowOffset,
                    )
                  ]),
              child: Text(message.text),
            ),
          ],
        ),
      ),
    );
  }

  List<Widget> addContainer(
      List<Widget> currentContainers, Message newMessage) {
    currentContainers.add(buildContainer(newMessage));
    return currentContainers;
  }

  @override
  Widget build(BuildContext context) {
    // Automatically scroll to bottom of chat
    ScrollController scrollController = ScrollController();
    Timer(Duration(milliseconds: 300), () {
      if (scrollController.hasClients)
        scrollController.jumpTo(scrollController.position.maxScrollExtent);
    });

    // Create array of widgets (messages)
    List<Widget> messagesWidget = [];
    for (Message msg in messages) {
      messagesWidget.add(buildContainer(msg));
    }

    return Expanded(
      child: ListView(
        controller: scrollController,
        children: messagesWidget,
      ),
    );
  }
}
