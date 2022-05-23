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

        <section id="mensajes">

            <?php

                if(isset($_POST["envia"])){
            ?>
                    <div id="mensajeLog">
            <?php

                    $otro_usuario=$_POST["envia"];

                    //SACO TODOS LOS MENSAJES
                    $consulta_mensaje="SELECT id_usuario_envia,fecha, hora, contenido,imagen FROM mensaje INNER JOIN usuario ON dni=id_usuario_envia WHERE id_usuario_envia='$otro_usuario' AND id_usuario_recibe='$_SESSION[dni]' OR id_usuario_recibe='$otro_usuario' AND id_usuario_envia='$_SESSION[dni]' ORDER BY fecha ASC, hora ASC";

                    $datos_mensaje=$conexion->query($consulta_mensaje);

                    while ($fila_mensaje=$datos_mensaje->fetch_array(MYSQLI_ASSOC)){
                        $fechaBuena=formatearFecha($fila_mensaje["fecha"]);
                        $horaBuena=formatearHora($fila_mensaje["hora"]);

                        if($fila_mensaje["id_usuario_envia"]!==$_SESSION["dni"]){
                            echo "<div class='caja_mensaje'><div class='img-mensaje-otro'>
                            <img src='../../assets/imagenes/usuarios/perfil/$fila_mensaje[imagen]' alt='foto' class='img-fluid'>
                        </div><p class='mensaje_otro'>"; echo nl2br("$fila_mensaje[contenido]"); echo "</p></div>";
                            echo "<div class='mb-5'>
                            <span>$fechaBuena - $horaBuena</span></span>
                            </div>";
                        }else{
                            echo "<div class='mensaje_mio'><div class='img-mensaje'>
                            <img src='../../assets/imagenes/usuarios/perfil/$fila_mensaje[imagen]' alt='foto' class='img-fluid'>
                        </div><p>"; echo nl2br("$fila_mensaje[contenido]"); echo "</p></div>";
                            echo "<div class='text-end mb-5'>
                            <span>$fechaBuena - $horaBuena</span></span>
                            </div>";
                        }
                    }
            
            ?>

                    </div>

                    <form class="mb-3" action="#" method="POST" id="requires-validation" novalidate>
                        <input type='hidden' name='envia' value=<?php echo $otro_usuario ?>>
                        <textarea name='mensaje' maxlength='5000' placeholder='Escribe tu mensaje' rows='5' required></textarea>      
                        <div class="col-md-12 mt-3">
                            <div class="mt-3 text-center">
                                <input class='btn boton' type="submit" name="enviar" value="Enviar">
                            </div>
                        </div>
                    </form>

                <?php

                    if(isset($_POST['enviar'])){

                        //SI SE HA DEJADO ALGÚN CAMPO VACÍO LO REDIRIJO A LA PROPIA PAGINA. PASO DE SEGURIDAD EXTRA AL REQUIRED DEL HTML
                        if(trim($_POST['mensaje'])===""){
                            echo "<meta http-equiv='refresh' content='0; url=chats.php'>";

                        //SI ALGÚN CAMPO NO CUMPLE CON LOS REQUISITOS LO REDIRIJO A LA PROPIA PAGINA
                        }else if(strlen(trim($_POST["mensaje"]))>5000){
                            echo "<meta http-equiv='refresh' content='0; url=chats.php'>";
                        }else{
                                                
                            $id=siguienteId('mensaje');
                            $fecha=date("Y-m-d",time());
                            $hora=date("H:i:s",time());
                            $contenido=$_POST["mensaje"];
                            $id_user_envia=$_SESSION["dni"];
                            $id_user_recibe=$_POST["envia"];

                            $consulta_insercion="INSERT INTO mensaje values (?,?,?,?,?,?)";
                            $resultado_insercion=$conexion->prepare($consulta_insercion);
            
                            $resultado_insercion->bind_param("isssss",$id, $fecha, $hora, $contenido, $id_user_envia, $id_user_recibe);
                            $resultado_insercion->execute();
                            $resultado_insercion->close();
                            echo "<meta http-equiv='refresh' content='0; url=chats.php'>";


                        }
                    }

                    
                }else{
                    echo "<div class='aun_no text-center'><h1>No hay mensajes que mostrar</h1></div>";
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