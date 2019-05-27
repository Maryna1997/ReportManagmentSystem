
function validate(obj) { 
var nom = obj.n_form.value;
var start = obj.start.value;
var end = obj.end.value;
var warn = document.getElementById("warn");

if((start=='-не обрано-' && end=='-не обрано-') || (start=='' && end=='') || (start=='' && end=='-не обрано-') || (start=='-не обрано-' && end==''))
warn.innerHTML = "Оберіть хоча б одну дату!";	
else{
var pattern=/^[0-3]{1}[0-9]{1}-[01]{1}[0-9]{1}-[012]{1}[0-9]{3}$/;
var prov1=pattern.test(start);
var prov2=pattern.test(end);
if(prov1==false && start!='-не обрано-' && start!='')
warn.innerHTML = "Перевірте формат початкової дати!";
else{	
if(prov2==false && end!='-не обрано-' && end!='')
warn.innerHTML = "Перевірте формат кінцевої дати!";	
else{
	var dd1 = start.substring(0,2);
	var mm1 = start.substring(3,5);
	var yy1 = start.substring(6,10);
	var d1=new Date(yy1, mm1-1, dd1);
	var dd2 = end.substring(0,2);
	var mm2 = end.substring(3,5);
	var yy2 = end.substring(6,10);
	var d2=new Date(yy2, mm2-1, dd2);
	if(d1>d2 && start!='-не обрано-' && start!='' && end!='-не обрано-' && end!='')
	warn.innerHTML = "Неправильно обраний період!";	
else{
	warn.innerHTML = "";
	document.getElementById('check').style.display = 'none';
	document.getElementById('submit').style.display = 'block';
	}
}
}
}
}