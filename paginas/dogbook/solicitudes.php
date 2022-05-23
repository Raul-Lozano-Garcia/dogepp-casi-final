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
                //SACO LAS SOLICITUDES (PERO SOLO LOS AUN NO HAYAN ACEPTADO O RECHAZADO LA SOLICITUD)
                $consulta_mensaje="SELECT id_usuario,imagen,nick,contenido,fecha FROM usuario INNER JOIN amigo ON dni=id_usuario WHERE id_usuario_amigo='$_SESSION[dni]' and amigo.estado='0' ORDER BY fecha DESC";

                $datos_mensaje=$conexion->query($consulta_mensaje);
                $filas_devueltas=$datos_mensaje->num_rows;

                // VEO SI DEVUELVE ALGUNA FILA PARA EMPEZAR A MOSTRAR O POR EL CONTRARIO DIGO QUE NO HAY NINGUNA
                if($filas_devueltas===0){
                    echo "<div class='aun_no text-center'><h1>Aún no tienes solicitudes de amistad</h1></div>";
                }else{
                    while ($fila_mensaje=$datos_mensaje->fetch_array(MYSQLI_ASSOC)){

                        echo "
                        <div class='row chats fila_a_buscar'>
                            <div class='col-12'>
                                <div class='row'>
                                    <div class='col-12 fila_chats'>
                                        <div class='img-chat me-4'>
                                            <img src='../../assets/imagenes/usuarios/perfil/$fila_mensaje[imagen]' alt='foto' class='img-fluid'>
                                        </div>
                                        <div class='contenido'>
                                            <h2>$fila_mensaje[nick]</h2>       
                                            <p>"; echo nl2br($fila_mensaje["contenido"]); echo "</p>
                                        </div> 
                                        <button class='btn boton abrir_modal_amigo'>Agregar</button>
                                        <div class='boton_agregar_amigo'>
                                            <div>
                                                <div class='form-body col-md-6 mx-auto p-3'>
                                                    <form action='#' method='POST' class='m-3' id='requires-validation' novalidate>
                                                        <input type='hidden' name='envia1' value='$fila_mensaje[id_usuario]'>
                                                        <input type='hidden' name='contenido' value='$fila_mensaje[contenido]'>
                                                        <input type='hidden' name='fecha' value='$fila_mensaje[fecha]'>
                                                        <div class='col-md-12 mt-3'>
                                                            <input class='form-control' type='text' name='nombre' placeholder='Nombre del amigo' maxlength='50' required>
                                                        </div>
                                                        <input class='col-md-12 mt-3 btn boton' name='agregar' type='submit' value='Agregar'>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <form action='#' method='POST' class='m-3'>
                                            <input type='hidden' name='envia2' value='$fila_mensaje[id_usuario]'>
                                            <input class='btn boton_complementario' name='rechazar' type='submit' value='Rechazar'>
                                        </form>
                                    </div>       
                                </div>
                            </div>
                        </div>
                        ";
                    }
                }
            ?>
        
       </section>

       <?php
        if(isset($_POST["agregar"])){
            //CAMBIO EL ESTADO DEL MENSAJE A 1, QUE SIGNIFICA QUE LE HA DADO A ACEPTAR Y YA NO SE VA A MOSTRAR MÁS EN SOLICITUDES
            $estado='1';
            $dni=trim($_POST["envia1"]);

            $consulta_actualizacion="UPDATE amigo SET estado=? WHERE id_usuario=? AND id_usuario_amigo=?";
            $resultado_actualizacion=$conexion->prepare($consulta_actualizacion);
            $resultado_actualizacion->bind_param("sss", $estado, $dni, $_SESSION["dni"]);  
            print_r($resultado_actualizacion);
            $resultado_actualizacion->execute();
            $resultado_actualizacion->close();

            // Y AHORA TENGO QUE AGREGAR A ESTE USUARIO COMO AMIGO DEL DE LA SOLICITUD
            $contenido=trim($_POST["contenido"]);
            $fecha=trim($_POST["fecha"]);
            $estado_ok='1';
            $nombre=trim($_POST["nombre"]);

            $consulta_insercion="INSERT INTO amigo values (?,?,?,?,?,?)";
            $resultado_insercion=$conexion->prepare($consulta_insercion);
            $resultado_insercion->bind_param("ssssss", $_SESSION["dni"], $dni, $contenido, $fecha, $estado_ok, $nombre);
            $resultado_insercion->execute();
            $resultado_insercion->close();
            echo "<meta http-equiv='refresh' content='0; url=solicitudes.php'>";

        }else if(isset($_POST["rechazar"])){
            $dni=trim($_POST["envia2"]);

            $consulta_borrar="DELETE FROM amigo WHERE id_usuario=? AND id_usuario_amigo=?";
            $resultado_borrar=$conexion->prepare($consulta_borrar);
            $resultado_borrar->bind_param("ss", $dni,$_SESSION["dni"]);
            $resultado_borrar->execute();
            $resultado_borrar->close();
            echo "<meta http-equiv='refresh' content='0; url=solicitudes.php'>";
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