<?php
$page = intval($_GET['page']);
$hpid = isset($_GET['hpid']) ? $_GET['hpid'] : 0;

if ($page == "") $page = 1;

$db = new PDO("mysql:host=localhost;dbname=medimap", "root", "");

$sql = "SELECT * FROM board";

if ($hpid !== 0) {
    $sql .= " WHERE hpid = :hpid";
}

$sql .= " ORDER BY idx ASC LIMIT " . ($page - 1) . ", " . ($page * 10);

$q = $db->prepare($sql);

if ($hpid !== 0) {
    $q->bindParam(":hpid", $hpid);
}

$rs = $q->execute();

$data = [];

while ($row = $q->fetch()) {
    $d["hpid"] = $row["hpid"];
    $d["dutyName"] = $row["dutyName"];
    $d["title"] = $row["title"];
    $d["content"] = $row["content"];
    $d["star"] = $row["star"];
    $d["create_at"] = $row["create_at"];
    $d["update_at"] = $row["update_at"];

    array_push($data, $d);
}

header('Content-Type: application/json; charset');

if ($rs) {
    echo json_encode(["result" => true, "data" => $data, "message" => "성공"]);
} else {
    echo json_encode(["result" => false, "data" => [], "message" => "실패"]);
}