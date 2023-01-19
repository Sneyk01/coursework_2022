# Курсовая работа


## Основное задание
Необходимо написать систему автоматического контрольно-пропускного пункта в коттеджном поселке. Система представляет собой сервер с базой данных, в которой хранятся автомобильные номера с различными статусами. Шлагбаум на контрольно-пропускном пункте может считывать номер подъехавшей машины и обращаться к серверу, запрашивая разрешение на пропуск этого автомобиля.

В базе данных все автомобильные номера разделяются на три категории: администратор, житель и гость.

 - Записи с категорией гостя являются одноразовыми, и после проезда не территорию, либо по истечению времени хранения, они будут удалены из базы данных.

 - Записи с категорией жителя имеют постоянный доступ к територии поселка и могут, при помощи telegram бота, добавлять в базу данных гостевые записи.

 - Записи с категорией администратора могут, при помощи админ-панели, добавлять новые записи жителей и гостей и редактировать старые. Так же администраторы могут настроивать срок действия гостевых записей.

При добавлении администратором нового жителя, сервером будет сгенерирован уникальный одноразовый ключ, который необходимо будет отправить telegram боту. После этого в базу данных будет записан id telegram аккаунта жителя и его регистрация будет завершена.

Для получения разрешения на пропуск автомобиля, шлагбаун будет отправлять get запрос, содержащий автомобильный номер, на сервер, а в качестве ответа, будет получать true или false.

## Доступ
Курсовая работа доступна по адресу: http://u142567.test-handyhost.ru/. Используется хостинг от handyhost.

При желании проект можно запустить самостоятельно. Для этого необходимо загрузить файлы из папки server в расположение своего сервера, импортировать базу данных MySQL из бэкапа "kpp_coursework.sql" и настроить параметры подключения к базе данных в файле "funcions.php".

