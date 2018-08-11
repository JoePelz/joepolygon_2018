import os
import yaml
import logging

# Get an instance of a logger
logger = logging.getLogger(__name__)
from django.db import models
from django.conf import settings
from django.core.exceptions import ObjectDoesNotExist


class Article:
    def __init__(self, article):
        self.raw = article
        self.name = article['name']
        self.path = article['path']
        self.absolute_path = self.path.startswith("http")

        if self.absolute_path:
            base_path = "/"
        else:
            base_path = "portfolio/articles/{}/".format(self.path)
        if article['image'].startswith('/'):
            self.image = article['image']
        else:
            self.image = base_path + article['image']

        self.styles = []
        for style in article.get('styles', []):
            if style.startswith('/'):
                self.styles.append(style)
            else:
                self.styles.append(base_path + style)

        self.scripts = []
        for script in article.get('scripts', []):
            if script.startswith('/'):
                self.styles.append(script)
            else:
                self.styles.append(base_path + script)


    def __str__(self):
        return "<Article: '{}'>".format(self.name)

    def __repr__(self):
        return str(self)


class Articles:
    def __load_data():
        path = os.path.join(settings.BASE_DIR, 'portfolio', 'data', 'articles.yml')
        data = []
        with open(path, 'r') as stream:
            try:
                data = yaml.safe_load(stream)
            except yaml.YAMLError as exc:
                print(exc)

        for section in data.get('sections', []):
            articles = []
            for article in section.get('articles', []):
                try:
                    articles.append(Article(article))
                except:
                    logger.warning("Unable to instantiate article: {}".format(article))
            articles = [Article(article) for article in section.get('articles', [])]
            section['articles'] = articles

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
        found = None
        for section in Articles.all_sections():
            if section.get('name') == section_name:
                found = section
                break
        if found is None:
            raise ObjectDoesNotExist
        return found

    @staticmethod
    def all():
        article_arrays = [Articles.where_in_section(section) for section in Articles.all_sections()]
        return sum(article_arrays, [])

    @staticmethod
    def where_in_section(section):
        return section.get('articles', [])

    @staticmethod
    def find_by_path(path) -> Article:
        found = None
        for a in Articles.all():
            if a.path == path:
                found = a
                break
        if found is None:
            raise ObjectDoesNotExist
        return found
