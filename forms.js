function valid_form(id){
	//Прием полей
	var fio=id.fio.value,
	email=id.email.value,
	tema=id.tema.value,
	mes=id.mes.value,
	err='';
	
	//Проверка полей
	var pattern =/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if(!pattern.test(email) || email.length>150){err+='- Некорректный E-mail\n';}
	
	if(fio.length<7 || fio.length>30){err+='- Некорректное ФИО\n';}
	if(tema.length<7 || tema.length>30){err+='- Некорректная тема\n';}
	if(mes.length<10 || mes.length>350){err+='- Некорректное сообщение\n';}
	
	if(err.length>0){alert('Исправьте ошибки: \n'+err);}
	else{
		// Передача GET и POST-переменных
		var formData=new FormData();
		formData.append('fio',fio);
		formData.append('email',email);
		formData.append('tema',tema);
		formData.append('mes',mes);
		
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				var rpz_TXT=xmlhttp.responseText;
				
				var bl=document.getElementById('ajax');
				bl.innerHTML=rpz_TXT;
			}
		}
		xmlhttp.open("POST",'send_form.php',true);
		xmlhttp.send(formData);
	}
}
