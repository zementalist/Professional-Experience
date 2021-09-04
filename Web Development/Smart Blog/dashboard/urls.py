from django.urls import path, include
from . import views

urlpatterns = [
    path('', views.index, name='dashboard'),
    path('<int:user_id>', views.get_user_posts, name="user_posts"), # posts of specific user
    
]