<?php
if(count($_POST)==4){
	//Прием полей
	$fio='';if(isset($_POST['fio'])){$fio=htmlspecialchars(stripslashes(strip_tags(trim($_POST['fio']))));}
	$email='';if(isset($_POST['email'])){$email=htmlspecialchars(stripslashes(strip_tags(trim($_POST['email']))));}
	$tema='';if(isset($_POST['tema'])){$tema=htmlspecialchars(stripslashes(strip_tags(trim($_POST['tema']))));}
	$mes='';if(isset($_POST['mes'])){$mes=htmlspecialchars(stripslashes(strip_tags(trim($_POST['mes']))));}
	
	//Проверка полей
	$err=array();//Массив для ошибок
	if(empty($fio) || mb_strlen($fio,'UTF-8')>40
	||!preg_match("/^[a-z0-9][a-z0-9\.-_]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i",$email)
	||empty($tema) || mb_strlen($tema,'UTF-8')>30
	||empty($mes) || mb_strlen($mes,'UTF-8')>350){exit;}
	
	//Отправка
	
	
	$result = mail("sonja.trofimova1110@yandex.ru","Текст","Сообщение: $_POST[mes] Тема: $_POST[tema]");
    
    if ($result) {
        echo "<p>Сообщение отправлено. </p>";
    }
    else {
    echo '<p class="mes_ok">Сообщение не отправлено. Попробуйте еще раз.</p>';    
    }
     
}