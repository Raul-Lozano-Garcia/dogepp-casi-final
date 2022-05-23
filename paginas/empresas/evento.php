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

        crearHeaderEmpresa("../..");

        //SACO LA FECHA DE HOY
        $hoy=date("Y-m-d",time());
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

    if(isset($_POST["id"])){

        //SACO LA INFO DEL EVENTO
        $id=trim($_POST["id"]);

        $consulta_info="SELECT nombre,imagen,descripcion,localizacion,fecha FROM evento WHERE id='$id'";

        $datos_info=$conexion->query($consulta_info);

        $fila_info=$datos_info->fetch_array(MYSQLI_ASSOC);

        $nombre=$fila_info["nombre"];
        $imagen=$fila_info["imagen"];
        $descripcion=$fila_info["descripcion"];
        $localizacion=$fila_info["localizacion"];
        $fecha=$fila_info["fecha"];

    ?>

        <!-- FORMULARIO EDITAR EVENTO -->
        <section id="formu_editar_evento" class="container-fluid formuGeneral">
            <div class="row">
                <div class="col-12">
                    <div class="container">
                        <div class="row fila_formu">
                            <div class="form-body mx-auto p-3">
     
                                <h1>Dogepp</h1>
                                <h2>Formulario para editar eventos</h2>
                                <form class="mb-3" action="#" method="POST" enctype="multipart/form-data" id="requires-validation" novalidate>
                                    <input type='hidden' name='id' value=<?php echo "$id" ?>>
                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="text" name="imagen" placeholder="URL de la imagen" maxlength="5000" value="<?php echo "$imagen" ?>">
                                        <div class="invalid-feedback">Imagen vacía</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="text" name="nombre" placeholder="Nombre" maxlength="100" value="<?php echo "$nombre" ?>">
                                        <div class="invalid-feedback">Nombre vacío</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="text" name="localizacion" placeholder="Localizacion" maxlength="500" value="<?php echo "$localizacion" ?>">
                                        <div class="invalid-feedback">Localización vacía</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label for="fecha">Fecha: </label>
                                        <input class="form-control" type="date" name="fecha" min="<?php echo $hoy?>" id="fecha" value="<?php echo "$fecha" ?>">
                                        <div class="invalid-feedback">Fecha vacía</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <textarea name='descripcion' maxlength='5000' rows='3' placeholder="Escribe aquí la descripción de tu evento"><?php echo "$descripcion" ?></textarea>  
                                    </div>
                                    
                                    <div class="col-md-12 mt-3">
                                        <div class="mt-3">
                                            <input class='btn boton' type="submit" name="enviar" value="Enviar">
                                        </div>
                                    </div>
                                </form>

                                <?php

                                    if(isset($_POST['enviar'])){

                                        $consulta_insercion="UPDATE evento SET nombre=?, imagen=?, descripcion=?, localizacion=?, fecha=? WHERE id=?";
                                        $resultado_insercion=$conexion->prepare($consulta_insercion);
                                    
                                        //SI LOS CAMPOS LOS DEJA VACIOS O NO CUMPLEN CON LOS REQUISITOS LE DEJO LO QUE TUVIESE ANTES DE MODIFICAR
                                        if(trim($_POST['nombre'])!="" && strlen(trim($_POST['nombre']))<=100){
                                            $nombre=trim($_POST['nombre']);
                                        }

                                        if(trim($_POST['imagen'])!="" && strlen(trim($_POST['imagen']))<=5000){
                                            $imagen=trim($_POST['imagen']);
                                        }

                                        if(trim($_POST['descripcion'])!="" && strlen(trim($_POST['descripcion']))<=5000){
                                            $descripcion=trim($_POST['descripcion']);
                                        }  
                                        
                                        if(trim($_POST['localizacion'])!="" && strlen(trim($_POST['localizacion']))<=500){
                                            $localizacion=trim($_POST['localizacion']);
                                        } 
                                        
                                        if(trim($_POST['fecha'])!=""){
                                            $fecha=trim($_POST['fecha']);
                                        }  

                                        $resultado_insercion->bind_param("sssssi", $nombre, $imagen, $descripcion, $localizacion,$fecha,$id);  
                                        $resultado_insercion->execute();
                                        $resultado_insercion->close();
                                        echo "<meta http-equiv='refresh' content='0; url=panel.php'>";  
                                    }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- FIN FORMULARIO EDITAR EVENTO -->

    <?php
        }else{
            echo "<div class='aun_no text-center'><h1>No hay evento que mostrar</h1></div>";
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