<?php
if(isset($_POST['submit']))
{
if (empty($_POST['user']) or empty($_POST['pass'])) 
{
echo "<script>alert('Ви ввели не всю інформацію!');</script>";
echo '<script type="text/javascript">
window.location.href="http://t1.sumdu.edu.ua/RMS/index.php";
</script>';
} 
if(!preg_match("/^[0-9a-zA-Z]/",$_POST['user']))
{ echo "<script>alert('Логін повинен складатися з букв англійського алфавіту та цифр!');</script>";
echo '<script type="text/javascript">
window.location.href="http://t1.sumdu.edu.ua/RMS/index.php";
</script>';}
else
{
$login=	$_POST['user'];
$password=$_POST['pass'];
if($login=="admin" && $password=="Pass12ADM")
{
session_start();
$_SESSION[id] = $login;	


}
else{
echo "<script>alert('Перевірте правильність введення логіна і пароля!');</script>";	
echo '<script type="text/javascript">
window.location.href="http://t1.sumdu.edu.ua/RMS/index.php";
</script>';
}
}
}
if(isset($_POST['logout'])){
	unset($_SESSION[id]);
	session_destroy();
	}

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>СумДУ-Система керування звітами</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/form.css" rel="stylesheet" type="text/css" />
<link href="css/form_zvit.css" rel="stylesheet" type="text/css" />
<link href="css/date.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
<script type="text/javascript" src="js/time.js"></script>
<script type="text/javascript" src="js/calendar_ru.js"></script>
<script type="text/javascript" src="js/proverka.js"></script>
</head>
<body onLoad="myclock()" link="red" vlink="blue" alink="#ff0000">
<div id="sumdu"></div>
<div id="main">
<div id="forma_time">
<form name="clockexam">
<input class="chas_input" type="text" size="9" name="clock">
</form>
</div>
<div id="forma_calendar">
<div style="width:230px; border-top:2px solid #00008B; border-bottom:2px solid #00008B; padding:6px; " >
<table id="calendar"  cellspacing="0" cellpadding="1">
  <thead>
    <tr><td bgcolor="#ffffff"><b>‹</b><td colspan="5" bgcolor="#00008B"><td bgcolor="#ffffff"><b>›</b>
    <tr border="1"><strong><td bgcolor="#00008B">Пн<td bgcolor="#00008B">Вт<td bgcolor="#00008B">Ср<td bgcolor="#00008B">Чт<td bgcolor="#00008B">Пт<td bgcolor="#00008B">Сб<td bgcolor="#00008B">Вс</strong>
  </thead>
  <tbody></tbody>
</table>
</div>
</div>
<?php
if(isset($_SESSION[id]))
{
?>
<div id="success">
<h3>Вітаємо, admin, ви успішно авторизувалися!</h3>
<div id="logout">
<form method="POST" action="index.php">
<input type="submit" name="logout" style="background-image: url(images/logout.png);" value="       ">
</form>
</div>
</div>
<div id="center">
<div id="forma">
<h3>Оберіть параметри для вашого звіту:</h3>
<div id="zvit">
<form name="formparam" method="POST" action="php/parametr.php">
<p id="warn"></p>
<b>Форма:</b>
<select name="n_form" >
    <option value="1">№1 "Реєстрація на курси QA"</option>
    <option value="2">№2 "Реєстрація на курси TA"</option>
    <option value="3">№3 "Реєстрація на курси Java"</option> 
    <option value="4">№4 "Реєстрація на курси CSA"</option>
    <option value="5">№5 "Реєстрація на олімпіаду Programming"</option>
	<option value="6">№6 "Реєстрація на олімпіаду QA"</option>
	<option value="7">№7 "Реєстрація на олімпіаду TA"</option>
	<option value="8">№8 "Бронювання готелю"</option>
	<option value="9">№9 "Олімпіади: зворотній зв'язок"</option>
    </select>
<br>	
Період:	

з <input type="text"  name="start" value="-не обрано-" onfocus="this.select();lcs(this)"
    onclick="event.cancelBubble=true;this.select();lcs(this)">

по <input type="text" name="end" value="-не обрано-" onfocus="this.select();lcs(this)"
    onclick="event.cancelBubble=true;this.select();lcs(this)">
	
	
<input type="button" id="check" value="Перевірка введених даних" onclick="validate(formparam)">
<input type="submit" id="submit" value="Завантажити звіт">
</form>
</div>
</div>
</div>
<?php
}
else{
?>
<div id="center">
<div style=" margin-top:310px;">
<h1><b>СИСТЕМА КЕРУВАННЯ ЗВІТАМИ</b></h1>
</div>
<div id="forma">

<h3>Для того, щоб скористатися сервісом, будь-ласка, авторизуйтесь:</h3>
<div id="login">
<form name='form-login' method="POST" action="index.php">
  <span class="fontawesome-user"></span>
 <input type="text" id="user" name="user" placeholder="Логін">
       
 <span class="fontawesome-lock"></span>
 <input type="password" id="pass" name="pass" placeholder="Пароль">

<input type="submit" name="submit" value="Увійти до системи">
</form>
</div>
</div>
</div>
</div>
<?php
}
?>

</div>
<div id="footer">
<h2>
 <b> Copyright © 2018 <a href="http://sumdu.edu.ua/">Сумський державний університет</a><br>
Розробка сайту і підтримка сайту: Чорнобай М.A.</b>
</h2>
</div>

<script>
function calendar(id, year, month) {
var Dlast = new Date(year,month+1,0).getDate(),
    D = new Date(year,month,Dlast),
    DNlast = new Date(D.getFullYear(),D.getMonth(),Dlast).getDay(),
    DNfirst = new Date(D.getFullYear(),D.getMonth(),1).getDay(),
    calendar = '<tr>',
    month=["Січень","Лютий","Березень","Квітень","Травень","Червень","Липень","Серпень","Вересень","Жовтень","Листопад","Грудень"];
if (DNfirst != 0) {
  for(var  i = 1; i < DNfirst; i++) calendar += '<td>';
}else{
  for(var  i = 0; i < 6; i++) calendar += '<td>';
}
for(var  i = 1; i <= Dlast; i++) {
  if (i == new Date().getDate() && D.getFullYear() == new Date().getFullYear() && D.getMonth() == new Date().getMonth()) {
    calendar += '<td class="today">' + i;
  }else{
    calendar += '<td>' + i;
  }
  if (new Date(D.getFullYear(),D.getMonth(),i).getDay() == 0) {
    calendar += '<tr>';
  }
}
for(var  i = DNlast; i < 7; i++) calendar += '<td> ';
document.querySelector('#'+id+' tbody').innerHTML = calendar;
document.querySelector('#'+id+' thead td:nth-child(2)').innerHTML = month[D.getMonth()] +' '+ D.getFullYear();
document.querySelector('#'+id+' thead td:nth-child(2)').dataset.month = D.getMonth();
document.querySelector('#'+id+' thead td:nth-child(2)').dataset.year = D.getFullYear();
if (document.querySelectorAll('#'+id+' tbody tr').length < 6) {  // чтобы при перелистывании месяцев не "подпрыгивала" вся страница, добавляется ряд пустых клеток. Итог: всегда 6 строк для цифр
    document.querySelector('#'+id+' tbody').innerHTML += '<tr><td> <td> <td> <td> <td> <td> <td> ';
}
}
calendar("calendar", new Date().getFullYear(), new Date().getMonth());
// переключатель минус месяц
document.querySelector('#calendar thead tr:nth-child(1) td:nth-child(1)').onclick = function() {
  calendar("calendar", document.querySelector('#calendar thead td:nth-child(2)').dataset.year, parseFloat(document.querySelector('#calendar thead td:nth-child(2)').dataset.month)-1);
}
// переключатель плюс месяц
document.querySelector('#calendar thead tr:nth-child(1) td:nth-child(3)').onclick = function() {
  calendar("calendar", document.querySelector('#calendar thead td:nth-child(2)').dataset.year, parseFloat(document.querySelector('#calendar thead td:nth-child(2)').dataset.month)+1);
}

</script>

</body>
</html>