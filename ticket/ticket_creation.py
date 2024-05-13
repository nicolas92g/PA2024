# import tkinter as tk
# from data_model import TicketData

# class TicketCreation(tk.Frame):
#     def __init__(self, master=None):
#         super().__init__(master)
#         self.master = master
#         self.pack()
#         self.create_widgets()
#         self.ticket_data = TicketData()

#     def create_widgets(self):
#         self.title_label = tk.Label(self, text="Titre du ticket")
#         self.title_label.pack()

#         self.title_entry = tk.Entry(self)
#         self.title_entry.pack()

#         self.desc_label = tk.Label(self, text="Description")
#         self.desc_label.pack()

#         self.desc_entry = tk.Text(self, height=4, width=50)
#         self.desc_entry.pack()

#         self.status_label = tk.Label(self, text="Statut")
#         self.status_label.pack()

#         self.status_var = tk.StringVar(self)
#         self.status_var.set("Non traité")
#         self.status_menu = tk.OptionMenu(self, self.status_var, "Non traité", "En cours de traitement", "Traité")
#         self.status_menu.pack()

#         self.submit_button = tk.Button(self, text="Envoyer le Ticket", command=self.submit_ticket)
#         self.submit_button.pack()

#     def submit_ticket(self):
#         title = self.title_entry.get()
#         description = self.desc_entry.get("1.0", "end-1c")
#         status = self.status_var.get()
#         self.ticket_data.add_ticket(title, description, status)
#         print("Ticket soumis avec succès : ", self.ticket_data.get_tickets())

# import tkinter as tk
# from tkinter import messagebox
# from data_model import TicketData

# class TicketCreation(tk.Frame):
#     def __init__(self, master=None):
#         super().__init__(master)
#         self.master = master
#         self.pack()
#         self.create_widgets()
#         self.ticket_data = TicketData()

#     def create_widgets(self):
#         self.title_label = tk.Label(self, text="Titre du ticket")
#         self.title_label.pack()

#         self.title_entry = tk.Entry(self)
#         self.title_entry.pack()

#         self.desc_label = tk.Label(self, text="Description")
#         self.desc_label.pack()

#         self.desc_entry = tk.Text(self, height=4, width=50)
#         self.desc_entry.pack()

#         self.status_label = tk.Label(self, text="Statut")
#         self.status_label.pack()

#         # Configurer la valeur par défaut et désactiver la modification
#         self.status_var = tk.StringVar(self)
#         self.status_var.set("Non traité")  # Définit par défaut sur "Non traité"
#         self.status_menu = tk.OptionMenu(self, self.status_var, "Non traité")
#         self.status_menu.config(state="disabled")  # Désactiver le menu déroulant pour empêcher les modifications
#         self.status_menu.pack()

#         self.submit_button = tk.Button(self, text="Envoyer le Ticket", command=self.submit_ticket)
#         self.submit_button.pack()

#     def submit_ticket(self):
#         title = self.title_entry.get().strip()
#         description = self.desc_entry.get("1.0", "end-1c").strip()
#         status = self.status_var.get()
#         if title and description:
#             self.ticket_data.add_ticket(title, description, status)
#             messagebox.showinfo("Succès", "Ticket soumis avec succès.")
#             self.title_entry.delete(0, 'end')
#             self.desc_entry.delete('1.0', 'end')
#         else:
#             messagebox.showerror("Erreur", "Le titre et la description ne peuvent pas être vides.")

# import tkinter as tk
# from tkinter import messagebox, font as tkfont
# from data_model import TicketData

# class TicketCreation(tk.Frame):
#     def __init__(self, master=None):
#         super().__init__(master)
#         self.master = master
#         self.grid(sticky="nsew")
#         self.create_widgets()
#         self.ticket_data = TicketData()

#     def create_widgets(self):
#         # Configurer le grid du frame principal
#         self.master.title("Création de Ticket")
#         self.master.grid_columnconfigure(0, weight=1)  # Centrer les widgets

#         # Polices personnalisées
#         labelFont = tkfont.Font(family="Helvetica", size=10, weight="bold")
#         entryFont = tkfont.Font(family="Helvetica", size=10)

#         # Titre du ticket
#         self.title_label = tk.Label(self, text="Titre du ticket", font=labelFont)
#         self.title_label.grid(row=0, column=0, padx=10, pady=10, sticky="ew")

#         self.title_entry = tk.Entry(self, font=entryFont)
#         self.title_entry.grid(row=1, column=0, padx=50, pady=10, sticky="ew")

#         # Description
#         self.desc_label = tk.Label(self, text="Description", font=labelFont)
#         self.desc_label.grid(row=2, column=0, padx=10, pady=10, sticky="ew")

#         self.desc_entry = tk.Text(self, height=4, width=50, font=entryFont)
#         self.desc_entry.grid(row=3, column=0, padx=50, pady=10, sticky="ew")

