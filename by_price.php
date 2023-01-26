
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
switch($accion){
    case "agregar": 
        $sentenciaSQL = $conexion->prepare("INSERT INTO cliente VALUES (NULL, :ci, :nombre, :appaterno, :apmaterno, :celular, :correo, :usuario, :contr, :img, '1', '0');");
        $sentenciaSQL->bindParam(':ci',$txtCi);
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':appaterno',$txtPaterno);
        $sentenciaSQL->bindParam(':apmaterno',$txtMaterno);
        $sentenciaSQL->bindParam(':celular',$txtCelular);
        $sentenciaSQL->bindParam(':correo',$txtCorreo);
        $sentenciaSQL->bindParam(':usuario',$txtUsuario);
        $sentenciaSQL->bindParam(':contr',$txtContra);

        $fecha = new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
        if ($tmpImagen!="") {
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
        }

        $sentenciaSQL->bindParam(':img',$nombreArchivo);
        $sentenciaSQL->execute();
        header("Location:clientes.php");
        break;
    case "modificar":
        $sentenciaSQL = $conexion->prepare("UPDATE cliente SET ci=:ci, nombre=:nombre, paterno=:appaterno, materno=:apmaterno, celular=:celular, correo=:correo, nomUsuario=:usuario, passw=:contr WHERE idCliente=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->bindParam(':ci',$txtCi);
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':appaterno',$txtPaterno);
        $sentenciaSQL->bindParam(':apmaterno',$txtMaterno);
        $sentenciaSQL->bindParam(':celular',$txtCelular);
        $sentenciaSQL->bindParam(':correo',$txtCorreo);
        $sentenciaSQL->bindParam(':usuario',$txtUsuario);
        $sentenciaSQL->bindParam(':contr',$txtContra);
        $sentenciaSQL->execute();

        if ($txtImagen!="") {

            // subimos la imagen nueva 
            $fecha = new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

            // borramos la imagen anterior 
            $sentenciaSQL = $conexion->prepare("SELECT * FROM cliente WHERE idCliente=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $datoCliente = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
            
            if (isset($datoCliente["fotoPerfil"]) && ($datoCliente["fotoPerfil"]!="imagen.jpg")) {
                if(file_exists("../../img/".$datoCliente["fotoPerfil"])){
                    unlink("../../img/".$datoCliente["fotoPerfil"]);
                }
            }    

            // guardamos el registro del nombre en la base de datos
            $sentenciaSQL = $conexion->prepare("UPDATE cliente SET fotoPerfil=:img WHERE idCliente=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->bindParam(':img',$nombreArchivo);
            $sentenciaSQL->execute();
        }
        header("Location:clientes.php");
        break;
    case "cancelar":
        header("Location:clientes.php");
        break;
    case "seleccionar":
        $sentenciaSQL = $conexion->prepare("SELECT * FROM cliente WHERE idCliente=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $datoCliente = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
        
        $txtUsuario=$datoCliente['nomUsuario'];
        $txtCorreo=$datoCliente['correo'];
        $txtContra=$datoCliente['passw'];
        $txtCi=$datoCliente['ci'];
        $txtNombre=$datoCliente['nombre'];
        $txtPaterno=$datoCliente['paterno'];
        $txtMaterno=$datoCliente['materno'];
        $txtCelular=$datoCliente['celular'];
        $txtImagen=$datoCliente['fotoPerfil'];
        break;
    case "borrar":
        $sentenciaSQL = $conexion->prepare("SELECT * FROM cliente WHERE idCliente=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $datoCliente = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
        
        if (isset($datoCliente["fotoPerfil"]) && ($datoCliente["fotoPerfil"]!="imagen.jpg")) {
            if(file_exists("../../img/".$datoCliente["fotoPerfil"])){
                unlink("../../img/".$datoCliente["fotoPerfil"]);
            }
        }

        $sentenciaSQL = $conexion->prepare("DELETE FROM cliente WHERE idCliente=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();

        header("Location:clientes.php");
        break;
}

$sentenciaSQL = $conexion->prepare("SELECT l.idLAPTOP, l.itemCode, m.nombre, l.pantalla , l.modelo, a.capacidad, tj.modelo, p.oficial, l.img FROM laptop l, marca m, precio p, almacenamiento a, tarjetadevideo tj
WHERE l.idMARCA = m.idMARCA AND l.idPRECIO = p.idPRECIO AND a.idLAPTOP = l.idLAPTOP AND tj.idLAPTOP = l.idLAPTOP
ORDER BY l.idLAPTOP");
$sentenciaSQL->execute();
$listaLaptops = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
// print_r($_POST);
// print_r($_FILES);
?>


<p>lista de laptops</p>
<div>
    Agregar cliente
    <form method="POST" enctype="multipart/form-data" action="">
    
        <div>
            <label for="txtID">RANGO:</label>
            <input type="text" name="txtID" id="txtID" placeholder="mínimo" value="<?=$txtID?>">
            <input type="text" name="txtID" id="txtID" placeholder="máximo" value="<?=$txtID?>">
            <div>
                <button type="submit" name="accion" value="agregar">Listar</button>
            </div>
        </div>

        <div>
            <label for="txtUsuario">Menor a:</label>
            <input type="text" name="txtUsuario" placeholder="" value="<?=$txtUsuario?>">
            <div>
                <button type="submit" name="accion" value="modificar">Listar</button>
            </div>
        </div>

        <div>
            <label for="txtCorreo">Mayor a:</label>
            <input type="text" name="txtCorreo" placeholder="" value="<?=$txtCorreo?>">
            <div>
                <button type="submit" name="accion" value="cancelar">Listar</button>
            </div>
        </div>


    </form>



</div>

<br/><br />


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


<div>
    <button type="submit" name="accion" value="cancelar">Generar PDF</button>
</div>
                
<?php include("template/footer.php") ?>
