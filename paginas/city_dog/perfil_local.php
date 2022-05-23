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

    if(isset($_GET["cif"])){

        //SACO LA INFO DEL LOCAL
        $cif=trim($_GET["cif"]);

        $consulta_info="SELECT nombre,telefono,localizacion,tipo,imagen FROM empresa WHERE cif='$cif'";

        $datos_info=$conexion->query($consulta_info);

        $fila_info=$datos_info->fetch_array(MYSQLI_ASSOC);

    ?>

        <!-- VER MIS DATOS -->
        <section id="mis_datos" class="container columna">
            <div class="row w-100">
                <div class="col-12">
                    <div class="row">
                        <div class="foto_perfil">
                            <div><img src="../../assets/imagenes/empresas/<?php echo $fila_info['imagen'] ?>" alt="imagen local" class="img-fluid"></div>
                        </div>
                        <div class="info_perfil">
                            <h1 class="text-center"><?php echo "$fila_info[nombre]" ?></h1>
                            <h3>Tipo de negocio: <?php echo $fila_info["tipo"] ?></h3>
                            <div>
                                <h3>Teléfono: 
                                <?php
                        
                                if($fila_info["telefono"]===null){
                                    echo "-";
                                }else{
                                    echo $fila_info["telefono"];
                                }
                                ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-light bg-dark p-5 my-5">
                <div class="col-12 text-center">
                    <h2>Localización</h2>
                    <div><?php echo $fila_info['localizacion'] ?></div>
                </div>
            </div>
            <div class="row w-100">
                <div class="col-12">
                    <h2 class="text-center">Eventos</h2>
                    
                    <?php

                        $consulta_comentarios="SELECT nombre, imagen, descripcion, localizacion, fecha FROM evento WHERE id_empresa='$cif'";

                        $datos_mensaje=$conexion->query($consulta_comentarios);
                        $filas_devueltas=$datos_mensaje->num_rows;

                        // VEO SI DEVUELVE ALGUNA FILA PARA EMPEZAR A MOSTRAR O POR EL CONTRARIO DIGO QUE NO HAY NINGUNA
                        if($filas_devueltas===0){
                            echo "<div class='aun_no text-center'><h1>Aún no hay eventos por parte de este empresa.</h1></div>";
                        }else{
                            while ($fila_mensaje=$datos_mensaje->fetch_array(MYSQLI_ASSOC)){
                                $fechaBuena=formatearFecha($fila_mensaje["fecha"]);
                                echo "<div class='eventos'>
                                <div><img src='$fila_mensaje[imagen]' alt='imagen evento' class='img-fluid'></div>
                                <div>
                                    <h3 class='fw-bold mb-0'>$fila_mensaje[nombre]</h3>
                                    <h4>$fila_mensaje[localizacion]</h4>
                                    <span class='d-block mb-3'>$fechaBuena</span>";
                                    ?><p><?php echo nl2br($fila_mensaje["descripcion"]) ?></p><?php
                                echo "</div>
                                </div>";
                            }
                        }

                    ?>

                </div>
            </div>
        </section>

        

    <?php
            if(isset(($_POST["enviar"]))){
                $dni=$_SESSION["dni"];
                $id_parque=trim($_POST["id_parque"]);
                $fecha=date("Y-m-d",time());
                $contenido=trim($_POST["contenido"]);
                $activo="1";

                $consulta_insercion="INSERT INTO comentario values (?,?,?,?,?,?)";
                $resultado_insercion=$conexion->prepare($consulta_insercion);
                $resultado_insercion->bind_param("isssis", $id, $fecha, $contenido, $dni, $id_parque, $activo);
                $resultado_insercion->execute();
                $resultado_insercion->close();
                echo "<meta http-equiv='refresh' content='0; url=parques.php'>";
            }
        }else{
            echo "<div class='aun_no text-center'><h1>No hay parque que mostrar</h1></div>";
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