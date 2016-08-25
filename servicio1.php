<?php
if ($_POST) {
                $cadena = "KknDlkLKmmm909b998vb92368nJuijs6s544sd";
                $usuario = $_POST['usuario'];
                $password = $_POST['password'];
               
               
                //$url = 'http://webapitest.uai.cl/wellness/login?token='.$cadena.'&?email='.$usuario.'&?password='.$password;
                $url = 'http://webapitest.uai.cl/wellness/login';
                              
                              
                echo "<br />Esta es la cadena: " . $cadena;
                echo "<br />Esta es la url: " . $url;
               
                $curl_post_data = array(
            								   "token" => $cadena,
                                               "email" => $usuario,
                                               "password" => $password
            );
                                              
                $curl = curl_init();
               
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
 			   	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 			   	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json" ));
               
                $curl_response = curl_exec($curl);
               
                curl_close($curl);
               
                 echo "<br /><br />Resultado: " . $curl_response;       
               
                $decoded = json_decode($curl_response);
               
                echo "<br /><br />Token devuelto por el servicio: " . $decoded;
                              
                //$data = decryptToken($decoded->Message,'asdasd');
 					              
                //echo "<br /><br />Token desencriptado: " . $data;          
}
?>
