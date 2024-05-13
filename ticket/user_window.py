# from login_form import LoginForm
# import tkinter as tk
# from tkinter import ttk, messagebox, Toplevel
# from datetime import datetime

# class UserWindow(tk.Toplevel):
#     def __init__(self, parent):
#         super().__init__(parent)
#         self.title('Espace Utilisateur')
#         self.geometry('800x500')
#         self.create_widgets()

#     def create_widgets(self):
#         self.tree = ttk.Treeview(self, columns=('ID', 'Title', 'Status', 'Date'), show='headings')
#         self.tree.heading('ID', text='ID', command=lambda: self.treeview_sort_column('ID', False, numeric=True))
#         self.tree.heading('Title', text='Titre')
#         self.tree.heading('Status', text='Statut', command=lambda: self.treeview_sort_column('Status', False))
#         self.tree.heading('Date', text='Date', command=lambda: self.treeview_sort_column('Date', False, date=True))
#         self.tree.bind("<Double-1>", self.on_item_double_click)
#         self.tree.pack(expand=True, fill=tk.BOTH, padx=10, pady=10)


#         self.load_tickets()

#     def load_tickets(self):
#         tickets = [
#             (1, 'Problème de connexion', 'Non traité', '10/05/2023'),
#             (2, 'Erreur serveur', 'En cours de traitement', '09/05/2023'),
#             (3, 'Bug dans l\'application', 'Traité', '11/05/2023')
#         ]
#         for ticket in tickets:
#             self.tree.insert('', tk.END, values=ticket)

#     def treeview_sort_column(self, col, reverse, numeric=False, date=False):
#         l = [(self.tree.set(k, col), k) for k in self.tree.get_children('')]
#         if numeric:
#             l.sort(key=lambda x: int(x[0]), reverse=reverse)
#         elif date:
#             l.sort(key=lambda x: datetime.strptime(x[0], '%d/%m/%Y'), reverse=reverse)
#         else:
#             l.sort(reverse=reverse)

#         # Rearrange items in sorted positions
#         for index, (val, k) in enumerate(l):
#             self.tree.move(k, '', index)

#         # Reverse sort next time
#         self.tree.heading(col, command=lambda: self.treeview_sort_column(col, not reverse, numeric=numeric, date=date))

#     def on_item_double_click(self, event):
#         item_id = self.tree.selection()[0]
#         ticket_details = self.tree.item(item_id, 'values')
#         self.show_ticket_details(ticket_details)

#     def show_ticket_details(self, details):
#         detail_window = Toplevel(self)
#         detail_window.title("Détails du Ticket")
#         detail_window.geometry("300x250")
#         tk.Label(detail_window, text=f"ID: {details[0]}").pack(pady=5)
#         tk.Label(detail_window, text=f"Titre: {details[1]}").pack(pady=5)
#         tk.Label(detail_window, text=f"Statut: {details[2]}").pack(pady=5)
#         tk.Label(detail_window, text=f"Date: {details[3]}").pack(pady=5)


# import tkinter as tk
# from tkinter import ttk, Toplevel, font as tkfont
# from ticket_creation import TicketCreation  # Assurez-vous que l'importation est correcte
# from datetime import datetime

# class UserWindow(tk.Toplevel):
#     def __init__(self, parent):
#         super().__init__(parent)
#         self.title('Espace Utilisateur')
#         self.geometry('800x500')
#         self.create_widgets()

#     def create_widgets(self):
#         # Configuration du TreeView
#         self.tree = ttk.Treeview(self, columns=('ID', 'Title', 'Status', 'Date'), show='headings')
#         self.tree.heading('ID', text='ID', command=lambda: self.treeview_sort_column('ID', False, numeric=True))
#         self.tree.heading('Title', text='Titre', command=lambda: self.treeview_sort_column('Title', False))
#         self.tree.heading('Status', text='Statut', command=lambda: self.treeview_sort_column('Status', False))
#         self.tree.heading('Date', text='Date', command=lambda: self.treeview_sort_column('Date', False, date=True))
#         self.tree.pack(expand=True, fill=tk.BOTH, padx=10, pady=10)

#         # Bouton pour créer un nouveau ticket
#         buttonFont = tkfont.Font(family="Helvetica", size=12, weight="bold")
#         self.create_ticket_button = tk.Button(self, text="Créer Nouveau Ticket", command=self.open_ticket_creation,
#                                               font=buttonFont, bg='#4c68a8', fg='white', padx=10, pady=10)
#         self.create_ticket_button.pack(pady=10)

#         self.load_tickets()

