from dashboard.views import index
from learningstyle.models import VAK
from django.contrib.auth.models import User
from django.shortcuts import render, redirect
from .forms import LoginForm, RegisterationForm
from django.contrib.auth.hashers import make_password
from django.contrib.auth.decorators import login_required
from django.contrib.auth import authenticate, login, logout

# Create your views here.

def login_scenario(request):
    # Init login form
    form = LoginForm(request.POST or None)
    # if this is a GET request -> show form
    if request.method == "GET":
        context = {
            'form' : form
        }
        return render(request, 'auth2/login.html', context)
    # else if this is POST request -> try login user
    elif request.method == "POST":
        # Find user by email (since django auth is by default using username to login)
        email, password = request.POST['email'], request.POST['password']
        user = User.objects.get(email=email)
        # if user exists -> check passwords matching
        if user is not None:
            user = authenticate(username=user.username, password=password)
            # if password is correct -> append username to the request
            # so django auth 'login' function can use it for login
            if user is not None:
                post = request.POST.copy()
                post['username'] = user.username
                request.POST = post
                login(request, user)
                # get previous url to check if there is a 'next' parameter
                previous_url = request.META.get('HTTP_REFERER')
                try:
                    # Extract the value of 'next'
                    next_param_value = previous_url[previous_url.index('next')+5:]
                except:
                    next_param_value = None
                # if 'next' parameter exists, use its value to redirect user to it
                if next_param_value is not None:
                    return redirect(next_param_value)
                else:
                    return redirect('dashboard')
            # password is incorrect
            else:
                context = {
                    'alert' : {
                        'type' : 'danger',
                        'message' : ' Invalid username or password.'
                    },
                    'form':form
                }
                return render(request, 'auth2/login.html', context)
        # email is not registerd/found
        else:
            context = {
                'alert' : {
                    'type' : 'danger',
                    'message' : 'This email is not registered.'
                }
            }
            return render(request, 'login.html', context)
    # request is neither POST nor GET
    else:
        return redirect('/account/login')

    
def register(request):
    # Init registration form
    form = RegisterationForm(request.POST or None)
    if request.method == "POST":
        if form.is_valid():
            # encrypt password
            raw_password = form.cleaned_data['password']
            form.cleaned_data['password'] = make_password(form.cleaned_data['password'])
            # create user
            user = form.save()
            # login user
            login(request, user)
            # create 'Learning Style (VAK)' row for the user
            VAK.objects.create(user=user)
            return redirect('/dashboard')
        else:
            # Form is invalid
            context = {
                'form' : form
            }
            return render(request, 'auth2/register.html', context)

    elif request.method == "GET":
        context = {
            'form' : form
        }
        return render(request, 'auth2/register.html', context)
    # request is neither POST nor GET
    else:
        return redirect('/account/register')

        
@login_required
def logout_user(request):
    logout(request)
    return redirect('/account/login')