#         # Statut
#         self.status_label = tk.Label(self, text="Statut", font=labelFont)
#         self.status_label.grid(row=4, column=0, padx=10, pady=10, sticky="ew")

#         self.status_var = tk.StringVar(self)
#         self.status_var.set("Non traité")
#         self.status_menu = tk.OptionMenu(self, self.status_var, "Non traité")
#         self.status_menu.config(state="disabled", font=entryFont)
#         self.status_menu.grid(row=5, column=0, padx=50, pady=10, sticky="ew")

#         # Bouton de soumission
#         self.submit_button = tk.Button(self, text="Envoyer le Ticket", command=self.submit_ticket, font=labelFont, bg='#333', fg='white')
#         self.submit_button.grid(row=6, column=0, padx=50, pady=20, sticky="ew")

#     def submit_ticket(self):
#         title = self.title_entry.get().strip()
#         description = self.desc_entry.get("1.0", "end-1c").strip()
#         status = self.status_var.get()
#         if title and description:
#             self.ticket_data.add_ticket(title, description, status)
#             messagebox.showinfo("Succès", "Ticket soumis avec succès.")
#             self.title_entry.delete(0, 'end')
#             self.desc_entry.delete('1.0', 'end')
#         else:
#             messagebox.showerror("Erreur", "Le titre et la description ne peuvent pas être vides.")

# import tkinter as tk
# from tkinter import messagebox, font as tkfont
# from tkinter import Scrollbar
# from data_model import TicketData
# from api_request import api_request

# class TicketCreation(tk.Frame):
#     def __init__(self, master=None):
#         super().__init__(master)
#         self.master = master
#         self.config(bg='white')
#         self.grid(sticky="nsew")

#         # Configure grid for self to expand and contract with the window
#         self.master.grid_rowconfigure(0, weight=1)
#         self.master.grid_columnconfigure(0, weight=1)

#         # Initialize ticket data model
#         self.ticket_data = TicketData()

#         self.create_widgets()

#     def create_widgets(self):
#         # Frame to hold widgets, centered in the middle of the window
#         inner_frame = tk.Frame(self, bg='white')
#         inner_frame.grid(row=0, column=0, sticky="nsew")

#         # Grid configuration for self to center the inner_frame both horizontally and vertically
#         self.grid_rowconfigure(0, weight=1)
#         self.grid_columnconfigure(0, weight=1)

#         # Setting the grid configuration for inner_frame to center its contents
#         inner_frame.grid_rowconfigure(0, weight=1)
#         inner_frame.grid_rowconfigure(7, weight=1)  # Add extra rowconfigure for vertical padding at the bottom
#         inner_frame.grid_columnconfigure(0, weight=1)
#         inner_frame.grid_columnconfigure(2, weight=1)  # Adding columns on either side of the main column

#         # Fonts
#         labelFont = tkfont.Font(family="Helvetica", size=12, weight="bold")
#         entryFont = tkfont.Font(family="Helvetica", size=12)

#         # Widgets setup, placed in the center column of the inner_frame
#         tk.Label(inner_frame, text="Titre du ticket", font=labelFont, bg='white').grid(row=1, column=1, sticky="ew")
#         self.title_entry = tk.Entry(inner_frame, font=entryFont)
#         self.title_entry.grid(row=2, column=1, sticky="ew")

#         tk.Label(inner_frame, text="Description", font=labelFont, bg='white').grid(row=3, column=1, sticky="ew")
#         self.desc_entry = tk.Text(inner_frame, height=4, font=entryFont)
#         self.desc_entry.grid(row=4, column=1, sticky="ew")

#         # Scrollbar for description text
#         scrollbar = Scrollbar(inner_frame, command=self.desc_entry.yview)
#         scrollbar.grid(row=4, column=2, sticky='ns')
#         self.desc_entry.config(yscrollcommand=scrollbar.set)

#         tk.Label(inner_frame, text="Statut", font=labelFont, bg='white').grid(row=5, column=1, sticky="ew")
#         self.status_var = tk.StringVar(self)
#         self.status_var.set("Non traité")
#         status_menu = tk.OptionMenu(inner_frame, self.status_var, "Non traité")
#         status_menu.config(state="disabled", font=entryFont)
#         status_menu.grid(row=6, column=1, sticky="ew")

#         submit_button = tk.Button(inner_frame, text="Envoyer le Ticket", command=self.submit_ticket, bg='#4c68a8', fg='white', font=labelFont)
#         submit_button.grid(row=7, column=1, sticky="ew")

