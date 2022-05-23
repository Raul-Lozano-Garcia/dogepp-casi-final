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

    if($_SESSION["dni"]!=="000000000"){
        header('Location: ../bienvenida/usuarios.php');
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
        crearHeaderAdmin("../..");
        $conexion=conectarServidor();

    ?>

    <!-- MAIN -->
    <main id="swup" class="transition-fade">

    <section id="panelUsuarios" class="container panelAdmin">

    <!-- BUSCADOR -->
    <span class="d-block text-end">Buscar por nick: <input type="search" id="search"></span>
        
    <?php

        //SACO LOS USUARIOS
        $consulta_mensaje="SELECT id_usuario, id_usuario_reportado, fecha, comentario FROM reporta";

        $datos_mensaje=$conexion->query($consulta_mensaje);
        $filas_devueltas=$datos_mensaje->num_rows;
        
        if ($filas_devueltas>0) {
            echo "<div class='row'>
                <table>
                <tr><th>Reporta</th><th>Reportado</th><th>Motivo</th><th>Fecha</th><th></th></tr>";
            while ($fila_mensaje=$datos_mensaje->fetch_array(MYSQLI_ASSOC)) {

                $fechaBuena=formatearFecha($fila_mensaje["fecha"]);
                
                $consulta_reporta="SELECT nick FROM usuario WHERE dni='$fila_mensaje[id_usuario]'";

                $datos_reporta=$conexion->query($consulta_reporta);

                $fila_reporta=$datos_reporta->fetch_array(MYSQLI_ASSOC);

                $consulta_reportado="SELECT nick FROM usuario WHERE dni='$fila_mensaje[id_usuario_reportado]'";

                $datos_reportado=$conexion->query($consulta_reportado);

                $fila_reportado=$datos_reportado->fetch_array(MYSQLI_ASSOC);



                echo "<tr class='fila_a_buscar'>
                        <td><h2>$fila_reporta[nick]</h2></td>
                        <td><h2>$fila_reportado[nick]</h2></td>
                        <td class='largo'>"; echo nl2br("$fila_mensaje[comentario]"); echo"</td>
                        <td>$fechaBuena</td>
                        <td>
                            <form method='POST' action='#'>
                                <input type='hidden' name='id_usuario' value='$fila_mensaje[id_usuario]'>
                                <input type='hidden' name='id_usuario_reportado' value='$fila_mensaje[id_usuario_reportado]'>
                                <input type='submit' name='borrar' value='Eliminar' class='btn boton_complementario'>
                            </form>
                         </td>
                    </tr>";
            }

            echo "</table>
            </div>";
        } else {
            echo "<h1 class='fw-bold text-center'>No hay reportes aún</h1>";
        }
        
    ?>
    </section>

    <?php
        if(isset(($_POST["borrar"]))){
            $id_usuario=trim($_POST["id_usuario"]);
            $id_usuario_reportado=trim($_POST["id_usuario_reportado"]);

            $consulta_borrar="DELETE FROM reporta WHERE id_usuario=? AND id_usuario_reportado=?";
            $resultado_borrar=$conexion->prepare($consulta_borrar);
            $resultado_borrar->bind_param("ss", $id_usuario, $id_usuario_reportado);
            $resultado_borrar->execute();
            $resultado_borrar->close();

            echo "<meta http-equiv='refresh' content='0; url=reportes.php'>";
        }
    ?>

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