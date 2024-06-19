<?php
session_start();
// Подключение к базе данных MySQL через phpMyAdmin
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "regis";

// Создание подключения к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}


// Проверяем авторизацию пользователя
$isUserLoggedIn = isset($_SESSION['user_id']);

// Получаем ник авторизованного пользователя
$username = ""; // по умолчанию пустая строка
if ($isUserLoggedIn) {
    $username = $_SESSION['username'];
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title>Автономные системы</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel=" shortcut icon" href="img/logo.png"/>

<style>
        /* Стили для модального окна */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
          background-color: #ddf4fb;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #000;
            border-radius:15px;
            width: 80%;

            max-width: 400px;
            text-align: center;
        }

        .modal-content input,
        .modal-content textarea {
            width: 100%;
            margin-bottom: 15px;
            padding: 5px;
            box-sizing: border-box;
            font-size: 16px;
            color: #000;
            border-radius: 10px;
    background-color: white;
        }

        .modal-content textarea {
            resize: vertical; /* Разрешает растягивание текстового поля только по вертикали */
        }

        .close {
          margin-left: 330px;
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover, .close:focus {
            color: #000;
            text-decoration: none;
        }

        .message {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 15px;
            border-radius: 5px;
            z-index: 9999;
        }
        .registrBtn{
    padding: 5px 10px;
    background-color: #64d6f9;
    color:  #000;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-family: 'WoobBurnRegular', sans-serif;
    margin-right: 2%; /* Добавим отступ справа для выравнивания */
}

        /* Медиа-запрос для адаптивности */
        @media (max-width: 768px) {
            .article {
                width: 100%; /* При разрешении экрана до 768px блоки статей займут всю ширину */
            }
        }
    </style>

</head>

<body>

  <div class="fon">
    <div class="hover-image-scale">
      <img src="img/fon.png" width="110%" height="500px" class="hover-image-scale">
    </div>

  </div>
  <div class="menu">

<!-- Добавляем кнопку "Регистрация/Вход" -->
<button class="login-button"  style="
    display: flex;
    margin-top: 20px;
    margin-left: 1030px;
    padding: 5px 10px;
    background-color: #26AFD9;
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-family: 'Oswald', sans-serif;
    margin-right: 30px;
    height: 40%;">
   <?= $isUserLoggedIn ? $username : 'Регистрация/Вход' ?></button>
        
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Регистрация / Вход</h3>

<div class="user-info">
        <span><?= $isUserLoggedIn ? $username : 'Зарагестрируйтесь, если у вас еще нет аккаунта' ?></span>
        <?php if ($isUserLoggedIn): ?>
            <button id="logoutButton" class="b1" style="background-color:#64d6f9;border:none;border-radius:3px;">Выход</button>
        <?php endif; ?>
    </div>
    <!-- Кнопки для выбора "Зарегистрироваться" и "Войти" -->
        <button id="registerBtn" class="b2" style="background-color:#64d6f9;border:none;border-radius:3px;margin-bottom: 3px;width: 250px;display: flex;align-content: space-around;margin-left: 50px;justify-content: center;">Зарегистрироваться</button>
        <button id="loginBtn" class="b3" style="background-color:#64d6f9;border:none;border-radius:3px;margin-bottom: 3px;width: 250px;display: flex;align-content: space-around;margin-left: 50px;justify-content: center;">Войти</button>
<!-- Форма для регистрации -->
        <form action="register_process.php" method="POST" id="registerForm" style="display: none;">
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit"  class="registrBtn">Зарегистрироваться</button>
        </form>

        <!-- Форма для входа -->
        <form action="login_process.php" method="POST" id="loginForm" style="display: none;">
            <label for="email_login">Email:</label>
            <input type="email" id="email_login" name="email" required>
            
            <label for="password_login">Пароль:</label>
            <input type="password" id="password_login" name="password" required>
            
            <button type="submit" class="registrBtn">Войти</button>
        </form>
        </div>
</div>

<script>
// Открытие модального окна при клике на кнопку
var loginButton = document.querySelector('.login-button');
var loginModal = document.getElementById('loginModal');
var closeLoginModal = document.querySelector('.close');
var registerBtn = document.getElementById('registerBtn');
var loginBtn = document.getElementById('loginBtn');
var registerForm = document.getElementById('registerForm');
var loginForm = document.getElementById('loginForm');

loginButton.addEventListener('click', function() {
    loginModal.style.display = 'block';
});

// Закрытие модального окна при клике на крестик
closeLoginModal.addEventListener('click', function() {
    loginModal.style.display = 'none';
});

// Закрытие модального окна при клике за пределами окна
window.onclick = function(event) {
    if (event.target === loginModal) {
        loginModal.style.display = 'none';
    }
};

// Переключение между формами "Регистрации" и "Входа"
registerBtn.addEventListener('click', function() {
    registerForm.style.display = 'block';
    loginForm.style.display = 'none';
});

loginBtn.addEventListener('click', function() {
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var logoutButton = document.getElementById('logoutButton');

    if (logoutButton) {
        logoutButton.addEventListener('click', function() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'logout_process.php', true); // Создаем GET-запрос на logout_process.php
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        window.location.href = "index.php"; // Перенаправляем на index.php после успешного выхода
                    } else {
                        console.error('Произошла ошибка при выходе');
                    }
                }
            };
            xhr.send();
        });
    }
});
</script>
 
  
  
 </div>



  </div>
  <div class="img"><a href="index.php"><img src="img/logo.png" alt="*"></a></div>
  <div class="text"><a href="index.php">
      <h1>H2O35.RU</h1>
    </a></div>
  <div class="nav">
  <div class="text1"><a href="index.php">Главная</a></div>
    <div class="text2"><a href="products.php">Товары</a></div>
    <div class="text3"><a href="rabot.php">Наши работы</a></div>
    <div class="text4"><a href="dostavka.php">Доставка и оплата</a></div>
    <div class="text5"><a href="contact.php">Контакты</a></div>
    
  </div>
  <div class="block">
    <div class="text8">
      Продажа, установка, монтаж и<br>
      обслуживание автономных<br>
      систем для частных домов, коттеджей<br>
      и организаций на всей территории<br>
      Вологодской области.
    </div>
    <a href="dostavka.html"><button class="button">Подробнее</button></a>
  </div>

  
  <div class="texttt1">
    <h1>Контакты</h1>
   
    <a>Менеджер по продажам<br>
        Телефон: +7 921 063 17 15<br>
        Эл. почта: price@h2o35.ru</a>
