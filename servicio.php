<html>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
Usuario:<input name="name" type="text" />
Password:<input name="password" type="text" />
<input type='submit' name='enviar'>
</form>
<?php 
if (isset($_POST['enviar'])){
	
$name= $_REQUEST['name'];
$password= $_REQUEST['password'];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://private-d36e3-uai1.apiary-mock.com/login{?token&?email&?password}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE);

$response = curl_exec($ch);
curl_close($ch);

var_dump($response);
}
?>
</body>
</html>
