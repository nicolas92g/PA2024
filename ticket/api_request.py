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
        
        if (response.status_code != 200):
            print(response.text[:200])
        response.raise_for_status()
        
        return response.json()

    except requests.exceptions.RequestException as e:
        print(f"Error : {e}")
        return None

token = ""