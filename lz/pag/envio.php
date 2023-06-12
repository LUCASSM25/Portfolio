<?php 
require_once('../function.php');
$conn = conexao();
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if($_GET['comentarios'] OR $_GET['star']){
        $coment = htmlspecialchars(stripslashes(trim($_GET['comentarios'])));
        $star = htmlspecialchars(stripslashes(trim($_GET['star'])));
        try {
            $cmd = $conn->prepare('INSERT INTO comentarios(coment,star) VALUE(:c,:s)');
            $cmd->bindValue(':c',$coment);
            $cmd->bindValue(':s',$star);
            $cmd->execute();
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}