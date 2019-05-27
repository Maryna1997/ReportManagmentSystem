<?php
		
$db=mysql_connect("localhost","ssut1","KsURvE5T53SWvkdqvYN5yaivN");
if (!$db) {
    die('Не удалось соединиться : ' . mysql_error());
}
$a=mysql_select_db("ssut1",$db); 
if (!$a) {
    die ('Не удалось выбрать базу : ' . mysql_error());
}

mysql_query("SET NAMES 'utf8'"); 
mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET SESSION collation_connection = 'utf8_general_ci'");

	$n_form=$_POST['n_form'];
	$date_start=$_POST['start'];
	$date_end=$_POST['end'];
	
	switch($n_form){
		case 1: $profile_id=10; break;
		case 2: $profile_id=14; break;
		case 3: $profile_id=11; break;
		case 4: $profile_id=39; break;
		case 5: $profile_id=7; break;
		case 6: $profile_id=8; break;
		case 7: $profile_id=33; break;
		case 8: $profile_id=42; break;
		case 9: $profile_id=28; break;
	}

if($date_start!='-не обрано-' && $date_start!=''){	
	$dd1=substr($date_start, 0,2);
	$mm1=substr($date_start, 3,2);
	$yy1=substr($date_start, 6,4);
	$date_start1 .= $yy1.'-'.$mm1.'-'.$dd1;
}
if($date_end!='-не обрано-' && $date_end!=''){	
	$dd2=substr($date_end, 0,2);
	$mm2=substr($date_end, 3,2);
	$yy2=substr($date_end, 6,4);
	$date_end1 .= $yy2.'-'.$mm2.'-'.$dd2;
}
if($date_end=='-не обрано-' || $date_end==''){	
$date .= "m.date_added >='".$date_start1."'";
}
if($date_start=='-не обрано-' || $date_start==''){	
$date .= "m.date_added <='".$date_end1."'";
}
if($date_start!='-не обрано-' && $date_start!='' && $date_end!='-не обрано-' && $date_end!=''){	
$date .= "m.date_added >='".$date_start1."' AND m.date_added <='".$date_end1."'";
}

$csv_file = ''; // создаем переменную, в которую записываем строки

