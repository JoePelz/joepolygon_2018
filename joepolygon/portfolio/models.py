import os
import yaml
import logging
import requests
import re

from django.db import models
from django.conf import settings
from django.core.exceptions import ObjectDoesNotExist
from django.contrib.staticfiles.templatetags.staticfiles import static
from .apps import PortfolioConfig

# Get an instance of a logger
logger = logging.getLogger(__name__)


def url_join(*parts):
    return '/'.join(s.strip('/') for s in parts)


class Article:
    def __init__(self, article):
        self.raw = article
        self.name = article['name']
        self.path = article['path']
        self.absolute_path = self.path.startswith("http")
        self.asset_path = article.get('asset_path', self.path)

        base_path = url_join(PortfolioConfig.name, 'articles', self.asset_path)

        if article['image'].startswith('/'):
            self.image = article['image']
        else:
            self.image = url_join(base_path, article['image'])

        self.styles = []
        for style in article.get('styles', []):
            if style.startswith('/'):
                self.styles.append(style)
            else:
                self.styles.append(url_join(base_path, style))

        self.scripts = []
        for script in article.get('scripts', []):
            if script.startswith('/'):
                self.scripts.append(script)
            else:
                self.scripts.append(url_join(base_path, script))

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
            if a.asset_path == path:
                found = a
                break
        if found is None:
            raise ObjectDoesNotExist
        return found


class KaleidoscopeUpload:
    FOLDER_NAME = 'uploads'

    @staticmethod
    def file_folder():
        return os.path.join(settings.BASE_DIR, 'portfolio', 'static', 'portfolio', 'articles', 'kaleidoscope', KaleidoscopeUpload.FOLDER_NAME)

    @staticmethod
    def static_path():
        return '/'.join(['portfolio', 'articles', 'kaleidoscope', KaleidoscopeUpload.FOLDER_NAME])

    @staticmethod
    def get_next_id():
        dir = KaleidoscopeUpload.file_folder()
        items = os.listdir(dir)
        if len(items) == 0:
            return "1"

        latest = None
        latest_time = 0
        for item in items:
            created_at = os.path.getctime(os.path.join(dir, item))
            if created_at > latest_time:
                latest = item
                latest_time = created_at
        return str((int(latest.split(".")[0]) + 1) % 100)

    @staticmethod
    def safe_to_download(url):
        h = requests.head(url, allow_redirects=True)
        header = h.headers
        content_type = header.get('content-type')
        if 'image' not in content_type.lower():
            return False

        content_length = header.get('content-length', None)
        if content_length and int(content_length) > 2**25:  # 32MB
            return False

        return True

    @staticmethod
    def get_filename_from_cd(cd):
        """
        Get filename from content-disposition
        # From https://www.codementor.io/aviaryan/downloading-files-from-urls-in-python-77q3bs0un
        """
        if not cd:
            return None
        fname = re.findall('filename=(.+)', cd)
        if len(fname) == 0:
            return None
        return fname[0]

    @staticmethod
    def create(url):
        if not KaleidoscopeUpload.safe_to_download(url):
            raise AttributeError("no.")
        r = requests.get(url, allow_redirects=True)
        filename = KaleidoscopeUpload.get_filename_from_cd(r.headers.get('content-disposition'))
        if not filename:
            filename = url.rsplit("/", 1)[-1]
        extension = filename.split('.')[-1]
        image_id = KaleidoscopeUpload.get_next_id()
        image_name = "{}.{}".format(image_id, extension)
        image_path = os.path.join(KaleidoscopeUpload.file_folder(), image_name)
        static_path = "{}/{}".format(KaleidoscopeUpload.static_path(), image_name)

        with open(image_path, 'wb') as f:
            f.write(r.content)
        return static_path
