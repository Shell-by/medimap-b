<?php

$id = htmlspecialchars($_POST['id']);
$pw = hash("sha256", $_POST['pw']);

if ($id == "" or $pw == "") exit();

$db = new PDO("mysql:host=localhost;dbname=medimap", "root", "");

$q = $db->prepare("INSERT INTO user SET id = :id, pw = :pw");

$q->bindParam(":id", $id);
$q->bindParam(":pw", $pw);
$rs = $q->execute();

header('Content-Type: application/json; charset');

if ($rs) {
    echo json_encode(["result" => true, "data" => [], "message" => "성공"]);
} else {
    echo json_encode(["result" => false, "data" => [], "message" => "실패"]);
}