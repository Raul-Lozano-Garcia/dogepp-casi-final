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

    <section id="panelAnuncios" class="container panelAdmin">

    <!-- BUSCADOR -->
    <span class="d-block text-end">Buscar por nombre: <input type="search" id="search"></span>
        
    <?php

        //SACO LOS ANUNCIOS
        $consulta_mensaje="SELECT id,titulo,descripcion,precio,imagen,activo FROM anuncio";

        $datos_mensaje=$conexion->query($consulta_mensaje);
        $filas_devueltas=$datos_mensaje->num_rows;
        
        if ($filas_devueltas>0) {
            echo "<div class='row'>
                <table>
                <tr><th>T??tulo</th><th>Descripci??n</th><th>Precio</th><th>Foto</th><th></th><th></th></tr>";
            while ($fila_mensaje=$datos_mensaje->fetch_array(MYSQLI_ASSOC)) {
                echo "<tr class='fila_a_buscar'>
                        <td><h2>$fila_mensaje[titulo]</h2></td>
                        <td class='largo'>"; echo nl2br("$fila_mensaje[descripcion]"); echo"</td>
                        <td>$fila_mensaje[precio]???</td>";

                        if($fila_mensaje["activo"]==='0'){
                            echo "<td><img src='../../assets/imagenes/adiestradores/anuncios/$fila_mensaje[imagen]' class='img-fluid desactivada'></td>";
                        }else{
                            echo "<td><img src='../../assets/imagenes/adiestradores/anuncios/$fila_mensaje[imagen]' class='img-fluid'></td>";
                        }
                        
                        echo "<td>
                            <form method='POST' action='ver_perfil_anuncio.php'>
                                <input type='hidden' name='id' value='$fila_mensaje[id]'>
                                <input type='submit' name='enviarId' value='Ver perfil' class='btn boton_analogo'>
                            </form>
                         </td>
                         ";

                        if($fila_mensaje["activo"]==='1'){
                            echo "<td>
                            <form method='POST' action='#'>
                                <input type='hidden' name='id' value='$fila_mensaje[id]'>
                                <input type='submit' name='borrar' value='Desactivar' class='btn boton_complementario'>
                            </form>
                        </td>";
                        }else{
                            echo "<td>
                            <form method='POST' action='#'>
                                <input type='hidden' name='id' value='$fila_mensaje[id]'>
                                <input type='submit' name='activar' value='Activar' class='btn boton'>
                            </form>
                        </td>";
                        }
                        echo "
                    </tr>";
            }

            echo "</table>
            </div>";
        } else {
            echo "<h1 class='fw-bold text-center'>No hay anuncios a??n</h1>";
        }
        
    ?>
    </section>

    <?php
        if(isset(($_POST["borrar"]))){
            $id=trim($_POST["id"]);

            $consulta_borrar="UPDATE anuncio SET activo='0' WHERE id=?";
            $resultado_borrar=$conexion->prepare($consulta_borrar);
            $resultado_borrar->bind_param("i", $id);
            $resultado_borrar->execute();
            $resultado_borrar->close();

            echo "<meta http-equiv='refresh' content='0; url=anuncios.php'>";
        }else if(isset(($_POST["activar"]))){
            $id=trim($_POST["id"]);

            $consulta_borrar="UPDATE anuncio SET activo='1' WHERE id=?";
            $resultado_borrar=$conexion->prepare($consulta_borrar);
            $resultado_borrar->bind_param("i", $id);
            $resultado_borrar->execute();
            $resultado_borrar->close();

            echo "<meta http-equiv='refresh' content='0; url=anuncios.php'>";
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