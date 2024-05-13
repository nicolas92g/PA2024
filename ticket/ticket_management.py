# import tkinter as tk
# from data_model import TicketData
# from tkinter import messagebox

# class TicketManagement(tk.Frame):
#     def __init__(self, master=None):
#         super().__init__(master)
#         self.master = master
#         self.pack()
#         self.ticket_data = TicketData()
#         self.create_widgets()

#     def create_widgets(self):
#         self.update_button = tk.Button(self, text="Mettre à jour le statut", command=self.update_status)
#         self.update_button.pack()

#         self.ticket_list = tk.Listbox(self)
#         self.ticket_list.pack()

#         self.load_tickets()

#     def load_tickets(self):
#         tickets = self.ticket_data.get_tickets()
#         for ticket_id, ticket_info in tickets.items():
#             self.ticket_list.insert(tk.END, f"Ticket {ticket_id}: {ticket_info['title']} - {ticket_info['status']}")

#     def update_status(self):
#         selected = self.ticket_list.curselection()
#         if selected:
#             ticket_id = selected[0] + 1  # ajustement de l'index
#             try:
#                 self.ticket_data.update_ticket(ticket_id, "En cours de traitement")
#                 self.ticket_list.delete(selected[0])
#                 self.ticket_list.insert(selected[0], f"Ticket {ticket_id}: {self.ticket_data.tickets[ticket_id]['title']} - En cours de traitement")
#                 messagebox.showinfo("Mise à jour", "Le statut du ticket a été mis à jour.")
#             except KeyError:
#                 messagebox.showerror("Erreur", f"Le ticket avec l'ID {ticket_id} n'existe pas.")

# import tkinter as tk
# from tkinter import messagebox, ttk
# import matplotlib.pyplot as plt
# from matplotlib.backends.backend_tkagg import FigureCanvasTkAgg
# from data_model import TicketData

# class TicketManagement(tk.Frame):
#     def __init__(self, master=None):
#         super().__init__(master)
#         self.master = master
#         self.grid(sticky="nsew")
#         self.master.grid_rowconfigure(0, weight=1)
#         self.master.grid_columnconfigure(0, weight=1)
#         self.ticket_data = TicketData()
#         self.create_widgets()

#     def create_widgets(self):
#         # Centrage dynamique des widgets
#         inner_frame = tk.Frame(self, bg='white')
#         inner_frame.grid(row=0, column=0, sticky="nsew")
#         self.grid_rowconfigure(0, weight=1)
#         self.grid_columnconfigure(0, weight=1)

#         # Bouton de mise à jour
#         self.update_button = tk.Button(inner_frame, text="Mettre à jour le statut", command=self.update_status)
#         self.update_button.grid(row=0, column=0, padx=10, pady=10)

#         # Listbox pour afficher les tickets
#         self.ticket_list = tk.Listbox(inner_frame, height=10, width=50)
#         self.ticket_list.grid(row=1, column=0, padx=10, pady=10)
#         self.load_tickets()

#         # Ajout des graphiques
#         self.figure, self.ax = plt.subplots(figsize=(5, 3))
#         self.canvas = FigureCanvasTkAgg(self.figure, master=inner_frame)
#         self.canvas_widget = self.canvas.get_tk_widget()
#         self.canvas_widget.grid(row=2, column=0, padx=10, pady=10)

#         # Mise à jour des graphiques
#         self.update_graphs()

#     def load_tickets(self):
#         self.ticket_list.delete(0, tk.END)  # Clear existing data
#         tickets = self.ticket_data.get_tickets()
#         for ticket_id, ticket_info in sorted(tickets.items(), key=lambda x: x[1]['status']):  # Example sorting by status
#             self.ticket_list.insert(tk.END, f"Ticket {ticket_id}: {ticket_info['title']} - {ticket_info['status']}")

#     def update_graphs(self):
#         # Dummy data for the graph
#         statuses = ['Non traité', 'En cours de traitement', 'Traité']
#         values = [15, 30, 10]  # Replace with actual counts
#         self.ax.clear()
#         self.ax.pie(values, labels=statuses, autopct='%1.1f%%')
#         self.ax.set_title('Répartition des Statuts des Tickets')
#         self.canvas.draw()

#     def update_status(self):
#         selected = self.ticket_list.curselection()
#         if selected:
#             ticket_id = selected[0] + 1  # Adjusting index
#             try:
#                 self.ticket_data.update_ticket(ticket_id, "En cours de traitement")
#                 self.load_tickets()
#                 self.update_graphs()
#                 messagebox.showinfo("Mise à jour", "Le statut du ticket a été mis à jour.")
#             except KeyError:
#                 messagebox.showerror("Erreur", f"Le ticket avec l'ID {ticket_id} n'existe pas.")

# if __name__ == "__main__":
#     root = tk.Tk()
#     root.geometry("800x600")  # Initial size of the window
#     app = TicketManagement(master=root)
#     app.mainloop()

# import tkinter as tk
# from tkinter import ttk, messagebox, Toplevel
# import matplotlib.pyplot as plt
# from matplotlib.backends.backend_tkagg import FigureCanvasTkAgg
# from data_model import TicketData

# class TicketManagement(tk.Frame):
#     def __init__(self, master=None):
#         super().__init__(master)
#         self.master = master
#         self.grid(sticky="nsew")
#         self.master.grid_rowconfigure(0, weight=1)
#         self.master.grid_columnconfigure(0, weight=1)
#         self.ticket_data = TicketData()
#         self.create_widgets()

#     def create_widgets(self):
#         # Centrage dynamique des widgets
#         inner_frame = tk.Frame(self, bg='white')
#         inner_frame.grid(row=0, column=0, sticky="nsew")
#         self.grid_rowconfigure(0, weight=1)
#         self.grid_columnconfigure(0, weight=1)

#         # Treeview pour afficher les tickets
#         self.tree = ttk.Treeview(inner_frame, columns=('ID', 'Title', 'Status'), show='headings')
#         self.tree.grid(row=0, column=0, sticky='nsew', padx=10, pady=10)
#         self.tree.heading('ID', text='Numéro du Ticket', command=lambda: self.sort_by('ID', False))
#         self.tree.heading('Title', text='Titre', command=lambda: self.sort_by('Title', False))
#         self.tree.heading('Status', text='Statut', command=lambda: self.sort_by('Status', False))
#         self.tree.column('ID', width=100)
#         self.tree.column('Title', width=200)
#         self.tree.column('Status', width=100)
#         self.load_tickets()

#         # Bouton de mise à jour
#         self.update_button = tk.Button(inner_frame, text="Mettre à jour le statut", command=self.update_status)
#         self.update_button.grid(row=1, column=0, padx=10, pady=10)

#         # Ajout des graphiques
#         self.figure, self.ax = plt.subplots(figsize=(5, 3))
#         self.canvas = FigureCanvasTkAgg(self.figure, master=inner_frame)
#         self.canvas_widget = self.canvas.get_tk_widget()
#         self.canvas_widget.grid(row=2, column=0, padx=10, pady=10)
#         self.update_graphs()

#     def load_tickets(self):
#         tickets = self.ticket_data.get_tickets()
#         for ticket_id, ticket_info in sorted(tickets.items(), key=lambda x: x[1]['status']):
#             self.tree.insert('', tk.END, values=(ticket_id, ticket_info['title'], ticket_info['status']))

#     def update_graphs(self):
#         statuses = ['Non traité', 'En cours de traitement', 'Traité']
#         values = [15, 30, 10]  # Replace with actual counts
#         self.ax.clear()
#         self.ax.pie(values, labels=statuses, autopct='%1.1f%%')
#         self.ax.set_title('Répartition des Statuts des Tickets')
#         self.canvas.draw()

