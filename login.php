<?php
$id = $_POST['id'];
$pw = hash("sha256", $_POST['pw']);

if ($id == "" or $pw == "") exit();

$db = new PDO("mysql:host=localhost;dbname=medimap", "root", "");

$q = $db->prepare("SELECT * FROM user WHERE id = :id AND pw = :pw");
$q->bindParam(':id', $id);
$q->bindParam(':pw', $pw);
$q->execute();

header('Content-Type: application/json; charset');

if ($q->rowCount() > 0) {
    $rs = $q->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["result" => true, "data" => ["idx" => $rs[0]["idx"]], "message" => "성공"]);
} else {
    echo json_encode(["result" => false, "data" => [], "message" => "실패"]);
}