</div>
<div class="texttt2">
    <a>Общие вопросы<br>
        Телефон: 8 (8172) 50-40-89 (Евгений)<br>
        Эл. почта: info@h2o35.ru</a>
</div>

<div class="texttt3">
    <a>Георазведка и бурение<br>
        Телефон: +7 921 143 53 28 (Александр)<br>
        Эл. почта: bur@h2o35.ru</a>
</div>

<div class="texttt4">
    <h1>Время работы:</h1>
   
    <a>пн-пт 09:00-18:00</a>
</div>
<div class="texttt5">
    <a>сб - 10:00-14:00</a>
</div>

<div class="texttt6">
    <a>вс - выходной</a>
</div>

<div class="texttt7">
    <h1>Реквизиты</h1>
   
    <a>ООО «Автономные системы»</a>
</div>
<div class="texttt8">
    <a>ОГРН 1173525008040</a>
</div>

<div class="texttt9">
    <a>ИНН 3525397545 КПП 352501001</a>
</div>

<div class="texttt10">
    <a>Р/с 40702810000000008005 в ПАО «БАНК СГБ»</a>
</div>
<div class="texttt11">
    <a>К/с 30101810800000000786</a>
</div>
<div class="texttt12">
    <a>БИК 041909786</a>
</div>












  <div class="footer3">
    <div class="text"><a href="*">
      <h1>H2O35.RU</h1>
    </a></div>
    <div class="img11"><a href="index.html"><img src="img/logo.png" alt="*"></a></div>
    <div class="contact">
        <div class="adres"><a>ООО “Автономные системы”<br>
          г. Вологда ул. Клубова д.7.</a> </div>
        <div class="tel"><a>тел: 8(8172)50-40-89, 8-921-063-17-15</a></div>
      </div>
    <div class="infa">
      <a>Продажа, установка, монтаж и обслуживание автономных систем<br>
         для частных домов, коттеджей и организаций на всей территории<br>
          Вологодской области.</a>
    </div>
  
    <div class="btn-up btn-up_hide"></div>
  
    <script>
      const btnUp = {
        el: document.querySelector('.btn-up'),
        show() {
          // удалим у кнопки класс btn-up_hide
          this.el.classList.remove('btn-up_hide');
        },
        hide() {
          // добавим к кнопке класс btn-up_hide
          this.el.classList.add('btn-up_hide');
        },
        addEventListener() {
          // при прокрутке содержимого страницы
          window.addEventListener('scroll', () => {
            // определяем величину прокрутки
            const scrollY = window.scrollY || document.documentElement.scrollTop;
            // если страница прокручена больше чем на 400px, то делаем кнопку видимой, иначе скрываем
            scrollY > 400 ? this.show() : this.hide();
          });
          // при нажатии на кнопку .btn-up
          document.querySelector('.btn-up').onclick = () => {
            // переместим в начало страницы
            window.scrollTo({
              top: 0,
              left: 0,
              behavior: 'smooth'
            });
          }
        }
      }
      btnUp.addEventListener();
    </script>
  </div>



  <div id="ajax"></div>
	<h4     style= "margin-top: 100px;
    margin-bottom: 1px;
    font-weight: 500;
    line-height: 1.2;
    size: 15px;">Обратная связь</h4>
	
<p>Если у Вас возникли какие - либо вопросы, Вы можете отправить нам сообщение, заполнив поля формы обратной связи, расположенной ниже. Мы читаем все сообщения и стараемся максимально быстро на них реагировать, но тем не менее, если у вас какой то срочный вопрос, требующий незамедлительно ответной реакции, лучше позвоните нам.</p>


	<div id="forma">
		<form name="myform" id="form_1">
			<p><input type="text" name="fio" placeholder="Ваши Фамилия Имя *" /></p>
			<p><input type="text" name="email" placeholder="Ваш e-mail *" /></p>
			<p><input type="text" name="tema" placeholder="Тема письма *" /></p>
			<p><textarea name="mes" placeholder="Сообщение *"></textarea></p>
			<p><input type="button" name="sends" value="Отправить" onclick="valid_form(document.getElementById('form_1'));" /></p>
		</form>
	</div>

<script src="forms.js" defer></script>





</body>

</html>