<html>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
Usuario:<input name="name" type="text" id="name"/>
Password:<input name="password" type="text" id="password" />
<input type='submit' name='enviar'>
</form>
<?php 
if (isset($_POST['enviar'])){?>
<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://private-905d21-duai.apiary-mock.com/login");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE);

$response = curl_exec($ch);
curl_close($ch);

var_dump($response);

}?>
</body>
</html>
