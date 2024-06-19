<?php
// Подключение к базе данных
$db = new mysqli('localhost', 'root', '', 'regis');

if ($db->connect_error) {
    die("Ошибка подключения к базе данных: " . $db->connect_error);
}

// Получение данных из формы
$email = $_POST['email'];
$password = $_POST['password'];

// Подготовленный запрос для выборки данных пользователя по email
$stmt = $db->prepare("SELECT id, username, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $username, $hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        session_start();
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        header('Location: index.php'); // Перенаправляем на главную страницу
        exit();
    } else {
        echo "Неверный email или пароль";
    }
} else {
    echo "Пользователь не найден";
}

$stmt->close();
$db->close();
?>