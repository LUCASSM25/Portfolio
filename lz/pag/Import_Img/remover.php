<?php
$id = $_GET['id'];
$pdo = new PDO("mysql:dbname=instagram;host=localhost", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = $pdo->prepare("SELECT url FROM fotos WHERE id = ?");
$sql->execute(array($id));

if($sql->rowCount() > 0) {
	$item = $sql->fetch();

	unlink("fotos/".$item["url"]);

	$sql = $pdo->prepare("DELETE FROM fotos WHERE id = ?");
	$sql->execute(array($id));

	header("Location: index.php");
}
?>