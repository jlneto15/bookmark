from django.http import HttpResponseRedirect
#from django.shortcuts import render
from django.contrib import messages
import requests

baseAPI = "http://127.0.0.1:8081/api"

def callApi(request, url, data, method):
	global urlAPI
	urlAPI = baseAPI + url

	print urlAPI

	if method == 'GET':
		response = requests.get(urlAPI)

	if method == 'POST':
		response = requests.post(urlAPI, data)

	if method == 'PUT':
		response = requests.put(urlAPI, data)

	if method == 'DELETE':
		response = requests.delete(urlAPI)

	print response.text

	if response.status_code == 401 :
		if url != "/auth/login/":
			messages.add_message(request, messages.ERROR, 'Usuario Deslogado')
		else:
			messages.add_message(request, messages.ERROR, 'Login/Senha Invalidos.')

		return False

	if response.status_code != 200 :
		messages.add_message(request, messages.ERROR, 'Ocorreu um ERRO')
		return False

	return response.json()

def getApi(request, url, data, method):
	if 'token' in request.session:
		print "TOKEN ADICIONADO"
		#request.META['Authorization'] = request.session['token']
		url += "?token="+request.session['token']

	response = callApi(request, url, data, method)

	#if 	response[u'response'][u'code'] != 200 :
	#	print response[u'response'][u'data']
	#	return HttpResponseRedirect('/login')

	return response