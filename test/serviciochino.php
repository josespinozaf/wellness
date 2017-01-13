<html>
<body>
<?php 
session_start();

                $token = 'KknDlkLKmmm909b998vb92368nJuijs6s544sd';
                $tokenApp = $_SESSION["tokenApp"];
               
                $url = 'http://webapitest.uai.cl/wellness/InformacionPersonal';
                //$url = 'http://private-74270a-uai2.apiary-mock.com/InformacionPersonal';
                                              
                echo "<br />Esta es la cadena: " . $token;
                echo "<br />Esta es la url: " . $url;
               
                echo "<br />TokenApp ingresado: " . $tokenApp;
                $curl_post_data = array(
            									"token" => $token,
                                               "tokenApp" => $tokenApp                                               
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
                echo "El curl_response es (string completo):".$curl_response;
                              
                $decoded = json_decode($curl_response);
                echo "<br /><br />Nombre Completo devuelto por el servicio: " . $decoded->nombreCompleto;
                echo "<br /><br />Rut devuelto por el servicio: " . $decoded->rut;
                        

?>
</body>
</html>
