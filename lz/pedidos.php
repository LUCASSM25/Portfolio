<?php
require_once("./function.php");
$relatorio = relatorio();
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
      <div class="nav-item pr-2"><a href="./index.php" class="nav-link">DASHBOARD</a></div>
      <div class="nav-item"><a href="" class="nav-link active">RELATORIO</a></div>
      <div class="nav-item"><a href="" class="nav-link">CONFIGURACOES</a></div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="table-responsive">
      <table class="table table-striped table-hover my-3 align-center">
        <thead>
          <tr>
            <th>Data</th>
            <th class="col-1 text-center">N:</th>
            <th class="col-2 text-center">Cliente</th>
            <th>Produto</th>
            <th class="col-1 text-center">Quant</th>
            <th>Valor</th>
            <th>Total</th>
            <th>Etapa</th>
          </tr>
        </thead>

        <?php
        $Vfinal=0;
        $id_anterior = '';
        echo "<tbody class='table-active'>";
        foreach ($relatorio as $v) {
          $Vfinal += $v['total'];
          // verifica se o ID ainda é igual
          if ($v['id'] != $id_anterior) {
            // atualiza a variável do ID anterior
            $id_anterior = $v['id'];
            // muda a cor da linha
            echo "<tr><td colspan-7></td></tr><tr>";
            
          } else {
            echo "<tr>";
          }

        echo "
            <td class='col-1'>$v[data]</td>
            <td class='col-1'>$v[id]</td>
            <td>$v[cliente]</td>
            <td>$v[nome]</td>
            <td class='text-center'>$v[quantidade]</td>
            <td>".number_format($v['preco'],2,',','.') . "</td>
            <td>R$ ".number_format($v['total'],2,',','.') . "</td>
            <td>";
            if($v['entrega']=='Sim'){
              echo "<img src=./Imagens/moto2.png style='width: 35px; height: 35px;cursor:pointer;'>";
            }else{
              echo "<img src=./Imagens/retirada.png style='width: 35px; height: 35px;cursor:pointer;'>";
            }
            echo "
            </td>
          </tr>
        "; 
      }
        ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="7" class="text-end">Total</td>
            <td><?php echo 'R$ '.number_format($Vfinal,2,',','.'); ?></td>
          </tr>
        </tfoot>
      </table>
    </div>

  </div>



</body>
<script type="text/javascript" src="./bootstrap-5.3.0-alpha1-dist/jquery_3"></script>
<script type="text/javascript" src="./bootstrap-5.3.0-alpha1-dist/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>

</html>