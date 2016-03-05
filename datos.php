<?php  

	// Conectando, seleccionando la base de datos
$link = mysql_connect('localhost', 'root', '12qwaszx')
    or die('No se pudo conectar: ' . mysql_error());
mysql_select_db('controlvehiculardb') or die('No se pudo seleccionar la base de datos');

// Realizar una consulta MySQL
$query = 'select * from coordenada';
$result = mysql_query($query);


$rawdata = array(); //creamos un array

//guardamos en un array multidimensional todos los datos de la consulta
$i=0;

while($row = mysql_fetch_array($result))
{
    $rawdata[$i] = $row;
    $i++;
}

mysql_close();

print json_encode($rawdata); //devolvemos el array


?>