#     def update_status(self):
#         selected = self.tree.selection()
#         if selected:
#             ticket_id = int(self.tree.item(selected[0])['values'][0])
#             try:
#                 self.ticket_data.update_ticket(ticket_id, "En cours de traitement")
#                 self.load_tickets()
#                 self.update_graphs()
#                 messagebox.showinfo("Mise à jour", "Le statut du ticket a été mis à jour.")
#             except KeyError:
#                 messagebox.showerror("Erreur", f"Le ticket avec l'ID {ticket_id} n'existe pas.")

#     def sort_by(self, col, descending):
#         # Convertir les valeurs en entiers si la colonne est 'ID' pour un tri numérique
#         if col == 'ID':
#             data = [(int(self.tree.set(child, col)), child) for child in self.tree.get_children('')]
#         else:
#             data = [(self.tree.set(child, col), child) for child in self.tree.get_children('')]

#         data.sort(reverse=descending, key=lambda x: x[0])
#         for index, (val, k) in enumerate(data):
#             self.tree.move(k, '', index)
#         self.tree.heading(col, command=lambda: self.sort_by(col, not descending))

# if __name__ == "__main__":
#     root = tk.Tk()
#     root.geometry("800x600")
#     app = TicketManagement(master=root)
#     app.mainloop()

# import tkinter as tk
# from tkinter import ttk, messagebox, Toplevel, font as tkfont
# import matplotlib.pyplot as plt
# from matplotlib.backends.backend_tkagg import FigureCanvasTkAgg
# from data_model import TicketData  # Assurez-vous que cette classe est correctement définie pour gérer les données des tickets

# class TicketManagement(tk.Frame):
#     def __init__(self, master=None):
#         super().__init__(master)
#         self.grid(sticky="nsew")
#         self.master.grid_rowconfigure(0, weight=1)
#         self.master.grid_columnconfigure(0, weight=1)
#         self.ticket_data = TicketData()
#         self.create_widgets()

#     def create_widgets(self):
#         inner_frame = tk.Frame(self, bg='white')
#         inner_frame.grid(row=0, column=0, sticky="nsew")
#         self.grid_rowconfigure(0, weight=1)
#         self.grid_columnconfigure(0, weight=1)

#         # Treeview for displaying tickets
#         self.tree = ttk.Treeview(inner_frame, columns=('ID', 'Title', 'Status'), show='headings')
#         self.tree.grid(row=0, column=0, sticky='nsew', padx=10, pady=10)
#         self.tree.heading('ID', text='Numéro du Ticket', command=lambda: self.sort_by('ID', False))
#         self.tree.heading('Title', text='Titre', command=lambda: self.sort_by('Title', False))
#         self.tree.heading('Status', text='Statut', command=lambda: self.sort_by('Status', False))
#         self.tree.bind("<Double-1>", self.on_item_double_click)  # Binding double-click event

#         # Button for updating status
#         self.update_button = tk.Button(inner_frame, text="Mettre à jour le statut", command=self.update_status)
#         self.update_button.grid(row=1, column=0, padx=10, pady=10)

#         # Graph setup
#         self.figure, self.ax = plt.subplots(figsize=(5, 3))
#         self.canvas = FigureCanvasTkAgg(self.figure, master=inner_frame)
#         self.canvas_widget = self.canvas.get_tk_widget()
#         self.canvas_widget.grid(row=2, column=0, padx=10, pady=10)

#         self.load_tickets()
#         self.update_graphs()

#     def load_tickets(self):
#         self.tree.delete(*self.tree.get_children())  # Clear existing entries
#         tickets = self.ticket_data.get_tickets()
#         for ticket_id, ticket_info in sorted(tickets.items(), key=lambda x: x[1]['status']):
#             self.tree.insert('', tk.END, values=(ticket_id, ticket_info['title'], ticket_info['status']))

#     def on_item_double_click(self, event):
#         item_id = self.tree.selection()[0]  # Get selected item ID
#         ticket_id = self.tree.item(item_id, 'values')[0]
#         ticket_info = self.ticket_data.get_tickets()[ticket_id]

#         def save_changes():
#             new_status = status_var.get()
#             try:
#                 self.ticket_data.update_ticket(ticket_id, new_status)
#                 self.load_tickets()
#                 self.update_graphs()
#                 messagebox.showinfo("Mise à jour", "Le statut du ticket a été mis à jour.")
#                 detail_window.destroy()  # Fermer la fenêtre de détails après l'enregistrement des changements
#             except KeyError:
#                 messagebox.showerror("Erreur", f"Le ticket avec l'ID {ticket_id} n'existe pas.")

#         detail_window = Toplevel(self)
#         detail_window.title("Détails du Ticket")
#         detail_window.geometry("1000x800")  # Dimension ajustée pour un meilleur contrôle
#         detail_window.resizable(False, False)  # Empêche le redimensionnement de la fenêtre

#         # Fonts
#         labelFont = ('Helvetica', 12, 'bold')
#         entryFont = ('Helvetica', 12)

#         tk.Label(detail_window, text=f"Numéro du Ticket: {ticket_id}", font=labelFont).pack(pady=(10, 2))
#         tk.Label(detail_window, text=f"Titre: {ticket_info['title']}", font=entryFont).pack(pady=(5, 2))

#         description_label = tk.Label(detail_window, text="Description:", font=labelFont)
#         description_label.pack(pady=(10, 2))
#         description_frame = tk.Frame(detail_window)
#         description_frame.pack(fill='both', expand=True, padx=20, pady=5)
#         description_text = tk.Text(description_frame, height=6, width=50, font=entryFont, wrap='word')
#         description_text.insert(tk.END, ticket_info['description'])
#         description_text.configure(state='disabled')
#         scrollbar = tk.Scrollbar(description_frame, command=description_text.yview, orient='vertical')
#         scrollbar.pack(side='right', fill='y')
#         description_text.config(yscrollcommand=scrollbar.set)
#         description_text.pack(side='left', fill='both', expand=True)

#         status_label = tk.Label(detail_window, text="Statut:", font=labelFont)
#         status_label.pack(pady=(10, 2))
#         status_var = tk.StringVar(value=ticket_info['status'])
#         status_menu = ttk.Combobox(detail_window, textvariable=status_var, values=['Non traité', 'En cours de traitement', 'Traité'], state="readonly")
#         status_menu.pack(pady=(5, 20))

#         save_button = tk.Button(detail_window, text="Enregistrer les changements", bg='#4c68a8', fg='white', font=labelFont, relief='raised', padx=10, pady=5, command=save_changes)
#         save_button.pack(pady=10)

#         detail_window.mainloop()


#     def update_graphs(self):
#         statuses = ['Non traité', 'En cours de traitement', 'Traité']
#         values = [15, 30, 10]  # Replace with actual counts
#         self.ax.clear()
#         self.ax.pie(values, labels=statuses, autopct='%1.1f%%')
#         self.ax.set_title('Répartition des Statuts des Tickets')
#         self.canvas.draw()

#     def sort_by(self, col, descending):
#         data = [(self.tree.set(child, col), child) for child in self.tree.get_children('')]
#         data.sort(reverse=descending, key=lambda x: int(x[0]) if col == 'ID' else x[0])
#         for index, (val, k) in enumerate(data):
#             self.tree.move(k, '', index)
#         self.tree.heading(col, command=lambda: self.sort_by(col, not descending))

#     def update_status(self):
#         selected = self.tree.selection()
#         if selected:
#             item = self.tree.item(selected[0])
#             ticket_id = item['values'][0]
#             try:
#                 self.ticket_data.update_ticket(ticket_id, "En cours de traitement")
#                 self.load_tickets()
#                 self.update_graphs()
#                 messagebox.showinfo("Mise à jour", "Le statut du ticket a été mis à jour.")
#             except KeyError:
#                 messagebox.showerror("Erreur", f"Le ticket avec l'ID {ticket_id} n'existe pas.")

