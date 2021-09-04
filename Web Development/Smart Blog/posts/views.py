import json
from .models import Post
from datetime import datetime
from django.db.models import Q
from django.urls import reverse
from django.core import serializers
from comments.models import Comment
from learningstyle.models import VAK
from learningstyle.views import classify
from django.contrib.auth.models import User
from django.contrib.auth import authenticate
from django.http import HttpResponse, JsonResponse
from django.contrib.auth.decorators import login_required
from django.shortcuts import render, redirect, get_object_or_404


# Create your views here.

def get_related_posts(user_id, post_id):
    # Function to get the most 3 recent posts written by a specific user
    related_posts = Post.objects.filter(Q(user_id=user_id) & ~Q(id=post_id)).order_by('-created_at')[:3]
    # truncate posts contents
    related_posts = Post.truncate_posts_body(related_posts, 43)
    return related_posts

def index(request):
    # Function to return all posts
    posts = Post.objects.all()
    context = {
        'posts': posts
    }
    return render(request, 'posts/index.html', context)

def show(request, id):
    # Function to show a single post
    # Get post , its comments, its related posts, user's learning style
    post = get_object_or_404(Post, id=id)
    comments = Comment.objects.filter(post = post.id)
    related_posts = get_related_posts(post.user.id, post.id)
    user_learning_style = VAK.get_learning_style(VAK, post.user_id)

    context = {
        'post' : post,
        'comments' : comments,
        'related_posts' : related_posts,
        'user_learning_style': user_learning_style
    }
    return render(request, 'posts/show.html', context)

@login_required
def create(request):
    # Functionn to show post_creation_form template
    return render(request, 'posts/create.html')

@login_required
def store(request):
    # Function to store new post
    if request.method == "POST":
        # Recieve form data & Create new post
        title, body, image, user = request.POST['title'], request.POST['body'], request.POST['image'], request.user
        new_post = Post.objects.create(title=title, body=body, image=image, user=user)
        # classify post body to determine writer's learning style
        classify(new_post)
        # get rleated posts (written by the same user)
        related_posts = get_related_posts(new_post.user.id, new_post.id)
        context = {
            'post' : new_post,
            'related_posts' : related_posts,
            'comments': None # No comments on the new posts yet
        }
        return render(request, 'posts/show.html', context)
    else:
        # request method is not POST
        return redirect('/dashboard')

@login_required
def edit(request, id):
    # Function to show post_editing_form template
    if request.method == "GET":
        post = get_object_or_404(Post, id=id)
        # if post exists
        if post is not None:
            context = {
                'post' : post
            }
            # if the user requesting edit, is the same user who wrote the post
            if request.user.id == post.user.id:
                return render(request, 'posts/edit.html', context)
            else:
                # user is trying to edit someone else's post
                context['alert'] = {
                    'type':'danger',
                    'message':"You can't edit others posts'"
                }
                return render(request, 'posts/show.html', context)
        else:
            # Post is not found
            return render(request, 'posts/not_found.html')
    else:
        # request method is not GET
        return redirect('/dashboard')

@login_required
def update(request, id):
    # Function to update a row of existing post
    if request.method == "POST":
        # check that request method is PUT
        _method = request.POST['_method'].upper()
        if _method == "PUT":
            # check that post exists
            post = Post.objects.get(id = id)
            if post is not None:
                # Recieve new data & Update post
                title, body, image = request.POST['title'], request.POST['body'], request.POST['image']
                post.title = title
                post.body = body
                post.image = image
                post.updated_at = datetime.now()
                post.save()
                # Classify post body to determine writer's learning style
                classify(post)
                # get related post, to redirect user to the updated post
                related_posts = get_related_posts(post.user.id, post.id)
                context = {
                    'post' : post,
                    'related_posts' : related_posts,
                    'alert' : {
                        'type' : 'success',
                        'message' : 'Your post is updated successfully.'
                    }
                }
                return render(request, 'posts/show.html', context)
            else:
                # Post is not found
                return render(request, 'posts/not_found.html')
        else:
            # request method is not PUT
            return redirect('/dashboard')
    else:
        # request method is not POST
        return redirect('/dashboard')

@login_required
def destroy(request, id):
    # Function to delete existing post
    if request.method == 'POST':
        _method = request.POST['_method'].upper()
        if _method == "DELETE":
            # Init context & retrieve post
            context = {}
            post = Post.objects.get(id = id)
            # if post exists -> delete it
            if post is not None:
                post.delete()
                # Return success message
                context = {
                    'alert': {
                        'type' : 'success',
                        'message' : 'Your post is removed successfully'
                    }
                }
            else:
                # Post is not found, return fail message
                context ={
                    'alert': {
                        'type' : 'danger',
                        'message' : 'Something went wrong, please try again.'
                    }
                }
            # assign alert to session, to redirect with context
            request.session['alert'] = context['alert']
            return redirect('/dashboard/' + str(request.user.id))
        else:
            # request method is not DELETE
            return redirect('/dashboard')
    else:
        # request method is not POST
        return redirect('/dashboard')


