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

    <!-- SI SE HA REGISTRADO CORRECTAMENTE LE MUESTRO UN MODAL Y REDIRIJO A ACCEDER -->
        <?php
            if(isset($_GET["apuntado"])){
        ?>
            <div class="modal-redireccion">
                <h2>Te has apuntado a la ruta correctamente. Espere mientras se le redirige a 'Rutas'</h2>
            </div>
        <?php
                echo "<meta http-equiv='refresh' content='3; url=rutas.php'>";
            }
        ?>

        <?php
            if(isset($_GET["desapuntado"])){
        ?>
            <div class="modal-redireccion">
                <h2>Te has desapuntado de la ruta correctamente. Espere mientras se le redirige a 'Rutas'</h2>
            </div>
        <?php
                echo "<meta http-equiv='refresh' content='3; url=rutas.php'>";
            }
        ?>

    <?php

    if(isset($_GET["id"])){

        //SACO LA INFO DE LA RUTA
        $id=trim($_GET["id"]);

        $consulta_info="SELECT inicio,fin,fecha,hora,mapa,reglas FROM ruta WHERE id='$id' AND activo='1'";

        $datos_info=$conexion->query($consulta_info);

        $fila_info=$datos_info->fetch_array(MYSQLI_ASSOC);


        //VER SI ESTE USUARIO ESTÁ APUNTADO
        $consulta_apuntarse_yo="SELECT id_ruta FROM apunta WHERE id_ruta='$id' AND id_usuario='$_SESSION[dni]'";

        $datos_apuntarse_yo=$conexion->query($consulta_apuntarse_yo);

        $filas_devueltas_yo=$datos_apuntarse_yo->num_rows;


        //VER TODOS LOS USUARIOS APUNTADOS
        $consulta_apuntarse_todos="SELECT COUNT(*) todos FROM apunta WHERE id_ruta='$id'";

        $datos_apuntarse_todos=$conexion->query($consulta_apuntarse_todos);

        $fila_info2=$datos_apuntarse_todos->fetch_array(MYSQLI_ASSOC);

        $fechaBuena=formatearFecha($fila_info["fecha"]);
        $horaBuena=formatearHora($fila_info["hora"]);

    ?>

        <!-- VER MIS DATOS -->
        <section id="mis_datos" class="container columna">
            <div class="row">
                <div class="col-md-12">

                <?php
                    if($filas_devueltas_yo===0){
                ?>

                    <div class='mx-auto'>
                        <form action='#' method='POST' class='m-3' id='requires-validation' novalidate>
                            <input type='hidden' name='id' value=<?php echo "$id" ?>>
                            <input type='hidden' name='dni' value=<?php echo "$_SESSION[dni]" ?>>
                            <input class='col-md-12 mt-3 btn boton' name='apuntarse' type='submit' value='Apuntarse'>
                        </form>
                    </div>

                <?php
                    }else{
                ?>

                    <div class='mx-auto'>
                        <form action='#' method='POST' class='m-3' id='requires-validation' novalidate>
                            <input type='hidden' name='id' value=<?php echo "$id" ?>>
                            <input type='hidden' name='dni' value=<?php echo "$_SESSION[dni]" ?>>
                            <input class='col-md-12 mt-3 btn boton_complementario' name='desapuntarse' type='submit' value='Desapuntarse'>
                        </form>
                    </div>

                <?php   
                    }
                ?>


                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="foto_perfil columna">
                            <h1 class="text-center"><?php echo "$fila_info[inicio] - $fila_info[fin]" ?></h1>
                            <div class="text-center"><?php echo "$fila_info[mapa]" ?></div>
                        </div>
                        <div class="info_perfil">
                            <div>
                                <h3>Fecha: <?php echo "$fechaBuena" ?></h3>
                            </div>
                            <div>
                                <h3>Hora: <?php echo "$horaBuena" ?></h3>
                            </div>
                            <div>
                                <h3>Gente total apuntada: <?php echo "$fila_info2[todos]" ?></h3>
                            </div>
                            <div class="mb-5">
                                <h3 class="mb-0 fw-bold">Reglas:</h3>
                                <p><?php echo nl2br($fila_info["reglas"]) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <?php
            if(isset(($_POST["apuntarse"]))){
                $dni=trim($_POST["dni"]);
                $id=trim($_POST["id"]);

                $consulta_insercion="INSERT INTO apunta values (?,?)";
                $resultado_insercion=$conexion->prepare($consulta_insercion);
                $resultado_insercion->bind_param("is", $id,$dni);
                $resultado_insercion->execute();
                $resultado_insercion->close();
                echo "<meta http-equiv='refresh' content='0; url=perfil_ruta.php?id=$id&apuntado'>";
            }else if(isset(($_POST["desapuntarse"]))){
                $dni=trim($_POST["dni"]);
                $id=trim($_POST["id"]);

                $consulta_insercion="DELETE FROM apunta WHERE id_ruta=? AND id_usuario=?";
                $resultado_insercion=$conexion->prepare($consulta_insercion);
                $resultado_insercion->bind_param("is", $id,$dni);
                $resultado_insercion->execute();
                $resultado_insercion->close();
                echo "<meta http-equiv='refresh' content='0; url=perfil_ruta.php?id=$id&desapuntado'>";
            }
        }else{
            echo "<div class='aun_no text-center'><h1>No hay ruta que mostrar</h1></div>";
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