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
    <main id="swup" class="transition-fade container">

        <!-- BUSCADOR -->
        <span class="d-block text-end">Buscar por nombre: <input type="search" id="search"></span>

        <section id="chats">

            <?php
                //SACO LOS CHATS

                $consulta_mensaje_1="SELECT id_usuario_envia FROM mensaje INNER JOIN usuario ON dni=id_usuario_recibe WHERE dni='$_SESSION[dni]' GROUP BY id_usuario_envia ORDER BY mensaje.fecha DESC, hora DESC";

                $datos_mensaje_1=$conexion->query($consulta_mensaje_1);
                $filas_devueltas_1=$datos_mensaje_1->num_rows;

                if($filas_devueltas_1===0){
                    echo "<div class='aun_no text-center'><h1>A??n no tienes conversaciones con anunciantes.</h1></div>";
                }else{
                    while ($fila_mensaje_1=$datos_mensaje_1->fetch_array(MYSQLI_ASSOC)){
                   
                    $consulta_mensaje="SELECT dni,imagen,nick FROM usuario WHERE dni='$fila_mensaje_1[id_usuario_envia]'";

                    $datos_mensaje=$conexion->query($consulta_mensaje);
                
                    while ($fila_mensaje=$datos_mensaje->fetch_array(MYSQLI_ASSOC)){

                        // AQU?? SACO EL ??LTIMO MENSAJE DE TODA LA CONVERSACI??N ENTRE ESTE USUARIO Y YO
                        $consulta_ultimo_mensaje="SELECT id_usuario_envia,contenido FROM mensaje WHERE id_usuario_recibe='$_SESSION[dni]' AND id_usuario_envia='$fila_mensaje[dni]' OR id_usuario_envia='$_SESSION[dni]' AND id_usuario_recibe='$fila_mensaje[dni]' ORDER BY mensaje.fecha DESC, hora DESC LIMIT 1";

                        $datos_ultimo_mensaje=$conexion->query($consulta_ultimo_mensaje);

                        $filas_devueltas_ultimo_mensaje=$datos_ultimo_mensaje->num_rows;

                        $fila_ultimo_mensaje=$datos_ultimo_mensaje->fetch_array(MYSQLI_ASSOC);

                        echo "
                        <div class='row chats fila_a_buscar'>
                            <div class='col-12'>
                                <div class='row'>
                                    <div class='col-12 fila_chats'>
                                        <div class='img-chat me-4'>
                                            <img src='../../assets/imagenes/usuarios/perfil/$fila_mensaje[imagen]' alt='foto' class='img-fluid'>
                                        </div>
                                        <div class='contenido'>
                                            <h2>$fila_mensaje[nick]</h2>";
                                            if($filas_devueltas_ultimo_mensaje>0){
                                                echo "<p>$fila_ultimo_mensaje[contenido]</p>";
                                            }
                                            
                                        echo "</div> 
                                        <form action='mensajes_adiestradores.php' method='POST' class='m-3'>
                                            <input type='hidden' name='envia' value='$fila_mensaje[dni]'>
                                            <input class='btn boton_analogo' type='submit' value='Chat'>
                                        </form>
                                    </div>       
                                </div>
                            </div>
                        </div>
                        ";
                    }
                
                    }
                }
            
            ?>
        
       </section>

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