#     def submit_ticket(self):
#         title = self.title_entry.get().strip()
#         description = self.desc_entry.get("1.0", "end-1c").strip()
#         status = self.status_var.get()
#         if title and description:
#             self.ticket_data.add_ticket(title, description, status)
#             messagebox.showinfo("Succès", "Ticket soumis avec succès.")
#             self.title_entry.delete(0, 'end')
#             self.desc_entry.delete('1.0', 'end')
#         else:
#             messagebox.showerror("Erreur", "Le titre et la description ne peuvent pas être vides.")

# if __name__ == "__main__":
#     root = tk.Tk()
#     root.geometry("1000x1000")  # Initial size of the window
#     app = TicketCreation(master=root)
#     app.mainloop()

import tkinter as tk
from tkinter import messagebox, font as tkfont
from tkinter import Scrollbar
import api_request 
from data_model import TicketData
from datetime import datetime

class TicketCreation(tk.Frame):
    def __init__(self, master=None):
        super().__init__(master)
        self.master = master
        self.config(bg='white')
        self.grid(sticky="nsew")

        # Configure grid for self to expand and contract with the window
        self.master.grid_rowconfigure(0, weight=1)
        self.master.grid_columnconfigure(0, weight=1)

        # Initialize ticket data model
        self.ticket_data = TicketData()

        self.create_widgets()

    def create_widgets(self):
        # Frame to hold widgets, centered in the middle of the window
        inner_frame = tk.Frame(self, bg='white')
        inner_frame.grid(row=0, column=0, sticky="nsew")

        # Grid configuration for self to center the inner_frame both horizontally and vertically
        self.grid_rowconfigure(0, weight=1)
        self.grid_columnconfigure(0, weight=1)

        # Setting the grid configuration for inner_frame to center its contents
        inner_frame.grid_rowconfigure(0, weight=1)
        inner_frame.grid_rowconfigure(7, weight=1)  # Add extra rowconfigure for vertical padding at the bottom
        inner_frame.grid_columnconfigure(0, weight=1)
        inner_frame.grid_columnconfigure(2, weight=1)  # Adding columns on either side of the main column

        # Fonts
        labelFont = tkfont.Font(family="Helvetica", size=12, weight="bold")
        entryFont = tkfont.Font(family="Helvetica", size=12)

        # Widgets setup, placed in the center column of the inner_frame
        tk.Label(inner_frame, text="Titre du ticket", font=labelFont, bg='white').grid(row=1, column=1, sticky="ew")
        self.title_entry = tk.Entry(inner_frame, font=entryFont)
        self.title_entry.grid(row=2, column=1, sticky="ew")

        tk.Label(inner_frame, text="Description", font=labelFont, bg='white').grid(row=3, column=1, sticky="ew")
        self.desc_entry = tk.Text(inner_frame, height=4, font=entryFont)
        self.desc_entry.grid(row=4, column=1, sticky="ew")

        # Scrollbar for description text
        scrollbar = Scrollbar(inner_frame, command=self.desc_entry.yview)
        scrollbar.grid(row=4, column=2, sticky='ns')
        self.desc_entry.config(yscrollcommand=scrollbar.set)

        tk.Label(inner_frame, text="Statut", font=labelFont, bg='white').grid(row=5, column=1, sticky="ew")
        self.status_var = tk.StringVar(self)
        self.status_var.set("Non traité")
        status_menu = tk.OptionMenu(inner_frame, self.status_var, "Non traité")
        status_menu.config(state="disabled", font=entryFont)
        status_menu.grid(row=6, column=1, sticky="ew")

        submit_button = tk.Button(inner_frame, text="Envoyer le Ticket", command=self.submit_ticket, bg='#4c68a8', fg='white', font=labelFont)
        submit_button.grid(row=7, column=1, sticky="ew")

    def submit_ticket(self):
        title = self.title_entry.get().strip()
        description = self.desc_entry.get("1.0", "end-1c").strip()
        status = self.status_var.get()
        
        # Obtenir la date actuelle au format "dd/mm/yyyy"
        current_date = datetime.now().strftime("%d/%m/%Y")
        
        if title and description:
            # Construire les données à envoyer
            
            params = {
                "title": title,
                "content": description,
                "state": status,
                "timestamp": current_date  # Ajouter la date de création du ticket
            }
            
            # Appeler la fonction api_request sans passer de données, si elle ne les prend pas en charge
            try:
                res = api_request.api_request("/ticket/create",api_request.token, params, True)
                print(res)
                messagebox.showinfo("Succès", "Ticket soumis avec succès.")
                self.title_entry.delete(0, 'end')
                self.desc_entry.delete('1.0', 'end')
            except Exception as e:
                messagebox.showerror("Erreur", f"Erreur lors de l'envoi du ticket : {str(e)}")
        else:
            messagebox.showerror("Erreur", "Le titre et la description ne peuvent pas être vides.")


if __name__ == "__main__":
    root = tk.Tk()
    root.geometry("1000x1000")  # Initial size of the window
    app = TicketCreation(master=root)
    app.mainloop()

