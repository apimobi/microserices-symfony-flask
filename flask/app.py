from flask import Flask
import requests
import json
from markupsafe import escape
from os import environ


GEO_BASE_URL = "https://geo.ipify.org/api/v1?apiKey="
GEO_API_KEY = environ.get('GEO_API_KEY')

app = Flask(__name__)

@app.route('/')
def hello():
    return "hello"

@app.route('/by-ip/<ip>')
def byIp(ip):
    r = requests.get(GEO_BASE_URL+GEO_API_KEY+"&ipAddress={}".format(escape(ip)))
    data = json.loads(r.text)
    return data

@app.route('/by-address/<address>')
def byAddress(address):
    r = requests.get(GEO_BASE_URL+GEO_API_KEY+"&ipAddress={}".format(escape(address)))
    data = json.loads(r.text)
    return data

if __name__ == "__main__":
    app.run(host="0.0.0.0", debug=True)