## Используемые технологии

  ### Среда
  Для работы с кодом будут использоваться продукты от JetBrains:
  - pyCharm - для написания telegram бота;
  - phpStorm - для написания админ панели.
  
  ### Языки
  Для написания админ панели и организации взаимодействия клиента с сервером будет использоваться PHP, css и JavaScript. В качестве языка для написания telegram бота будет использоваться python.
  
  ### Фреймворки
  Для создания дизайна админ панели будет использоваться фреймворк bootstrap.
  
  ### Библиотеки
  В качестве библиотеки для написания telegram бота была выбрана библиотека pyTelegramBotAPI.
  На стороне сервера используется библиотека jQuery и модуль color для неё.
  
 ## Ход работы 
  ### Разработка пользовательского дизайна интерфейса
  В редакторе Figma был разработан прототип пользовательского интерфейса:
  
  Страница авторизации админ панели:
  <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/authorization.svg"/width = 80%></p>

  
  Главная страница админ панели:
  <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/main.svg"/width = 80%></p>
  
  
  Вкладка настроек админ панели:
  <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/setting.svg"/width = 80%></p>
    
  
  Вкладка настроек аккаунта администратора:
  <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/change_password.svg"/width = 80%></p>


  Всплывающее окно добавления новой записи жителя:
  <table><tr><td>
  <img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/modal_1.png">
  </td></tr></table>
  
  
  Всплывающее окно редактирования записи жителя:
  <table><tr><td>
  <img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/modal_1.1.png">
  </td></tr></table>
  

  Всплывающее окно добавления новой записи гостя:
  <table><tr><td>
  <img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/modal_2.png">
  </td></tr></table>
  
  
  Всплывающее окно редактирования записи гостя:
  <table><tr><td>
  <img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/modal_2.1.png">
  </td></tr></table>

  ### Описание пользовательских сценариев
  #### Описание процесса регистрации жителя
  Для регистрации новой записи жителя поселка администратору необходимо создать через админ панель  запись о человеке, с основной информацией о нем: имя, фамилия, автомобильные номера и его дом. После этого будет автоматически сформирован 10-ти символьный регистрационный ключ, который администратор должен передать жильцу. После того, как житель получит свой ключ регистрации, ему необходимо найти в telegram нужного бота и выбрав в его меню кнопку "Создать аккаунт" отправить полученный ключ. После этого жильцу откроется возможность добавлять в базу данных гостевые автомобильные номера.
  
  #### Описание возможностей админ панели
  При входе в админ панель администратору будет необходимо ввести логин и пароль от его учетной записи. После того, как авторизация пройдет успешно, для администратора открываются следующие возможности:
   - Просмотр списка всех жителей
   - Просмотр списка всех гостей
   - Добавление новых жителей
   - Добавление новых гостей
   - Редактирование учетных записей жителей
   - Редактирование записей гостевых номеров
   - Редактирование учетной записи администратора
   - Настройка параметров работы сервера (например по проществии какого времени удалять гостевые записи)

  Все операции в панели администратора выполняются при помощи ajax запросов, поэтому никаких обновлений страниц и переадресаций происходить не будет.
  
  При добавлении новой записи о жителе или госте, перед администратором открывается всплывающее окно с полями, необходимыми для заполнения. При добавлении жителя нужно заполнить имя, фамилию, номер дома и номера автомобилей. При добавлении гостя - только автомобильный номер. Если введенный номер уже присутствует в одной из таблиц, сервер вернет сообщение с ошибкой. В случае успеха, пользователь увидит сообщение, что запись добавлена, а в выбранной таблице отобразится новая запись. 
  
  При изменении параметров, в случае успешной операции, строчка с выбранным параметром на время станет зеленой, в противном случае (если попытаться установить время действия токена или гостевой записи меньше чем 60 секунд или ввести буквы) - красным.
  
  Если пользователь находится на вкладке просмотра списка жильцов или гостей, то этот список будет автоматически сверяться с базой данных и обновляться раз в минуту.
  
  При каждом обновлении таблицы гостей или при запросе на создание новой гостевой записи, происходит проверка времени действия автомобильных номеров, и старые записи удаляются. (Проверка при запросе происходит для того, чтобы при добавлении записи о госте через telegram бота "просроченные", но еще не удаленные номера не мешали занять нужный номер)

  #### Примеры пользовательских сценариев
  
  - Сценарий 1
  <p align = "left"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/s1.svg"></p>
  
  - Сценарий 2
  <p align = "left"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/s2.svg"></p>
  
  - Сценарий 3
  <p align = "left"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/s3.svg"></p>
  
  
  ### Описание API сервера и хореографии
  #### Для удобного взаимодействия telegram бота с сервером, был написан api. На данный момент сервер умеет обрабатывать get, post и put запросы от telegram бота. Ниже приведены схемы обмена данными между сервером и telegram ботом:
  
  1. Когда боту необходимо узнать информацию о пользователе, он отправляет get запрос содержащий telegram id аккаунта. Если записи об этом пользователе имеются в базе данных, сервер вернет нужную боту информацию. В противном случае, бот получит JSON файл вида: {result: "False"}. Пример get запроса представлен ниже:
  <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/bot_get.svg"/width = 50%></p>
  
  2. Когда боту необходимо добавить новую запись в таблицу гостей, он отправляет на сервер post запрос с автомобильным номером, который необходимо добавить, и id пользователя (id в базе данных, не путать с с telegram id), от которого был отправлен запрос. В случае успешного добавления записи, сервер вернет боту JSON файл вида: {result: "True"}, если добавить номер не удалось - сервер вернет JSON файл {result: "False"}. Пример post запроса представлен ниже:
  <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/bot_post.svg"/width = 50%></p>
  
  3. Когда боту необходимо завершить регистрацию пользователя, путем добавления его telegram id в базу данных, он отправляет put запрос, содержащий ключ регистрации и telegram id пользователя, который отправил этот ключ. Если регистрационный ключ был найден в базе данных, то сервер отправит боту всю необходимую информацию об этом пользователе в JSON файле. В противном случае, сервер вернет JSON файл вида: {result: "False"}. Пример put запроса представлен ниже:
  <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/bot_put.svg"/width = 50%></p>
  
  
 #### Шлагбаум для общения с сервером также использует api. На данный момент сервер может обработать get запрос от шлагбаума.
 
 1. Когда шлагбауму необходимо узнать, есть ли номер машины в базе данных или нет, он отправляет get запрос содержащий номер автомобиля. Если номер есть в базе данных, сервер вернет {result: "True"}, в противном случае - {result: "False"}. Пример get запроса представлен ниже:
  <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/barier_get.svg"/width = 50%></p>
  
  
  ### Описание структуры базы данных
  Для хранения данных об учетных записях будет использоваться MySQL. Для каждой роли (администратор, житель и гость) будет создана своя таблица.
  
  Таблица для администраторов будет содержать в себе логин и хэш пароля от админ панели, соль для пароля, токен текущей сессии, время создания токена и id пользователя. Таблица администраторов не содержит никакой личной информации. Если администратор тоже является жителем поселка, ему необходимо создать запись в таблице жителей. Структура таблицы администраторов и пример записи в ней:
  | Название | Тип | Длина | По умолчанию | Описание |
