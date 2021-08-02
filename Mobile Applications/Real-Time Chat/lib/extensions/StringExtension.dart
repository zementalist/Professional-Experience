extension StringExtension on String {
  String capitalize() {
    if (this.length == 1)
      return this.toUpperCase();
    else if (this.length > 1)
      return "${this[0].toUpperCase()}${this.substring(1).toLowerCase()}";
    else {
      return this;
    }
  }
}
