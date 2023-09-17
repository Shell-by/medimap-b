<?php

$serviceKey = "";
$hpid = $_GET['hpid'];
$pageNo = "1";
$numOfRows = "10";

$ch = curl_init();
$url = 'http://apis.data.go.kr/B552657/ErmctInfoInqireService/getEgytBassInfoInqire'; /*URL*/
$queryParams = '?' . urlencode('serviceKey') . '='. $serviceKey; /*Service Key*/
$queryParams .= '&' . urlencode('pageNo') . '=' . urlencode($pageNo); /**/
$queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode($numOfRows); /**/

curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$response = curl_exec($ch);
curl_close($ch);

$xml = simplexml_load_string($response);

header('Content-Type: application/json; charset');

print_r(json_encode($xml));