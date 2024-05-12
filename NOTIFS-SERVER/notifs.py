import requests
import time
import vars
from datetime import datetime

def send_notification(message):
    url = "https://onesignal.com/api/v1/notifications"
    headers = {
        "Content-Type": "application/json; charset=utf-8",
        "Authorization": f"Basic {vars.rest_api_key}"
    }
    payload = {
        "app_id": vars.app_id,
        "included_segments": ["All"],
        "contents": {"en": message},
        "ttl": 0
    }
    
    try:
        response = requests.post(url, headers=headers, json=payload)
        response.raise_for_status()  # Raise an error for non-2xx responses
        print("Notification sent successfully!")
    except requests.exceptions.RequestException as e:
        print(f"Error sending notification: {e}")



def login():
    params = {
        "email": "OneSignal@gmail.com",
        "password": vars.PASSWORD
    }
    try:
        return requests.post('https://api.au-temps-donne.nicolas-guillot.fr/api/login', params=params).json()['token']
    except Exception as e:
        print("error while login :", e)

def api_request(api_uri, bearer_token, params=None, USE_POST = False):
    api_url = 'https://api.au-temps-donne.nicolas-guillot.fr/api' + api_uri
    headers = {
        'Content-Type': 'application/json',
        'Authorization': f'Bearer {bearer_token}'
    }

    try:
        if (USE_POST):
            response = requests.post(api_url, headers=headers, params=params)
        else:
            response = requests.get(api_url, headers=headers, params=params)

        return response.json()
    
    except requests.exceptions.RequestException as e:
        print(f"Error fetching tickets: {e}")
        return None
    

while (True):
    token = login()

    products = api_request('/product/list', token)
    
    for product in products:
        product_date = datetime.strptime(product['date_limite'], "%Y-%m-%d")
        diff = (product_date.date() - datetime.today().date()).days

        name =  '"'+ product['nom'] + '" avec pour id : "' + str(product['id']) + '"'
        message = ''

        if diff < 0:
            message = 'le produit : ' + name + ' est expiré'
        elif diff == 0:
            message = 'le produit : ' + name + ' expire aujourd\'hui' 
        elif diff <= 4:
            message = 'le produit : ' + name + ' expire dans ' + str(diff) + ' jours'
        else:
            continue
        
        send_notification(message)
        time.sleep(5)

    time.sleep(30)
    
