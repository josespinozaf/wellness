<html>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
Usuario:<input name="name" type="text" id="name"/>
Password:<input name="password" type="text" id="password" />
<input type='submit' name='enviar'>
</form>
<?php 
if (isset($_POST['enviar'])){
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://private-d36e3-uai1.apiary-mock.com/login?token=KknDlkLKmmm909b998vb92368nJuijs6s544sd&email=josespinoza%40alumnos.uai.cl&password=1234.AaA");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/x-www-form-urlencoded"
));

$response = curl_exec($ch);
curl_close($ch);

var_dump($response);
}?>
</body>
</html>
