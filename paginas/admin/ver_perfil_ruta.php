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
        crearHeaderAdmin("../..");
        
    ?>

    <!-- MAIN -->
    <main id="swup" class="transition-fade">

    <?php

    if(isset($_POST["id"])){

        //SACO LA INFO DE PERFIL
        $id=trim($_POST["id"]);

        $consulta_info="SELECT inicio,fin,fecha,hora,reglas,mapa,nick FROM ruta INNER JOIN usuario ON dni=id_usuario WHERE id='$id'";

        $datos_info=$conexion->query($consulta_info);

        $fila_info=$datos_info->fetch_array(MYSQLI_ASSOC);

        $fechaBuena=formatearFecha($fila_info["fecha"]);
        $horaBuena=formatearHora($fila_info["hora"]);
    ?>

        <!-- VER MIS DATOS -->
        <section id="mis_datos" class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="info_perfil">
                            <h1><?php echo "$fila_info[inicio] - $fila_info[fin]" ?></h1>
                            <h3>Autor: <?php echo "$fila_info[nick]" ?></h3>
                            <h3>Fecha: <?php echo "$fechaBuena" ?></h3>
                            <h3>Hora: <?php echo "$horaBuena" ?></h3>
                            <div>
                                <h3 class="fw-bold mb-0">Reglas:</h3>
                                <p><?php echo nl2br($fila_info["reglas"]) ?></p>
                            </div>
                            <div class="row text-light bg-dark p-5 my-5">
                                <div class="col-12 text-center">
                                    <h2>Localización</h2>
                                    <div><?php echo $fila_info['mapa'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <?php

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