| :------: | :------: | :------: | :------: | :------: |
| **id** | int  | 11 | NO | Автоматический идентификатор администратора |
| **login** | varchar | 20 | NO | Логин администратора |
| **password** | varchar| 32 | NO | Хэш пароля от учетной записи |
| **salt** | varchar | 10 | NO | Соль для хэширования |
| **token** | varchar | 20 | NO | Уникальный токен |
| **time** | int | 11 | NO | Время создания токена |

  ```sh
  {
     "id": 1,
     "login": "admin",
     "password": "b7387a2deb85d1ea99d3b74fcf92c6d3",
     "salt": "qtVrkp1iu6",
     "token": "XHtJBYE1IVLEPThuVND46Dh9Q",
     "token_time": 1668966113
 }
  ```

 Таблица жителей будет содержать в себе имя и фамилию жильца, номер его автомобиля и дома, id пользователя, id телеграмм аккаунта и пригласительный ключ. Если у жителя несколько автомобилей, то они будут указаны в поле через точкой с запятой. Структура таблицы жителей и пример записи в ней:
   | Название | Тип | Длина | По умолчанию | Описание |
| :------: | :------: | :------: | :------: | :------: |
| **id** | int  | 11 | NO | Автоматический идентификатор жильца |
| **first_name** | varchar | 20 | NO | Имя жильца |
| **last_name** | varchar| 20 | NO | Фамилия жильца |
| **car_numbers** | text |  | NO | Автомобильные номера |
| **house_number** | varchar| 20 | NO | Номер дома жильца |
| **telegram_id** | varchar | 9 | NO | Telegram id жильца |
| **secret_key** | varchar | 10 | NO | Ключ для регистрации в telegram боте |

   ```sh
  {
     "id": 1,
     "first_name": "Gleb",
     "last_name": "Prokhorov",
     "car_numbers": "С202РХ"
     "house_number": "8a",
     "telegram_id": 800457635,
     "secret_key": None
 }
  ```
  
  Таблица гостей будет содержать в себе id пользователя, автомобильный номер, время создания записи и id пользователя, создавшего гостевую запись. В случае, если запись создана или редактировалась администратором, в поле с id создателя будет написано "Администратор". Структура таблицы гостей и пример записи в ней:
     | Название | Тип | Длина | По умолчанию | Описание |
