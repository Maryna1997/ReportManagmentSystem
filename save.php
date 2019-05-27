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

$csv_file = ''; // создаем переменную, в которую записываем строки

$query = "SELECT DATE_FORMAT(m.date_added, '%Y-%m-%d') AS 'Дата реєстрації',
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
WHERE m.profile_id = 11 AND m.date_added > '2013-09-20'
GROUP BY t.message_id, m.date_added";
$result = mysql_query($query);
if ($result)
{
   while ($row = mysql_fetch_assoc($result))
   {
      $csv_file .= '"'.$row["Дата реєстрації"].'","'.$row["ПІБ"].'","'.$row["Університет"].'","'.$row["Номер групи"].'","'.$row["Номер курсу"].'","'.$row["Контактний телефон"].'","'.$row["E-mail"].'","'.$row["Цікавий Вам напрям діяльності"].'","'.$row["Інше"].'","'.$row["Що зацікавило Вас у навчальному центрі?"].'","'.str_replace(array("\r","\n"),"",$row["Як Ви дізналися про навчальний центр?"]).'","'.$row["Середній бал в заліковій книжці"].'","'.$row["Мережеві технології"].'","'.$row["ООП"].'","'.$row["Web"].'","'.$row["Мережеве програмування"].'","'.$row["Бази даних"].'","'.$row["Java"].'","'.$row["C++"].$row["Delphi"].$row["Pascal"].$row["PHP"].$row["Інші мови програмування"].$row["Рівень англійскої"].$row["Чому Ви хочете пройти навчання у навчальному центрі?"].'","'.$row["Додаткові відомості про себе"].'","'.$row["Який час найбільше підходить Вам для проходження нашого курсу?"].'"'."\r\n";
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