# if __name__ == "__main__":
#     root = tk.Tk()
#     root.geometry("800x600")
#     app = TicketManagement(master=root)
#     app.mainloop()

# import tkinter as tk
# from tkinter import ttk, messagebox, Toplevel, font as tkfont
# import matplotlib.pyplot as plt
# from matplotlib.backends.backend_tkagg import FigureCanvasTkAgg
# from data_model import TicketData  # Assurez-vous que cette classe est correctement définie pour gérer les données des tickets

# class TicketManagement(tk.Frame):
#     def __init__(self, master=None):
#         super().__init__(master)
#         self.grid(sticky="nsew")
#         self.master.grid_rowconfigure(0, weight=1)
#         self.master.grid_columnconfigure(0, weight=1)
#         self.ticket_data = TicketData()
#         self.create_widgets()

#     def create_widgets(self):
#         inner_frame = tk.Frame(self, bg='white')
#         inner_frame.grid(row=0, column=0, sticky="nsew")
#         self.grid_rowconfigure(0, weight=1)
#         self.grid_columnconfigure(0, weight=1)

#         # Treeview for displaying tickets
#         self.tree = ttk.Treeview(inner_frame, columns=('ID', 'Title', 'Status'), show='headings')
#         self.tree.grid(row=0, column=0, sticky='nsew', padx=10, pady=10)
#         self.tree.heading('ID', text='Numéro du Ticket', command=lambda: self.sort_by('ID', False))
#         self.tree.heading('Title', text='Titre', command=lambda: self.sort_by('Title', False))
#         self.tree.heading('Status', text='Statut', command=lambda: self.sort_by('Status', False))
#         self.tree.bind("<Double-1>", self.on_item_double_click)  # Binding double-click event

#         # Graph setup
#         self.figure, self.ax = plt.subplots(figsize=(5, 3))
#         self.canvas = FigureCanvasTkAgg(self.figure, master=inner_frame)
#         self.canvas_widget = self.canvas.get_tk_widget()
#         self.canvas_widget.grid(row=1, column=0, padx=10, pady=10)

#         self.load_tickets()
#         self.update_graphs()

#     def load_tickets(self):
#         self.tree.delete(*self.tree.get_children())  # Clear existing entries
#         tickets = self.ticket_data.get_tickets()
#         for ticket_id, ticket_info in sorted(tickets.items(), key=lambda x: x[1]['status']):
#             self.tree.insert('', tk.END, values=(ticket_id, ticket_info['title'], ticket_info['status']))

#     def on_item_double_click(self, event):
#         item_id = self.tree.selection()[0]  # Get selected item ID
#         ticket_id = self.tree.item(item_id, 'values')[0]
#         ticket_info = self.ticket_data.get_tickets()[ticket_id]

#         def save_changes():
#             new_status = status_var.get()
#             try:
#                 self.ticket_data.update_ticket(ticket_id, new_status)
#                 self.load_tickets()
#                 self.update_graphs()
#                 messagebox.showinfo("Mise à jour", "Le statut du ticket a été mis à jour.")
#                 detail_window.destroy()  # Fermer la fenêtre de détails après l'enregistrement des changements
#             except KeyError:
#                 messagebox.showerror("Erreur", f"Le ticket avec l'ID {ticket_id} n'existe pas.")

#         detail_window = Toplevel(self)
#         detail_window.title("Détails du Ticket")
#         detail_window.geometry("1000x800")  # Dimension ajustée pour un meilleur contrôle
#         detail_window.resizable(False, False)  # Empêche le redimensionnement de la fenêtre

#         # Fonts
#         labelFont = ('Helvetica', 12, 'bold')
#         entryFont = ('Helvetica', 12)

#         tk.Label(detail_window, text=f"Numéro du Ticket: {ticket_id}", font=labelFont).pack(pady=(10, 2))
#         tk.Label(detail_window, text=f"Titre: {ticket_info['title']}", font=entryFont).pack(pady=(5, 2))

#         description_label = tk.Label(detail_window, text="Description:", font=labelFont)
#         description_label.pack(pady=(10, 2))
#         description_frame = tk.Frame(detail_window)
#         description_frame.pack(fill='both', expand=True, padx=20, pady=5)
#         description_text = tk.Text(description_frame, height=6, width=50, font=entryFont, wrap='word')
#         description_text.insert(tk.END, ticket_info['description'])
#         description_text.configure(state='disabled')
#         scrollbar = tk.Scrollbar(description_frame, command=description_text.yview, orient='vertical')
#         scrollbar.pack(side='right', fill='y')
#         description_text.config(yscrollcommand=scrollbar.set)
#         description_text.pack(side='left', fill='both', expand=True)

#         status_label = tk.Label(detail_window, text="Statut:", font=labelFont)
#         status_label.pack(pady=(10, 2))
#         status_var = tk.StringVar(value=ticket_info['status'])
#         status_menu = ttk.Combobox(detail_window, textvariable=status_var, values=['Non traité', 'En cours de traitement', 'Traité'], state="readonly")
#         status_menu.pack(pady=(5, 20))

#         save_button = tk.Button(detail_window, text="Enregistrer les changements", bg='#4c68a8', fg='white', font=labelFont, relief='raised', padx=10, pady=5, command=save_changes)
#         save_button.pack(pady=10)

#         detail_window.mainloop()


#     def update_graphs(self):
#         statuses = ['Non traité', 'En cours de traitement', 'Traité']
#         values = [15, 30, 10]  # Replace with actual counts
#         self.ax.clear()
#         self.ax.pie(values, labels=statuses, autopct='%1.1f%%')
#         self.ax.set_title('Répartition des Statuts des Tickets')
#         self.canvas.draw()

#     def sort_by(self, col, descending):
#         data = [(self.tree.set(child, col), child) for child in self.tree.get_children('')]
#         data.sort(reverse=descending, key=lambda x: int(x[0]) if col == 'ID' else x[0])
#         for index, (val, k) in enumerate(data):
#             self.tree.move(k, '', index)
#         self.tree.heading(col, command=lambda: self.sort_by(col, not descending))

#     def update_status(self):
#         pass  # Suppression de la fonction inutile

# if __name__ == "__main__":
#     root = tk.Tk()
#     root.geometry("800x600")
#     app = TicketManagement(master=root)
#     app.mainloop()

# import tkinter as tk
# from tkinter import ttk, messagebox, Toplevel, font as tkfont
# import matplotlib.pyplot as plt
# from matplotlib.backends.backend_tkagg import FigureCanvasTkAgg
# from data_model import TicketData  # Assurez-vous que cette classe est correctement définie pour gérer les données des tickets

# class TicketManagement(tk.Frame):
#     def __init__(self, master=None):
#         super().__init__(master)
#         self.grid(sticky="nsew")
#         self.master.grid_rowconfigure(0, weight=1)
#         self.master.grid_columnconfigure(0, weight=1)
#         self.ticket_data = TicketData()
#         self.create_widgets()

#     def create_widgets(self):
#         inner_frame = tk.Frame(self, bg='white')
#         inner_frame.grid(row=0, column=0, sticky="nsew")
#         self.grid_rowconfigure(0, weight=1)
#         self.grid_columnconfigure(0, weight=1)

#         # Treeview for displaying tickets
#         self.tree = ttk.Treeview(inner_frame, columns=('ID', 'Title', 'Status'), show='headings')
#         self.tree.grid(row=0, column=0, sticky='nsew', padx=10, pady=10)
#         self.tree.heading('ID', text='Numéro du Ticket', command=lambda: self.sort_by('ID', False))
#         self.tree.heading('Title', text='Titre', command=lambda: self.sort_by('Title', False))
#         self.tree.heading('Status', text='Statut', command=lambda: self.sort_by('Status', False))
#         self.tree.bind("<Double-1>", self.on_item_double_click)  # Binding double-click event

