FROM python:3.6
ADD . /code
WORKDIR /code
RUN pip install -r requirements.txt
RUN pip install python-dotenv
CMD python app.py