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

        //SACO LA INFO DE MI PERFIL
        $consulta_info="SELECT nick, contraseña, imagen, nombre, teléfono, estado FROM usuario WHERE dni='$_SESSION[dni]'";

        $datos_info=$conexion->query($consulta_info);

        $fila_info=$datos_info->fetch_array(MYSQLI_ASSOC);

    ?>

        <!-- VER MIS DATOS -->
        <section id="mis_datos" class="container">
            <div class="row">
                <div class="col-12">


                    <div class="row">

                    <div class="foto_perfil">
                        <div><img src="../../assets/imagenes/usuarios/perfil/<?php echo $fila_info['imagen'] ?>" alt="imagen perfil" class="img-fluid"></div>
                    </div>
                    <div class="info_perfil">
                        <h1><?php echo "Nombre: $fila_info[nombre] (Nick: $fila_info[nick])" ?></h1>
                        <h3>DNI: <?php echo $_SESSION["dni"] ?></h3>
                        <h3>Tipo de perfil: 
                            
                        <?php
                        
                            if($_SESSION["tipo"]==='a'){
                                echo "Adiestrador";
                            }else{
                                echo "Básico"; 
                            }
                        
                        ?>
                    
                        </h3>
                        <h3>Teléfono: 

                        <?php
                        
                            if($fila_info["teléfono"]===null){
                                echo "-";
                            }else{
                                echo $fila_info["teléfono"]; 
                            }

                        ?>
                        </h3>
                        <div>
                            <h3>Estado: <?php echo nl2br($fila_info["estado"]) ?></h3>
                        </div>
                    </div>


                    </div>
                </div>
            </div>
        </section>

    <?php
        
        //RECOJO LOS DATOS ANTES DE MODIFICAR EN VARIABLES
        $nick=$fila_info["nick"];
        $telefono=$fila_info["teléfono"];
        $nombre=$fila_info["nombre"];
        $estado=$fila_info["estado"];
        $imagen_ant=$fila_info["imagen"];
        $pass=$fila_info["contraseña"]; 
        $dni=$_SESSION["dni"];

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
                                        <input class="form-control" type="text" name="nombre" placeholder="Nombre" maxlength="150">
                                        <div class="invalid-feedback">Nombre incorrecto</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="text" name="nick" placeholder="Nick" maxlength="50">
                                        <div class="invalid-feedback">Nick incorrecto</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="password" name="pass" placeholder="Contraseña" maxlength="32">
                                        <div class="invalid-feedback">Contraseña incorrecta</div>
                                    </div>

                                    <div class='col-md-12 mt-3'>
                                        <label for='imagen_nue'>Foto(PNG o JPG): </label>
                                        <input type='file' name='imagen_nue' id='imagen_nue'>
                                        <div class='invalid-feedback'>Imagen incorrecta</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="number" name="telefono" placeholder="Teléfono" min='100000000' max='999999999'>
                                        <div class="invalid-feedback">Teléfono incorrecto</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <textarea name='estado' maxlength='250' placeholder='Escribe tu estado' rows='3'></textarea>  
                                    </div>
                                    
                                    <div class="col-md-12 mt-3">
                                        <div class="mt-3">
                                            <input class='btn boton' type="submit" name="enviar" value="Enviar">
                                        </div>
                                    </div>
                                </form>

                                <?php

                                    if(isset($_POST['enviar'])){

                                        $consulta_insercion="UPDATE usuario SET nombre=?, nick=?, contraseña=?, imagen=?, teléfono=?, estado=? WHERE dni=?";
                                        $resultado_insercion=$conexion->prepare($consulta_insercion);
                                    
                                        //SI LOS CAMPOS LOS DEJA VACIOS O NO CUMPLEN CON LOS REQUISITOS LE DEJO LO QUE TUVIESE ANTES DE MODIFICAR
                                        if(trim($_POST['nombre'])!="" && strlen(trim($_POST['nombre']))<=150){
                                            $nombre=trim($_POST['nombre']);
                                        }

                                        if(trim($_POST['nick'])!="" && strlen(trim($_POST['nick']))<=50){
                                            $nick=trim($_POST['nick']);
                                        }

                                        if(trim($_POST['pass'])!="" && strlen(trim($_POST['pass']))<=32){
                                            $pass=md5(trim($_POST['pass']));
                                        }
                                        
                                        if(trim($_POST['estado'])!="" && strlen(trim($_POST['estado']))<=250){
                                            $estado=trim($_POST['estado']);
                                        }   
                                        
                                        if(trim($_POST['telefono'])!="" && is_numeric(trim($_POST['telefono']))){
                                            $telefono=trim($_POST['telefono']);
                                        }else if(trim($_POST['telefono'])==""){
                                            $telefono=null;
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
                                                move_uploaded_file($nombre_temporal_imagen,"../../assets/imagenes/usuarios/perfil/$nombre_imagen");
                                                $foto_final=$nombre_imagen;
                                            }
                                        }else{
                                            $foto_final=$imagen_ant;
                                        }

                                        $resultado_insercion->bind_param("ssssiss", $nombre, $nick, $pass, $foto_final, $telefono, $estado, $dni);  
                                        $resultado_insercion->execute();
                                        $resultado_insercion->close();
                                        echo "<meta http-equiv='refresh' content='0; url=perfil.php'>";   
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

    <?php
        crearFooter("../..");
    ?>

    <!-- ME DESCONECTO DE LA BASE DE DATOS -->
    <?php
        $conexion->close();
    ?>

</body>
</html>