<?php 
if ($_POST) {
                $cadena = 'KknDlkLKmmm909b998vb92368nJuijs6s544sd';
                $usuario = $_POST['usuario'];
                $password = $_POST['password'];
               
                $url = 'http://webapitest.uai.cl/wellness/login';
                                              
                echo "<br />Esta es la cadena: " . $cadena;
                echo "<br />Esta es la url: " . $url;
               
                echo "<br />param1: " . $usuario;
                echo "<br />param2: " . $password;
                $curl_post_data = array(
            									"token" => $cadena,
                                               "email" => $usuario,
                                               "password" => $password,
            );
                $data_string = json_encode($curl_post_data);      
               
                $curl = curl_init();
               
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                         
    'Content-Type: application/json',                                                                               
    'Content-Length: ' . strlen($data_string))                                                                      
                ); 
 
                echo '<br />';
                echo $curl;
                $curl_response = curl_exec($curl);
               
                curl_close($curl);
                echo '<br />';
                echo $curl_response;
                              
                $decoded = json_decode($curl_response);
                echo "<br /><br />Token devuelto por el servicio: " . $decoded->token;
               
                $decoded = json_decode($curl_response);
               
}
?>