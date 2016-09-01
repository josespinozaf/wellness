<html>
<body>
<form action="servicio1.php" method="post">
Usuario:<input name="email" type="text" id="email"/>
Password:<input name="password" type="text" id="password" />
<input type='submit' name='enviar'>
</form>
</body>
</html>
<?php 
session_start();
session_unset();
?>