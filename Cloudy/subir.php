<?php 

include("templates/cabecera-menu.php");

include 'db/db.php';


session_start();

//Recibe el usuario
$cuenta = $_SESSION['s_usuario'];


//Se crea conexion con la base de datos
$objeto = new conexion();
$conn = $objeto->connexion();

if (isset($_POST['submit'])){
    if(is_uploaded_file($_FILES['archivo']['tmp_name'])){

        
        $directorio = "Archivos/";

        //Nombre del archivo
        $nombre = ($_FILES['archivo']['name']);

        //Direccion del archivo
        $subir = $directorio . $nombre;

        //Fecha actual en la que se subira el archivo
        $fecha = date("y/m/d");

        $tipo = explode("/", $_FILES['archivo']['type']);

        //Almacena el archivo subido en una ruta especifica
        if(move_uploaded_file($_FILES['archivo']['tmp_name'], $subir)){

            //Insercion de archivo a la base de datos
            $query = "INSERT INTO archivos(usuario, fecha, ruta, tipo_mime, tipo) VALUES ('$cuenta', '$fecha', '".$_FILES['archivo']['name']."', '".$_FILES['archivo']['type']."','".$tipo[0]."')";


            //Redirecciona al usuario a la pagina principal
            if(mysqli_query($conn, $query)){
                echo '<script type="text/JavaScript"> redireccionar(); </script>';
            }

        }


    } else {

        echo '<script type="text/JavaScript"> noHayArchivo(); </script>';

    }
}

?>

    <!-- Formulario de subida de archivos -->
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
        <div class="subir justify-content-center text-center">
            <label for="archivo">
                <i class="fa-solid fa-upload"></i> <br><br><br>
                <b id="subir">Cargar un archivo desde el ordenador.</b>
            </label>
            <input type="file" id="archivo" name="archivo">
        </div>
        <div class="submit">
            <input type="submit" name="submit" value="Subir">    
        </div>

    </form>

<?php include("templates/pie.php")?>