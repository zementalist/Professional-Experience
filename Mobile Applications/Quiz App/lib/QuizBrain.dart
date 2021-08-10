import 'Question.dart';

class QuizBrain {
  List<Question> _questions = [
    Question('Frustration is a negative and a positive motive ?', true),
    Question(
        'When a father insult his child repetitively, the child\'s mental performance degrades when being with his father ?',
        true),
    Question('Humor is one of the dark methods of emotional attraction', false),
    Question(
        'Introverted Intuition is the cognitive function that turns a collection of concepts into a pattern ?',
        true),
    Question(
        'Extroverted Sensing is the cognitive function that depends on the past experiences & tried and true method ?',
        false),
    Question('Psych is divided into 3 categories: Ego, Superego and Id', true),
    Question(
        'Fearful avoidant usually rejects intimacy because of fear ?', false),
    Question(
        'Regression is projecting one\'s behavior and characteristics on others ?',
        false),
  ];

  int questionNumber = 0;
  bool isFinished = false;

  int countQuestions() {
    return _questions.length;
  }

  String getQuestion() {
    return _questions[questionNumber].getText();
  }

  bool getAnswer() {
    return _questions[questionNumber].getAnswer();
  }

  int nextQuestion() {
    if (questionNumber < _questions.length - 1) {
      return questionNumber++;
    } else {
      isFinished = true;
      return questionNumber;
    }
  }

  void reset() {
    questionNumber = 0;
    isFinished = false;
  }
}
