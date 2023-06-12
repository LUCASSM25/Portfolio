<?php
require_once("./function.php");
$produtos = produtos();
$categoria = categorias();
$pedidos = pedidos();
?>
<!DOCTYPE html>

<html leng="pt-br">

<head>
    <title>LZ_PIZZARIA</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="./bootstrap-5.3.0-alpha1-dist/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/geral.css">
</head>

<body>
    <div class="container text-center">
        <img src="./Imagens/LZ Pizzaria.png" class="img-fluid logo">
    </div>

    <div class="d-flex justify-content-center">
        <div class="nav nav-pills justify-content-center">
            <div class="nav-item"><a href="" class="nav-link active">DASHBOARD</a></div>
            <div class="nav-item"><a href="./pedidos.php" class="nav-link">RELATORIO</a></div>
            <div class="nav-item"><a href="" class="nav-link">CONFIGURACOES</a></div>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="nav nav-pills small mt-3">
            <!-- Button trigger modal --------------------->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pedido">
                Novo
            </button>

            <!---------------------------- Modal -->
            <div class="modal fade" id="pedido" tabindex="-1" aria-labelledby="Pedido" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Lancamento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <h5 class='modal-title text-center my-3'>PIZZAS</h5>
                            <div class="container">
                                <div class="row justify-content-center flex-md-row flex-sm-column">
                                    <?php // MOSTRA OS PRODUTOS POR CATEGORIA
                                    foreach ($categoria as $cat) {
                                        echo "<h5 class='modal-title text-center my-3'>$cat[nome]</h5>";
                                        foreach ($produtos as $produto) {
                                            if ($produto['Categoria'] == $cat['nome']) {
                                    ?>
                                                <div class="col-lg-2 col-md-12 my-2 text-center pe-auto">
                                                    <div class="card produtos" data-id='<?php echo ($produto['id']); ?>'>
                                                        <img src="./Imagens/prod/<?php echo ($produto['url']); ?>" class="card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="card-title"><?php echo ($produto['nome']); ?></h5>
                                                            <p class="card-text"><?php echo ('R$ ' . number_format($produto['preco'], 2, ',', '.')); ?></p>
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <button class="btn btn-secondary BTNmenos">-</button>
                                                                <div class="mx-2 qt">0</div>
                                                                <button class="btn btn-secondary BTNmais">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                        <div class="d-flex flex-column align-items-center">
                            <img src='./Imagens/moto2.png' onclick="openEnt()" style='width: 35px; height: 35px;cursor:pointer;'>
                            <div class="col-6 openEnt" style="display:none;">
                                <span class="input-group-text">Endereço</span>
                                <input type="text" class="form-control ">
                            </div>
                            <div class="col-6 openEnt" style="display:none;">
                                <span class="input-group-text">Valor</span>
                                <input type="number" class="form-control">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="button" onclick="envCart()" class="btn btn-primary" data-bs-dismiss="modal">Pedir</button>
                        </div>
                        <!----------------------------fim Modal -->
                    </div>
                </div>
            </div>
            <!----------------------------fim Modal -->
        </div>
    </div>
    <?php

    $qtDia = 0;
    $precoDia = 0;
    foreach ($pedidos as $v) {
        $qtDia += $v['quantidade'];
        $precoDia += $v['preco'] * $v['quantidade'];
    }
    ?>
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="card col-9 col-md-3 mx-2 my-3">
                <div class="card-body">
                    <h5 class="card-title">Pedidos do dia</h5>
                    <p class="card-text">Total: <?php echo $qtDia; ?> pedidos</p>
                </div>
            </div>
            <div class="card col-9 col-md-3 mx-2 my-3">
                <div class="card-body">
                    <h5 class="card-title">Vendas Totais</h5>
                    <p class="card-text">R$ <?php echo number_format($precoDia, 2, ',', '.'); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <?php
            $id_anterior = null;
            //PERCORRE OS PEDIDO    
            foreach ($pedidos as $v) {
                if ($v['id'] != $id_anterior) {
                    $id_anterior = $v['id'];
            ?>
                    <div class="card col-3 mx-3 my-1 text-center">
                        <div class="card-body">

                            <h5 class="card-title">
                                <?php if ($v['entrega'] == 'Sim') {
                                    echo "<img src=./Imagens/moto2.png style='width: 35px; height: 35px;cursor:pointer;'></br>";
                                } else {
                                    echo "<img src=./Imagens/retirada.png style='width: 35px; height: 35px;cursor:pointer;'> </br>";
                                }
                                echo ($v['cli'] . '</br>' . $v['data']); ?></h5>
                            <?php // MOSTRA OS PRODUTOS RELACIONADOS AO PEDIDO
                            echo "<p class='card-text'>";
                            $i = 0;
                            foreach ($pedidos as $item) {
                                if ($item['id'] == $v['id']) { //MOSTRA OS NOMES DOS PRODUTO RELACIONADOS AO ID DO PRIMEIRO FOREACH
                                    $i++;
                                    if ($i > 1) {
                                        echo ("</p><p class='card-text'>");
                                    }
                                    echo ($item['quantidade'] . 'x ');
                                    echo ($item['nome']);
                                }
                            }
                            echo "</p>";
                            ?>

                        </div>
                    </div>
            <?php

                }
            };

            ?>
        </div>
    </div>
    <script type="text/javascript" src="./jsApi/envio.js"></script>
</body>
<script type="text/javascript" src="./bootstrap-5.3.0-alpha1-dist/jquery_3"></script>
<script type="text/javascript" src="./bootstrap-5.3.0-alpha1-dist/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>

</html>