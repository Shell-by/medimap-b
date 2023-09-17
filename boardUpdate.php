<?php

$idx = $_POST['idx'];
$title = htmlspecialchars($_POST['title']);
$content = htmlspecialchars($_POST['content']);
$star = $_POST['star'];

if ($idx == "" or $title == "" or $content == "" or $star == "") exit();

$db = new PDO("mysql:host=localhost;dbname=medimap", "root", "");

$q = $db->prepare("UPDATE board SET title = :title, content = :content, star = :star, update_at = now() WHERE idx = :idx");
$q->bindParam(':idx', $idx);
$q->bindParam(':title', $title);
$q->bindParam(':content', $content);
$q->bindParam(':star', $star);
$rs = $q->execute();

header('Content-Type: application/json; charset');

if ($rs) {
    echo json_encode(["result" => true, "data" => [], "message" => "성공"]);
} else {
    echo json_encode(["result" => false, "data" => [], "message" => "실패"]);
}