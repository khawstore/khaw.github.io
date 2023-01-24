<?php

$host="localhost";
$bd="khaw";
$usuario="root";
$pssd="toor";

try {
    $conexion=new PDO("mysql:host=$host;dbname=$bd", $usuario, $pssd);
    if($conexion){echo "Conectado.. a sistema";}
} catch (Exception $ex) {
    echo $ex->getMessage();
}

