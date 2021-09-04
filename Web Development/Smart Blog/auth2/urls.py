from django.urls import path, include
from . import views

urlpatterns = [
    path('login', views.login_scenario, name='login_scenario'),
    path('register', views.register, name='register_scenario'),
    path('logout', views.logout_user, name='logout_user')
]