#         # Graph setup
#         self.figure, self.ax = plt.subplots(figsize=(5, 3))
#         self.canvas = FigureCanvasTkAgg(self.figure, master=inner_frame)
#         self.canvas_widget = self.canvas.get_tk_widget()
#         self.canvas_widget.grid(row=1, column=0, padx=10, pady=10)

#         self.load_tickets()
#         self.update_graphs()

#     def load_tickets(self):
#         self.tree.delete(*self.tree.get_children())  # Clear existing entries
#         tickets = self.ticket_data.get_tickets()
#         for ticket_id, ticket_info in sorted(tickets.items(), key=lambda x: x[1]['status']):
#             self.tree.insert('', tk.END, values=(ticket_id, ticket_info['title'], ticket_info['status']))

#     def on_item_double_click(self, event):
#         item_id = self.tree.selection()[0]  # Get selected item ID
#         ticket_id = self.tree.item(item_id, 'values')[0]
#         ticket_info = self.ticket_data.get_tickets()[ticket_id]

#         def save_changes():
#             new_status = status_var.get()
#             try:
#                 self.ticket_data.update_ticket(ticket_id, new_status)
#                 self.load_tickets()
#                 self.update_graphs()
#                 messagebox.showinfo("Mise à jour", "Le statut du ticket a été mis à jour.")
#                 detail_window.destroy()  # Fermer la fenêtre de détails après l'enregistrement des changements
#             except KeyError:
#                 messagebox.showerror("Erreur", f"Le ticket avec l'ID {ticket_id} n'existe pas.")

#         detail_window = Toplevel(self)
#         detail_window.title("Détails du Ticket")
#         detail_window.geometry("1000x800")  # Dimension ajustée pour un meilleur contrôle
#         detail_window.resizable(False, False)  # Empêche le redimensionnement de la fenêtre

#         # Fonts
#         labelFont = ('Helvetica', 12, 'bold')
#         entryFont = ('Helvetica', 12)

#         tk.Label(detail_window, text=f"Numéro du Ticket: {ticket_id}", font=labelFont).pack(pady=(10, 2))
#         tk.Label(detail_window, text=f"Titre: {ticket_info['title']}", font=entryFont).pack(pady=(5, 2))

#         description_label = tk.Label(detail_window, text="Description:", font=labelFont)
#         description_label.pack(pady=(10, 2))
#         description_frame = tk.Frame(detail_window)
#         description_frame.pack(fill='both', expand=True, padx=20, pady=5)
#         description_text = tk.Text(description_frame, height=6, width=50, font=entryFont, wrap='word')
#         description_text.insert(tk.END, ticket_info['description'])
#         description_text.configure(state='disabled')
#         scrollbar = tk.Scrollbar(description_frame, command=description_text.yview, orient='vertical')
#         scrollbar.pack(side='right', fill='y')
#         description_text.config(yscrollcommand=scrollbar.set)
#         description_text.pack(side='left', fill='both', expand=True)

#         status_label = tk.Label(detail_window, text="Statut:", font=labelFont)
#         status_label.pack(pady=(10, 2))
#         status_var = tk.StringVar(value=ticket_info['status'])
#         status_menu = ttk.Combobox(detail_window, textvariable=status_var, values=['Non traité', 'En cours de traitement', 'Traité'], state="readonly")
#         status_menu.pack(pady=(5, 20))

#         save_button = tk.Button(detail_window, text="Enregistrer les changements", bg='#4c68a8', fg='white', font=labelFont, relief='raised', padx=10, pady=5, command=save_changes)
#         save_button.pack(pady=10)

#         detail_window.mainloop()


#     def calculate_ticket_counts(self):
#         ticket_counts = {'Non traité': 0, 'En cours de traitement': 0, 'Traité': 0}
#         tickets = self.ticket_data.get_tickets()
#         for ticket_info in tickets.values():
#             ticket_counts[ticket_info['status']] += 1
#         return ticket_counts

#     def update_graphs(self):
#         ticket_counts = self.calculate_ticket_counts()
#         statuses = ['Non traité', 'En cours de traitement', 'Traité']
#         values = [ticket_counts[status] for status in statuses]
#         total_tickets = sum(values)
#         percentages = [count / total_tickets * 100 if total_tickets > 0 else 0 for count in values]

#         self.ax.clear()
#         self.ax.pie(percentages, labels=statuses, autopct='%1.1f%%')
#         self.ax.set_title('Répartition des Statuts des Tickets')
#         self.canvas.draw()

#     def sort_by(self, col, descending):
#         data = [(self.tree.set(child, col), child) for child in self.tree.get_children('')]
#         data.sort(reverse=descending, key=lambda x: int(x[0]) if col == 'ID' else x[0])
#         for index, (val, k) in enumerate(data):
#             self.tree.move(k, '', index)
#         self.tree.heading(col, command=lambda: self.sort_by(col, not descending))

#     def update_status(self):
#         pass  # Suppression de la fonction inutile

# if __name__ == "__main__":
#     root = tk.Tk()
#     root.geometry("800x600")
#     app = TicketManagement(master=root)
#     app.mainloop()

# import tkinter as tk
# from tkinter import ttk, messagebox, Toplevel, font as tkfont
# import matplotlib.pyplot as plt
# from matplotlib.backends.backend_tkagg import FigureCanvasTkAgg
# from data_model import TicketData  # Assurez-vous que cette classe est correctement définie pour gérer les données des tickets

# class TicketManagement(tk.Frame):
#     def __init__(self, master=None):
#         super().__init__(master)
#         self.grid(sticky="nsew")
#         self.master.grid_rowconfigure(0, weight=1)
#         self.master.grid_columnconfigure(0, weight=1)
#         self.ticket_data = TicketData()
#         self.create_widgets()

#     def create_widgets(self):
#         inner_frame = tk.Frame(self, bg='white')
#         inner_frame.grid(row=0, column=0, sticky="nsew")
#         self.grid_rowconfigure(0, weight=1)
#         self.grid_columnconfigure(0, weight=1)

#         # Treeview for displaying tickets
#         self.tree = ttk.Treeview(inner_frame, columns=('ID', 'Title', 'Status'), show='headings')
#         self.tree.grid(row=0, column=0, sticky='nsew', padx=10, pady=10)
#         self.tree.heading('ID', text='Numéro du Ticket', command=lambda: self.sort_by('ID', False))
#         self.tree.heading('Title', text='Titre', command=lambda: self.sort_by('Title', False))
#         self.tree.heading('Status', text='Statut', command=lambda: self.sort_by('Status', False))
#         self.tree.bind("<Double-1>", self.on_item_double_click)  # Binding double-click event

#         # Refresh button
#         self.refresh_button = tk.Button(inner_frame, text="Actualiser", command=self.refresh_table)
#         self.refresh_button.grid(row=1, column=0, padx=10, pady=10)

#         # Graph setup
#         self.figure, self.ax = plt.subplots(figsize=(5, 3))
#         self.canvas = FigureCanvasTkAgg(self.figure, master=inner_frame)
#         self.canvas_widget = self.canvas.get_tk_widget()
#         self.canvas_widget.grid(row=2, column=0, padx=10, pady=10)

#         self.load_tickets()
#         self.update_graphs()

#     def load_tickets(self):
#         self.tree.delete(*self.tree.get_children())  # Clear existing entries
#         tickets = self.ticket_data.get_tickets()
#         for ticket_id, ticket_info in sorted(tickets.items(), key=lambda x: x[1]['status']):
#             self.tree.insert('', tk.END, values=(ticket_id, ticket_info['title'], ticket_info['status']))

#     def on_item_double_click(self, event):
#         item_id = self.tree.selection()[0]  # Get selected item ID
#         ticket_id = self.tree.item(item_id, 'values')[0]
#         ticket_info = self.ticket_data.get_tickets()[ticket_id]

