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
        
    ?>

    <!-- MAIN -->
    <main id="swup" class="transition-fade">

    <?php

    if(isset($_POST["id"])){

        //SACO LA INFO DE ANUNCIO
        $id=trim($_POST["id"]);

        $consulta_info="SELECT dni,titulo,anuncio.imagen imagen,nick,precio,descripcion FROM usuario INNER JOIN anuncio ON dni=id_usuario WHERE anuncio.id='$id' AND anuncio.activo='1'";

        $datos_info=$conexion->query($consulta_info);

        $fila_info=$datos_info->fetch_array(MYSQLI_ASSOC);

    ?>

        <!-- VER MIS DATOS -->
        <section id="mis_datos" class="container columna">
            <div class="row mb-5">
                <div class="col-md-12">
                    <form action='#' method='POST' class='m-3' id='requires-validation' novalidate>
                        <input type='hidden' name='id' value=<?php echo "$id" ?>>
                        <input class='col-md-12 mt-3 btn boton_complementario' name='borrar' type='submit' value='Borrar'>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="foto_perfil">
                            <div><img src="../../assets/imagenes/adiestradores/anuncios/<?php echo $fila_info['imagen'] ?>" alt="imagen anuncio" class="img-fluid"></div>
                        </div>
                        <div class="info_perfil">
                            <h1><?php echo "$fila_info[titulo]" ?></h1>
                            <h2><?php echo "$fila_info[nick]" ?></h2>
                            <div>
                                <h3><span class="fw-bold">Precio:</span> <?php echo "$fila_info[precio]" ?></h3>
                            </div>
                            <div>
                                <h3><span class="fw-bold">Descripción:</span> <?php echo nl2br($fila_info["descripcion"]) ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
        $imagen_ant=$fila_info["imagen"];
        $descripcion=$fila_info["descripcion"];
        $precio=$fila_info["precio"];
        $titulo=$fila_info["titulo"];
        ?>

        <!-- FORMULARIO EDITAR ANUNCIO -->
        <section id="formu_editar_anuncio" class="container-fluid mb-5">
            <div class="row">
                <div class="col-12">
                    <div class="container">
                        <div class="row fila_formu">
                            <div class="form-body col-md-6 mx-auto p-3">
     
                                <h1>Dogepp</h1>
                                <h2>Formulario para editar anuncios</h2>
                                <form class="mb-3" action="#" method="POST" enctype="multipart/form-data" id="requires-validation" novalidate>
                                    <input type='hidden' name='id' value=<?php echo "$id" ?>>
                                    <div class='col-md-12 mt-3'>
                                        <label for='imagen_nue'>Foto(PNG o JPG): </label>
                                        <input type='file' name='imagen_nue' id='imagen_nue'>
                                        <div class='invalid-feedback'>Imagen incorrecta</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="text" name="titulo" placeholder="Título" maxlength="100">
                                        <div class="invalid-feedback">Título vacío</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="number" name="precio" placeholder="Precio" min="0" max="999.99" step=".01">
                                        <div class="invalid-feedback">Precio vacío o inválido</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <textarea name='descripcion' maxlength='5000' rows='3' placeholder="Escribe aquí la descripción de tu anuncio"></textarea>  
                                    </div>
                                    
                                    <div class="col-md-12 mt-3">
                                        <div class="mt-3">
                                            <input class='btn boton' type="submit" name="enviar" value="Enviar">
                                        </div>
                                    </div>
                                </form>

                                <?php

                                    if(isset($_POST['enviar'])){

                                        $consulta_insercion="UPDATE anuncio SET imagen=?, titulo=?, precio=?, descripcion=? WHERE id=?";
                                        $resultado_insercion=$conexion->prepare($consulta_insercion);
                                    
                                        //SI LOS CAMPOS LOS DEJA VACIOS O NO CUMPLEN CON LOS REQUISITOS LE DEJO LO QUE TUVIESE ANTES DE MODIFICAR
                                        if(trim($_POST['titulo'])!="" && strlen(trim($_POST['titulo']))<=100){
                                            $titulo=trim($_POST['titulo']);
                                        }

                                        if(trim($_POST['descripcion'])!="" && strlen(trim($_POST['descripcion']))<=5000){
                                            $descripcion=trim($_POST['descripcion']);
                                        }  
                                        
                                        if(trim($_POST['precio'])!="" && is_numeric(trim($_POST['precio']))){
                                            $precio=trim($_POST['precio']);
                                        }
                                    
                                        //SI HA INSERTADO UNA IMAGEN VÁLIDA SE COJE ESA. SINO SE LE DEJA LA QUE TENIA
                                        if($_FILES['imagen_nue']['tmp_name']!=""){

                                            $extension_imagen=extension_imagen($_FILES['imagen_nue']['type']);
                                            if($extension_imagen===''){
                                                $foto_final=$imagen_ant;
                                            }else{
                                                //COPIO LA IMAGEN CON NAME "imagen_nue"
                                                $nombre_temporal_imagen=$_FILES['imagen_nue']['tmp_name'];
                                                $nombre_imagen="$dni".$extension_imagen;
                                                move_uploaded_file($nombre_temporal_imagen,"../../assets/imagenes/adiestradores/anuncios/$nombre_imagen");
                                                $foto_final=$nombre_imagen;
                                            }
                                        }else{
                                            $foto_final=$imagen_ant;
                                        }

                                        $resultado_insercion->bind_param("ssdsi", $foto_final, $titulo, $precio, $descripcion, $id);  
                                        $resultado_insercion->execute();
                                        $resultado_insercion->close();
                                        echo "<meta http-equiv='refresh' content='0; url=anuncios.php'>";  
                                    }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- FIN FORMULARIO EDITAR ANUNCIO -->

    <?php
            if(isset(($_POST["borrar"]))){
                $id=trim($_POST["id"]);

                $consulta_borrar="UPDATE anuncio SET activo='0' WHERE id=?";
                $resultado_borrar=$conexion->prepare($consulta_borrar);
                $resultado_borrar->bind_param("i", $id);
                $resultado_borrar->execute();
                $resultado_borrar->close();

                echo "<meta http-equiv='refresh' content='0; url=anuncios.php'>";
            }
        }else{
            echo "<div class='aun_no text-center'><h1>No hay anuncio que mostrar</h1></div>";
        }

    ?>
    <!-- FIN VER MIS DATOS -->

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