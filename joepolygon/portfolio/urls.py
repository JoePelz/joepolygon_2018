from django.urls import path

from . import views

# namespace
app_name = 'portfolio'

urlpatterns = [
    # ex: /portfolio/
    path('', views.index, name='index'),
    # # ex: /articles/rix/
    path('articles/<str:article_path>/', views.article, name='article'),
]