#         def save_changes():
#             new_status = status_var.get()
#             try:
#                 self.ticket_data.update_ticket(ticket_id, new_status)
#                 self.load_tickets()
#                 self.update_graphs()
#                 messagebox.showinfo("Mise à jour", "Le statut du ticket a été mis à jour.")
#                 detail_window.destroy()  # Fermer la fenêtre de détails après l'enregistrement des changements
#             except KeyError:
#                 messagebox.showerror("Erreur", f"Le ticket avec l'ID {ticket_id} n'existe pas.")

#         detail_window = Toplevel(self)
#         detail_window.title("Détails du Ticket")
#         detail_window.geometry("1000x800")  # Dimension ajustée pour un meilleur contrôle
#         detail_window.resizable(False, False)  # Empêche le redimensionnement de la fenêtre

#         # Fonts
#         labelFont = ('Helvetica', 12, 'bold')
#         entryFont = ('Helvetica', 12)

#         tk.Label(detail_window, text=f"Numéro du Ticket: {ticket_id}", font=labelFont).pack(pady=(10, 2))
#         tk.Label(detail_window, text=f"Titre: {ticket_info['title']}", font=entryFont).pack(pady=(5, 2))

#         description_label = tk.Label(detail_window, text="Description:", font=labelFont)
#         description_label.pack(pady=(10, 2))
#         description_frame = tk.Frame(detail_window)
#         description_frame.pack(fill='both', expand=True, padx=20, pady=5)
#         description_text = tk.Text(description_frame, height=6, width=50, font=entryFont, wrap='word')
#         description_text.insert(tk.END, ticket_info['description'])
#         description_text.configure(state='disabled')
#         scrollbar = tk.Scrollbar(description_frame, command=description_text.yview, orient='vertical')
#         scrollbar.pack(side='right', fill='y')
#         description_text.config(yscrollcommand=scrollbar.set)
#         description_text.pack(side='left', fill='both', expand=True)

#         status_label = tk.Label(detail_window, text="Statut:", font=labelFont)
#         status_label.pack(pady=(10, 2))
#         status_var = tk.StringVar(value=ticket_info['status'])
#         status_menu = ttk.Combobox(detail_window, textvariable=status_var, values=['Non traité', 'En cours de traitement', 'Traité'], state="readonly")
#         status_menu.pack(pady=(5, 20))

#         save_button = tk.Button(detail_window, text="Enregistrer les changements", bg='#4c68a8', fg='white', font=labelFont, relief='raised', padx=10, pady=5, command=save_changes)
#         save_button.pack(pady=10)

#         detail_window.mainloop()

#     def calculate_ticket_counts(self):
#         ticket_counts = {'Non traité': 0, 'En cours de traitement': 0, 'Traité': 0}
#         tickets = self.ticket_data.get_tickets()
#         for ticket_info in tickets.values():
#             ticket_counts[ticket_info['status']] += 1
#         return ticket_counts

#     def update_graphs(self):
#         ticket_counts = self.calculate_ticket_counts()
#         statuses = ['Non traité', 'En cours de traitement', 'Traité']
#         values = [ticket_counts[status] for status in statuses]
#         total_tickets = sum(values)
#         percentages = [count / total_tickets * 100 if total_tickets > 0 else 0 for count in values]

#         self.ax.clear()
#         self.ax.pie(percentages, labels=statuses, autopct='%1.1f%%')
#         self.ax.set_title('Répartition des Statuts des Tickets')
#         self.canvas.draw()

#     def sort_by(self, col, descending):
#         data = [(self.tree.set(child, col), child) for child in self.tree.get_children('')]
#         data.sort(reverse=descending, key=lambda x: int(x[0]) if col == 'ID' else x[0])
#         for index, (val, k) in enumerate(data):
#             self.tree.move(k, '', index)
#         self.tree.heading(col, command=lambda: self.sort_by(col, not descending))

#     def refresh_table(self):
#         self.ticket_data.load_tickets()  # Charger à nouveau les tickets à partir de la classe TicketData
#         self.load_tickets()  # Charger les tickets dans l'interface
#         self.update_graphs()

# if __name__ == "__main__":
#     root = tk.Tk()
#     root.geometry("800x600")
#     app = TicketManagement(master=root)
#     app.mainloop()

# VERSION GRANDE
# import tkinter as tk
# from tkinter import ttk, messagebox, Toplevel
# import matplotlib.pyplot as plt
# from matplotlib.backends.backend_tkagg import FigureCanvasTkAgg
# from data_model import TicketData  # Assurez-vous que cette classe est correctement définie pour gérer les données des tickets

# class TicketManagement(tk.Frame):
#     def __init__(self, master=None):
#         super().__init__(master)
#         self.grid(sticky="nsew")
#         self.master.grid_rowconfigure(0, weight=1)
#         self.master.grid_columnconfigure(0, weight=1)
#         self.ticket_data = TicketData()
#         self.create_widgets()

#     def create_widgets(self):
#         self.grid_rowconfigure(0, weight=1)
#         self.grid_columnconfigure(0, weight=1)

#         inner_frame = tk.Frame(self, bg='white')
#         inner_frame.grid(row=0, column=0, sticky="nsew")
#         inner_frame.grid_rowconfigure(0, weight=1)
#         inner_frame.grid_columnconfigure(0, weight=1)

#         # Treeview for displaying tickets
#         self.tree = ttk.Treeview(inner_frame, columns=('ID', 'Title', 'Status'), show='headings')
#         self.tree.grid(row=0, column=0, sticky='nsew', padx=10, pady=10)
#         self.tree.heading('ID', text='Numéro du Ticket', command=lambda: self.sort_by('ID', False))
#         self.tree.heading('Title', text='Titre', command=lambda: self.sort_by('Title', False))
#         self.tree.heading('Status', text='Statut', command=lambda: self.sort_by('Status', False))
#         self.tree.bind("<Double-1>", self.on_item_double_click)  # Binding double-click event

#         # Refresh button
#         self.refresh_button = tk.Button(inner_frame, text="Actualiser", command=self.refresh_table)
#         self.refresh_button.grid(row=1, column=0, padx=10, pady=10)

#         # Graph setup
#         self.figure, self.ax = plt.subplots(figsize=(5, 3))
#         self.canvas = FigureCanvasTkAgg(self.figure, master=inner_frame)
#         self.canvas_widget = self.canvas.get_tk_widget()
#         self.canvas_widget.grid(row=2, column=0, padx=10, pady=10)

#         self.load_tickets()
#         self.update_graphs()

#         # Définir la taille minimale et maximale de inner_frame
#         inner_frame.update_idletasks()
#         inner_frame.minsize(inner_frame.winfo_reqwidth(), inner_frame.winfo_reqheight())
#         inner_frame.maxsize(inner_frame.winfo_reqwidth(), inner_frame.winfo_reqheight())

#     def load_tickets(self):
#         self.tree.delete(*self.tree.get_children())  # Clear existing entries
#         tickets = self.ticket_data.get_tickets()
#         for ticket_id, ticket_info in sorted(tickets.items(), key=lambda x: x[1]['status']):
#             self.tree.insert('', tk.END, values=(ticket_id, ticket_info['title'], ticket_info['status']))

#     def on_item_double_click(self, event):
#         item_id = self.tree.selection()[0]  # Get selected item ID
#         ticket_id = self.tree.item(item_id, 'values')[0]
#         ticket_info = self.ticket_data.get_tickets()[ticket_id]

#         def save_changes():
#             new_status = status_var.get()
#             try:
#                 self.ticket_data.update_ticket(ticket_id, new_status)
#                 self.load_tickets()
#                 self.update_graphs()
#                 messagebox.showinfo("Mise à jour", "Le statut du ticket a été mis à jour.")
#                 detail_window.destroy()  # Fermer la fenêtre de détails après l'enregistrement des changements
#             except KeyError:
#                 messagebox.showerror("Erreur", f"Le ticket avec l'ID {ticket_id} n'existe pas.")

