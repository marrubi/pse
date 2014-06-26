<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>	
<title>Computación Paralela</title>
<link href="style.css" rel="stylesheet" type="text/css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script src="./javascript/tools.js"></script>

<!-- para los graficos -->
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

</head>
<?php

if (isset($_FILES['archivo']) && !empty($_FILES['archivo']['name']) && !empty($_POST['tipo_busqueda']) && !empty($_POST['tipo_ejecucion'])){
		
		//variables para la carga de archivo
		$nombre = $_FILES['archivo']['name'];
		$nombre_tmp = $_FILES['archivo']['tmp_name'];
		$tipo = $_FILES['archivo']['type'];
		$tamano = $_FILES['archivo']['size'];
		
		$nombre = str_replace(" ", "_", $nombre);
		
		//cargando archivo
		$absPath = realpath(dirname(__FILE__));
		move_uploaded_file($nombre_tmp, $absPath."/subidas/".$nombre);    
}
?>

<script language="javascript">
	
	var info;
	
	window.onbeforeunload = function (e) {
	        alert("hola");
	};
	
	$(document).ready(function() {
		$("#ajax_loading").show();
		$.ajax({
        url: "json.php",
        type: "POST",
        
        data: ({
				nombre : <?php echo "'".$nombre."'"; ?>,
				frases : <?php echo "'".$_POST['frases']."'"; ?>,
				tipo_ejecucion : <?php echo "'".$_POST['tipo_ejecucion']."'"; ?>,
				tipo_busqueda : <?php echo "'".$_POST['tipo_busqueda']."'"; ?>,
				NumeroProcesadores : <?php echo "'".$_POST['NumeroProcesadores']."'"; ?>,
			  }),
		success: function(data){
					info = jQuery.parseJSON(data);
					$("#ajax_loading").hide();

					$('#Resultado').html(drawTable(info.match));
					// agrega las gráficas de desempeño en la parte inferior de las hojas
					addPlot(info);
					addScatter(info);					
					addPerformance(info);
					// agrega las gráficas de desempeño en la parte inferior de las hojas
					addPlot(info);
					addScatter(info);
					addPerformance(info);
		},
		});
	});
</script>
<body>
<div class="content">
  <div id="header">
    <div class="title">
      <h1>Computación Paralela</h1>
      <br /> 
      <h3>Pattern Search Engine</h3>
    </div>
  </div>
  <div id="main">
    <div class="center">

<h1 id="titulo-res">Resultado</h1>
<img src="./images/ajax.gif" id="ajax_loading" width="100" />
<div id="Resultado">

</div>

<div id="performance"> </div>

<div id="scatter"> </div>

<div id="tiempo_rank"></div>
</div>
    <div class="leftmenu">
      <div class="nav">
        <ul>
           <li><a href="index.html">Inicio</a></li>
           <li><a href="curso.php">Curso</a></li>
           <li><a href="herramientas.php">Herramientas</a></li>
	   <li><a href="#" onclick="kill()">PKill</a></li>
        </ul>
      </div>
    </div>
</div>

<div id="prefooter"></div>

<div id="footer">
    <div class="padding"> Copyright Curso Computación Paralela 2014 / Primer Semestre, UTEM  </div>
</div>

</div>

</body>
</html>
