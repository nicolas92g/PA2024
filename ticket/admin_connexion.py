# admin_connexion.py
import tkinter as tk
from tkinter import messagebox
from login_form import LoginForm
from ticket_management import TicketManagement  # Assurez-vous d'importer TicketManagement

def show_admin_login(parent):
    def on_login_success(user_type, token):
        if user_type == 'admin':
            admin_window = TicketManagement(parent, token)
            admin_window.grab_set()

    login_form = LoginForm(parent, on_login_success)
    login_form.grab_set()