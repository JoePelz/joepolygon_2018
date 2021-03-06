from django.shortcuts import render, get_object_or_404
from django.template import loader
from django.utils import timezone
from django.urls import reverse
from django.http import HttpResponse, Http404, HttpResponseRedirect

from .models import Question, Choice


def index(request):
    latest_question_list = Question.objects.filter(
        published_at__lte=timezone.now()).order_by('-published_at')[:5]

    context = {'latest_question_list': latest_question_list}

    # template = loader.get_template('polls/index.html')
    # return HttpResponse(template.render(context, request))
    # replace the above with the shortcut "render" function
    return render(request, 'polls/index.html', context)


def detail(request, question_id):
    # try:
    #     question = Question.objects.get(pk=question_id)
    # except Question.DoesNotExist:
    #     raise Http404("Question does not exist")
    # replace the above with get_object_or_404
    question = get_object_or_404(Question, pk=question_id)
    if question.published_at > timezone.now():
        raise Http404
    context = {'question': question}
    return render(request, 'polls/detail.html', context)


def results(request, question_id):
    question = get_object_or_404(Question, pk=question_id)
    context = {'question': question}
    return render(request, 'polls/results.html', context)


def vote(request, question_id):
    question = get_object_or_404(Question, pk=question_id)
    try:
        selected_choice = question.choice_set.get(pk=request.POST['choice'])
    except (KeyError, Choice.DoesNotExist):
        # Redisplay the question voting form.
        return render(request, 'polls/detail.html', {
            'question': question,
            'error_message': "You didn't select a choice.",
        })
    else:
        selected_choice.votes += 1
        selected_choice.save()
        # Always return an HttpResponseRedirect after successfully dealing
        # with POST data. This prevents data from being posted twice if a
        # user hits the Back button.
        return HttpResponseRedirect(reverse('polls:results', args=(question.id,)))