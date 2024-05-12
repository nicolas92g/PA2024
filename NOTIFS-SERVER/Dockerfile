FROM python:alpine

WORKDIR /app

COPY notifs.py .
COPY vars.py .

RUN pip install requests

ENTRYPOINT ["python", "notifs.py"]