<?php
// Подключение к базе данных
$db = new mysqli('localhost', 'root', '', 'regis');

if ($db->connect_error) {
    die("Ошибка подключения к базе данных: " . $db->connect_error);
}

// Получение данных из формы
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Хешируем пароль

// Подготовленный запрос для вставки данных
$stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $password);

// Выполнение запроса
if ($stmt->execute()) {
    header('Location: index.php');
    exit;
} else {
    echo "Ошибка при регистрации: " . $db->error;
}

// Закрытие подключения к базе данных
$stmt->close();
$db->close();
?>