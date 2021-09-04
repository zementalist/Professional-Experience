import json
from .models import Comment
from posts.models import Post
from django.core import serializers
from django.http import JsonResponse
from django.shortcuts import redirect
from learningstyle.views import classify
from django.contrib.auth.decorators import login_required

# NOTE: this view works as an API, not django.forms

@login_required
def store(request):
    # Method to store new row-item in the database
    if request.method == "POST":
        # decode request parameters using JSON
        decoded_request = json.loads(request.body.decode('utf-8'))
        body, post_id, user_id = decoded_request['body'], decoded_request['post_id'], request.user.id
        # retrieve the post from DB
        post = Post.objects.get(id=post_id)
        if post is not None:
            # create comment & classify its body to detemine user's learning style
            comment = Comment.objects.create(body=body, post_id=post_id, user_id=user_id)
            classify(comment)
            # convert Comment instance into JSON object
            serialized_comment = serializers.serialize('json', [comment])
            jsoned_comment = json.loads(serialized_comment)[0]['fields']
            # assign comment_id to the object
            jsoned_comment['id'] = comment.id
            return JsonResponse({'success':1, 'comment':jsoned_comment})
        else:
            # Post doesn't exist anymore
            return JsonResponse({
                'success':0,
                'alert': {
                    'type':'danger',
                    'message':'You cannot comment on a post that does not exist.'
                }
            })
    else:
        # request method is not POST
        return redirect('dashboard')


@login_required
def destroy(request, comment_id):
    if request.method == 'DELETE':
        comment = Comment.objects.get(id=comment_id)
        if comment is not None:
            # check that the user can delete his own comments only
            if request.user.id == comment.user.id:
                comment.delete()
                return JsonResponse({
                    'success': 1, 
                    'alert': {
                        'type':'success',
                        'message' : 'Your comment is deleted successfully.'
                        }
                    })
            else:
                # user is trying to delete a comment for another user (not allowed in client anyway)
                return JsonResponse({
                    'success': 0, 
                    'alert': {
                        'type' : 'danger',
                        'message' : 'You cannot delete this comment!'
                        }
                    })
        else:
            # comment doesn't exist or already deleted
            return JsonResponse({
                'success': 0, 
                'alert': {
                    'type' : 'danger',
                    'message' : 'Comment is not found'
                    }
                })
    else:
        # request is not of type DELETE
        return JsonResponse({
            'success':0,
            'alert': {
                'type' : 'info',
                'message' : 'Method is not supported for this route'
            }
        })
