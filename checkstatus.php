<?php
$clientId = '***********'; // Change with your Client ID
$secretKey = '***********'; // Change with your Secret Key 
$invoice = '1234';
$requestId = rand(1, 100000);
date_default_timezone_set("Atlantic/Azores");
$url = 'https://api-sandbox.doku.com';
$path = '/orders/v1/status/'.$invoice;
$timestamp      = date('Y-m-d\TH:i:s\Z');
$abc 			= 'Client-Id:'.$clientId."\n".'Request-Id:'.$requestId."\n".'Request-Timestamp:'.$timestamp."\n".'Request-Target:'.$path;
echo $abc.'<br>';
//$secret		= 'SK-vyCJdZV2jPuv4Mo8lWB5';
$signature  = base64_encode(hash_hmac('sha256', $abc, $secretKey, true));
$header = 'HMACSHA256='.$signature;
echo $signature.'<br>';
echo $header.'<br>';
echo $clientId.'<br>';
echo $requestId.'<br>';
echo $url.$path.$invoice.'<br>';
// print_r($checksum);die();
$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt_array($curl, array(
  CURLOPT_URL => $url.$path,
  CURLOPT_RETURNTRANSFER => 1,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Client-Id: '.$clientId,
    'Request-Id: '.$requestId,
    'Request-Timestamp: '.$timestamp,
    'Signature: '."HMACSHA256=".$signature
  ),
));

$response = curl_exec($curl);

curl_close($curl);
if ($err) {
      echo "cURL Error #:" . $err;
} else {
    echo $response;
} ?>