#     def load_tickets(self):
#         # Charger ici les tickets de l'utilisateur
#         tickets = [
#             (1, 'Problème de connexion', 'Non traité', '10/05/2023'),
#             (2, 'Erreur serveur', 'En cours de traitement', '09/05/2023'),
#             (3, 'Bug dans l\'application', 'Traité', '11/05/2023')
#         ]
#         for ticket in tickets:
#             self.tree.insert('', tk.END, values=ticket)

#     def treeview_sort_column(self, col, reverse, numeric=False, date=False):
#         l = [(self.tree.set(k, col), k) for k in self.tree.get_children('')]
#         if numeric:
#             l.sort(key=lambda x: int(x[0]), reverse=reverse)
#         elif date:
#             l.sort(key=lambda x: datetime.strptime(x[0], '%d/%m/%Y'), reverse=reverse)
#         else:
#             l.sort(key=lambda x: x[0], reverse=reverse)

#         for index, (val, k) in enumerate(l):
#             self.tree.move(k, '', index)

#         # Reverse sort next time
#         self.tree.heading(col, command=lambda: self.treeview_sort_column(col, not reverse, numeric, date))

#     def open_ticket_creation(self):
#         # Ouvre la fenêtre de création de ticket
#         ticket_creation_window = TicketCreation(self)
#         ticket_creation_window.grab_set()  # Donne le focus à cette fenêtre

#     def on_item_double_click(self, event):
#         item_id = self.tree.selection()[0]
#         ticket_details = self.tree.item(item_id, 'values')
#         self.show_ticket_details(ticket_details)

#     def show_ticket_details(self, details):
#         detail_window = Toplevel(self)
#         detail_window.title("Détails du Ticket")
#         detail_window.geometry("300x250")
#         tk.Label(detail_window, text=f"ID: {details[0]}").pack(pady=5)
#         tk.Label(detail_window, text=f"Titre: {details[1]}").pack(pady=5)
#         tk.Label(detail_window, text=f"Statut: {details[2]}").pack(pady=5)
#         tk.Label(detail_window, text=f"Date: {details[3]}").pack(pady=5)

# import tkinter as tk
# from tkinter import ttk, Toplevel, font as tkfont
# from datetime import datetime
# from ticket_creation import TicketCreation  # Assurez-vous que l'importation est correcte

# class UserWindow(tk.Toplevel):
#     def __init__(self, parent):
#         super().__init__(parent)
#         self.title('Espace Utilisateur')
#         self.geometry('800x500')
#         self.create_widgets()

#     def create_widgets(self):
#         # Configuration du TreeView
#         self.tree = ttk.Treeview(self, columns=('ID', 'Title', 'Status', 'Date'), show='headings')
#         self.tree.heading('ID', text='ID', command=lambda: self.treeview_sort_column('ID', False, numeric=True))
#         self.tree.heading('Title', text='Titre', command=lambda: self.treeview_sort_column('Title', False))
#         self.tree.heading('Status', text='Statut', command=lambda: self.treeview_sort_column('Status', False))
#         self.tree.heading('Date', text='Date', command=lambda: self.treeview_sort_column('Date', False, date=True))
#         self.tree.grid(row=0, column=0, sticky='nsew', padx=10, pady=10)

#         self.grid_rowconfigure(0, weight=1)
#         self.grid_columnconfigure(0, weight=1)

#         # Bouton pour créer un nouveau ticket
#         buttonFont = tkfont.Font(family="Helvetica", size=12, weight="bold")
#         self.create_ticket_button = tk.Button(self, text="Créer Nouveau Ticket", command=self.open_ticket_creation,
#                                               font=buttonFont, bg='#4c68a8', fg='white', padx=10, pady=10)
#         self.create_ticket_button.grid(row=1, column=0, pady=10)

#         self.load_tickets()

#     def load_tickets(self):
#         # Charger ici les tickets de l'utilisateur
#         tickets = [
#             (1, 'Problème de connexion', 'Non traité', '10/05/2023'),
#             (2, 'Erreur serveur', 'En cours de traitement', '09/05/2023'),
#             (3, 'Bug dans l\'application', 'Traité', '11/05/2023')
#         ]
#         for ticket in tickets:
#             self.tree.insert('', tk.END, values=ticket)

#     def treeview_sort_column(self, col, reverse, numeric=False, date=False):
#         l = [(self.tree.set(k, col), k) for k in self.tree.get_children('')]
#         if numeric:
#             l.sort(key=lambda x: int(x[0]), reverse=reverse)
#         elif date:
#             l.sort(key=lambda x: datetime.strptime(x[0], '%d/%m/%Y'), reverse=reverse)
#         else:
#             l.sort(key=lambda x: x[0], reverse=reverse)

#         for index, (val, k) in enumerate(l):
#             self.tree.move(k, '', index)