| :------: | :------: | :------: | :------: | :------: |
| **id** | int  | 11 | NO | Автоматический идентификатор гостя |
| **car_number** | varchar | 8 | NO | Автомобильный номер гостя |
| **inviting_id** | varchar| 20 | NO | ID жильца, создавшего запись |
| **creation_time** | int | 11 | NO | Время создания записи |

   ```sh
  {
     "id": 1,
     "car_number": "К754ЕА",
     "inviting_id": 1,
     "creation_time": 1668967113
 }
  ```
  
  Для хранения настроек сервера используется еще одна таблица. В ней хранятся параметры времени, спустя которое удаляются записи гостей и истекает срок действия токена. Эта таблица содержит в себе id параметра, его название и значение. Структура таблицы настроек и пример записи в ней:
       | Название | Тип | Длина | По умолчанию | Описание |
| :------: | :------: | :------: | :------: | :------: |
| **id** | int  | 11 | NO | Автоматический идентификатор параметра |
| **Name** | varchar | 15 | NO | Название параметра |
| **Value** | varchar| 15 | NO | Значение параметра |

```sh
{
 "id": 1,
 "Name": "token_time",
 "Value": 3600
}
```
  
  ### Описание алгоритмов
  #### Алгоритм telegram бота
  <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/telegram_bot.svg"></p>
  
  #### Алгоритмы API
    
  Алгоритм обработке GET запроса от шлагбаума:
<p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/schemes-GET-barier.svg"/width = 50%></p>

  Ниже представлены три алгоритма обработки API запросов от бота:
  
  Алгоритм обработки GET запроса:
  <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/schemes-GET.svg"/width = 30%></p>
  
  Алгоритм обработки POST запроса:
  <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/schemes-POST.svg"/width = 30%></p>
  
  Алгоритм обработки PUT запроса:
  <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/schemes-PUT.svg"/width = 30%></p>

 #### Алгоритмы панели администратора
 
 Алгоритм страницы авторизации login.php:
 <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/schemes-login.svg"/width = 30%></p>
 
 Алгоритм функции проверки токена:
 <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/schemes-check_token.svg"/width = 55%></p>
 
 Алгоритм верхних кнопок панели администратора:
 <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/schemes-top_buttons.svg"/width = 18%></p>
 
 Алгоритм кнопок добавления записей:
 <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/schemes-add_buttons.svg"/width = 30%></p>
 
 Алгоритм изменения записей в таблицах:
 <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/schemes-change_table.svg"/width = 30%></p>
 
 Алгоритм удаления записей в таблицах:
 <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/schemes-delete.svg"/width = 30%></p>
 
 Алгоритм смены пароля от учетной записи:
 <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/schemes-change_password.svg"/width = 30%></p>
 
 Алгоритм выхода из учетной записи:
 <p align = "center"><img src="https://github.com/Sneyk01/coursework_2022/blob/main/images/schemes-exit.svg"/width = 12%></p>
 
 ### Значимые фрагменты кода
 
Функция проверки токена авторизации:
```sh
function check_cookie() {   // Если токен подходит - true, иначе просто отпраавляем на login.php
    $link = connect_db();
    $token = isset($_COOKIE["Token"]) ? $_COOKIE["Token"] : null;

    if($token == null) {
        if ($_SERVER["REQUEST_URI"] == "/login.php")    // Если мы уже на login.php (иначе постоянная пересылка)
            return false;
        //echo json_encode(["result" => "Token"]);
        header("location: login.php");
        exit();
    }

    $data = get_admins($link);

    foreach ($data as $admin) {
        if ($admin["token"] === $token) {
            global $TOKEN_TIME;
            if (($admin["time"] + get_token_time()) >= time())
                return true;
            else {  // Удаляем старый токен
                $sql = "UPDATE `admin_table` SET `token` = '' WHERE `admin_table`.`token` = '".$token."';";
                $result = mysqli_query($link, $sql);
                header("location: login.php?s");
                //echo json_encode(["result" => "Token_s"]);
                exit();
            }
        }
    }

    if ($_SERVER["REQUEST_URI"] == "/login.php" || $_SERVER["REQUEST_URI"] == "/login.php?s") // Сообщение о сессии
        return false;
    header("location: login.php");
    //echo json_encode(["result" => "Token"]);
    exit();
}
```

