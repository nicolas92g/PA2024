import tkinter as tk
from tkinter import ttk, Toplevel, font as tkfont
from datetime import datetime
from ticket_creation import TicketCreation  # Assurez-vous que l'importation est correcte
import api_request


class UserWindow(tk.Toplevel):
    def __init__(self, parent):
        super().__init__(parent)
        self.title('Espace Utilisateur')
        self.geometry('800x500')
        self.create_widgets()

    def OnDoubleClick(self, event):
        item = self.tree.selection()
        print("you clicked on", self.tree.item(item)['values'][0])

    def create_widgets(self):
        # Configuration du TreeView
        self.tree = ttk.Treeview(self, columns=('ID', 'Title', 'Status', 'Date'), show='headings')
        self.tree.heading('ID', text='ID', command=lambda: self.treeview_sort_column('ID', False, numeric=True))
        self.tree.heading('Title', text='Titre', command=lambda: self.treeview_sort_column('Title', False))
        self.tree.heading('Status', text='Statut', command=lambda: self.treeview_sort_column('Status', False))
        self.tree.heading('Date', text='Date', command=lambda: self.treeview_sort_column('Date', False, date=True))
        self.tree.grid(row=0, column=0, sticky='nsew', padx=10, pady=10)
        self.tree.bind("<Double-1>", self.on_item_double_click)

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
            tickets = api_request.api_request("/ticket/list", api_request.token)
            print(tickets)
            for ticket in tickets:
                self.tree.insert('', tk.END, values=(ticket["id"], ticket["titre"], ticket["etat"], ticket["horaire"]))
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