if($n_form==1 || $n_form==2 || $n_form==3 || $n_form==4){
$query .= "SELECT DATE_FORMAT(m.date_added, '%Y-%m-%d') AS 'Дата реєстрації',
GROUP_CONCAT( if( t.field_id = '1', t.field_value, NULL ) ) AS 'ПІБ',
GROUP_CONCAT( if( t.field_id = '26', if(t.field_value = 'інший', '', t.field_value), if(t.field_id = '137', if(t.field_value = '', '', t.field_value), NULL)) SEPARATOR '') AS 'Університет',
GROUP_CONCAT( if( t.field_id = '29' OR t.field_id = '138', t.field_value, NULL ) SEPARATOR ' - ') AS 'Номер групи',
GROUP_CONCAT( if( t.field_id = '28', t.field_value, NULL ) ) AS 'Номер курсу',
GROUP_CONCAT( if( t.field_id = '3', t.field_value, NULL ) ) AS 'Контактний телефон',
GROUP_CONCAT( if( t.field_id = '2', t.field_value, NULL ) ) AS 'E-mail',
GROUP_CONCAT( if( t.field_id = '33', t.field_value, NULL ) ) AS 'Цікавий Вам напрям діяльності',
GROUP_CONCAT( if( t.field_id = '56', t.field_value, NULL ) ) AS 'Інше',
GROUP_CONCAT( if( t.field_id = '34', t.field_value, NULL ) ) AS 'Що зацікавило Вас у навчальному центрі?',
GROUP_CONCAT( if( t.field_id = '35', t.field_value, NULL ) ) AS 'Як Ви дізналися про навчальний центр?',
GROUP_CONCAT( if( t.field_id = '36', t.field_value, NULL ) ) AS 'Середній бал в заліковій книжці',
GROUP_CONCAT( if( t.field_id = '37', t.field_value, NULL ) ) AS 'Мережеві технології',
GROUP_CONCAT( if( t.field_id = '38', t.field_value, NULL ) ) AS 'ООП',
GROUP_CONCAT( if( t.field_id = '39', t.field_value, NULL ) ) AS 'Web',
GROUP_CONCAT( if( t.field_id = '40', t.field_value, NULL ) ) AS 'Мережеве програмування',
GROUP_CONCAT( if( t.field_id = '41', t.field_value, NULL ) ) AS 'Бази даних',
GROUP_CONCAT( if( t.field_id = '42', t.field_value, NULL ) ) AS 'Java',
GROUP_CONCAT( if( t.field_id = '43', t.field_value, NULL ) ) AS 'C++',
GROUP_CONCAT( if( t.field_id = '44', t.field_value, NULL ) ) AS 'Delphi',
GROUP_CONCAT( if( t.field_id = '45', t.field_value, NULL ) ) AS 'Pascal',
GROUP_CONCAT( if( t.field_id = '46', t.field_value, NULL ) ) AS 'PHP',
GROUP_CONCAT( if( t.field_id = '47', t.field_value, NULL ) ) AS 'Інші мови програмування',
GROUP_CONCAT( if( t.field_id = '49', t.field_value, NULL ) ) AS 'Рівень англійскої',
GROUP_CONCAT( if( t.field_id = '52', t.field_value, NULL ) ) AS 'Чому Ви хочете пройти навчання у навчальному центрі?',
GROUP_CONCAT( if( t.field_id = '53', t.field_value, NULL ) ) AS 'Додаткові відомості про себе',
GROUP_CONCAT( if( t.field_id = '66', t.field_value, NULL ) ) AS 'Який час найбільше підходить Вам для проходження нашого курсу?'

FROM sumdu_aicontactsafe_fieldvalues t
JOIN sumdu_aicontactsafe_messages m
ON (m.id = t.message_id)
WHERE m.profile_id = ".$profile_id." AND ".$date."
GROUP BY t.message_id, m.date_added";

$csv_file .= '"Дата реєстрації","ПІБ","Університет","Номер групи","Номер курсу","Контактний телефон","E-mail","Цікавий Вам напрям діяльності","Інше","Що зацікавило Вас у навчальному центрі?","Як Ви дізналися про навчальний центр?","Середній бал в заліковій книжці","Мережеві технології","ООП","Web","Мережеве програмування","Бази даних","Java","C++","Delphi","Pascal","PHP","Інші мови програмування","Рівень англійскої","Чому Ви хочете пройти навчання у навчальному центрі?","Додаткові відомості про себе","Який час найбільше підходить Вам для проходження нашого курсу?"'."\r\n";
}

if($n_form==5){
$query .= "SELECT DATE_FORMAT(m.date_added, '%Y-%m-%d') AS 'Дата реєстрації',
GROUP_CONCAT( if( t.field_id = '1', t.field_value, NULL ) ) AS 'ПІБ',
GROUP_CONCAT( if( t.field_id = '26', t.field_value, NULL ) ) AS 'Університет',
GROUP_CONCAT( if( t.field_id = '28', t.field_value, NULL ) ) AS 'Номер курсу',
GROUP_CONCAT( if( t.field_id = '29', t.field_value, NULL ) ) AS 'Номер групи',
GROUP_CONCAT( if( t.field_id = '3', t.field_value, NULL ) ) AS 'Контактний телефон',
GROUP_CONCAT( if( t.field_id = '2', t.field_value, NULL ) ) AS 'E-mail',
GROUP_CONCAT( if( t.field_id = '30', t.field_value, NULL ) ) AS 'Бажані мови/середовища програмування'
FROM sumdu_aicontactsafe_fieldvalues t
JOIN sumdu_aicontactsafe_messages m
ON (m.id = t.message_id)
WHERE m.profile_id = ".$profile_id." AND ".$date."
GROUP BY t.message_id, m.date_added";

$csv_file .= '"Дата реєстрації","ПІБ","Університет","Номер курсу","Номер групи","Контактний телефон","E-mail","Бажані мови/середовища програмування"'."\r\n";
}