Функция проверки автомобильного номера на повторения:
```sh
function check_number_duplicate($number, $link): bool
{
    $result = get_residents($link);

    foreach ($result as $resident) {
        $numbers = explode(";", $resident["car_numbers"]);
        if (in_array($number, $numbers))
            return false;
    }
    
    $setting = get_params($link);
        $visitors_time = 86400; // Значение по умолчанию (1 день)
        foreach ($setting as $param)
            if ($param["Name"] == "visitors_time")
                $visitors_time = $param["Value"];
    
    $result = get_visitors($link);
    foreach ($result as $visitor) {
        if ($visitor["car_number"] == $number) {    // If number contain in visitors table
            if ($visitor["creation_time"] + $visitors_time >= time())
                return false;
            else {
                $sql = "DELETE FROM `visitors_table` WHERE `visitors_table`.`id` = ".$visitor["id"].";";    // Delete old number
                $result = mysqli_query($link, $sql);
            }       
        }
    }

    return true;
}
```
Пример ajax запроса:
```sh
$("document").ready(function () {
        $("#login").on("submit", function(){
            //alert("wow");
            event.preventDefault();
            $.ajax({
                url: 'handler.php',
                type: 'POST',
                dataType: 'html',
                data: $(this).serialize(),
                success: function (data){
                    if (data === "True") {
                        location.href = "index.php"
                    }
                    else
                        $("#message").html(data);
                }
            })
        })
```

Функция вывода списка жителей:
```sh
$data = get_residents($link);

foreach ($data as $person) {
    echo "<div class='row' id='r".$person["id"]."'>";
    echo "<div class='col-1  border-bottom border-end border-start border-dark'> <h6 class='mb-2' align='center' id='resident_i".$person['id']."'>".$person["id"]."</h6></div>";
    echo "<div class='col-2  border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_f".$person['id']."'>".$person["first_name"]."</h6></div>";
    echo "<div class='col-2 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_l".$person['id']."'>".$person["last_name"]."</h6></div>";
    echo "<div class='col-2 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_c".$person['id']."'>".$person["car_numbers"]."</h6></div>";
    echo "<div class='col-1 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_h".$person['id']."'>".$person["house_number"]."</h6></div>";
    echo "<div class='col-1 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_t".$person['id']."'>".$person["telegram_id"]."</h6></div>";
    echo "<div class='col-1 border-bottom border-end border-dark'> <h6 class='mb-2' align='center' id='resident_k".$person['id']."'>".$person["secret_key"]."</h6></div>";
    echo "<div class='col-1 mb-1'>"."<button value='".$person["id"]."' class='btn btn-warning border border-dark col-12 text-white edit' data-bs-toggle='modal' data-bs-target='#editFormModal'> Изменить </button>"."</div>";
    echo "<div class='col-1 mb-1'>"."<button value='".$person["id"]."' class='btn btn-danger border border-dark col-12 delete'> Удалить </button>"."</div>";
    echo "</div>";
}
```
Основа обработчика api запросов:
```sh
header('Content-type: application/json; charset=UTF-8');

$answer = ["result" => "False"];

$method = $_SERVER['REQUEST_METHOD'];
$o_data = get_data($method);

$request = parse_get();
$router = $request[0];
$data = array_slice($request, 1);

if (file_exists("routers/".$router.".php")) {
    include_once "routers/".$router.".php";
    $answer = route($method, $data, $o_data);
}

echo json_encode($answer);


function parse_get() {
    $result = (isset($_GET["q"])) ? $_GET["q"] : "";
    $result = rtrim($result, "/");
    return explode("/", $result);
}


function get_data($method) {
    if ($method == "GET") return $_GET;
    if ($method == "POST") return $_POST;

    $data = array();
    $exploded = explode('&', file_get_contents("php://input"));
    foreach ($exploded as $pair) {
        $item = explode("=", $pair);
        if (count($item) == 2) {
            $data[urldecode($item[0])] = urldecode($item[1]);
        }
    }
    return $data;
}
```
