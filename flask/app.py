from flask import Flask
import requests
import json
from markupsafe import escape


geo_base_url = "https://geo.ipify.org/api/v1?apiKey="
geo_api_key = ""

app = Flask(__name__)

@app.route('/')
def hello():
    return "hello"

@app.route('/by-ip/<ip>')
def byIp(ip):
    r = requests.get(geo_base_url+geo_api_key+"&ipAddress={}".format(escape(ip)))
    data = json.loads(r.text)
    return data

if __name__ == "__main__":
    app.run(host="0.0.0.0", debug=True)