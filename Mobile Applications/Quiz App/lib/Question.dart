class Question {
  String _text;
  bool _answer;

  Question(String text, bool answer) {
    this._text = text;
    this._answer = answer;
  }

  String getText() {
    return this._text;
  }

  bool getAnswer() {
    return this._answer;
  }
}
