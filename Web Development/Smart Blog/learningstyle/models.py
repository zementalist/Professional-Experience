from django.db import models
from django.contrib.auth.models import User
from datetime import datetime

# Create your models here.

class VAK(models.Model):
    user = models.ForeignKey(User, on_delete=models.CASCADE)
    visual = models.PositiveSmallIntegerField(default=0)
    auditory = models.PositiveSmallIntegerField(default=0)
    kinesthetic = models.PositiveSmallIntegerField(default=0)
    updated_at = models.DateTimeField(default = datetime.now, blank=True)

    def get_learning_style(self, user_id):
        # Function to extract the learning style of a user
        styles = ['visual', 'auditory', 'kinesthetic']
        # retireve the values of the 3 types for a specific user
        user_vak = self.objects.values_list(styles[0], styles[1], styles[2]).get(user=user_id)
        user_vak = list(user_vak)
        # get the max value of the 3 types, get its name, capitlize it
        learning_style = styles[user_vak.index(max(user_vak))] # readability ;)
        return learning_style.capitalize()