#         detail_window = Toplevel(self)
#         detail_window.title("Détails du Ticket")
#         detail_window.geometry("1000x800")  # Dimension ajustée pour un meilleur contrôle
#         detail_window.resizable(False, False)  # Empêche le redimensionnement de la fenêtre

#         # Fonts
#         labelFont = ('Helvetica', 12, 'bold')
#         entryFont = ('Helvetica', 12)

#         tk.Label(detail_window, text=f"Numéro du Ticket: {ticket_id}", font=labelFont).pack(pady=(10, 2))
#         tk.Label(detail_window, text=f"Titre: {ticket_info['title']}", font=entryFont).pack(pady=(5, 2))

#         description_label = tk.Label(detail_window, text="Description:", font=labelFont)
#         description_label.pack(pady=(10, 2))
#         description_frame = tk.Frame(detail_window)
#         description_frame.pack(fill='both', expand=True, padx=20, pady=5)
#         description_text = tk.Text(description_frame, height=6, width=50, font=entryFont, wrap='word')
#         description_text.insert(tk.END, ticket_info['description'])
#         description_text.configure(state='disabled')
#         scrollbar = tk.Scrollbar(description_frame, command=description_text.yview, orient='vertical')
#         scrollbar.pack(side='right', fill='y')
#         description_text.config(yscrollcommand=scrollbar.set)
#         description_text.pack(side='left', fill='both', expand=True)

#         status_label = tk.Label(detail_window, text="Statut:", font=labelFont)
#         status_label.pack(pady=(10, 2))
#         status_var = tk.StringVar(value=ticket_info['status'])
#         status_menu = ttk.Combobox(detail_window, textvariable=status_var, values=['Non traité', 'En cours de traitement', 'Traité'], state="readonly")
#         status_menu.pack(pady=(5, 20))

#         save_button = tk.Button(detail_window, text="Enregistrer les changements", bg='#4c68a8', fg='white', font=labelFont, relief='raised', padx=10, pady=5, command=save_changes)
#         save_button.pack(pady=10)

#         detail_window.mainloop()

#     def calculate_ticket_counts(self):
#         ticket_counts = {'Non traité': 0, 'En cours de traitement': 0, 'Traité': 0}
#         tickets = self.ticket_data.get_tickets()
#         for ticket_info in tickets.values():
#             ticket_counts[ticket_info['status']] += 1
#         return ticket_counts

#     def update_graphs(self):
#         ticket_counts = self.calculate_ticket_counts()
#         statuses = ['Non traité', 'En cours de traitement', 'Traité']
#         values = [ticket_counts[status] for status in statuses]
#         total_tickets = sum(values)
#         percentages = [count / total_tickets * 100 if total_tickets > 0 else 0 for count in values]

#         self.ax.clear()
#         self.ax.pie(percentages, labels=statuses, autopct='%1.1f%%')
#         self.ax.set_title('Répartition des Statuts des Tickets')
#         self.canvas.draw()

#     def sort_by(self, col, descending):
#         data = [(self.tree.set(child, col), child) for child in self.tree.get_children('')]
#         data.sort(reverse=descending, key=lambda x: int(x[0]) if col == 'ID' else x[0])
#         for index, (val, k) in enumerate(data):
#             self.tree.move(k, '', index)
#         self.tree.heading(col, command=lambda: self.sort_by(col, not descending))

#     def refresh_table(self):
#         self.ticket_data.load_tickets()  # Charger à nouveau les tickets à partir de la classe TicketData
#         self.load_tickets()  # Charger les tickets dans l'interface
#         self.update_graphs()

# if __name__ == "__main__":
#     root = tk.Tk()
#     root.geometry("800x600")
#     app = TicketManagement(master=root)
#     app.mainloop()

# VERSION PETITE
# import tkinter as tk
# from tkinter import ttk, messagebox, Toplevel
# import matplotlib.pyplot as plt
# from matplotlib.backends.backend_tkagg import FigureCanvasTkAgg
# from data_model import TicketData  # Assurez-vous que cette classe est correctement définie pour gérer les données des tickets

# class TicketManagement(tk.Frame):
#     def __init__(self, master=None):
#         super().__init__(master)
#         self.grid(sticky="nsew")
#         self.master.grid_rowconfigure(0, weight=1)
#         self.master.grid_columnconfigure(0, weight=1)
#         self.ticket_data = TicketData()
#         self.create_widgets()

#     def create_widgets(self):
#         self.grid_rowconfigure(0, weight=1)
#         self.grid_columnconfigure(0, weight=1)

#         inner_frame = tk.Frame(self, bg='white')
#         inner_frame.grid(row=0, column=0, sticky="nsew")
#         inner_frame.grid_rowconfigure(0, weight=1)
#         inner_frame.grid_columnconfigure(0, weight=1)

#         # Treeview for displaying tickets
#         self.tree = ttk.Treeview(inner_frame, columns=('ID', 'Title', 'Status'), show='headings')
#         self.tree.grid(row=0, column=0, sticky='nsew', padx=10, pady=10)
#         self.tree.heading('ID', text='Numéro du Ticket', command=lambda: self.sort_by('ID', False))
#         self.tree.heading('Title', text='Titre', command=lambda: self.sort_by('Title', False))
#         self.tree.heading('Status', text='Statut', command=lambda: self.sort_by('Status', False))
#         self.tree.bind("<Double-1>", self.on_item_double_click)  # Binding double-click event

#         # Refresh button
#         self.refresh_button = tk.Button(inner_frame, text="Actualiser", command=self.refresh_table)
#         self.refresh_button.grid(row=1, column=0, padx=10, pady=10)

#         # Graph setup
#         self.figure, self.ax = plt.subplots(figsize=(5, 3))
#         self.canvas = FigureCanvasTkAgg(self.figure, master=inner_frame)
#         self.canvas_widget = self.canvas.get_tk_widget()
#         self.canvas_widget.grid(row=2, column=0, padx=10, pady=10)

#         self.load_tickets()
#         self.update_graphs()

#         # Définir la taille minimale et maximale de inner_frame
#         inner_frame.update_idletasks()
#         self.master.minsize(inner_frame.winfo_reqwidth(), inner_frame.winfo_reqheight())
#         self.master.maxsize(inner_frame.winfo_reqwidth(), inner_frame.winfo_reqheight())

#     def load_tickets(self):
#         self.tree.delete(*self.tree.get_children())  # Clear existing entries
#         tickets = self.ticket_data.get_tickets()
#         for ticket_id, ticket_info in sorted(tickets.items(), key=lambda x: x[1]['status']):
#             self.tree.insert('', tk.END, values=(ticket_id, ticket_info['title'], ticket_info['status']))

#     def on_item_double_click(self, event):
#         item_id = self.tree.selection()[0]  # Get selected item ID
#         ticket_id = self.tree.item(item_id, 'values')[0]
#         ticket_info = self.ticket_data.get_tickets()[ticket_id]

#         def save_changes():
#             new_status = status_var.get()
#             try:
#                 self.ticket_data.update_ticket(ticket_id, new_status)
#                 self.load_tickets()
#                 self.update_graphs()
#                 messagebox.showinfo("Mise à jour", "Le statut du ticket a été mis à jour.")
#                 detail_window.destroy()  # Fermer la fenêtre de détails après l'enregistrement des changements
#             except KeyError:
#                 messagebox.showerror("Erreur", f"Le ticket avec l'ID {ticket_id} n'existe pas.")

