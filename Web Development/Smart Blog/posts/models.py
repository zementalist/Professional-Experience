from django.db import models
from django.contrib.auth.models import User
from datetime import datetime
from django.utils.text import Truncator
# Create your models here.


class Post(models.Model):
    title = models.CharField(max_length=100)
    body = models.TextField()
    image = models.CharField(max_length=200)
    user = models.ForeignKey(User, on_delete=models.CASCADE)
    created_at = models.DateTimeField(default = datetime.now, blank=True)
    updated_at = models.DateTimeField(default= datetime.now, blank=True)

    def retrieve_truncate_posts(self, n_chars):
        # Function to retrieve truncate posts contents into number of characters
        posts = self.objects.all()
        truncated_posts = self.truncate_posts_body(posts, n_chars)
        return truncated_posts

    def truncate_posts_body(post, n_chars):
        # Function to truncate posts contents into number of characters
        try:
            # this block will run safely if 'post' is an array of posts
            list_of_posts = post
            for single_post in list_of_posts:
                single_post.body = Truncator(single_post.body).chars(n_chars)
        except:
            # this block will run if 'post' is actually a single post instance
            post.body = Truncator(post.body).chars(n_chars)
        finally:
            return post