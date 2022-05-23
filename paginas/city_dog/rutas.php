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

        $hoy=date("Y-m-d",time());
        
    ?>

    <!-- MAIN -->
    <main id="swup" class="transition-fade container">

        <!-- BUSCADOR -->
        <span class="d-block text-end">Buscar por localizacion: <input type="search" id="search"></span>

        <section id="chats">

            <?php
                //SACO LOS PARQUES
                $consulta_parque="SELECT id,inicio,fin,fecha,hora FROM ruta WHERE activo='1'";

                $datos_mensaje=$conexion->query($consulta_parque);
                $filas_devueltas=$datos_mensaje->num_rows;

                // VEO SI DEVUELVE ALGUNA FILA PARA EMPEZAR A MOSTRAR O POR EL CONTRARIO DIGO QUE NO HAY NINGUNA
                if($filas_devueltas===0){
                    echo "<div class='aun_no text-center'><h1>Aún no hay rutas. Para crear tú una clica en el botón + de abajo.</h1></div>";
                }else{
                    while ($fila_mensaje=$datos_mensaje->fetch_array(MYSQLI_ASSOC)){
                        $fechaBuena=formatearFecha($fila_mensaje["fecha"]);
                        $horaBuena=formatearHora($fila_mensaje["hora"]);

                        $manana = strtotime('+1 day', strtotime($fila_mensaje["fecha"]));
                        $manana = date('Y-m-d', $manana);

                        if($hoy>=$manana){
                            $activoo='0';
                            $consulta_borrar="UPDATE ruta SET activo=? WHERE id=?";
                            $resultado_borrar=$conexion->prepare($consulta_borrar);
                            $resultado_borrar->bind_param("si", $activoo,$fila_mensaje["id"]);
                            $resultado_borrar->execute();
                            $resultado_borrar->close();
                            echo "<meta http-equiv='refresh' content='0; url=rutas.php'>";
                        }
                        
                        echo "
                        <div class='row chats fila_a_buscar'>
                            <div class='col-12'>
                                <div class='row'>
                                    <div class='col-12 fila_chats'>
                                        <div class='contenido'>
                                            <h2>$fila_mensaje[inicio] - $fila_mensaje[fin]</h2>
                                            <div>
                                            
                                                <h3 class='my-3'>$fechaBuena</h3>
                                                <h3>$horaBuena</h3>
                                            </div> 
                                                  
                                        </div>
                                        <form action='perfil_ruta.php' method='GET' class='m-3'>
                                            <input type='hidden' name='id' value='$fila_mensaje[id]'>
                                            <input class='btn boton_analogo' type='submit' value='Ver más'>
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
       <div class="row container-fluid">
            <div class="col-12"> 
                <a href="agregar_rutas.php"><div class="boton-mas text-center">+</div></a>
            </div>
        </div>

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