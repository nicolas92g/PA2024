# import tkinter as tk
# from ticket_creation import TicketCreation
# from ticket_management import TicketManagement

# class Home(tk.Frame):
#     def __init__(self, master=None):
#         super().__init__(master)
#         self.master = master
#         self.pack()
#         self.create_widgets()

#     def create_widgets(self):
#         self.master.title("Gestion de Tickets")
#         self.logo = tk.Label(self, text="Logo de l'entreprise ici")
#         self.logo.pack()

#         self.user_login = tk.Button(self, text="Connexion Utilisateur", command=self.user_login)
#         self.user_login.pack()

#         self.admin_login = tk.Button(self, text="Connexion Administrateur", command=self.admin_login)
#         self.admin_login.pack()

#     def user_login(self):
#         self.new_window = tk.Toplevel(self.master)
#         self.app = TicketCreation(self.new_window)

#     def admin_login(self):
#         self.new_window = tk.Toplevel(self.master)
#         self.app = TicketManagement(self.new_window)

# def main():
#     root = tk.Tk()
#     app = Home(master=root)
#     app.mainloop()

# if __name__ == "__main__":
#     main()

# import tkinter as tk
# from tkinter import PhotoImage, font as tkfont
# from ticket_creation import TicketCreation
# from ticket_management import TicketManagement

# class Home(tk.Frame):
#     def __init__(self, master=None):
#         super().__init__(master)
#         self.master = master
#         self.pack()
#         self.create_widgets()

#     def create_widgets(self):
#         self.master.title("Gestion de Tickets")
#         self.config(bg='white')  # Définit la couleur de fond de la fenêtre

#         # Charger et afficher une image comme logo
#         self.logo_image = PhotoImage(file="real-madrid-logo2016.png")  # Assurez-vous que le chemin d'accès est correct
#         self.logo = tk.Label(self, image=self.logo_image, bg='white')
#         self.logo.pack(pady=20)

#         # Définition des polices
#         customFont = tkfont.Font(family="Helvetica", size=12, weight="bold")

#         # Boutons avec un style amélioré
#         self.user_login = tk.Button(self, text="Connexion Utilisateur", command=self.user_login,
#                                     font=customFont, bg='#333', fg='white', padx=10, pady=5)
#         self.user_login.pack(pady=10)

#         self.admin_login = tk.Button(self, text="Connexion Administrateur", command=self.admin_login,
#                                      font=customFont, bg='#555', fg='white', padx=10, pady=5)
#         self.admin_login.pack(pady=10)

#     def user_login(self):
#         self.new_window = tk.Toplevel(self.master)
#         self.app = TicketCreation(self.new_window)
#         self.new_window.configure(bg='white')

#     def admin_login(self):
#         self.new_window = tk.Toplevel(self.master)
#         self.app = TicketManagement(self.new_window)
#         self.new_window.configure(bg='white')

# def main():
#     root = tk.Tk()
#     app = Home(master=root)
#     app.mainloop()

# if __name__ == "__main__":
#     main()

import tkinter as tk
from tkinter import PhotoImage, font as tkfont
# Assurez-vous d'importer correctement les fonctions ou les classes depuis les autres fichiers
from user_connexion import show_user_login
from admin_connexion import show_admin_login
from tkinter import messagebox

class Home(tk.Frame):
    def __init__(self, master=None):
        super().__init__(master)
        self.master = master
        self.grid(sticky="nsew")

        # Configuration de la grille pour que le frame central prenne tout l'espace
        self.master.grid_rowconfigure(0, weight=1)
        self.master.grid_columnconfigure(0, weight=1)

        # Créer les widgets dans un sous-frame pour un meilleur contrôle du layout
        self.sub_frame = tk.Frame(self.master, bg='white')
        self.sub_frame.grid(row=0, column=0, sticky="nsew")

        self.create_widgets()

    def create_widgets(self):
        self.master.title("Au temps donné - Gestion de Tickets")
        
        # Logo
        self.logo_image = PhotoImage(file="logo.png")  # Assurez-vous que le chemin est correct
        self.logo = tk.Label(self.sub_frame, image=self.logo_image, bg='white')
        self.logo.pack(pady=(20, 10))  # Espacement vertical ajusté

        # Définition des polices
        customFont = tkfont.Font(family="Helvetica", size=12, weight="bold")

        # Boutons avec un style amélioré
        self.btn_user_login = tk.Button(self.sub_frame, text="Connexion", command=lambda: show_user_login(self.master),
                                font=customFont, bg='#4c68a8', fg='white', padx=10, pady=10)
        self.btn_user_login.pack(pady=10)    # Retiré fill='x', ajouté padx pour contrôle de la largeur


    def open_user_login(self):
        # Utilisation de la fonction de connexion utilisateur
        show_user_login(self.master)

def main():
    root = tk.Tk()
    root.geometry('600x800')  # Taille ajustée pour plus de réalisme
    app = Home(master=root)
    root.mainloop()

if __name__ == "__main__":
    main()

