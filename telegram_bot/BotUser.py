import json
import requests

json_string = """ {
  "result": "True",  
  "user_name": "Ivan",
  "number": "SRH202",
  "id": 15
  }"""

# 854753528


class BotUser:
    def __init__(self, telegram_id=None, url=None):
        if telegram_id is None:
            self.id = None
            self.name = None
            self.car_numbers = None
            self.telegram_id = None
            self.message = None

        else:
            answer = {}

            self.telegram_id = telegram_id
            if url is not None:
                response = requests.get(url + "/telegram_bot/id/" + str(telegram_id))
                answer = json.loads(response.text)

            if answer["result"] == "True":
                self.set_fields(answer["first_name"], answer["car_numbers"].split(";"), answer["id"])
                print(self.car_numbers)
            else:
                self.set_fields()

    def set_fields(self, name=None, car_numbers=None, db_id=None, message=None):
        self.name = name
        self.car_numbers = car_numbers
        self.id = db_id
        self.message = message

    def request_register(self, url, key, telegram_id):
        data = {"key": str(key), "telegram_id": str(telegram_id)}
        response = requests.put(url + "/telegram_bot/", data)
        print(str(response.text))
        answer = json.loads(response.text)
        if answer["result"] == "True":
            self.set_fields(answer["first_name"], answer["car_numbers"].split(";"), answer["id"])

    def add_visitor(self, url, visitor_number):
        data = {"number": str(visitor_number), "user_id": str(self.id)}
        response = requests.post(url + "/telegram_bot/", data)
        answer = json.loads(response.text)
        if answer["result"] == "False":
            self.message = answer["message"]


if __name__ == '__main__':
    # none
    flag = 1
