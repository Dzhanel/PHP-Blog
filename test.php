<?PHP
session_start();
$_SESSION['name'] = "MySession";
echo $_SESSION['name'];