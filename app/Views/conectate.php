<?php
/* Conexion a la base de datos */
$conn = pg_connect("host=localhost dbname=salasituacional user=postgres password=torres0707");
/* Debe retornar pgsql link */
/*
var_dump($conn);
die();
*/

/* La información que requiero */
$sql      = "Select * from sgc_usuario_operador";
$resultado = pg_query($conn, $sql);
/* Debe retornar pgsql result */
/*
var_dump($resultado);
die();
*/

/* Mostrar la información que requiero */
$usuarios = pg_fetch_all($resultado);
//$usuarios=pg_fetch_array($resultado, NULL, PGSQL_ASSOC);
//var_dump($usuarios);
//die();

foreach ($usuarios as $usuario) {
	//var_dump($usuario);
	echo $usuario['usuopnom'] . '<br>';
}
//O con la Sintaxis Simplificada (HTML embebido):
?>
<!--center>
<div style="">
<table border=2 style="color:white;">
<php
	foreach($usuarios as $usuario):
?>
<tr><td>
<= $usuario['usuopemail']; ?></td>
<td>
<= $usuario['usuopeape']; ?></td></tr>
<php
	endforeach; 
>
</div>
</table-->