#         detail_window = Toplevel(self)
#         detail_window.title("Détails du Ticket")
#         detail_window.geometry("1000x800")  # Dimension ajustée pour un meilleur contrôle
#         detail_window.resizable(False, False)  # Empêche le redimensionnement de la fenêtre

#         # Fonts
#         labelFont = ('Helvetica', 12, 'bold')
#         entryFont = ('Helvetica', 12)

#         tk.Label(detail_window, text=f"Numéro du Ticket: {ticket_id}", font=labelFont).pack(pady=(10, 2))
#         tk.Label(detail_window, text=f"Titre: {ticket_info['title']}", font=entryFont).pack(pady=(5, 2))

#         description_label = tk.Label(detail_window, text="Description:", font=labelFont)
#         description_label.pack(pady=(10, 2))
#         description_frame = tk.Frame(detail_window)
#         description_frame.pack(fill='both', expand=True, padx=20, pady=5)
#         description_text = tk.Text(description_frame, height=6, width=50, font=entryFont, wrap='word')
#         description_text.insert(tk.END, ticket_info['description'])
#         description_text.configure(state='disabled')
#         scrollbar = tk.Scrollbar(description_frame, command=description_text.yview, orient='vertical')
#         scrollbar.pack(side='right', fill='y')
#         description_text.config(yscrollcommand=scrollbar.set)
#         description_text.pack(side='left', fill='both', expand=True)

#         status_label = tk.Label(detail_window, text="Statut:", font=labelFont)
#         status_label.pack(pady=(10, 2))
#         status_var = tk.StringVar(value=ticket_info['status'])
#         status_menu = ttk.Combobox(detail_window, textvariable=status_var, values=['Non traité', 'En cours de traitement', 'Traité'], state="readonly")
#         status_menu.pack(pady=(5, 20))

#         save_button = tk.Button(detail_window, text="Enregistrer les changements", bg='#4c68a8', fg='white', font=labelFont, relief='raised', padx=10, pady=5, command=save_changes)
#         save_button.pack(pady=10)

#         detail_window.mainloop()

#     def calculate_ticket_counts(self):
#         ticket_counts = {'Non traité': 0, 'En cours de traitement': 0, 'Traité': 0}
#         tickets = self.ticket_data.get_tickets()
#         for ticket_info in tickets.values():
#             ticket_counts[ticket_info['status']] += 1
#         return ticket_counts

#     def update_graphs(self):
#         ticket_counts = self.calculate_ticket_counts()
#         statuses = ['Non traité', 'En cours de traitement', 'Traité']
#         values = [ticket_counts[status] for status in statuses]
#         total_tickets = sum(values)
#         percentages = [count / total_tickets * 100 if total_tickets > 0 else 0 for count in values]

#         self.ax.clear()
#         self.ax.pie(percentages, labels=statuses, autopct='%1.1f%%')
#         self.ax.set_title('Répartition des Statuts des Tickets')
#         self.canvas.draw()

#     def sort_by(self, col, descending):
#         data = [(self.tree.set(child, col), child) for child in self.tree.get_children('')]
#         data.sort(reverse=descending, key=lambda x: int(x[0]) if col == 'ID' else x[0])
#         for index, (val, k) in enumerate(data):
#             self.tree.move(k, '', index)
#         self.tree.heading(col, command=lambda: self.sort_by(col, not descending))

#     def refresh_table(self):
#         self.ticket_data.load_tickets()  # Charger à nouveau les tickets à partir de la classe TicketData
#         self.load_tickets()  # Charger les tickets dans l'interface
#         self.update_graphs()

# if __name__ == "__main__":
#     root = tk.Tk()
#     root.geometry("800x600")
#     app = TicketManagement(master=root)
#     app.mainloop()

# import tkinter as tk
# from tkinter import ttk, messagebox, Toplevel
# import matplotlib.pyplot as plt
# from matplotlib.backends.backend_tkagg import FigureCanvasTkAgg
# from data_model import TicketData  # Assurez-vous que cette classe est correctement définie pour gérer les données des tickets
# import datetime

# class TicketManagement(tk.Frame):
#     def __init__(self, master=None):
#         super().__init__(master)
#         self.grid(sticky="nsew")
#         self.master.grid_rowconfigure(0, weight=1)
#         self.master.grid_columnconfigure(0, weight=1)
#         self.ticket_data = TicketData()
#         self.create_widgets()

#     def create_widgets(self):
#         self.grid_rowconfigure(0, weight=1)
#         self.grid_columnconfigure(0, weight=1)

#         inner_frame = tk.Frame(self, bg='white')
#         inner_frame.grid(row=0, column=0, sticky="nsew")
#         inner_frame.grid_rowconfigure(0, weight=1)
#         inner_frame.grid_columnconfigure(0, weight=1)

#         # Treeview for displaying tickets with scrollbar
#         self.tree = ttk.Treeview(inner_frame, columns=('ID', 'Title', 'Status', 'Date'), show='headings')
#         self.tree.grid(row=0, column=0, sticky='nsew', padx=10, pady=10)

#         # Scrollbar
#         tree_scroll = ttk.Scrollbar(inner_frame, orient="vertical", command=self.tree.yview)
#         tree_scroll.grid(row=0, column=1, sticky='ns')
#         self.tree.config(yscrollcommand=tree_scroll.set)

#         self.tree.heading('ID', text='Numéro du Ticket', command=lambda: self.sort_by('ID', False))
#         self.tree.heading('Title', text='Titre', command=lambda: self.sort_by('Title', False))
#         self.tree.heading('Status', text='Statut', command=lambda: self.sort_by('Status', False))
#         self.tree.heading('Date', text='Date', command=lambda: self.sort_by('Date', False))
#         self.tree.bind("<Double-1>", self.on_item_double_click)  # Binding double-click event

#         # Refresh button
#         self.refresh_button = tk.Button(inner_frame, text="Actualiser", command=self.refresh_table)
#         self.refresh_button.grid(row=1, column=0, padx=10, pady=10)

#         # Graph setup
#         self.figure, self.ax = plt.subplots(figsize=(5, 3))
#         self.canvas = FigureCanvasTkAgg(self.figure, master=inner_frame)
#         self.canvas_widget = self.canvas.get_tk_widget()
#         self.canvas_widget.grid(row=2, column=0, padx=10, pady=10)

#         self.load_tickets()
#         self.update_graphs()

#         # Définir la taille minimale et maximale de inner_frame
#         inner_frame.update_idletasks()
#         self.master.minsize(inner_frame.winfo_reqwidth(), inner_frame.winfo_reqheight())
#         self.master.maxsize(inner_frame.winfo_reqwidth(), inner_frame.winfo_reqheight())

#     def load_tickets(self):
#         self.tree.delete(*self.tree.get_children())  # Clear existing entries
#         tickets = self.ticket_data.get_tickets()
#         for ticket_id, ticket_info in sorted(tickets.items(), key=lambda x: x[1]['status']):
#             date_formatted = self.format_date(ticket_info.get('date'))
#             self.tree.insert('', tk.END, values=(ticket_id, ticket_info['title'], ticket_info['status'], date_formatted))

#     def on_item_double_click(self, event):
#         item_id = self.tree.selection()[0]  # Get selected item ID
#         ticket_id = self.tree.item(item_id, 'values')[0]
#         ticket_info = self.ticket_data.get_tickets()[ticket_id]

#         def save_changes():
#             new_status = status_var.get()
#             try:
#                 self.ticket_data.update_ticket(ticket_id, new_status)
#                 self.load_tickets()
#                 self.update_graphs()
#                 messagebox.showinfo("Mise à jour", "Le statut du ticket a été mis à jour.")
#                 detail_window.destroy()  # Fermer la fenêtre de détails après l'enregistrement des changements
#             except KeyError:
#                 messagebox.showerror("Erreur", f"Le ticket avec l'ID {ticket_id} n'existe pas.")

