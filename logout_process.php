<?php
session_start();

// Очистить данные об авторизованном пользователе из сессии
unset($_SESSION['user_id']);
unset($_SESSION['username']);
// Другие данные о пользователе, которые нужно очистить

// Уничтожить сессию
session_unset();
session_destroy();
?>