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
                <h2>Se le ha enviado el mensaje a su amigo. Debe esperar a que acepte su solicitud. Espere mientras se le redirige a 'Amigos'</h2>
            </div>
        <?php
                echo "<meta http-equiv='refresh' content='3; url=amigos.php'>";
            }
        ?>

        <!-- FORMULARIO AGREGAR AMIGO -->
        <section id="formu_agregar_amigo" class="container-fluid formuGeneral">
            <div class="row">
                <div class="col-12">
                    <div class="container">
                        <div class="row fila_formu">
                            <div class="form-body mx-auto p-3">
     
                                <h1>Dogepp</h1>
                                <h2>Formulario para agregar amigos</h2>
                                <form class="mb-3" action="#" method="POST" id="requires-validation" novalidate>

                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="nick" placeholder="Nombre del usuario" maxlength="50" required>
                                        <div class="invalid-feedback">Nombre del usuario vac??o</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="text" name="nombre" placeholder="Nombre para agregar" maxlength="50" required>
                                        <div class="invalid-feedback">Nombre para agregar vac??o</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <textarea name='contenido' maxlength='500' placeholder='Escribe un mensaje para que tu amigo sepa quien eres' rows='3'></textarea>  
                                    </div>
                                    
                                    <div class="col-md-12 mt-3">
                                        <div class="mt-3">
                                            <input class='btn boton' type="submit" name="enviar" value="Enviar">
                                        </div>
                                    </div>
                                </form>

                                <?php

                                    if(isset($_POST['enviar'])){

                                        //SI SE HA DEJADO ALG??N CAMPO VAC??O LO REDIRIJO A LA PROPIA PAGINA. PASO DE SEGURIDAD EXTRA AL REQUIRED DEL HTML
                                        if(trim($_POST['nick'])==="" || trim($_POST['nombre'])==="" || trim($_POST['contenido'])===""){
                                            echo "<meta http-equiv='refresh' content='0; url=agregar_amigos.php'>";

                                        //SI ALG??N CAMPO NO CUMPLE CON LOS REQUISITOS LO REDIRIJO A LA PROPIA PAGINA
                                        }else if(strlen(trim($_POST["nick"]))>50 || strlen(trim($_POST["nombre"]))>50 || strlen(trim($_POST["contenido"]))>500){
                                            echo "<meta http-equiv='refresh' content='0; url=agregar_amigos.php'>";
                                        }else{

                                            $contenido=trim($_POST['contenido']);
                                            $nombre=trim($_POST['nombre']);
                                            $nick=trim($_POST['nick']);


                                            //COMPRUEBO SI EL NICK EXISTE
                                            $consulta_nick="SELECT dni FROM usuario WHERE nick=? and dni<>?";
                                            $resultado=$conexion->prepare($consulta_nick);
                                            $resultado->bind_param("ss",$nick, $_SESSION["dni"]);
                                            $resultado->bind_result($dni2);
                                            $resultado->execute();
                                            $resultado->store_result();
                                            
                                            $filas_devueltas=$resultado->num_rows; 

                                            if($filas_devueltas>0){
                                                $resultado->fetch();

                                                $fecha=date("Y-m-d",time());
                                                $estado='0';
                                                $dniMio=$_SESSION["dni"];

                                                $consulta_insercion="INSERT INTO amigo values (?,?,?,?,?,?)";
                                                $resultado_insercion=$conexion->prepare($consulta_insercion);
                                                $resultado_insercion->bind_param("ssssss", $dniMio, $dni2, $contenido, $fecha, $estado, $nombre);
                                                $resultado_insercion->execute();
                                                $resultado_insercion->close();
                                                echo "<meta http-equiv='refresh' content='0; url=agregar_amigos.php?ok'>";
                                            }else{
                                                echo "<h2 class='login-mal'>Usuario no existe</h2>";
                                            }
                                        }
                                    }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- FIN FORMULARIO AGREGAR AMIGO -->

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