#         detail_window = Toplevel(self)
#         detail_window.title("Détails du Ticket")
#         detail_window.geometry("1000x800")  # Dimension ajustée pour un meilleur contrôle
#         detail_window.resizable(False, False)  # Empêche le redimensionnement de la fenêtre

#         # Fonts
#         labelFont = ('Helvetica', 12, 'bold')
#         entryFont = ('Helvetica', 12)

#         tk.Label(detail_window, text=f"Numéro du Ticket: {ticket_id}", font=labelFont).pack(pady=(10, 2))
#         tk.Label(detail_window, text=f"Titre: {ticket_info['title']}", font=entryFont).pack(pady=(5, 2))

#         description_label = tk.Label(detail_window, text="Description:", font=labelFont)
#         description_label.pack(pady=(10, 2))
#         description_frame = tk.Frame(detail_window)
#         description_frame.pack(fill='both', expand=True, padx=20, pady=5)
#         description_text = tk.Text(description_frame, height=6, width=50, font=entryFont, wrap='word')
#         description_text.insert(tk.END, ticket_info['description'])
#         description_text.configure(state='disabled')
#         scrollbar = tk.Scrollbar(description_frame, command=description_text.yview, orient='vertical')
#         scrollbar.pack(side='right', fill='y')
#         description_text.config(yscrollcommand=scrollbar.set)
#         description_text.pack(side='left', fill='both', expand=True)

#         status_label = tk.Label(detail_window, text="Statut:", font=labelFont)
#         status_label.pack(pady=(10, 2))
#         status_var = tk.StringVar(value=ticket_info['status'])
#         status_menu = ttk.Combobox(detail_window, textvariable=status_var, values=['Non traité', 'En cours de traitement', 'Traité'], state="readonly")
#         status_menu.pack(pady=(5, 20))

#         save_button = tk.Button(detail_window, text="Enregistrer les changements", bg='#4c68a8', fg='white', font=labelFont, relief='raised', padx=10, pady=5, command=save_changes)
#         save_button.pack(pady=10)

#         detail_window.mainloop()

#     def calculate_ticket_counts(self):
#         ticket_counts = {'Non traité': 0, 'En cours de traitement': 0, 'Traité': 0}
#         tickets = self.ticket_data.get_tickets()
#         for ticket_info in tickets.values():
#             ticket_counts[ticket_info['status']] += 1
#         return ticket_counts

#     def update_graphs(self):
#         ticket_counts = self.calculate_ticket_counts()
#         statuses = ['Non traité', 'En cours de traitement', 'Traité']
#         values = [ticket_counts[status] for status in statuses]
#         total_tickets = sum(values)
#         percentages = [count / total_tickets * 100 if total_tickets > 0 else 0 for count in values]

#         self.ax.clear()
#         self.ax.pie(percentages, labels=statuses, autopct='%1.1f%%')
#         self.ax.set_title('Répartition des Statuts des Tickets')
#         self.canvas.draw()

#     def sort_by(self, col, descending):
#         data = [(self.tree.set(child, col), child) for child in self.tree.get_children('')]
#         data.sort(reverse=descending, key=lambda x: int(x[0]) if col == 'ID' else x[0])
#         for index, (val, k) in enumerate(data):
#             self.tree.move(k, '', index)
#         self.tree.heading(col, command=lambda: self.sort_by(col, not descending))

#     def refresh_table(self):
#         self.ticket_data.load_tickets()  # Charger à nouveau les tickets à partir de la classe TicketData
#         self.load_tickets()  # Charger les tickets dans l'interface
#         self.update_graphs()

#     def format_date(self, date_str):
#         if date_str:
#             date = datetime.datetime.strptime(date_str, "%Y-%m-%d %H:%M:%S")
#             return date.strftime("%d/%m/%Y")
#         else:
#             return ""

# if __name__ == "__main__":
#     root = tk.Tk()
#     root.geometry("800x600")
#     app = TicketManagement(master=root)
#     app.mainloop()

import tkinter as tk
from tkinter import ttk, messagebox, Toplevel
import matplotlib.pyplot as plt
from matplotlib.backends.backend_tkagg import FigureCanvasTkAgg
from data_model import TicketData  # Assurez-vous que cette classe est correctement définie pour gérer les données des tickets
import datetime

class TicketManagement(tk.Frame):
    def __init__(self, master=None):
        super().__init__(master)
        self.grid(sticky="nsew")
        self.master.grid_rowconfigure(0, weight=1)
        self.master.grid_columnconfigure(0, weight=1)
        self.ticket_data = TicketData()
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
        self.tree.delete(*self.tree.get_children())  # Clear existing entries
        tickets = self.ticket_data.get_tickets()
        for ticket_id, ticket_info in sorted(tickets.items(), key=lambda x: x[1]['status']):
            date_formatted = self.format_date(ticket_info.get('date'))
            self.tree.insert('', tk.END, values=(ticket_id, ticket_info['title'], ticket_info['status'], date_formatted))

    def on_item_double_click(self, event):
        item_id = self.tree.selection()[0]  # Get selected item ID
        ticket_id = self.tree.item(item_id, 'values')[0]
        ticket_info = self.ticket_data.get_tickets()[ticket_id]

        def save_changes():
            new_status = status_var.get()
            try:
                self.ticket_data.update_ticket(ticket_id, new_status)
                self.load_tickets()
                self.update_graphs()
                messagebox.showinfo("Mise à jour", "Le statut du ticket a été mis à jour.")
                detail_window.destroy()  # Fermer la fenêtre de détails après l'enregistrement des changements
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
        tk.Label(detail_window, text=f"Titre: {ticket_info['title']}", font=entryFont).pack(pady=(5, 2))
        tk.Label(detail_window, text=f"Date: {self.format_date(ticket_info.get('date'))}", font=entryFont).pack(pady=(5, 2))

        description_label = tk.Label(detail_window, text="Description:", font=labelFont)
        description_label.pack(pady=(10, 2))
        description_frame = tk.Frame(detail_window)
        description_frame.pack(fill='both', expand=True, padx=20, pady=5)
        description_text = tk.Text(description_frame, height=6, width=50, font=entryFont, wrap='word')
        description_text.insert(tk.END, ticket_info['description'])
        description_text.configure(state='disabled')
        scrollbar = tk.Scrollbar(description_frame, command=description_text.yview, orient='vertical')
        scrollbar.pack(side='right', fill='y')
        description_text.config(yscrollcommand=scrollbar.set)
        description_text.pack(side='left', fill='both', expand=True)

        status_label = tk.Label(detail_window, text="Statut:", font=labelFont)
        status_label.pack(pady=(10, 2))
        status_var = tk.StringVar(value=ticket_info['status'])
        status_menu = ttk.Combobox(detail_window, textvariable=status_var, values=['Non traité', 'En cours de traitement', 'Traité'], state="readonly")
        status_menu.pack(pady=(5, 20))

        save_button = tk.Button(detail_window, text="Enregistrer les changements", bg='#4c68a8', fg='white', font=labelFont, relief='raised', padx=10, pady=5, command=save_changes)
        save_button.pack(pady=10)

        self.wait_window(detail_window)

    def calculate_ticket_counts(self):
        ticket_counts = {'Non traité': 0, 'En cours de traitement': 0, 'Traité': 0}
        tickets = self.ticket_data.get_tickets()
        for ticket_info in tickets.values():
            ticket_counts[ticket_info['status']] += 1
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
        self.ticket_data.load_tickets()  # Charger à nouveau les tickets à partir de la classe TicketData
        self.load_tickets()  # Charger les tickets dans l'interface
        self.update_graphs()

    def format_date(self, date_str):
        if date_str:
            date = datetime.datetime.strptime(date_str, "%Y-%m-%d %H:%M:%S")
            return date.strftime("%d/%m/%Y")
        else:
            return ""


