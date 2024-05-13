# class TicketData:
#     def __init__(self):
#         self.tickets = {}

#     def add_ticket(self, title, description, status="Non traité"):
#         ticket_id = len(self.tickets) + 1
#         self.tickets[ticket_id] = {'title': title, 'description': description, 'status': status}

#     def get_tickets(self):
#         return self.tickets

#     def update_ticket(self, ticket_id, status):
#         if ticket_id in self.tickets:
#             self.tickets[ticket_id]['status'] = status


# import json

# class TicketData:
#     def __init__(self, filepath='tickets.json'):
#         self.filepath = filepath
#         self.load_tickets()

#     def load_tickets(self):
#         try:
#             with open(self.filepath, 'r') as file:
#                 self.tickets = json.load(file)
#         except (FileNotFoundError, json.JSONDecodeError):
#             self.tickets = {}

#     def save_tickets(self):
#         with open(self.filepath, 'w') as file:
#             json.dump(self.tickets, file, indent=4)

#     def add_ticket(self, title, description, status="Non traité"):
#         ticket_id = str(len(self.tickets) + 1)
#         self.tickets[ticket_id] = {'title': title, 'description': description, 'status': status}
#         self.save_tickets()

#     def get_tickets(self):
#         return self.tickets

#     def update_ticket(self, ticket_id, status):
#         if ticket_id in self.tickets:
#             self.tickets[ticket_id]['status'] = status
#             self.save_tickets()

import requests

class TicketData:
    def __init__(self, api_base_url='http://localhost:8000/api', api_token='YourAPITokenHere'):
        self.api_base_url = api_base_url
        self.api_token = api_token

    def get_auth_header(self):
        """
        Generates the authentication header with the bearer token.
        """
        return {'Authorization': f'Bearer {self.api_token}'}

    def get_tickets(self):
        """
        Retrieves tickets from the API.
        """
        headers = self.get_auth_header()
        response = requests.get(f"{self.api_base_url}/tickets", headers=headers)
        if response.status_code == 200:
            return response.json()
        else:
            raise Exception("Failed to retrieve tickets")

    def add_ticket(self, title, description, status="Non traité"):
        """
        Adds a new ticket through the API.
        """
        data = {
            'title': title,
            'description': description,
            'status': status
        }
        headers = self.get_auth_header()
        response = requests.post(f"{self.api_base_url}/tickets", json=data, headers=headers)
        if response.status_code != 201:
            raise Exception("Failed to create ticket")

    def update_ticket(self, ticket_id, status):
        """
        Updates the status of an existing ticket via the API.
        """
        data = {
            'status': status
        }
        headers = self.get_auth_header()
        response = requests.put(f"{self.api_base_url}/tickets/{ticket_id}", json=data, headers=headers)
        if response.status_code != 200:
            raise Exception("Failed to update ticket")

