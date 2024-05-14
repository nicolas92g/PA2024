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
        self.email_entry.insert(0, "")
        self.email_entry.pack()

        self.password_label = tk.Label(self, text="Mot de passe")
        self.password_label.pack()
        self.password_entry = tk.Entry(self, show="*")
        self.password_entry.insert(0, "")
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
