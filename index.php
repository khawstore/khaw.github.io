<?php include("template/header.php") ?>

<?php  
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtUsuario=(isset($_POST['txtUsuario']))?$_POST['txtUsuario']:"";
$txtCorreo=(isset($_POST['txtCorreo']))?$_POST['txtCorreo']:"";
$txtContra=(isset($_POST['txtContra']))?$_POST['txtContra']:"";
$txtCi=(isset($_POST['txtCi']))?$_POST['txtCi']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtPaterno=(isset($_POST['txtPaterno']))?$_POST['txtPaterno']:"";
$txtMaterno=(isset($_POST['txtMaterno']))?$_POST['txtMaterno']:"";
$txtCelular=(isset($_POST['txtCelular']))?$_POST['txtCelular']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("template/bd.php");

// echo $txtID."<br />";
// echo $txtNombre."<br />";
// echo $txtImagen."<br />";
// echo $accion."<br />";
// sin archivos
$sentenciaSQL = $conexion->prepare("SELECT l.idLAPTOP, l.itemCode, m.nombre, l.pantalla , l.modelo, a.capacidad, tj.modelo, p.oficial, l.img FROM laptop l, marca m, precio p, almacenamiento a, tarjetadevideo tj
WHERE l.idMARCA = m.idMARCA AND l.idPRECIO = p.idPRECIO AND a.idLAPTOP = l.idLAPTOP AND tj.idLAPTOP = l.idLAPTOP
ORDER BY l.idLAPTOP");
$sentenciaSQL->execute();
$listaLaptops = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
// print_r($_POST);
// print_r($_FILES);
?>



<div>
    <h1>
        Lista de laptops
    </h1>
    <table class="table" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>item code</th>
                <th>marca</th>
                <th>pantalla</th>
                <th>modelo</th>
                <th>almacenamiento</th>
                <th>tarjeta gráfica</th>
                <th>precio</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaLaptops as $laptop): ?>
                <tr>
                    <td><?= $laptop['idLAPTOP']?></td>
                    <td><?= $laptop['itemCode']?></td>
                    <td><?= $laptop['nombre']?></td>
                    <td><?= $laptop['pantalla']?></td>
                    <td><?= $laptop['modelo']?></td>
                    <td><?= $laptop['capacidad']?></td>
                    <td><?= $laptop['modelo']?></td>
                    <td><?= $laptop['oficial']?></td>
                    <td>
                        <img src="img/catalog-prices/<?=$laptop['img']?>" alt="" width="50">                        
                    </td>
                     
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>


<?php include("template/footer.php") ?>










