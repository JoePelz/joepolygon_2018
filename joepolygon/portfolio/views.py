from django.shortcuts import render, get_object_or_404
from django.template import loader
from django.utils import timezone
from django.urls import reverse
from django.http import HttpResponse, Http404, HttpResponseRedirect
from django.core.exceptions import ObjectDoesNotExist

from .models import Articles

def index(request):
    context = {
        'title': 'Joe Polygon',
        'section_names': Articles.all_section_names(),
        'sections': Articles.all_sections()
    }

    # template = loader.get_template('polls/index.html')
    # return HttpResponse(template.render(context, request))
    # replace the above with the shortcut "render" function
    return render(request, 'portfolio/index.html', context)


def article(request, article_path):
    try:
        article = Articles.find_by_path(article_path)
    except ObjectDoesNotExist:
        raise Http404

    context = {
        'title': article.name,
        'section_names': Articles.all_section_names(),
        'javascripts': article.scripts,
        'stylesheets': article.styles,
        'content_path': '{}/index.html'.format(article.asset_path)
    }
    return render(request, 'portfolio/article.html', context)
