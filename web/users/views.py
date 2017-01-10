from django.http import HttpResponseRedirect
from django.shortcuts import render
from django.contrib import messages
from app.utils import getApi, callApi
import requests

# Create your views here.
def list(request):
	response = getApi(request, '/user/', [], 'GET')
	if response == False:
		return HttpResponseRedirect('/login')

	data = {
		'data': response[u'response'][u'data'],
		'user': request.session['user']
	}
	return render(request, 'index.html', context= data)

def home(request):
	if 'token' in request.session:
		print "Usuario Logado: "+ request.session['token']
		return HttpResponseRedirect('/bookmark')
	return HttpResponseRedirect('/login')

def login(request):
	#messages.add_message(request, messages.INFO, 'Hello world.')
	if request.method == "POST":
		response = callApi(request, '/auth/login/', request.POST, 'POST')
		if response == False:
			return HttpResponseRedirect('/logout')

		print response
		if response[u'response'][u'code'] == 200:
			request.session['token'] = response[u'response'][u'data'][u'token']
			request.session['user'] = response[u'response'][u'data'][u'user']
			return HttpResponseRedirect('/bookmark')

		return HttpResponseRedirect('/login')
	return render(request, 'login.html')

def logout(request):
	if 'token' in request.session:
		del request.session['token']
		
	if 'user' in request.session:
		del request.session['user']
		
	return HttpResponseRedirect('/')

def register(request):
	if request.method == "POST":
		print request.POST
		response = callApi(request, '/user/', request.POST, 'POST')

		print response[u'response'][u'data'][u'token']
		request.session['token'] = response[u'response'][u'data'][u'token']
		request.session['user'] = response[u'response'][u'data'][u'user']
		
		return HttpResponseRedirect('/')

	return render(request, 'register.html')
