import os
import yaml

from django.db import models
from django.conf import settings


class Articles:
    def __load_data():
        path = os.path.join(settings.BASE_DIR, 'portfolio', 'data', 'articles.yml')
        data = []
        with open(path, 'r') as stream:
            try:
                data = yaml.safe_load(stream)
            except yaml.YAMLError as exc:
                print(exc)
        return data
    DATA = __load_data()
    del __load_data

    @staticmethod
    def all_sections():
        return Articles.DATA.get('sections', [])

    @staticmethod
    def all_section_names():
        return [section.get('name', 'noname') for section in Articles.all_sections()]

    @staticmethod
    def find_section_by_name(section_name):
        found = {}
        for section in Articles.all_sections():
            if section.get('name') == section_name:
                found = section
                break
        return found

    @staticmethod
    def all():
        article_arrays = [Articles.where_in_section(section) for section in Articles.all_sections()]
        return sum(article_arrays, [])

    @staticmethod
    def where_in_section(section):
        return section.get('articles', [])

    @staticmethod
    def find_by_path(path):
        pass


class Article:
    def __init__(self, article):
        self.raw = article
        self.name = article['name']
        self.path = article['path']
        self.image = article['image']
        self.styles = article.get('styles', [])
        self.scripts = article.get('scripts', [])
