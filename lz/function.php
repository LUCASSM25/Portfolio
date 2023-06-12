<?php 
    session_start();
    date_default_timezone_set('America/Manaus');

    function conexao(){
      $servidor="localhost";
      $banco="u562936743_LZ";
      $usuario="u562936743_Administrador";
      $senha="AMgeGK*cX1";

        try {
		      $conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
		      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              return $conn;
		    }
		    catch(PDOException $e) 
		    {
		      echo "Erro: ".$e->getMessage();
		    }
    }

    function produtos(){
        $conn = conexao();
        $conn = $conn -> query("SELECT * FROM produto");
        $return = $conn->fetchAll(PDO::FETCH_ASSOC);
        return $return;
    }

    function pedidos(){
        $conn = conexao();
        $cmd = $conn -> query("SELECT pedido.id, pedido.`data`,pedido.`status`, pedido.entrega,pedido.nome as cli,produto.nome, item_pedido.quantidade, produto.preco FROM pedido INNER JOIN item_pedido ON pedido.id = item_pedido.id_pedido INNER JOIN produto ON id_prodX = produto.id  ORDER BY pedido.`data` DESC");
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }
    function categorias(){
        $conn = conexao();
        $cmd = $conn -> query("SELECT * FROM categoria");
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    function relatorio(){
        $conn = conexao();
        $conn = $conn -> query("SELECT pedido.id, pedido.entrega, pedido.`data`,pedido.`status`, pedido.entrega,pedido.valorEnt,pedido.nome as cliente,produto.nome, item_pedido.quantidade,produto.preco, produto.Categoria,(item_pedido.quantidade * produto.preco) as total FROM pedido INNER JOIN item_pedido ON pedido.id = item_pedido.id_pedido INNER JOIN produto ON id_prodX = produto.id ORDER BY data DESC,id_pedido,Categoria");
        return $conn->fetchAll(PDO::FETCH_ASSOC);
    }
    function pedido($nome,$desc,$preco,$url,$cat){
        $conn = conexao();
        $conn = $conn -> prepare("INSERT INTO pedido(nome, descricao, preco, url, Categoria) VALUES(:n,:d,:p,:u,:c)");
        $conn->bindValue(':n', $nome);
        $conn->bindValue(':d', $desc);
        $conn->bindValue(':p', $preco);
        $conn->bindValue(':u', $url);
        $conn->bindValue(':c', $cat);
        $conn->execute();

    }