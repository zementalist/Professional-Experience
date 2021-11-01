"""FaceFactory URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/3.2/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.contrib import admin
from django.urls import path, include
from Home import views as home_views
from django.contrib.staticfiles.urls import staticfiles_urlpatterns
urlpatterns = [
    # path('admin/', admin.site.urls),
    path('', home_views.index, name='home'),
    path('detect/', include('detector.urls')),
    path('analyze/', include('analyzer.urls')),
    path('extract/', include('extractor.urls')),
]
urlpatterns += staticfiles_urlpatterns()