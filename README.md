# Курсовая работа


## Основное задание
Необходимо написать систему автоматического контрльно-пропускного пункта в котежном поселке. Система представляет собой сервер с базой данных, в которой хранятся автомобильные номера с различными статусами. Шлагбаун на контрольно-пропускном пункте может считывать номер подъехавшей машины и обращаться к серверу, запрашивая разрешение на пропуск этого автомобиля.

В базе данных все автомобильные номера разделяются на три категории: администратор, житель и гость.

 - Записи с категорией гостя являются одноразовыми, и после проезда не территорию, либо по истечению времени хранения, они будут удалены из базы данных.

 - Записи с категорией жителя могут, при помощи telegram бота, добавлять в базу данных гостевые записи.

 - Записи с категорией администратора могут, при помощи админ-панели, добавлять новые записи жителей и гостей и редактировать старые. Так же администраторы могут настроивать срок действия гостевых записей.

При добавлении администратором нового жителя, сервером будет сгенерирован уникальный одноразовый ключ, который необходимо будет отправить telegram боту. После этого в базу данных будет записан id telegram аккаунта жителя и его регистрация будет завершена.

Для получения разрешения на пропуск автомобиля, шлагбаун будет отправлять get запрос, содержащий автомобильный номер, на сервер, а в качестве ответа, будет получать true или false.

## Используемые технологии

  ### Платофрма
  none
  
  ### Среда
  Для работы с кодом будут использоваться продукты от JetBrains:
  - pyCharm - для написания telegram бота;
  - phpStorm - для написания админ панели.
  
  ### Языки
  Для написания админ панели и оргнанизации взаимодействия клиента с сервером будет использоваться PHP. В качестве языка для написания telegram бота будет использоваться python.
  
  ### Фреймворки
  Для создания дизайна админ панели будет использоваться фреймворк bootstrap.
  
  ### Библиотеки
  В качестве библиотеки для написания telegram бота была выбрана библиотека pyTelegramBotAPI.
  
 ## Ход работы 
  ### Описание пользовательских сценариев
  #### Описание процесса регистрации жителя
  Для регистрации новой записи жителя поселка администратору необходимо создать через админ панель  запись о человеке, с основной инфрмацией о нем: имя, фамилия, автомобильные номера и его дом. После этого будет автоматически сформирован 10-ти символьный регистрационный ключ, который администратор должен передать жильцу. После того, как житель получит свой ключ регистрации, ему необходимо найти в telegram нужного бота и выбрав в его меню кнопку "Создать аккаунт" отправить полученный ключ. После этого жильцу откроется возможность добавлять в базу данных гостевые автомобильные номера.
  
  #### Описание возможностей админ панели
  При входе в админ панель администратору будет необходимо ввести логин и пароль от его учетной записи. В случае, если пароль был утерян, у администратора есть возможность востановить пароль от учетной записи. После того, как авторизация пройдет успешно, для администратора открываются следующие возможности:
   - Просмотр списка всех жителей
   - Просмотр списка всех гостей
   - Добавление новых жителей
   - Добавление новых гостей
   - Редактирование учетных записей жителей
   - Редактирование учетной записи администратора
   - Настройка параметров работы сервера (например по проществию какого времени удалять гостевые записи)

  #### Примеры пользовательских сценариев
  
  <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/s1.svg"></p>
  
  
  ### Описание API сервера и хореографии
  Для удобного взаимодействия telegram бота с сервером, был написан api. На данный момент сервер умеет обрабатывать get, post и put запросы от telegram бота. Ниже приведены схемы обмена данными между сервером и telegram ботом:
  
  1. Когда боту необходимо узнать информацию о пользователе, он отправляет get запрос содержащий telegram id аккаунта. Если записи об этом пользователе имеются в базе данных, сервер вернет нужную боту информацию. В противном случае, бот получит JSON файл вида: {result: "False"}. Пример get запроса представлен ниже:
  <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/bot_get.svg"/width = 50%></p>
  
  2. Когда боту необходимо добавить новую запись в таблицу гостей, он отправляет на сервер post запрос с автомобильным номером, который необходимо добавить, и id пользователя (id в базе данных, не путать с с telegram id), от которого был отправлен запрос. В случае успешного добавления записи, сервер вернет боту JSON файл вида: {result: "True"}, если добавить номер не удалось - сервер вернет JSON файл {result: "False"}. Пример post запроса представлен ниже:
  <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/bot_post.svg"/width = 50%></p>
  
  3. Когда боту необходимо завершить регистрацию пользователя, путем добавления его telegram id в базу данных, он отправляет put запрос, содержащий ключ регистрации и telegram id пользователя, который отправил этот ключ. Если регистрациооный ключ был найден в базе данных, то сервер отправит боту всю необходимую информацию об этом пользователе в JSON файле. В противном случае, сервер вернет JSON файл вида: {result: "False"}. Пример put запроса представлен ниже:
  <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/bot_put.svg"/width = 50%></p>
  
  
  ### Описание структуры базы данных
  Для хранения данных об учетных записях будет использоваться MySQL. Для каждой роли (администратор, житель и гость) будет создана своя таблица.
  Таблица для администраторов будет содержать в себе логин и хэш пароля от админ панели, соль для пароля, токен текущей сессии, время создания токена и id пользователя.
 
  Таблица администраторов не содержит никакой личной информации. Если администратор тоже является жителем поселка, ему необходимо создать запись в таблице жителей. Пример записи в таблице администраторов:
  ```sh
  {
     "id": 1,
     "login": "admin",
     "password": "b7387a2deb85d1ea99d3b74fcf92c6d3",
     "salt": "qtVrkp1iu6"
     "token": "XHtJBYE1IVLEPThuVND46Dh9Q"
     "token_time": 1668966113,
 }
  ```
 Таблица жителей будет содержать в себе имя и фамилию жильца, номер его автомобиля и дома, id пользователя, id телеграмм аккаунта и пригласительный ключ. Если у жителя несколько автомобилей, то они будут указаны в поле через точкой с запятой.
   ```sh
  {
     "id": 1,
     "first_name": "Gleb",
     "last_name": "Prokhorov",
     "car_numbers": "С202РХ"
     "house_number": "8a"
     "telegram_id": 800457635,
     "secret_key": None
 }
  ```
  Таблица гостей будет содержать в себе id пользователя, автомобильный номер, время создания записи и id пользователя, создавшего гостевую запись.
   ```sh
  {
     "id": 1,
     "car_number": "К754ЕА"
     "inviting_id": 1,
     "creation_time": 1668967113
 }
  ```

 
