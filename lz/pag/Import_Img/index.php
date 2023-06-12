<?php
if ($_SERVER['HTTP_HOST'] == "biabolos.com.br") {
	$servidor = "localhost";
	$banco = "u562936743_bia_bolos";
	$usuario = "u562936743_bia_bolos";
	$senha = "25eQwBtmiKTAzym@";
} else {
	$servidor = "localhost";
	$banco = "bia_bolos";
	$usuario = "root";
	$senha = "";
}

try {

	$conn = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo "Erro: " . $e->getMessage();
}
if (isset($_FILES['foto'])) {
	$files = $_FILES['foto'];
	for ($i = 0; $i < count($files['name']); $i++) {
		$tmp_name = $files['tmp_name'][$i];
		if (!empty($tmp_name)) {
			$novonome = "foto" . rand(0, 1000) . time() . ".jpg";
			move_uploaded_file($tmp_name, "../imagens/Fotos/" . $novonome);

			list($largura_original, $altura_original) = getimagesize("../imagens/Fotos/" . $novonome);

			$largura_maxima = 500;

			if ($largura_original > $largura_maxima) {
				$ratio = $largura_original / $largura_maxima;
				$largura = $largura_maxima;
				$altura = $altura_original / $ratio;
			} else {
				$largura = $largura_original;
				$altura = $altura_original;
			}

			$novaimg = imagecreatetruecolor($largura, $altura);
			$img = imagecreatefromjpeg("../imagens/Fotos/" . $novonome);

			imagecopyresampled($novaimg, $img, 0, 0, 0, 0, $largura, $altura, $largura_original, $altura_original);

			imagejpeg($novaimg, "../imagens/Fotos/" . $novonome, 80);

			$sql = $conn->prepare("INSERT INTO tb_prod_venda (url, NomePV) VALUES (?,?)");
			$sql->execute(array($novonome, "Bia Bolos"));
		}
	}
}
?>
<html>

<head>
	<title>Página de Exemplo</title>
	<link rel="stylesheet" type="text/css" href="estilo.css" />
</head>

<body>
	<div id="primeira">
		<div id="topo">
			<img id="logo" src="instagram_logo.png" height="35" />
		</div>
	</div>
	<div class="area">
		<div class="formulario">
			<form method="POST" enctype="multipart/form-data">
				Selecione uma foto para postar:<br />
				<input type="file" name="foto[]" multiple /><br />
				<input type="submit" value="Enviar Foto" />
			</form>
		</div>
	</div>


	<div id="lightbox_fundo" onclick="fecharLightbox()"></div>
	<div id="lightbox_foto" onclick="fecharLightbox()"></div>

	<script type="text/javascript">
		function abrirLightbox(obj) {
			document.body.scrollTop = 0;

			document.getElementById("lightbox_fundo").style.display = "block";
			document.getElementById("lightbox_foto").style.display = "block";

			var img = obj.getAttribute("src");
			document.getElementById("lightbox_foto").innerHTML = "<img src='" + img + "' width='100%' />";
		}

		function fecharLightbox() {
			document.getElementById("lightbox_fundo").style.display = "none";
			document.getElementById("lightbox_foto").style.display = "none";
		}
	</script>
</body>

</html>