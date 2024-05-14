import tkinter as tk
from tkinter import ttk, messagebox, Toplevel
import matplotlib.pyplot as plt
from matplotlib.backends.backend_tkagg import FigureCanvasTkAgg
import datetime
import api_request

class TicketManagement(tk.Frame):
    def __init__(self, master=None):
        super().__init__(master)
        self.grid(sticky="nsew")
        self.master.grid_rowconfigure(0, weight=1)
        self.master.grid_columnconfigure(0, weight=1)

        self.create_widgets()

        

    def create_widgets(self):
        self.grid_rowconfigure(0, weight=1)
        self.grid_columnconfigure(0, weight=1)

        inner_frame = tk.Frame(self, bg='white')
        inner_frame.grid(row=0, column=0, sticky="nsew")
        inner_frame.grid_rowconfigure(0, weight=1)
        inner_frame.grid_columnconfigure(0, weight=1)

        # Treeview for displaying tickets with scrollbar
        self.tree = ttk.Treeview(inner_frame, columns=('ID', 'Title', 'Status', 'Date'), show='headings')
        self.tree.grid(row=0, column=0, sticky='nsew', padx=10, pady=10)

        # Scrollbar
        tree_scroll = ttk.Scrollbar(inner_frame, orient="vertical", command=self.tree.yview)
        tree_scroll.grid(row=0, column=1, sticky='ns')
        self.tree.config(yscrollcommand=tree_scroll.set)

        self.tree.heading('ID', text='Numéro du Ticket', command=lambda: self.sort_by('ID', False))
        self.tree.heading('Title', text='Titre', command=lambda: self.sort_by('Title', False))
        self.tree.heading('Status', text='Statut', command=lambda: self.sort_by('Status', False))
        self.tree.heading('Date', text='Date', command=lambda: self.sort_by('Date', False))
        self.tree.bind("<Double-1>", self.on_item_double_click)  # Binding double-click event

        # Refresh button
        self.refresh_button = tk.Button(inner_frame, text="Actualiser", command=self.refresh_table)
        self.refresh_button.grid(row=1, column=0, padx=10, pady=10)

        # Graph setup
        self.figure, self.ax = plt.subplots(figsize=(5, 3))
        self.canvas = FigureCanvasTkAgg(self.figure, master=inner_frame)
        self.canvas_widget = self.canvas.get_tk_widget()
        self.canvas_widget.grid(row=2, column=0, padx=10, pady=10)

        self.load_tickets()
        self.update_graphs()

        # Définir la taille minimale et maximale de inner_frame
        inner_frame.update_idletasks()
        self.master.minsize(inner_frame.winfo_reqwidth(), inner_frame.winfo_reqheight())
        self.master.maxsize(inner_frame.winfo_reqwidth(), inner_frame.winfo_reqheight())

    def load_tickets(self):
        self.tickets = api_request.api_request("/ticket/list", api_request.token)
        self.tree.delete(*self.tree.get_children())  # Clear existing entries
        for ticket in self.tickets:
            #date_formatted = self.format_date(ticket['horaire'])
            self.tree.insert('', tk.END, values=(ticket['id'], ticket['titre'], ticket['etat'], ticket['horaire']))

    def on_item_double_click(self, event):
        item_id = self.tree.selection()[0]  # Get selected item ID
        ticket_id = int(self.tree.item(item_id, 'values')[0])
        ticket_info = self.tickets[ticket_id - 1]

        def save_changes():
            new_status = status_var.get()
            try:

                api_request.api_request('/ticket/updateState', api_request.token, {'ticket': ticket_id, 'state': new_status}, True)

                self.load_tickets()
                self.update_graphs()
                detail_window.destroy()  # Fermer la fenêtre de détails après l'enregistrement des changements
                messagebox.showinfo("Mise à jour", "Le statut du ticket a été mis à jour.")
                
            except KeyError:
                messagebox.showerror("Erreur", f"Le ticket avec l'ID {ticket_id} n'existe pas.")

        detail_window = Toplevel(self)
        detail_window.title("Détails du Ticket")
        detail_window.geometry("1000x800")  # Dimension ajustée pour un meilleur contrôle
        detail_window.resizable(False, False)  # Empêche le redimensionnement de la fenêtre

        # Fonts
        labelFont = ('Helvetica', 12, 'bold')
        entryFont = ('Helvetica', 12)

        tk.Label(detail_window, text=f"Numéro du Ticket: {ticket_id}", font=labelFont).pack(pady=(10, 2))
        tk.Label(detail_window, text=f"Titre: {ticket_info['titre']}", font=entryFont).pack(pady=(5, 2))
        tk.Label(detail_window, text=f"Date: {ticket_info['horaire']}", font=entryFont).pack(pady=(5, 2))

        description_label = tk.Label(detail_window, text="Description:", font=labelFont)
        description_label.pack(pady=(10, 2))
        description_frame = tk.Frame(detail_window)
        description_frame.pack(fill='both', expand=True, padx=20, pady=5)
        description_text = tk.Text(description_frame, height=6, width=50, font=entryFont, wrap='word')
        description_text.insert(tk.END, ticket_info['contenu'])
        description_text.configure(state='disabled')
        scrollbar = tk.Scrollbar(description_frame, command=description_text.yview, orient='vertical')
        scrollbar.pack(side='right', fill='y')
        description_text.config(yscrollcommand=scrollbar.set)
        description_text.pack(side='left', fill='both', expand=True)

        status_label = tk.Label(detail_window, text="Statut:", font=labelFont)
        status_label.pack(pady=(10, 2))
        status_var = tk.StringVar(value=ticket_info['etat'])
        status_menu = ttk.Combobox(detail_window, textvariable=status_var, values=['Non traité', 'En cours de traitement', 'Traité'], state="readonly")
        status_menu.pack(pady=(5, 20))

        save_button = tk.Button(detail_window, text="Enregistrer les changements", bg='#4c68a8', fg='white', font=labelFont, relief='raised', padx=10, pady=5, command=save_changes)
        save_button.pack(pady=10)

        self.wait_window(detail_window)

    def calculate_ticket_counts(self):
        ticket_counts = {'Non traité': 0, 'En cours de traitement': 0, 'Traité': 0}
        for ticket_info in self.tickets:
            ticket_counts[ticket_info['etat']] += 1
        return ticket_counts

    def update_graphs(self):
        ticket_counts = self.calculate_ticket_counts()
        statuses = ['Non traité', 'En cours de traitement', 'Traité']
        values = [ticket_counts[status] for status in statuses]
        total_tickets = sum(values)
        percentages = [count / total_tickets * 100 if total_tickets > 0 else 0 for count in values]

        self.ax.clear()
        self.ax.pie(percentages, labels=statuses, autopct='%1.1f%%')
        self.ax.set_title('Répartition des Statuts des Tickets')
        self.canvas.draw()

    def sort_by(self, col, descending):
        data = [(self.tree.set(child, col), child) for child in self.tree.get_children('')]
        data.sort(reverse=descending, key=lambda x: int(x[0]) if col == 'ID' else x[0])
        for index, (val, k) in enumerate(data):
            self.tree.move(k, '', index)
        self.tree.heading(col, command=lambda: self.sort_by(col, not descending))

    def refresh_table(self):
        
        self.load_tickets()  # Charger les tickets dans l'interface
        self.update_graphs()

    def format_date(self, date_str):
        if date_str:
            date = datetime.datetime.strptime(date_str, "%Y-%m-%d %H:%M:%S")
            return date.strftime("%d/%m/%Y")
        else:
            return ""
