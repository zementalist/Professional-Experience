from django import forms
from django.contrib.auth.models import User
from django.core.exceptions import ObjectDoesNotExist
from django.contrib.auth.password_validation import validate_password

import re
import string

class LoginForm(forms.ModelForm):
    class Meta:
        model = User
        fields = [
            'email',
            'password'
        ]
    email = forms.CharField(required=True, label='', widget=forms.EmailInput(attrs={
        'class': 'form-control',
        'required':'required',
        'placeholder': 'Email',
        'name':'email'}))
    password = forms.CharField(required=True, label='', widget=forms.PasswordInput(attrs={
        'class':'form-control',
        'required':'required',
        'placeholder':'Password',
        'name':'password'
    }))

class RegisterationForm(forms.ModelForm):

    first_name = forms.CharField(required=False, label='', widget=forms.TextInput(attrs={
        'class': 'form-control',
        'required':'required',
        'placeholder': 'First Name',
        'name':'email'}))
    last_name = forms.CharField(required=False, label='', widget=forms.TextInput(attrs={
        'class': 'form-control',
        'required':'required',
        'placeholder': 'Last Name',
        'name':'last_name'}))
    username = forms.CharField(required=True, label='', widget=forms.TextInput(attrs={
        'class': 'form-control',
        'required':'required',
        'placeholder': 'Username',
        'name':'username'}))
    email = forms.CharField(required=True, label='', widget=forms.EmailInput(attrs={
        'class': 'form-control',
        'required':'required',
        'placeholder': 'Email',
        'name':'email'}))
    password = forms.CharField(required=True, label='', widget=forms.PasswordInput(attrs={
        'class': 'form-control',
        'required':'required',
        'placeholder': 'Password',
        'name':'password'}))
    password_confirmation = forms.CharField(required=True, label='', widget=forms.PasswordInput(attrs={
        'class': 'form-control',
        'required':'required',
        'placeholder': 'Confirm Password',
        'name':'password_confirmation'}))

    def clean_first_name(self, *args, **kwargs):
        # Check that: length < 15 chars & No punctuations & Must NOT start with number
        first_name = self.cleaned_data.get('first_name')
        if len(first_name) > 15:
            raise forms.ValidationError("Invalid First Name: Too long! (max 15 chars).")
        pattern = re.compile("[{}]+".format(re.escape(string.punctuation.replace("_", ""))))
        if pattern.search(first_name):
            raise forms.ValidationError("Invalid First Name: Special characters are forbidden, only '_' is allowed.")
        if re.search('\d', first_name) is not None:
            raise forms.ValidationError("Invalid First Name: Numbers are not allowed")
        return first_name

    def clean_last_name(self, *args, **kwargs):
        # Check that: length < 15 chars & No punctuations & Must NOT start with number
        last_name = self.cleaned_data.get('last_name')
        if len(last_name) > 15:
            raise forms.ValidationError("Invalid Last Name.")
        pattern = re.compile("[{}]+".format(re.escape(string.punctuation.replace("_", ""))))
        if pattern.search(last_name):
            raise forms.ValidationError("Invalid Last Name: Special characters are forbidden, only '_' is allowed.")
        if re.search('\d', last_name) is not None:
            raise forms.ValidationError("Invalid Last Name: Numbers are not allowed.")
        return last_name

    def clean_username(self, *args, **kwargs):
        # Check that: length < 30 chars & No punctuations & Must NOT start with number
        username = self.cleaned_data.get('username')
        if len(username) > 30:
            raise forms.ValidationError("Invalid Username.")
        pattern = re.compile("[{}]+".format(re.escape(string.punctuation.replace("_", ""))))
        if pattern.search(username):
            raise forms.ValidationError("Invalid Username: Special characters are forbidden, only '_' is allowed.")
        if re.search('\d', username[0]) is not None:
            raise forms.ValidationError("Invalid Username: It must start with a letter.")
        return username

    def clean_email(self, *args, **kwargs):
        # Check that:  Email is unique (doesn't exist in the database)
        email = self.cleaned_data.get('email')
        try:
            user = User.objects.get(email = email)
            raise forms.ValidationError("Email is already taken.")
        except ObjectDoesNotExist:
            pass
        return email



    def clean_password(self, *args, **kwargs):
        # Use default django password validation & check that password_confirmation matches password
        password_confirmation = self.cleaned_data.get('password_confirmation')
        password = self.cleaned_data.get('password')
        validate_password(password)
        if not password == password_confirmation:
            raise forms.ValidationError("Password Confirmation does not match Password.")
        return password

    def clean_password_confirmation(self):
        password_confirmation = self.cleaned_data.get('password_confirmation')
        return password_confirmation


    class Meta:
        model = User
        fields = [
                'first_name',
                'last_name',
                'username',
                'email',
                'password_confirmation',
                'password',
            ]

