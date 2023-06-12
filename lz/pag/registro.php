<?php
require_once('../function.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lê o corpo da requisição
    $corpo = file_get_contents('php://input');

    // Decodifica os dados de JSON
    $dados = json_decode($corpo, true);

    // Verifica se o objeto decodificado é um array
    if (is_array($dados)) {
        // Acessa os valores enviados pelo JavaScript
        try {
            $conn = conexao();
            $conn->beginTransaction();

            //VARIAVEIS
            $data = $dados['data'];
            $nome = $dados['nome'];
            $cel = $dados['cel'];
            $Ent = $dados['Ent'];

            $cmd = $conn->prepare('INSERT INTO pedido(id_cliente, data, nome,contato, entrega,endereco,valorEnt) VALUES(:id,:d,:nome,:cel,:Ent,:End,:v)');
            $cmd->bindValue('id', 1);
            $cmd->bindValue('d', $data);
            $cmd->bindValue('nome', $nome);
            $cmd->bindValue('cel', $cel);
            $cmd->bindValue('Ent', $Ent[0]);
            
            if ($Ent[0] = 'Sim') {
                $cmd->bindValue('End', strval($Ent[1]));
                $cmd->bindValue('v', strval($Ent[2]));
            } else {
                $cmd->bindValue('End', '');
                $cmd->bindValue('v', '0');
            }
            $cmd->execute();
            $id = $conn->lastInsertId();

            $cmd = $conn->prepare('INSERT INTO item_pedido(id_pedido,id_prodX,quantidade) VALUES(:idP,:idPr,:qt)');

            foreach ($dados['cart'] as $v) {
                list($prod, $qt) = explode('&', $v);
                $cmd->bindValue('idP', $id);
                $cmd->bindValue('idPr', $prod);
                $cmd->bindValue('qt', $qt);
                $cmd->execute();
            }

            $conn->commit();
            echo $conn->errorInfo();
        } catch (Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }

        /*$response = array('status' => 'success', 'message' => 'Dados recebidos com sucesso!');
            echo json_encode($response);*/


        /* foreach($dados['nome'] as $c => $v){
                if(is_array($v)){
                    print_r($v);
                }else
                echo($c);
                echo($v);
            }/*
            /*echo json_encode($requestData);*/
    }
}
/*}*/