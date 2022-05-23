<?php
    session_start();

    if(isset($_COOKIE["mantenerUsuario"])){
        session_decode($_COOKIE["mantenerUsuario"]);
    }

    if(isset($_COOKIE["mantenerEmpresa"])){
        session_decode($_COOKIE["mantenerEmpresa"]);
    }

    if(isset($_SESSION["dni"])){
        header('Location: usuarios.php');
    }

    if(!isset($_SESSION["cif"])){
        header('Location: ../acceder/acceder.php');        
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

    <!-- MAIN -->
    <main id="swup" class="transition-fade">

        <!-- FLECHA VOLVER -->
        <a class="volver flecha_volver" href="empresas.php"><i class="fa-solid fa-arrow-left"></i></a>

        <!-- FORMULARIO EMPRESAS -->
        <section id="formu_empresa" class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="container">
                        <div class="row fila_formu">
                            <div class="form-body col-md-6 mx-auto p-3">
     
                                <h1>Dogepp</h1>
                                <h2>Formulario de empresa</h2>
                                <form class="mb-3" action="#" method="POST" enctype="multipart/form-data" id="requires-validation" novalidate>

                                    <input type='hidden' name="cif" value="<?php echo $_SESSION["cif"]; ?>">

                                    <div class="col-md-12">
                                        <input class="form-control" type="number" name="telefono" placeholder="Teléfono" min="100000000" max="999999999" required>
                                        <div class="invalid-feedback">Teléfono vacío o incorrecto</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="text" name="tipo" placeholder="Tipo de empresa" maxlength="100" required>
                                        <div class="invalid-feedback">Tipo de empresa vacío</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="text" name="localizacion" placeholder="Localización (inserta un mapa de Google)" maxlength="1000" required>
                                        <div class="invalid-feedback">Mapa de Google vacío</div>
                                    </div>

                                                                
                                    <div class='col-md-12 mt-3'>
                                        <label for='imagen'>Imagen o logo (PNG o JPG): </label>
                                        <input type='file' name='imagen' id='imagen' required>
                                        <div class='invalid-feedback'>Imagen vacía o formato incorrecto</div>
                                    </div>
                                    
                                    <div class="col-md-12 mt-3">
                                        <div class="mt-3">
                                            <input class='btn boton' type="submit" name="enviar" value="Enviar">
                                        </div>
                                    </div>
                                </form>

                                <?php

                                    if(isset($_POST['enviar'])){

                                        $cif=$_SESSION["cif"];

                                        //SI SE HA DEJADO ALGÚN CAMPO VACÍO LO REDIRIJO A LA PROPIA PAGINA. PASO DE SEGURIDAD EXTRA AL REQUIRED DEL HTML
                                        if(trim($_POST['telefono'])==="" || trim($_POST['tipo'])==="" || trim($_POST['localizacion'])==="" || $_FILES['imagen']['tmp_name']===""){
                                            echo "<meta http-equiv='refresh' content='0; url=empresas2.php'>";

                                        //SI ALGÚN CAMPO NO CUMPLE CON LOS REQUISITOS LO REDIRIJO A LA PROPIA PAGINA
                                        }else if(strlen(trim($_POST["tipo"]))>100 || strlen(trim($_POST["localizacion"]))>1000 || !is_numeric(trim($_POST["telefono"]))){
                                            echo "<meta http-equiv='refresh' content='0; url=empresas2.php'>";
                                        }else{

                                            //COMPRUEBO QUE ME HA METIDO UN FORMATO VÁLIDO PARA LA FOTO. SINO REDIRIJO
                                            $extension_imagen=extension_imagen($_FILES['imagen']['type']);
                                            if($extension_imagen===''){
                                                echo "<meta http-equiv='refresh' content='0; url=empresas2.php'>";
                                            }else{
                                                $consulta_insercion="UPDATE empresa SET telefono=?, tipo=?, localizacion=?, imagen=? WHERE cif=?";
                                                $resultado_insercion=$conexion->prepare($consulta_insercion);

                                                $tipo=trim($_POST['tipo']);
                                                $telefono=trim($_POST['telefono']);
                                                $localizacion=trim($_POST['localizacion']);
                                
                                                //COMPRUEBO QUE EXISTE LA CARPETA DE EMPRESAS. SINO LA CREO
                                                if(!file_exists("../../assets/imagenes/empresas")){
                                                    mkdir("../../assets/imagenes/empresas");
                                                }
                                
                                                //COPIO LA IMAGEN CON EL NAME "FOTO"
                                                $nombre_temporal_imagen=$_FILES['imagen']['tmp_name'];
                                                $nombre_imagen="$cif".$extension_imagen;
                                                move_uploaded_file($nombre_temporal_imagen,"../../assets/imagenes/empresas/$nombre_imagen");
                                                $foto=$nombre_imagen;
                                
                                                $resultado_insercion->bind_param("issss", $telefono, $tipo, $localizacion, $foto, $cif);
                                                $resultado_insercion->execute();
                                                $resultado_insercion->close();
                                                echo "<meta http-equiv='refresh' content='0; url=../empresas/panel.php'>";
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
        <!-- FIN FORMULARIO EMPRESAS -->

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