from django.shortcuts import render
from django.contrib.auth.decorators import login_required
from posts.models import Post


import json

# Create your views here.

def index(request):
    # retrieve posts and truncate its content to 123 characters
    posts = Post.retrieve_truncate_posts(Post, 123)
    context = {
        "posts" : posts,
    }
    return render(request, 'dashboard/dashboard.html', context) 

@login_required
def get_user_posts(request, user_id):
    # retrieve posts and truncate its content to 123 characters
    posts = Post.objects.filter(user_id = user_id)
    truncated_posts = Post.truncate_posts_body(posts, 123)
    context = {
        'posts' : truncated_posts,
    }
    # this route is also the response to deleting a post, so
    # check if there was an alert from the previous route
    if request.session.get('alert', None):
        context['alert'] = request.session['alert']
        request.session['alert'] = None

    return render(request, 'dashboard/dashboard.html', context)
