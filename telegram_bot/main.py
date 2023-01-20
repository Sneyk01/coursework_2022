from BotUser import *

import telebot
from telebot import types


# Создаем экземпляр бота
token = '' // API ключ бота
bot = telebot.TeleBot(token)

# Адрес для api запросов
url = "http://u142567.test-handyhost.ru/api" // Адрес сайта
users = {}


# Создаем разметки клавиатуры
markup_main = types.ReplyKeyboardMarkup(resize_keyboard=True)
item1 = types.KeyboardButton("Добавить гостя")
item2 = types.KeyboardButton("Справка")
markup_main.add(item1)
markup_main.add(item2)

markup = types.ReplyKeyboardMarkup(resize_keyboard=True)
item1 = types.KeyboardButton("Создать аккаунт")
item2 = types.KeyboardButton("Справка")
markup.add(item1)
markup.add(item2)


def send_message(message):
    bot.send_message(message.from_user.id, users[str(message.from_user.id)].message)
    users[str(message.from_user.id)].message = None


# Функция, обрабатывающая команду /start
@bot.message_handler(commands=["start"])
def start(message, res=False):
    u_id = message.from_user.id
    print(u_id)
    users[str(message.from_user.id)] = BotUser(u_id, url)

    if users[str(message.from_user.id)].id is not None:
        bot.send_message(message.from_user.id, 'Привет, ' + users[str(message.from_user.id)].name, reply_markup=markup_main)
    else:
        bot.send_message(message.from_user.id, 'Похоже, вы у нас впервые. \n'
                                               'Если у вас есть код регистрации - нажмите кнопку "Создать аккаунт. "\n'
                                               'Для получения дполнительной информации - нажмите '
                                               'кнопку "Справка"', reply_markup=markup)


# Получение сообщений от юзера
@bot.message_handler(content_types=["text"])
def handle_text(message):
    if str(message.from_user.id) in users:
        if users[str(message.from_user.id)].id is None:
            if message.text.strip() == 'Создать аккаунт':
                bot.send_message(message.chat.id, 'Для создания аккаунта введите пригласительный код:')
                bot.register_next_step_handler(message, register)
            if message.text.strip() == 'Справка':
                bot.send_message(message.from_user.id, 'Это telegram бот для жителей котеджного поселка "...", '
                                                       'с помощью этого бота вы можете добавлять автомобильные номера '
                                                       'ваших гостей в базу данных шлагбаума, чтобы они могли попасть '
                                                       'на территорию. Если у вас уже есть учетная '
                                                       'запись гостя - нажмите "Создать аккаунт" и введите ключ '
                                                       'регистрации. Если у вас еще нет учетной записи - обратитесь '
                                                       'к администратору. Контакты для связи: ...')

            if message.text.strip() != 'Справка' and message.text.strip() != 'Создать аккаунт':
                bot.send_message(message.from_user.id, 'Я вас не понимаю')

        if users[str(message.from_user.id)].id is not None:
            if message.text.strip() == 'Добавить гостя':
                bot.send_message(message.from_user.id, 'Введить автомобильный номер гостя в формате а000аа:')
                bot.register_next_step_handler(message, register_visitor)
            if message.text.strip() == 'Справка':
                bot.send_message(message.from_user.id, 'Ваш аккаунт активирован. '
                                                       'Для добавления гостевой записи нажмите "добавить гостя" '
                                                       'и после этого введите автомобильный номер. После одного '
                                                       'проезда или по истечению срока действия '
                                                       '(1 день по умолчанию, подробности у администратора) '
                                                       'номер будет удален')

            if message.text.strip() != 'Справка' and message.text.strip() != 'Добавить гостя':
                bot.send_message(message.from_user.id, 'Я вас не понимаю')
    else:
        bot.send_message(message.from_user.id, 'Похоже, что мы вас не помним. Пожалуйства введите /start')


def register(message):
    key = message.text
    users[str(message.from_user.id)].request_register(url, key, message.from_user.id)
    if users[str(message.from_user.id)].id is not None:
        bot.send_message(message.from_user.id, 'Поздравляем, ' + users[str(message.from_user.id)].name +
                         ', ваша учетная запись успешно зарегистрированна! Для ознакомления с инструкцией -'
                         ' нажмите кнопку "Справка"', reply_markup=markup_main)
    else:
        bot.send_message(message.from_user.id, 'Похоже, что вы ввели неверный ключ. Проверьте его корректность '
                                               'и попробуйте снова')


def register_visitor(message):
    number = message.text.lower()

    if number in users[str(message.from_user.id)].car_numbers:
        bot.send_message(message.from_user.id, 'Вы не можете добавить свой номер, действие отменено')
        return

    bot.send_message(message.from_user.id, 'Номер считан')
    users[str(message.from_user.id)].add_visitor(url, number)
    if users[str(message.from_user.id)].message is not None:
        send_message(message)


# Запускаем бота
bot.polling(none_stop=True, interval=0)