if($n_form==6 || $n_form==7){
$query .= "SELECT DATE_FORMAT(m.date_added, '%Y-%m-%d') AS 'Дата реєстрації',
GROUP_CONCAT( if( t.field_id = '1', t.field_value, NULL ) ) AS 'ПІБ',
GROUP_CONCAT( if( t.field_id = '26', t.field_value, NULL ) ) AS 'Університет',
GROUP_CONCAT( if( t.field_id = '28', t.field_value, NULL ) ) AS 'Номер курсу',
GROUP_CONCAT( if( t.field_id = '29', t.field_value, NULL ) ) AS 'Номер групи',
GROUP_CONCAT( if( t.field_id = '3', t.field_value, NULL ) ) AS 'Контактний телефон',
GROUP_CONCAT( if( t.field_id = '2', t.field_value, NULL ) ) AS 'E-mail'
FROM sumdu_aicontactsafe_fieldvalues t
JOIN sumdu_aicontactsafe_messages m
ON (m.id = t.message_id)
WHERE m.profile_id = ".$profile_id." AND ".$date."
GROUP BY t.message_id, m.date_added";

$csv_file .= '"Дата реєстрації","ПІБ","Університет","Номер курсу","Номер групи","Контактний телефон","E-mail"'."\r\n";
}


if($n_form==8){
$query .= "SELECT DATE_FORMAT(m.date_added, '%Y-%m-%d') AS 'Дата бронювання',
GROUP_CONCAT( if( t.field_id = '218', t.field_value, NULL ) ) AS 'ПІБ осіб, котрі прибувають',
GROUP_CONCAT( if( t.field_id = '206', t.field_value, NULL ) ) AS 'Дата заїзду',
GROUP_CONCAT( if( t.field_id = '207', t.field_value, NULL ) ) AS 'Дата від’їзду',
GROUP_CONCAT( if( t.field_id = '219', t.field_value, NULL ) ) AS 'Категорія номера або ліжко – місця',
GROUP_CONCAT( if( t.field_id = '220', t.field_value, NULL ) ) AS 'Кількість номерів',
GROUP_CONCAT( if( t.field_id = '205', t.field_value, NULL ) ) AS 'Email',
GROUP_CONCAT( if( t.field_id = '204', t.field_value, NULL ) ) AS 'Контактний телефон',
GROUP_CONCAT( if( t.field_id = '221', t.field_value, NULL ) ) AS 'Форма оплати'
FROM sumdu_aicontactsafe_fieldvalues t
JOIN sumdu_aicontactsafe_messages m
ON (m.id = t.message_id)
WHERE m.profile_id = ".$profile_id." AND ".$date."
GROUP BY t.message_id, m.date_added";
$csv_file .= '"Дата бронювання","ПІБ осіб, котрі прибувають","Дата заїзду","Дата від’їзду","Категорія номера або ліжко – місця","Кількість номерів","E-mail","Контактний телефон","Форма оплати"'."\r\n";
}

