from django.urls import path, include
from . import views

urlpatterns = [
    path('store', views.store, name='store_comment'), # POST (CREATE)
    path('<int:comment_id>/delete', views.destroy, name='delete_post'),  # Delete (DELETE)
]