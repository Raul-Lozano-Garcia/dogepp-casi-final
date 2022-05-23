<?php
    session_start();

    if(isset($_COOKIE["mantenerUsuario"])){
        session_decode($_COOKIE["mantenerUsuario"]);
    }

    if(isset($_COOKIE["mantenerEmpresa"])){
        session_decode($_COOKIE["mantenerEmpresa"]);
    }

    if(isset($_SESSION["dni"])){
        header('Location: ../bienvenida/usuarios.php');
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
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swup@latest/dist/swup.min.js" defer></script> 
    <script type="text/javascript" src="../../js/swup.js" defer></script>
    <script type="text/javascript" src="../../js/toast.js"></script>
    <script type="text/javascript" src="../../js/app.js" defer></script>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

    <?php
        require_once("../../php/funciones.php");
        $conexion=conectarServidor();

        crearHeaderEmpresa("../..");
    ?>

    <!-- MAIN -->
    <main id="swup" class="transition-fade">

    <!-- FLECHA VOLVER -->
    <form class="volver flecha_volver" action="#" method="POST">
        <input type="submit" class="btn boton_complementario" name="volver" value="Volver">
    </form>

    <?php

    if(isset($_POST["volver"])){
        echo "<meta http-equiv='refresh' content='0; url=panel.php'>";
    }

    ?>

    <?php

        //SACO LA INFO DE MI PERFIL
        $consulta_info="SELECT nombre, contraseña, imagen, localizacion, telefono, tipo FROM empresa WHERE cif='$_SESSION[cif]'";

        $datos_info=$conexion->query($consulta_info);

        $fila_info=$datos_info->fetch_array(MYSQLI_ASSOC);

    ?>

        <!-- VER MIS DATOS -->
        <section id="mis_datos" class="container">
            <div class="row">
                <div class="col-12">


                    <div class="row">

                    <div class="foto_perfil">
                        <div><img src="../../assets/imagenes/empresas/<?php echo $fila_info['imagen'] ?>" alt="imagen perfil" class="img-fluid"></div>
                    </div>
                    <div class="info_perfil">
                        <h1><?php echo "Nombre: $fila_info[nombre]" ?></h1>
                        <h3>CIF: <?php echo $_SESSION["cif"] ?></h3>
                        <h3>Tipo de empresa: <?php echo "$fila_info[tipo]" ?></h3>
                        <h3>Teléfono: <?php echo "$fila_info[telefono]" ?></h3>
                        <div class="row text-light bg-dark p-5 my-5">
                            <div class="col-12 text-center">
                                <h2>Localización</h2>
                                <div><?php echo $fila_info['localizacion'] ?></div>
                            </div>
                        </div>
                    </div>


                    </div>
                </div>
            </div>
        </section>

    <?php
        
        //RECOJO LOS DATOS ANTES DE MODIFICAR EN VARIABLES
        $nombre=$fila_info["nombre"];
        $telefono=$fila_info["telefono"];
        $tipo=$fila_info["tipo"];
        $localizacion=$fila_info["localizacion"];
        $imagen_ant=$fila_info["imagen"];
        $pass=$fila_info["contraseña"]; 
        $cif=$_SESSION["cif"];

    ?>
    <!-- FIN VER MIS DATOS -->

        <!-- FORMULARIO EDITAR PERFIL -->
        <section id="formu_editar_perfil" class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="container">
                        <div class="row fila_formu">
                            <div class="form-body col-md-6 mx-auto p-3">
     
                                <h1>Dogepp</h1>
                                <h2>Formulario para editar el perfil</h2>
                                <h3 class="mb-5"><b>(Dejar vacíos los campos que se quieran mantener)</b></h3>
                                <form class="mb-3" action="#" method="POST" enctype="multipart/form-data" id="requires-validation" novalidate>

                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="nombre" placeholder="Nombre" maxlength="100">
                                        <div class="invalid-feedback">Nombre incorrecto</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="password" name="pass" placeholder="Contraseña" maxlength="32">
                                        <div class="invalid-feedback">Contraseña incorrecta</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="number" name="telefono" placeholder="Teléfono" min='100000000' max='999999999'>
                                        <div class="invalid-feedback">Teléfono incorrecto</div>
                                    </div>

                                    <div class='col-md-12 mt-3'>
                                        <label for='imagen_nue'>Foto(PNG o JPG): </label>
                                        <input type='file' name='imagen_nue' id='imagen_nue'>
                                        <div class='invalid-feedback'>Imagen incorrecta</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="text" name="localizacion" placeholder="Localización (inserte mapa de Google Maps)" maxlength="1000">
                                        <div class="invalid-feedback">Localización incorrecta</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="text" name="tipo" placeholder="Tipo" maxlength="100">
                                        <div class="invalid-feedback">Tipo incorrecto</div>
                                    </div>
                                    
                                    <div class="col-md-12 mt-3">
                                        <div class="mt-3">
                                            <input class='btn boton' type="submit" name="enviar" value="Enviar">
                                        </div>
                                    </div>
                                </form>

                                <?php

                                    if(isset($_POST['enviar'])){

                                        $consulta_insercion="UPDATE empresa SET nombre=?, contraseña=?, telefono=?, imagen=?, localizacion=?, tipo=? WHERE cif=?";
                                        $resultado_insercion=$conexion->prepare($consulta_insercion);
                                    
                                        //SI LOS CAMPOS LOS DEJA VACIOS O NO CUMPLEN CON LOS REQUISITOS LE DEJO LO QUE TUVIESE ANTES DE MODIFICAR
                                        if(trim($_POST['nombre'])!="" && strlen(trim($_POST['nombre']))<=100){
                                            $nombre=trim($_POST['nombre']);
                                        }

                                        if(trim($_POST['pass'])!="" && strlen(trim($_POST['pass']))<=32){
                                            $pass=md5(trim($_POST['pass']));
                                        }
                                        
                                        if(trim($_POST['localizacion'])!="" && strlen(trim($_POST['localizacion']))<=1000){
                                            $localizacion=trim($_POST['localizacion']);
                                        }   

                                        if(trim($_POST['tipo'])!="" && strlen(trim($_POST['tipo']))<=100){
                                            $tipo=trim($_POST['tipo']);
                                        } 
                                        
                                        if(trim($_POST['telefono'])!="" && is_numeric(trim($_POST['telefono']))){
                                            $telefono=trim($_POST['telefono']);
                                        }
                                    
                                        //SI HA INSERTADO UNA IMAGEN VÁLIDA SE COJE ESA. SINO SE LE DEJA LA QUE TENIA
                                        if($_FILES['imagen_nue']['tmp_name']!=""){

                                            $extension_imagen=extension_imagen($_FILES['imagen_nue']['type']);
                                            if($extension_imagen===''){
                                                $foto_final=$imagen_ant;
                                            }else{
                                                //COPIO LA IMAGEN CON NAME "imagen_nue"
                                                $nombre_temporal_imagen=$_FILES['imagen_nue']['tmp_name'];
                                                $nombre_imagen="$cif".$extension_imagen;
                                                move_uploaded_file($nombre_temporal_imagen,"../../assets/imagenes/empresas/$nombre_imagen");
                                                $foto_final=$nombre_imagen;
                                            }
                                        }else{
                                            $foto_final=$imagen_ant;
                                        }

                                        $resultado_insercion->bind_param("ssissss", $nombre, $pass, $telefono, $foto_final, $localizacion, $tipo, $cif);  
                                        $resultado_insercion->execute();
                                        $resultado_insercion->close();
                                        echo "<meta http-equiv='refresh' content='0; url=perfil_empresa.php'>";   
                                    }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- FIN FORMULARIO EDITAR PERFIL -->

    </main>
    <!-- FIN MAIN -->

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