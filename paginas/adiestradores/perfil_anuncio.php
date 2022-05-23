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
            if(isset($_GET["ok"])){
        ?>
            <div class="modal-redireccion">
                <h2>Se ha reportado al anunciante correctamente. Espere mientras se le redirige a 'Anuncios'</h2>
            </div>
        <?php
                echo "<meta http-equiv='refresh' content='3; url=anuncios.php'>";
            }
        ?>

    <?php

    if(isset($_GET["id"])){

        //SACO LA INFO DE ANUNCIO
        $id=trim($_GET["id"]);

        $consulta_info="SELECT dni,titulo,anuncio.imagen imagen,nick,precio,descripcion FROM usuario INNER JOIN anuncio ON dni=id_usuario WHERE anuncio.id='$id' AND anuncio.activo='1'";

        $datos_info=$conexion->query($consulta_info);

        $fila_info=$datos_info->fetch_array(MYSQLI_ASSOC);

    ?>

        <!-- VER MIS DATOS -->
        <section id="mis_datos" class="container columna">
            <div class="row mb-5">
                <?php
                    $consulta_ya_ha_reportado="SELECT id_usuario FROM reporta WHERE id_usuario_reportado='$fila_info[dni]' AND id_usuario='$_SESSION[dni]'";

                    $datos_ya_ha_reportado=$conexion->query($consulta_ya_ha_reportado);
            
                    $filas_devueltas=$datos_ya_ha_reportado->num_rows;

                    if($filas_devueltas===0){
                ?>
                <div class="col-md-6">
                    <button class="btn boton_analogo copiarURL">Copiar al portapapeles</button>
                </div>
                <div class="col-md-6">
                <button class='btn boton_complementario abrir_modal_amigo'>Reportar usuario</button>
                    <div class='boton_agregar_amigo'>
                        <div>
                            <div class='form-body col-md-6 mx-auto p-3'>
                                <form action='#' method='POST' class='m-3' id='requires-validation' novalidate>
                                    <input type='hidden' name='dni' value=<?php echo "$fila_info[dni]" ?>>
                                    <input type='hidden' name='id' value=<?php echo "$id" ?>>
                                    <div class='col-md-12 mt-3'>
                                    <textarea name='contenido' maxlength='5000' placeholder='Escribe el motivo del reporte' rows='3' required></textarea>  
                                    </div>
                                    <input class='col-md-12 mt-3 btn boton_complementario' name='reportar' type='submit' value='Enviar reporte'>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                    }else{
                ?>
                <div class="col-md-12">
                    <button class="btn boton_analogo copiarURL">Copiar al portapapeles</button>
                </div>
                <?php
                    }
                ?>

            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="foto_perfil">
                            <div><img src="../../assets/imagenes/adiestradores/anuncios/<?php echo $fila_info['imagen'] ?>" alt="imagen anuncio" class="img-fluid"></div>
                        </div>
                        <div class="info_perfil">
                            <h1><?php echo "$fila_info[titulo]" ?></h1>
                            <h2><?php echo "$fila_info[nick]" ?></h2>
                            <div>
                                <h3><span class="fw-bold">Precio:</span> <?php echo "$fila_info[precio]" ?></h3>
                            </div>
                            <div>
                                <h3><span class="fw-bold">Descripción:</span> <?php echo nl2br($fila_info["descripcion"]) ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <?php
            if(isset(($_POST["reportar"]))){
                $dni=trim($_POST["dni"]);
                $mio=$_SESSION["dni"];
                $fecha=date("Y-m-d",time());
                $contenido=trim($_POST["contenido"]);
                $id=trim($_POST["id"]);

                $consulta_insercion="INSERT INTO reporta values (?,?,?,?)";
                $resultado_insercion=$conexion->prepare($consulta_insercion);
                $resultado_insercion->bind_param("ssss", $mio, $dni, $fecha, $contenido);
                $resultado_insercion->execute();
                $resultado_insercion->close();
                echo "<meta http-equiv='refresh' content='0; url=perfil_anuncio.php?id=$id&ok'>";
            }
        }else{
            echo "<div class='aun_no text-center'><h1>No hay anuncio que mostrar</h1></div>";
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