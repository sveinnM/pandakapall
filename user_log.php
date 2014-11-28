<?php
if (isset($_POST["nameID"])) {
	$cookie_value = md5($_POST["nameID"]);
	$cookie_namevalue = $_POST["name"];

	setcookie("login_cookie", $cookie_value, time() + 86400, "/");
	setcookie("name_cookie", $cookie_namevalue, time() + 86400, "/");
}

if (isset($_POST["signOut"])) {
	setcookie("login_cookie", uniqid(), time() - 86400, "/");
	setcookie("name_cookie", uniqid(), time() - 86400, "/");
}