if($n_form==9){
$query .= "SELECT DATE_FORMAT(m.date_added, '%Y-%m-%d') AS 'Дата заповнення',
GROUP_CONCAT( if( t.field_id = '169', t.field_value, NULL ) ) AS 'Прізвище, ім`я',
GROUP_CONCAT( if( t.field_id = '181', t.field_value, NULL ) ) AS 'Як Ви дізналися про нашу олімпіаду?',
GROUP_CONCAT( if( t.field_id = '144', t.field_value, NULL ) ) AS 'Опишіть, будь ласка, загальні враження від олімпіади. Що вам більше всього сподобалося? Що не сподобалося?',
GROUP_CONCAT( if( t.field_id = '243', t.field_value, NULL ) ) AS 'Оцініть, будь ласка, наскільки цікавими були завдання олімпіади',
GROUP_CONCAT( if( t.field_id = '244', t.field_value, NULL ) ) AS 'Оцініть, будь ласка, наскільки складними були завдання олімпіади',
GROUP_CONCAT( if( t.field_id = '245', t.field_value, NULL ) ) AS 'Які з задач Вам сподобались найбільше? Чому?',
GROUP_CONCAT( if( t.field_id = '246', t.field_value, NULL ) ) AS 'Які з задач Вам  не сподобались? Чому?',
GROUP_CONCAT( if( t.field_id = '164', t.field_value, NULL ) ) AS 'Оцініть, будь ласка, наскільки сподобалася Вам організація олімпіади',
GROUP_CONCAT( if( t.field_id = '165', t.field_value, NULL ) ) AS 'Дайте, будь ласка, розгорнутий коментар до своєї відповіді',
GROUP_CONCAT( if( t.field_id = '166', t.field_value, NULL ) ) AS 'Оцініть, будь ласка, наскільки ефективно куратор від компанії реагував на проблеми, які виникали під час проведенн¤ олімпіади',
GROUP_CONCAT( if( t.field_id = '167', t.field_value, NULL ) ) AS 'Яку саме допомогу Вам надавав куратор від компанії під час проведення олімпіади?',
GROUP_CONCAT( if( t.field_id = '168', t.field_value, NULL ) ) AS 'Напишіть, будь ласка, що, на Вашу думку, можна покращити у проведенні олімпіади?'
FROM sumdu_aicontactsafe_fieldvalues t
JOIN sumdu_aicontactsafe_messages m
ON (m.id = t.message_id)
WHERE m.profile_id = ".$profile_id." AND ".$date."
GROUP BY t.message_id, m.date_added";

$csv_file .= '"Дата заповнення","Прізвище, ім`я","Як Ви дізналися про нашу олімпіаду?","Опишіть, будь ласка, загальні враження від олімпіади. Що вам більше всього сподобалося? Що не сподобалося?","Оцініть, будь ласка, наскільки цікавими були завдання олімпіади","Оцініть, будь ласка, наскільки складними були завдання олімпіади","Які з задач Вам сподобались найбільше? Чому?","Які з задач Вам  не сподобались? Чому?","Оцініть, будь ласка, наскільки сподобалася Вам організація олімпіади","Дайте, будь ласка, розгорнутий коментар до своєї відповіді","Оцініть, будь ласка, наскільки ефективно куратор від компанії реагував на проблеми, які виникали під час проведенн¤ олімпіади","Яку саме допомогу Вам надавав куратор від компанії під час проведення олімпіади?","Напишіть, будь ласка, що, на Вашу думку, можна покращити у проведенні олімпіади?"'."\r\n";
}

