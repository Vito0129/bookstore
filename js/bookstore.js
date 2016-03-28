var xmlhttp;

function validateLogin()
{
	var usermail = document.getElementById('mainusermail').value;
	var password = document.getElementById('mainpassword').value;
	if (usermail == '' || password == '')
	{
		alert('Make sure all fields are filled in before continuing');
		return false;
	}
}

function validateRegistration()
{
	var usermail = document.getElementById('usermail').value;
	var password = document.getElementById('password').value;
	var checkpassword = document.getElementById('checkpassword').value;
	if (usermail == '' || password == '' || checkpassword == '')
	{
		alert('Make sure all fields are filled in before continuing');
		return false;
	}
	if (password != cpassword)
	{
		alert('Passwords do not match');
		return false;
	}
}

//drag and drop from w3schools
function getTitle(s) {
    var incre = "myForm"+s;
    document.getElementById(incre).submit();
}

//jquery from onextrapixel.com
$(document).ready(function(){
	//fade in from http://www.onextrapixel.com/2010/02/23/how-to-use-jquery-to-make-slick-page-transitions/
	$("body").css("display", "none");
	$("body").fadeIn(500);
});

function getXMLHttpObject()
{
	if (window.XMLHttpRequest)
	{
		xmlHttp = new XMLHttpRequest(); //good browsers
	}
	else 
	{
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); // IE
	}
	return xmlHttp;
}

function addto(isbn, user, title)
{
	if(document.getElementById(isbn)!=null) return;
	var xmlhttp = getXMLHttpObject(); //create
	var params = "isbn="+isbn+"&user="+user+"&sid="+Math.random();
	xmlhttp.open('POST',"add.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
	var newli = document.createElement('li');
	var but = document.createElement('button'); //create the X button
	var newbook = document.createElement('label');
	newli.setAttribute('id',isbn);
	var newsel = document.createElement('select');
	newsel.setAttribute('style','float:right');
	newsel.setAttribute('onchange','changenumber(\"' + isbn + '\",\"' + user + '\",this.value);');
	but.innerHTML = 'X&nbsp;';
	but.setAttribute('onclick','removefrom(\"' + isbn + '\",\"' + user + '\",\"' + title + '\");');
	var count = 1;
	while(count < 10){
		var newop = document.createElement('option');
		newop.setAttribute('value',count);
		newop.innerHTML = count;
		newsel.appendChild(newop);
		count = count + 1;
	}
	but.setAttribute('class','close');
	newtitle = title;
	if(newtitle.length > 16){
		newtitle = newtitle.substr(0,16) + '...';
	}
	newbook.innerHTML = newtitle;
	newli.appendChild(but);
	newli.appendChild(newsel);
	newli.appendChild(newbook);
	document.getElementById('shoppingCartBar').appendChild(newli);
}

function  changenumber(isbn,user,number) {
	var xmlhttp = getXMLHttpObject(); //create
	var params = "isbn="+isbn+"&user="+user+"&number="+number+"&sid="+Math.random();
	xmlhttp.open('POST',"changenumber.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
}

function removefrom(isbn, user, title)
{
	var xmlhttp = getXMLHttpObject();
	var params = "isbn="+isbn+'&user='+user+'&sid='+Math.random();
	xmlhttp.open('POST','remove.php',true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
	var removed = document.getElementById(isbn);
	removed.parentNode.removeChild(removed);
}

function allowDrop(ev) {
	ev.preventDefault();
}

function drag(ev) {
	ev.dataTransfer.setData("text", ev.target.id);
	//ev.dataTransfer.setData('name', ev.target.name);
}

function drop(ev) {
	ev.preventDefault();
	var data = ev.dataTransfer.getData("text");
	ev.target.appendChild(document.getElementById(data).cloneNode(true));
	updoot(data);
}