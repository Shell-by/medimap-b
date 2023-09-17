<?php
$idx = $_POST['idx'];
$hpid = $_POST['hpid'];
$dutyName = $_POST['dutyName'];
$title = htmlspecialchars($_POST['title']);
$content = htmlspecialchars($_POST['content']);
$star = $_POST['star'];

if ($idx == "" or $hpid == "" or $title == "" or $content == "" or $star == "") exit();

$db = new PDO("mysql:host=localhost;dbname=medimap", "root", "");

$q = $db->prepare("INSERT INTO board SET user_idx = :idx, hpid = :hpid, dutyName = :dutyName, title = :title, content = :content, star = :star");
$q->bindParam(':idx', $idx);
$q->bindParam(':hpid', $hpid);
$q->bindParam(':dutyName', $dutyName);
$q->bindParam(':title', $title);
$q->bindParam(':content', $content);
$q->bindParam(':star', $star);
$rs = $q->execute();

header('Content-Type: application/json; charset');

if ($rs) {
    echo json_encode(["result" => true, "data" => ["idx" => $db->lastInsertId()], "message" => "성공"]);
} else {
    echo json_encode(["result" => false, "data" => [], "message" => "실패"]);
}