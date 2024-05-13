
# import tkinter as tk
# from tkinter import messagebox

# class LoginForm(tk.Toplevel):
#     def __init__(self, parent, on_login_success, login_type):
#         super().__init__(parent)
#         self.on_login_success = on_login_success
#         self.login_type = login_type
#         self.title('Connexion')
#         self.geometry('300x200')
#         self.create_widgets()

#     def create_widgets(self):
#         tk.Label(self, text="Nom d'utilisateur:").pack(pady=(20, 5))
#         self.username_entry = tk.Entry(self)
#         self.username_entry.pack()

#         tk.Label(self, text="Mot de passe:").pack(pady=5)
#         self.password_entry = tk.Entry(self, show='*')
#         self.password_entry.pack()

#         tk.Button(self, text="Se connecter", command=self.check_credentials).pack(pady=20)

#     def check_credentials(self):
#         username = self.username_entry.get()
#         password = self.password_entry.get()
#         # Simuler une vérification des identifiants
#         if username == "admin" and password == "admin" and self.login_type == 'admin':
#             messagebox.showinfo("Login Success", "Vous êtes connecté en tant qu'admin.")
#             self.destroy()  # Fermer le formulaire de connexion
#             self.on_login_success()
#         elif username == "user" and password == "user" and self.login_type == 'user':
#             messagebox.showinfo("Login Success", "Vous êtes connecté en tant qu'utilisateur.")
#             self.destroy()  # Fermer le formulaire de connexion
#             self.on_login_success()
#         else:
#             messagebox.showerror("Login Failed", "Nom d'utilisateur ou mot de passe incorrect")

# import requests
# import tkinter as tk
# from tkinter import messagebox

# class LoginForm(tk.Toplevel):
#     def __init__(self, parent, on_success_callback=None):
#         super().__init__(parent)
#         self.title("Connexion")
#         self.geometry("300x200")
#         self.on_success_callback = on_success_callback
#         self.build_form()

#     def build_form(self):
#         self.username_label = tk.Label(self, text="Email")
#         self.username_label.pack()
#         self.username_entry = tk.Entry(self)
#         self.username_entry.pack()

#         self.password_label = tk.Label(self, text="Mot de passe")
#         self.password_label.pack()
#         self.password_entry = tk.Entry(self, show="*")
#         self.password_entry.pack()

#         self.submit_button = tk.Button(self, text="Connexion", command=self.submit_login)
#         self.submit_button.pack()

#     def submit_login(self):
#         email = self.username_entry.get()
#         password = self.password_entry.get()
#         url = 'https://api.au-temps-donne.nicolas-guillot.fr/api/login'
#         data = {'email': email, 'password': password}

#         try:
#             response = requests.post(url, json=data)
#             if response.status_code == 200:
#                 response_data = response.json()
#                 if response_data.get('success', False):
#                     messagebox.showinfo("Succès", "Connexion réussie.")
#                     token = response_data.get('token')
#                     print("Token:", token)  # Utilisez ce token pour les requêtes suivantes
#                     if self.on_success_callback:
#                         self.on_success_callback(token)  # Pass the token to the callback
#                     self.destroy()
#                 else:
#                     messagebox.showerror("Erreur", response_data.get('message', 'Erreur de connexion'))
#             else:
#                 messagebox.showerror("Erreur", f"Échec de la connexion avec le serveur: {response.status_code}")
#         except requests.exceptions.RequestException as e:
#             messagebox.showerror("Erreur", f"Erreur réseau: {e}")


import tkinter as tk
from tkinter import messagebox
import api_request

# class LoginForm(tk.Toplevel):
#     def __init__(self, parent, on_success_callback=None):
#         super().__init__(parent)
#         self.title("Connexion")
#         self.geometry("300x200")
#         self.on_success_callback = on_success_callback
#         self.build_form()

#     def build_form(self):
#         self.email_label = tk.Label(self, text="Email")
#         self.email_label.pack()
#         self.email_entry = tk.Entry(self)
#         self.email_entry.pack()

#         self.password_label = tk.Label(self, text="Mot de passe")
#         self.password_label.pack()
#         self.password_entry = tk.Entry(self, show="*")
#         self.password_entry.pack()

#         self.submit_button = tk.Button(self, text="Connexion", command=self.submit_login)
#         self.submit_button.pack()

#     def submit_login(self):
#         email = self.email_entry.get()
#         password = self.password_entry.get()
#         params = {
#             "email":email, "password":password
#         }
#         api_request.token = api_request.api_request("/login","",params, True)["token"]
#         roles = api_request.api_request("/user/roles",api_request.token)[0]["nom"]
#         print(roles)
        # print(api_request.token)



        # url = 'https://api.au-temps-donne.nicolas-guillot.fr/api/login'
        # data = {'email': email, 'password': password}

        # try:
        #     response = requests.post(url, json=data)
        #     if response.status_code == 200:
        #         response_data = response.json()
        #         if response_data.get('success', False):
        #             messagebox.showinfo("Succès", "Connexion réussie.")
        #             if self.on_success_callback:
        #                 self.on_success_callback(response_data.get('token'))
        #             self.destroy()
        #         else:
        #             messagebox.showerror("Erreur", response_data.get('message', 'Erreur de connexion'))
        #     else:
        #         messagebox.showerror("Erreur", f"Échec de la connexion avec le serveur: {response.status_code}")
        # except requests.exceptions.RequestException as e:
        #     messagebox.showerror("Erreur", f"Erreur réseau: {e}")


import tkinter as tk
from tkinter import messagebox
import api_request
from ticket_management import TicketManagement 
from user_window import UserWindow

class LoginForm(tk.Toplevel):
    def __init__(self, parent):
        super().__init__(parent)
        self.title("Connexion")
        self.geometry("300x200")
        self.parent = parent
        self.build_form()

    def build_form(self):
        self.email_label = tk.Label(self, text="Email")
        self.email_label.pack()
        self.email_entry = tk.Entry(self)
        self.email_entry.pack()

        self.password_label = tk.Label(self, text="Mot de passe")
        self.password_label.pack()
        self.password_entry = tk.Entry(self, show="*")
        self.password_entry.pack()

        self.submit_button = tk.Button(self, text="Connexion", command=self.submit_login)
        self.submit_button.pack()

    def submit_login(self):
        email = self.email_entry.get()
        password = self.password_entry.get()
        params = {
            "email": email,
            "password": password
        }
        try:
            api_request.token = api_request.api_request("/login", "", params, True)["token"]
            roles = api_request.api_request("/user/roles", api_request.token)[0]["nom"]
            if "benevole" in roles:
                self.destroy()  # Fermer la fenêtre de connexion
                user_window = UserWindow(self.parent)
                user_window.grab_set()  # Empêcher l'interaction avec les autres fenêtres
            elif "admin" in roles:
                self.destroy()  # Fermer la fenêtre de connexion
                ticket_management = TicketManagement(self.parent)
                ticket_management.grab_set()  # Empêcher l'interaction avec les autres fenêtres
            else:
                messagebox.showerror("Erreur", "Rôle non pris en charge.")
        except Exception as e:
            messagebox.showerror("Erreur", str(e))

# Exemple d'utilisation :
if __name__ == "__main__":
    root = tk.Tk()
    app = LoginForm(root)
    root.mainloop()
