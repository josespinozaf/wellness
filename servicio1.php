<?php 
session_start();
if ($_POST) {
                $token = 'KknDlkLKmmm909b998vb92368nJuijs6s544sd';
                $email = $_POST['email'];
                $password = $_POST['password'];
               
                $url = 'http://webapitest.uai.cl/wellness/login';
                //$url = 'http://private-74270a-uai2.apiary-mock.com/login';
                                              
                echo "<br />Esta es la cadena: " . $token;
                echo "<br />Esta es la url: " . $url;
               
                echo "<br />Email ingresado: " . $email;
                echo "<br />Password ingresada: " . $password;
                $curl_post_data = array(
            									"token" => $token,
                                               "email" => $email,
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
                $curl_response = curl_exec($curl);
               
                curl_close($curl);
                echo '<br />';
                echo "El curl_response es (string complet):".$curl_response;
                              
                $decoded = json_decode($curl_response);
                $tokenApp = $decoded->token;
                echo "<br /><br />TokenApp devuelto por el servicio: " . $decoded->token;
                echo "<a href='http://localhost:81/moodle/local/wellness/serviciochino.php'>Link</a>";
                $_SESSION["tokenApp"] = $tokenApp;
               
}
?>