$result = mysql_query($query);
if ($result)
{
   while ($row = mysql_fetch_assoc($result))
   {
	  if($n_form==1 || $n_form==2 || $n_form==3 || $n_form==4){
      $csv_file .= '"'.$row["Дата реєстрації"].'","'.$row["ПІБ"].'","'.$row["Університет"].'","'.$row["Номер групи"].
	  '","'.$row["Номер курсу"].'","'.$row["Контактний телефон"].'","'.$row["E-mail"].'","'.$row["Цікавий Вам напрям діяльності"].
	  '","'.$row["Інше"].'","'.$row["Що зацікавило Вас у навчальному центрі?"].'","'.str_replace(array("\r","\n"),"",$row["Як Ви дізналися про навчальний центр?"]).
	  '","'.$row["Середній бал в заліковій книжці"].'","'.$row["Мережеві технології"].'","'.$row["ООП"].'","'.$row["Web"].'","'.$row["Мережеве програмування"].'","'.
	  $row["Бази даних"].'","'.$row["Java"].'","'.$row["C++"].'","'.$row["Delphi"].'","'.$row["Pascal"].'","'.$row["PHP"].'","'.$row["Інші мови програмування"].'","'.
	  $row["Рівень англійскої"].'","'.$row["Чому Ви хочете пройти навчання у навчальному центрі?"].'","'.$row["Додаткові відомості про себе"].'","'.
	  $row["Який час найбільше підходить Вам для проходження нашого курсу?"].'"'."\r\n";
	  }
	  if($n_form==5){
		$csv_file .= '"'.$row["Дата реєстрації"]. '","'.str_replace(array("\r","\n"),"",$row["ПІБ"]).'","'.
		str_replace(array("\r","\n"),"",$row["Університет"]).'","'.str_replace(array("\r","\n"),"",$row["Номер курсу"]).'","'.
		str_replace(array("\r","\n"),"",$row["Номер групи"]).'","'.str_replace(array("\r","\n"),"",$row["Контактний телефон"]).'","'.
		str_replace(array("\r","\n"),"",$row["E-mail"]).'","'.str_replace(array("\r","\n"),"",$row["Бажані мови/середовища програмування"]).'"'."\r\n";
	  }
	  
	    if($n_form==6 || $n_form==7){
		$csv_file .= '"'.$row["Дата реєстрації"]. '","'.str_replace(array("\r","\n"),"",$row["ПІБ"]).'","'.
		str_replace(array("\r","\n"),"",$row["Університет"]).'","'.str_replace(array("\r","\n"),"",$row["Номер курсу"]).'","'.
		str_replace(array("\r","\n"),"",$row["Номер групи"]).'","'.str_replace(array("\r","\n"),"",$row["Контактний телефон"]).'","'.
		str_replace(array("\r","\n"),"",$row["E-mail"]).'"'."\r\n";
	  }
	  
	  if($n_form==8){
		$csv_file .= '"'.$row["Дата бронювання"].'","'.str_replace(array("\r","\n"),"",$row["ПІБ осіб, котрі прибувають"]).'","'.
		str_replace(array("\r","\n"),"",$row["Дата заїзду"]).'","'.str_replace(array("\r","\n"),"",$row["Дата від’їзду"]).'","'.
		str_replace(array("\r","\n"),"",$row["Категорія номера або ліжко – місця"]).'","'.str_replace(array("\r","\n"),"",$row["Кількість номерів"]).'","'.
		str_replace(array("\r","\n"),"",$row["E-mail"]).'","'.str_replace(array("\r","\n"),"",$row["Контактний телефон"]).
		str_replace(array("\r","\n"),"",$row["Форма оплати"]).'"'."\r\n";
	  }
	  if($n_form==9){
      $csv_file .= '"'.$row["Дата заповнення"].'","'.str_replace(array("\r","\n"),"",$row["Прізвище, ім`я"]).'","'.
	  str_replace(array("\r","\n"),"",$row["Як Ви дізналися про нашу олімпіаду?"]).'","'.
	  str_replace(array("\r","\n"),"",$row["Опишіть, будь ласка, загальні враження від олімпіади. Що вам більше всього сподобалося? Що не сподобалося?"]).'","'.
	  str_replace(array("\r","\n"),"",$row["Оцініть, будь ласка, наскільки цікавими були завдання олімпіади"]).'","'.
	  str_replace(array("\r","\n"),"",$row["Оцініть, будь ласка, наскільки складними були завдання олімпіади"]).'","'.
	  str_replace(array("\r","\n"),"",$row["Які з задач Вам сподобались найбільше? Чому?"]).'","'.
	  str_replace(array("\r","\n"),"",$row["Які з задач Вам  не сподобались? Чому?"]).'","'.
	  str_replace(array("\r","\n"),"",$row["Оцініть, будь ласка, наскільки сподобалася Вам організація олімпіади"]).'","'.
	  str_replace(array("\r","\n"),"",$row["Дайте, будь ласка, розгорнутий коментар до своєї відповіді"]).'","'.
	  str_replace(array("\r","\n"),"",$row["Оцініть, будь ласка, наскільки ефективно куратор від компанії реагував на проблеми, які виникали під час проведенн¤ олімпіади"]).'","'.
	  str_replace(array("\r","\n"),"",$row["Яку саме допомогу Вам надавав куратор від компанії під час проведення олімпіади?"]).'","'.
	  str_replace(array("\r","\n"),"",$row["Напишіть, будь ласка, що, на Вашу думку, можна покращити у проведенні олімпіади?"]).'"'."\r\n";
	  }
	  
	  	  
      // в качестве начала и конца полей я указал " (двойные кавычки)
      // в качестве разделителей полей я указал , (запятая)
      // \r\n - это перенос строки
	  }
}

$file_name .= 'export'.'_'.date("Y-m-d_H-i-s").'.csv'; // название файла
$file = fopen($file_name,"w"); // открываем файл для записи, если его нет, то создаем его в текущей папке, где расположен скрипт
fwrite($file,trim($csv_file)); // записываем в файл строки
fclose($file); // закрываем файл

// задаем заголовки. то есть задаем всплывающее окошко, которое позволяет нам сохранить файл.
header('Content-type: text/csv; charset=windows-1251'); // указываем, что это csv документ
header("Content-Disposition: inline; filename=$file_name"); // указываем файл, с которым будем работать
readfile($file_name); // считываем файл
unlink($file_name); // удаляем файл. то есть когда вы сохраните файл на локальном компе, то после он удалится с сервера

?>