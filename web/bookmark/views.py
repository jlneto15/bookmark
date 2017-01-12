from django.http import HttpResponseRedirect
from django.shortcuts import render
from django.contrib import messages
import requests
from app.utils import getApi

# Create your views here.
def index(request):

	response = getApi(request, '/bookmark/', [], 'GET')

	if response == False:
		return HttpResponseRedirect('/login')

	data = {
		'data': response[u'response'][u'data'],
		'user': request.session['user']
	}

	return render(request, 'bookmark.html', data)


def new(request):
	if request.method == "POST":
		response = getApi(request, '/bookmark/', request.POST, 'POST')
		messages.add_message(request, messages.SUCCESS, 'Bookmark salvo com sucesso!!!.')
		return HttpResponseRedirect('/bookmark')

	data = {
		"id":0,
		"title":"",
		"url":"",
		"action": "/bookmark/form/",
		'user': request.session['user']
	}

	return render(request, 'bookmark-form.html', data)

def edit(request, id):
	if request.method == "POST":
		response = getApi(request, '/bookmark/'+id, request.POST, 'PUT')
		if response != False :
			messages.add_message(request, messages.SUCCESS, 'Bookmark salvo com sucesso!!!.')

		return HttpResponseRedirect('/bookmark')

	response = getApi(request, '/bookmark/'+id, [], 'GET')
	if response == False:
		return HttpResponseRedirect('/bookmark')

	data = {
		"id":response[u'response'][u'data'][u'id'],
		"title":response[u'response'][u'data'][u'title'],
		"url":response[u'response'][u'data'][u'url'],
		"action": "/bookmark/form/" + str(response[u'response'][u'data'][u'id']) + "/",
		'user': request.session['user']
	}
	return render(request, 'bookmark-form.html', data)

def delete(request, id):
	response = getApi(request, '/bookmark/' + id, [], 'DELETE')
	if response != False :
		messages.add_message(request, messages.SUCCESS, 'Bookmark excluido com sucesso!!!.')

	return HttpResponseRedirect('/bookmark')