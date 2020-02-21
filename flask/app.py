from flask import Flask
import requests
import json
from markupsafe import escape
from os import environ


GEO_BASE_URL = "https://geo.ipify.org/api/v1?apiKey="
GEO_API_KEY = environ.get('GEO_API_KEY')
ARCGIS_CLIENT_ID = environ.get('ARCGIS_CLIENT_ID')
ARCGIS_CLIENT_SECRET = environ.get('ARCGIS_CLIENT_SECRET')
ARCGIS_URL_FIND = "https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/findAddressCandidates"
ARCGIS_URL_TOKEN = "https://www.arcgis.com/sharing/rest/oauth2/token"

app = Flask(__name__)

@app.route('/')
def hello():
    return "hello"

@app.route('/by-ip/<ip>')
def byIp(ip):
    r = requests.get(GEO_BASE_URL+GEO_API_KEY+"&ipAddress={}".format(escape(ip)))
    
    if r.status_code == 200 :
        data = json.loads(r.text)
        lat = data['location']['lat']
        lon = data['location']['lng']

        return {"lat" : lat, "lng" : lon}

    return {"error" : r.status_code}


@app.route('/by-address/<address>')
def byAddress(address):
 
    token = getToken()
    headers = {
        'Authorization': "Bearer "+token
    }
    r = requests.get(ARCGIS_URL_FIND+"?f=json&singleLine={}&outFields= Match_addr,Addr_type".format(escape(address)), headers=headers)

    if r.status_code == 200 :
        data = json.loads(r.text)
        lat = data['candidates'][0]['location']['y']
        lon = data['candidates'][0]['location']['x']

        return {"lat" : lat, "lng" : lon}

    return {"error" : r.status_code}
    


def getToken():

    payload = "client_id="+ARCGIS_CLIENT_ID+"&client_secret="+ARCGIS_CLIENT_SECRET+"&grant_type=client_credentials"
    headers = {
        'content-type': "application/x-www-form-urlencoded",
        'accept': "application/json",
        'cache-control': "no-cache",
        'postman-token': "11df29d1-17d3-c58c-565f-2ca4092ddf5f"
    }

    response = requests.request("POST", ARCGIS_URL_TOKEN, data=payload, headers=headers)
    data = json.loads(response.text)

    return data['access_token']


if __name__ == "__main__":
    app.run(host="0.0.0.0", debug=True)