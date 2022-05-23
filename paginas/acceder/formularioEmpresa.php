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

    <!-- MAIN -->
    <main id="swup" class="transition-fade">

        <!-- FLECHA VOLVER -->
        <a class="volver flecha_volver" href="registro_tipos.php"><i class="fa-solid fa-arrow-left"></i></a>

        <!-- SI SE HA REGISTRADO CORRECTAMENTE LE MUESTRO UN MODAL Y REDIRIJO A ACCEDER -->
        <?php
            if(isset($_GET["ok"])){
        ?>
            <div class="modal-redireccion">
                <h2>Su registro se ha completado con éxito. Espere mientras se le redirige al formulario de acceso</h2>
            </div>
        <?php
                echo "<meta http-equiv='refresh' content='3; url=acceder.php'>";
            }
        ?>

        <!-- FORMULARIO CREAR EMPRESA -->
        <section id="formu_crear_empresa" class="container-fluid formuGeneral">
            <div class="row">
                <div class="col-12">
                    <div class="container">
                        <div class="row fila_formu">
                            <div class="form-body mx-auto p-3">
     
                                <h1>Dogepp</h1>
                                <h2>Formulario de usuarios empresas</h2>
                                <form class="mb-3" action="#" method="POST" id="requires-validation" novalidate>

                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="cif" placeholder="CIF" maxlength="9" required>
                                        <div class="invalid-feedback">CIF vacío</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="text" name="nombre" placeholder="Nombre" maxlength="100" required>
                                        <div class="invalid-feedback">Nombre vacío</div>
                                    </div>
                                                
                                    <div class='col-md-12 mt-3'>
                                        <input class="form-control" type="password" name="pass" placeholder="Contraseña" maxlength="32" required>
                                        <div class="invalid-feedback">Contraseña vacía</div>
                                    </div>
                                    
                                    <div class="col-md-12 mt-3">
                                        <div class="mt-3">
                                            <input class='btn boton' type="submit" name="enviar" value="Enviar">
                                        </div>
                                    </div>
                                </form>

                                <?php

                                    if(isset($_POST['enviar'])){

                                        //SI SE HA DEJADO ALGÚN CAMPO VACÍO LO REDIRIJO A LA PROPIA PAGINA. PASO DE SEGURIDAD EXTRA AL REQUIRED DEL HTML
                                        if(trim($_POST['cif'])==="" || trim($_POST['nombre'])==="" || trim($_POST['pass'])===""){
                                            echo "<meta http-equiv='refresh' content='0; url=formularioEmpresa.php'>";

                                        //SI ALGÚN CAMPO NO CUMPLE CON LOS REQUISITOS LO REDIRIJO A LA PROPIA PAGINA
                                        }else if(strlen(trim($_POST["cif"]))!==9 || strlen(trim($_POST["nombre"]))>100 || strlen(trim($_POST["pass"]))>32){
                                            echo "<meta http-equiv='refresh' content='0; url=formularioEmpresa.php'>";
                                        }else{

                                            $cif=trim($_POST['cif']);
                                            $nombre=trim($_POST['nombre']);
                                            $pass=md5(trim($_POST['pass']));


                                            $consulta_usuario="SELECT cif FROM empresa WHERE cif=?";
                                            $resultado=$conexion->prepare($consulta_usuario);
                                            $resultado->bind_param("s",$cif);
                                            $resultado->bind_result($cif2);
                                            $resultado->execute();
                                            $resultado->store_result();
                                            
                                            $filas_devueltas=$resultado->num_rows; 
                                            
                                            if($filas_devueltas>0){
                                                echo "<h2 class='login-mal'>Lo sentimos. Esta empresa ya existe</h2>"; 
                                            }else{
                                                $consulta_insercion="INSERT INTO empresa values (?,?,?,null,'default.png','1',null,null)";
                                                $resultado_insercion=$conexion->prepare($consulta_insercion);
                                                $resultado_insercion->bind_param("sss", $cif, $nombre, $pass);
                                                $resultado_insercion->execute();
                                                $resultado_insercion->close();
                                                echo "<meta http-equiv='refresh' content='0; url=formularioEmpresa.php?ok'>";
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
        <!-- FIN FORMULARIO CREAR EMPRESA -->

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