<?php include("template/header.php") ?>

<?php  

include("template/bd.php");

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










