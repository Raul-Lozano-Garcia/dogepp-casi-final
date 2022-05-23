<?php
    session_start();

    if(isset($_COOKIE["mantenerUsuario"])){
        session_decode($_COOKIE["mantenerUsuario"]);
    }

    if(isset($_COOKIE["mantenerEmpresa"])){
        session_decode($_COOKIE["mantenerEmpresa"]);
    }

    if(isset($_SESSION["cif"])){
        header('Location: ../acceder/acceder.php');
    }

    if(!isset($_SESSION["dni"])){
        header('Location: ../acceder/acceder.php');        
    }

    if($_SESSION["dni"]==="000000000"){
        header('Location: ../admin/panel.php');
    }

    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dogepp | La web favorita de tu perro</title>
    <link rel="icon" href="../../assets/imagenes/logo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swup@latest/dist/swup.min.js" defer></script> 
    <script type="text/javascript" src="../../js/swup.js" defer></script>
    <script type="text/javascript" src="../../js/app.js" defer></script>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

    <?php
        require_once("../../php/funciones.php");
        $conexion=conectarServidor();
    ?>

    <?php
        crearHeaderApp("../..");

        if($_SESSION["tipo"]!=='a'){
            header('Location: anuncios.php');
        }

        //SACAMOS EL SIGUIENTE ID
        $id=siguienteId('anuncio');
        
    ?>

    <!-- MAIN -->
    <main id="swup" class="transition-fade">

        <!-- SI SE HA REGISTRADO CORRECTAMENTE LE MUESTRO UN MODAL Y REDIRIJO A ACCEDER -->
        <?php
            if(isset($_GET["ok"])){
        ?>
            <div class="modal-redireccion">
                <h2>Se ha creado el anuncio correctamente. Espere mientras se le redirige a 'Anuncios'</h2>
            </div>
        <?php
                echo "<meta http-equiv='refresh' content='3; url=anuncios.php'>";
            }
        ?>

        <!-- FORMULARIO AGREGAR ANUNCIO -->
        <section id="formu_agregar_anuncio" class="container-fluid formuGeneral">
            <div class="row">
                <div class="col-12">
                    <div class="container">
                        <div class="row fila_formu">
                            <div class="form-body mx-auto p-3">
     
                                <h1>Dogepp</h1>
                                <h2>Formulario para agregar anuncios</h2>
                                <form class="mb-3" action="#" method="POST" enctype="multipart/form-data" id="requires-validation" novalidate>

                                    <div class='col-md-12 mt-3'>
                                        <label for='imagen'>Foto(PNG o JPG): </label>
                                        <input type='file' name='imagen' id='imagen' required>
                                        <div class='invalid-feedback'>Imagen incorrecta</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="text" name="titulo" placeholder="Título" maxlength="100" required>
                                        <div class="invalid-feedback">Título vacío</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="number" name="precio" placeholder="Precio" min="0" max="999.99" step=".01" required>
                                        <div class="invalid-feedback">Precio vacío o inválido</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <textarea name='descripcion' maxlength='5000' placeholder='Escribe la descripción de tu anuncio' rows='3' required></textarea>  
                                    </div>
                                    
                                    <div class="col-md-12 mt-3">
                                        <div class="mt-3">
                                            <input class='btn boton' type="submit" name="enviar" value="Enviar">
                                        </div>
                                    </div>
                                </form>

                                <?php

                                    if(isset($_POST['enviar'])){

                                        $dni=$_SESSION["dni"];
                                        $activo='1';

                                        //SI SE HA DEJADO ALGÚN CAMPO VACÍO LO REDIRIJO A LA PROPIA PAGINA. PASO DE SEGURIDAD EXTRA AL REQUIRED DEL HTML
                                        if(trim($_POST['titulo'])==="" || trim($_POST['precio'])==="" || trim($_POST['descripcion'])==="" || $_FILES['imagen']['tmp_name']===""){
                                            echo "<meta http-equiv='refresh' content='0; url=agregar_anuncios.php'>";

                                        //SI ALGÚN CAMPO NO CUMPLE CON LOS REQUISITOS LO REDIRIJO A LA PROPIA PAGINA
                                        }else if(strlen(trim($_POST["titulo"]))>100 || strlen(trim($_POST["descripcion"]))>5000 || !is_numeric(trim($_POST["precio"]))){
                                            echo "<meta http-equiv='refresh' content='0; url=agregar_anuncios.php'>";
                                        }else{

                                            //COMPRUEBO QUE ME HA METIDO UN FORMATO VÁLIDO PARA LA IMAGEN. SINO REDIRIJO
                                            $extension_imagen=extension_imagen($_FILES['imagen']['type']);
                                            if($extension_imagen===''){
                                                echo "<meta http-equiv='refresh' content='0; url=agregar_anuncios.php'>";
                                            }else{
                                                $consulta_insercion="INSERT INTO anuncio values (?,?,?,?,?,?,?)";
                                                $resultado_insercion=$conexion->prepare($consulta_insercion);
                                    
                                                $titulo=trim($_POST['titulo']);
                                                $precio=trim($_POST['precio']);
                                                $descripcion=trim($_POST['descripcion']);
                                
                                                //COMPRUEBO QUE EXISTE LA CARPETA DE ANUNCIOS. SINO LA CREO
                                                if(!file_exists("../../assets/imagenes/adiestradores/anuncios")){
                                                    mkdir("../../assets/imagenes/adiestradores/anuncios");
                                                }
                                
                                                //COPIO LA IMAGEN CON EL NAME "IMAGEN"
                                                $nombre_temporal_imagen=$_FILES['imagen']['tmp_name'];
                                                $nombre_imagen="$id".$extension_imagen;
                                                move_uploaded_file($nombre_temporal_imagen,"../../assets/imagenes/adiestradores/anuncios/$nombre_imagen");
                                                $imagen=$nombre_imagen;
                                
                                                $resultado_insercion->bind_param("issdsss",$id, $imagen, $titulo, $precio, $descripcion, $dni, $activo);
                                                $resultado_insercion->execute();
                                                $resultado_insercion->close();
                                                echo "<meta http-equiv='refresh' content='0; url=agregar_anuncios.php?ok'>";
                                            }
                                        }
                                    }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- FIN FORMULARIO AGREGAR ANUNCIO -->

    </main>
    <!-- FIN MAIN -->

    <?php
        crearFooter("../..");
    ?>

    <!-- ME DESCONECTO DE LA BASE DE DATOS -->
    <?php
        $conexion->close();
    ?>

</body>
</html>