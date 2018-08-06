from django.shortcuts import render, get_object_or_404
from django.template import loader
from django.utils import timezone
from django.urls import reverse
from django.http import HttpResponse, Http404, HttpResponseRedirect


def index(request):
    context = {
        'title': 'Joe Polygon',
        'sections': ["Programming", "School", "Artistry", "Inspiration"]
    }

    # template = loader.get_template('polls/index.html')
    # return HttpResponse(template.render(context, request))
    # replace the above with the shortcut "render" function
    return render(request, 'portfolio/index.html', context)

# <hr />
# {% load static %}
# <img src="{% static "polls/images/logo_wide_small.jpg" %}" alt="My image">
# <hr />
