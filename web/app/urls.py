from django.conf.urls import url
from django.contrib import admin
from users import views as usersViews
from bookmark import views as bookmarkViews

urlpatterns = [
    url(r'^login', usersViews.login),
    url(r'^logout', usersViews.logout),
    url(r'^register', usersViews.register),
    url(r'^bookmark/$', bookmarkViews.index),
    url(r'^bookmark/form/(?P<id>[0-9]+)/$', bookmarkViews.edit),
    url(r'^bookmark/form/$', bookmarkViews.new),
    url(r'^bookmark/delete/(?P<id>[0-9]+)/$', bookmarkViews.delete),
    url(r'^users/', usersViews.list),
    url(r'^$', usersViews.home),
]
