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

    if(isset($_POST["dni"])){

        //SACO LA INFO DE PERFIL
        $dni=trim($_POST["dni"]);

        $consulta_info="SELECT imagen, estado FROM usuario WHERE dni='$dni'";

        $datos_info=$conexion->query($consulta_info);

        $fila_info=$datos_info->fetch_array(MYSQLI_ASSOC);

        $consulta_info2="SELECT amigo.nombre nombre, usuario.nombre nombre_real FROM amigo INNER JOIN usuario ON dni=id_usuario_amigo WHERE id_usuario='$_SESSION[dni]' AND id_usuario_amigo='$dni'";

        $datos_info2=$conexion->query($consulta_info2);

        $fila_info2=$datos_info2->fetch_array(MYSQLI_ASSOC);

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
                            <h1><?php echo "$fila_info2[nombre] ($fila_info2[nombre_real])" ?></h1>
                            <div>
                                <h3>Estado: <?php echo nl2br($fila_info["estado"]) ?></h3>
                            </div>
                            <form action='#' method='POST' class='m-3 text-center'>
                                <input type='hidden' name='dni' value=<?php echo "$dni" ?>>
                                <input class='btn boton_complementario' name="borrar" type='submit' value='Eliminar amigo'>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <?php
        if(isset(($_POST["borrar"]))){
            $dni=trim($_POST["dni"]);

            $consulta_borrar_mensajes_1="DELETE FROM mensaje WHERE id_usuario_envia=? AND id_usuario_recibe=?";
            $resultado_borrar_mensajes_1=$conexion->prepare($consulta_borrar_mensajes_1);
            $resultado_borrar_mensajes_1->bind_param("ss", $dni,$_SESSION["dni"]);
            $resultado_borrar_mensajes_1->execute();
            $resultado_borrar_mensajes_1->close();

            $consulta_borrar_mensajes_2="DELETE FROM mensaje WHERE id_usuario_recibe=? AND id_usuario_envia=?";
            $resultado_borrar_mensajes_2=$conexion->prepare($consulta_borrar_mensajes_2);
            $resultado_borrar_mensajes_2->bind_param("ss", $dni,$_SESSION["dni"]);
            $resultado_borrar_mensajes_2->execute();
            $resultado_borrar_mensajes_2->close();

            $consulta_borrar_amigos_1="DELETE FROM amigo WHERE id_usuario=? AND id_usuario_amigo=?";
            $resultado_borrar_amigos_1=$conexion->prepare($consulta_borrar_amigos_1);
            $resultado_borrar_amigos_1->bind_param("ss", $dni,$_SESSION["dni"]);
            $resultado_borrar_amigos_1->execute();
            $resultado_borrar_amigos_1->close();

            $consulta_borrar_amigos_2="DELETE FROM amigo WHERE id_usuario_amigo=? AND id_usuario=?";
            $resultado_borrar_amigos_2=$conexion->prepare($consulta_borrar_amigos_2);
            $resultado_borrar_amigos_2->bind_param("ss", $dni,$_SESSION["dni"]);
            $resultado_borrar_amigos_2->execute();
            $resultado_borrar_amigos_2->close();

            echo "<meta http-equiv='refresh' content='0; url=amigos.php'>";
        }


        }else{
            echo "<div class='aun_no text-center'><h1>No hay perfil que mostrar</h1></div>";
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