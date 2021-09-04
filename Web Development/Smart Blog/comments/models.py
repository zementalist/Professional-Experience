from django.db import models
from posts.models import Post
from django.contrib.auth.models import User
from datetime import datetime

# Create your models here.

class Comment(models.Model):
    body = models.TextField()
    post = models.ForeignKey(Post, on_delete=models.CASCADE)
    user = models.ForeignKey(User, on_delete=models.CASCADE)
    created_at = models.DateTimeField(default = datetime.now, blank=True)