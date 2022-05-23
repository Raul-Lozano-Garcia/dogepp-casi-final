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

        //SACAMOS EL SIGUIENTE ID
        $id=siguienteId('ruta');

        //SACO LA FECHA DE HOY
        $hoy=date("Y-m-d",time());
        
    ?>

    <!-- MAIN -->
    <main id="swup" class="transition-fade">

        <!-- SI SE HA REGISTRADO CORRECTAMENTE LE MUESTRO UN MODAL Y REDIRIJO A ACCEDER -->
        <?php
            if(isset($_GET["ok"])){
        ?>
            <div class="modal-redireccion">
                <h2>Se ha creado la ruta correctamente. Espere mientras se le redirige a 'Rutas'</h2>
            </div>
        <?php
                echo "<meta http-equiv='refresh' content='3; url=rutas.php'>";
            }
        ?>

        <!-- FORMULARIO AGREGAR RUTA -->
        <section id="formu_agregar_ruta" class="container-fluid formuGeneral">
            <div class="row">
                <div class="col-12">
                    <div class="container">
                        <div class="row fila_formu">
                            <div class="form-body mx-auto p-3">
     
                                <h1>Dogepp</h1>
                                <h2>Formulario para agregar rutas</h2>
                                <form class="mb-3" action="#" method="POST" id="requires-validation" novalidate>

                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="inicio" placeholder="Inicio" maxlength="50" required>
                                        <div class="invalid-feedback">Inicio vacío</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="text" name="fin" placeholder="Fin" maxlength="50" required>
                                        <div class="invalid-feedback">Fin vacío</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label for="fecha">Fecha</label>
                                        <input class="form-control" type="date" name="fecha" id="fecha" min="<?php echo $hoy?>" required>
                                        <div class="invalid-feedback">Fecha vacía</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label for="hora">Hora</label>
                                        <input type="time" name="hora" id="hora" required>
                                        <div class="invalid-feedback">Hora vacía</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <textarea name='reglas' maxlength='5000' placeholder='Enuncie las reglas de la ruta' rows='3'></textarea>  
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="text" name="mapa" placeholder="Localización (inserta mapa de Google Maps)" maxlength="1000" required>
                                        <div class="invalid-feedback">Mapa vacío</div>
                                    </div>
                                    
                                    <div class="col-md-12 mt-3">
                                        <div class="mt-3">
                                            <input class='btn boton' type="submit" name="enviar" value="Enviar">
                                        </div>
                                    </div>
                                </form>

                                <?php

                                    if(isset($_POST['enviar'])){

                                        $dni=$_SESSION["dni"];
                                        $activo='1';

                                        //SI SE HA DEJADO ALGÚN CAMPO VACÍO LO REDIRIJO A LA PROPIA PAGINA. PASO DE SEGURIDAD EXTRA AL REQUIRED DEL HTML
                                        if(trim($_POST['inicio'])==="" || trim($_POST['fin'])==="" || trim($_POST['fecha'])==="" || trim($_POST['hora'])==="" || trim($_POST['mapa'])===""){
                                            echo "<meta http-equiv='refresh' content='0; url=agregar_rutas.php'>";

                                        //SI ALGÚN CAMPO NO CUMPLE CON LOS REQUISITOS LO REDIRIJO A LA PROPIA PAGINA
                                        }else if(strlen(trim($_POST["inicio"]))>50 || strlen(trim($_POST["fin"]))>50 || strlen(trim($_POST["reglas"]))>5000 || strlen(trim($_POST["mapa"]))>1000){
                                            echo "<meta http-equiv='refresh' content='0; url=agregar_rutas.php'>";
                                        }else{
                                            
                                            $consulta_insercion="INSERT INTO ruta values (?,?,?,?,?,?,?,?,?)";
                                            $resultado_insercion=$conexion->prepare($consulta_insercion);
                                
                                            $inicio=trim($_POST['inicio']);
                                            $fin=trim($_POST['fin']);
                                            $mapa=trim($_POST['mapa']);
                                            $hora=trim($_POST['hora']);
                                            $fecha=trim($_POST['fecha']);

                                            if(trim($_POST['reglas'])!="" && strlen(trim($_POST['reglas']))<=5000){
                                                $reglas=trim($_POST["reglas"]);
                                            }else{
                                                $reglas="Ninguna";
                                            }
                            
                                            $resultado_insercion->bind_param("issssssss",$id,$inicio,$fin,$fecha,$hora,$reglas,$mapa, $dni, $activo);
                                            $resultado_insercion->execute();
                                            $resultado_insercion->close();
                                            echo "<meta http-equiv='refresh' content='0; url=agregar_rutas.php?ok'>";
                                            
                                        }
                                    }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- FIN FORMULARIO AGREGAR RUTA -->

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