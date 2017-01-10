from django import forms

class UserRegiserForm(forms.Form):
#	name = forms.CharField(label='Seu Nome', max_length=100, attrs={'class':'form-control'})
	name = forms.CharField(widget=forms.TextInput(attrs={'class': 'form-control'}))

	email = forms.CharField(label='Seu Email', max_length=100)
	password = forms.CharField(label='Senha', max_length=100)
#    class Meta:
#        fields = ('nome', 'email','password')