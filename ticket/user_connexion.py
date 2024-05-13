# user_connexion.py
import tkinter as tk
from login_form import LoginForm
from user_window import UserWindow

def show_user_login(parent):
    
    login_form = LoginForm(parent)
    login_form.grab_set()
