import datetime

from django.db import models
from django.utils import timezone


class Question(models.Model):
    question_text = models.CharField(max_length=200)
    published_at = models.DateTimeField('date published')

    def __str__(self):
        return "({}) {}".format(self.id, self.question_text)

    def was_published_recently(self):
        now = timezone.now()
        ago = now - datetime.timedelta(days=1)
        return ago <= self.published_at <= now


class Choice(models.Model):
    question = models.ForeignKey(Question, on_delete=models.CASCADE)
    choice_text = models.CharField(max_length=200)
    votes = models.IntegerField(default=0)

    def __str__(self):
        return "({}) {}".format(self.id, self.choice_text)