#         # Reverse sort next time
#         self.tree.heading(col, command=lambda: self.treeview_sort_column(col, not reverse, numeric, date))

#     def open_ticket_creation(self):
#         # Ouvre la fenêtre de création de ticket
#         ticket_creation_window = TicketCreation(self)
#         ticket_creation_window.grab_set()  # Donne le focus à cette fenêtre

#     def on_item_double_click(self, event):
#         item_id = self.tree.selection()[0]
#         ticket_details = self.tree.item(item_id, 'values')
#         self.show_ticket_details(ticket_details)

#     def show_ticket_details(self, details):
#         detail_window = Toplevel(self)
#         detail_window.title("Détails du Ticket")
#         detail_window.geometry("300x250")
#         tk.Label(detail_window, text=f"ID: {details[0]}").pack(pady=5)
#         tk.Label(detail_window, text=f"Titre: {details[1]}").pack(pady=5)
#         tk.Label(detail_window, text=f"Statut: {details[2]}").pack(pady=5)
#         tk.Label(detail_window, text=f"Date: {details[3]}").pack(pady=5)

import tkinter as tk
from tkinter import ttk, Toplevel, font as tkfont
from datetime import datetime
from ticket_creation import TicketCreation  # Assurez-vous que l'importation est correcte
from api_request import api_request

class UserWindow(tk.Toplevel):
    def __init__(self, parent):
        super().__init__(parent)
        self.title('Espace Utilisateur')
        self.geometry('800x500')
        self.create_widgets()

    def create_widgets(self):
        # Configuration du TreeView
        self.tree = ttk.Treeview(self, columns=('ID', 'Title', 'Status', 'Date'), show='headings')
        self.tree.heading('ID', text='ID', command=lambda: self.treeview_sort_column('ID', False, numeric=True))
        self.tree.heading('Title', text='Titre', command=lambda: self.treeview_sort_column('Title', False))
        self.tree.heading('Status', text='Statut', command=lambda: self.treeview_sort_column('Status', False))
        self.tree.heading('Date', text='Date', command=lambda: self.treeview_sort_column('Date', False, date=True))
        self.tree.grid(row=0, column=0, sticky='nsew', padx=10, pady=10)

        self.grid_rowconfigure(0, weight=1)
        self.grid_columnconfigure(0, weight=1)

        # Bouton pour créer un nouveau ticket
        buttonFont = tkfont.Font(family="Helvetica", size=12, weight="bold")
        self.create_ticket_button = tk.Button(self, text="Créer Nouveau Ticket", command=self.open_ticket_creation,
                                              font=buttonFont, bg='#4c68a8', fg='white', padx=10, pady=10)
        self.create_ticket_button.grid(row=1, column=0, pady=10)

        self.load_tickets()

    def load_tickets(self):
        # Appeler l'API pour récupérer les tickets de l'utilisateur
        try:
            tickets = api_request("/user/tickets", self.token)
            for ticket in tickets:
                self.tree.insert('', tk.END, values=(ticket["id"], ticket["title"], ticket["status"], ticket["date"]))
        except Exception as e:
            print(f"Error fetching user tickets: {e}")

    def treeview_sort_column(self, col, reverse, numeric=False, date=False):
        l = [(self.tree.set(k, col), k) for k in self.tree.get_children('')]
        if numeric:
            l.sort(key=lambda x: int(x[0]), reverse=reverse)
        elif date:
            l.sort(key=lambda x: datetime.strptime(x[0], '%d/%m/%Y'), reverse=reverse)
        else:
            l.sort(key=lambda x: x[0], reverse=reverse)

        for index, (val, k) in enumerate(l):
            self.tree.move(k, '', index)

    def open_ticket_creation(self):
        # Ouvre une nouvelle fenêtre pour la création de ticket
        ticket_creation_window = Toplevel(self)
        ticket_creation_app = TicketCreation(ticket_creation_window)
        ticket_creation_window.grab_set()  # Donne le focus à cette fenêtre

    def on_item_double_click(self, event):
        item_id = self.tree.selection()[0]
        ticket_details = self.tree.item(item_id, 'values')
        self.show_ticket_details(ticket_details)

    def show_ticket_details(self, details):
        detail_window = Toplevel(self)
        detail_window.title("Détails du Ticket")
        detail_window.geometry("300x250")
        tk.Label(detail_window, text=f"ID: {details[0]}").pack(pady=5)
        tk.Label(detail_window, text=f"Titre: {details[1]}").pack(pady=5)
        tk.Label(detail_window, text=f"Statut: {details[2]}").pack(pady=5)
        tk.Label(detail_window, text=f"Date: {details[3]}").pack(pady=5)
