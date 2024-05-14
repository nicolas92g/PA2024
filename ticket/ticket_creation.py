import tkinter as tk
from tkinter import messagebox, font as tkfont
from tkinter import Scrollbar
import api_request 
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
        current_date = str(datetime.now())
        
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
                res = api_request.api_request("/ticket/create", api_request.token, params, True)
                print("res = ", res)
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

