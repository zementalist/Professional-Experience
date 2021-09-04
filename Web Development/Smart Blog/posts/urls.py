from django.urls import path, include
from . import views

urlpatterns = [

    #path('', views.?, name='??'), This route is the same as /dashboard
    path('create', views.create, name="create_post"), # GET
    path('store', views.store, name="store_post"), # POST
    path('<int:id>', views.show, name='show_post'), # GET  (READ)
    path('<int:id>/edit', views.edit, name='edit_post'), # GET
    path('<int:id>/update', views.update, name='update_post'), # PUT (UPDATE)
    path('<int:id>/delete', views.destroy, name='delete_post')  # Delete (DELETE)
]