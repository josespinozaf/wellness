<html>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
Usuario:<input name="name" type="text" id="name"/>
Password:<input name="password" type="text" id="password" />
<input type='submit' name='enviar'>
</form>
<?php 
if (isset($_POST['enviar'])){?>
<script type="text/javascript">
var name = document.getElementById("name").value;
var password = document.getElementById("passwori").value
var token = "KknDlkLKmmm909b998vb92368nJuijs6s544sd";
var request = new XMLHttpRequest();
request.open('POST', 'http://private-d36e3-uai1.apiary-mock.com/login{?token&?email&?password}');
request.onreadystatechange = function () {
  if (this.readyState === 4) {
    console.log('Status:', this.status);
    console.log('Headers:', this.getAllResponseHeaders());
    console.log('Body:', this.responseText);
  }
};

request.send();
</script>
<?php }?>
</body>
</html>
