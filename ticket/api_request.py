import requests
import json

def api_request(api_uri, bearer_token, params=None, USE_POST = False):
    api_url = 'https://api.au-temps-donne.nicolas-guillot.fr/api' + api_uri
    headers = {
        'Content-Type': 'application/json',
        'Authorization': f'Bearer {bearer_token}'
    }

    try:
        if (USE_POST):
            response = requests.post(api_url, headers=headers, json=params)
        else:
            response = requests.get(api_url, headers=headers, params=params)
        print(response)
        return response.json()

    except requests.exceptions.RequestException as e:
        print(f"Error : {e}")
        return None

token = ""