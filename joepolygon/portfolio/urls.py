from django.urls import path

from . import views

# namespace
app_name = 'portfolio'

urlpatterns = [
    # ex: /portfolio/
    path('', views.index, name='index'),
    # /portfolio/articles/kaleidoscope/upload?url=<IMAGE_URL>
    path('articles/kaleidoscope/upload', views.upload, name='article'),
    # ex: /portfolio/articles/rix/
    path('articles/<str:article_path>/', views.article, name='article'),
]
