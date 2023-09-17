<?php
$url = "https://apis.data.go.kr/B552657/ErmctInfoInqireService/getEmrrmRltmUsefulSckbdInfoInqire";
$serviceKey = "";
$STAGE1 = $_GET['STAGE1'];
$STAGE2 = $_GET['STAGE2'];
$pageNo = $_GET['pageNo'];
$t = $_GET['type'];
$numOfRows = 10;

$ch = curl_init();
$url = 'http://apis.data.go.kr/B552657/ErmctInfoInqireService/getEmrrmRltmUsefulSckbdInfoInqire'; /*URL*/
$queryParams = '?' . urlencode('serviceKey') . '='. $serviceKey; /*Service Key*/
$queryParams .= '&' . urlencode('STAGE1') . '=' . urlencode($STAGE1); /**/
$queryParams .= '&' . urlencode('STAGE2') . '=' . urlencode($STAGE2); /**/
$queryParams .= '&' . urlencode('pageNo') . '=' . urlencode($pageNo); /**/
$queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode($numOfRows); /**/

curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$response = curl_exec($ch);
curl_close($ch);

$xml=simplexml_load_string($response);

// var_dump($xml->body->items);
$items = $xml->body->items;
// var_dump($items->item[2]);

$json = [];
function xml_to_array($item) {
    return json_decode(json_encode($item), true)[0];
}

for ($i = 0; $i < 10; $i++) {
    if (!isset($items->item[$i])) break;
    if ($t == "e" && $items->item[$i]->hvec <= 0) continue;
    $data['emergenvyRoom'] = xml_to_array($items->item[$i]->hvec); //응급실
    $data['operatingRoom'] = xml_to_array($items->item[$i]->hvoc); //수술실
    $data['mri'] = xml_to_array($items->item[$i]->hvmriayn); //mri
    $data['ct'] = xml_to_array($items->item[$i]->hvangioayn); //ct
    $data['ventilator'] = xml_to_array($items->item[$i]->hvventiayn); //인공호흡기
    $data['anbulance'] = xml_to_array($items->item[$i]->hvamyn); //구급차
    $data['dutyName'] = xml_to_array($items->item[$i]->dutyName); //병원 이름
    $data['hpid'] = xml_to_array($items->item[$i]->hpid); //병원 id
    $data['dutyTel'] = xml_to_array($items->item[$i]->dutyTel3); //응급실 전화번호
    $json[$i] = $data;
}


// echo $url.$queryParams;
header('Content-Type: application/json; charset');
print_r(json_encode($json));