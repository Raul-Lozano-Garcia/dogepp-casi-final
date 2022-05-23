<?php
    session_start();

    if(isset($_POST["cerrar_sesion"])){
        if(isset($_COOKIE['mantenerUsuario'])){
            setcookie("mantenerUsuario",null,time()-60,"/");
        }
        if(isset($_COOKIE['mantenerEmpresa'])){
            setcookie("mantenerEmpresa",null,time()-60,"/");
        }
        $_SESSION=array();
        session_destroy();
        header('Location: acceder.php');
    }

    

    if(isset($_COOKIE["mantenerUsuario"])){
        session_decode($_COOKIE["mantenerUsuario"]);
    }

    if(isset($_COOKIE["mantenerEmpresa"])){
        session_decode($_COOKIE["mantenerEmpresa"]);
    }

    // SI YA ME HE LOGEADO, NO PUEDO ACCEDER AQUÍ A TRAVÉS DE LA URL
    if(isset($_SESSION["dni"])){
        if($_SESSION["dni"]==="000000000"){
            header('Location: ../admin/panel.php');
        }else{
            header('Location: ../dogbook/chats.php');
        }
        
    }

    if(isset($_SESSION["cif"])){
        header('Location: ../bienvenida/empresas.php');
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

    <!-- MAIN -->
    <main id="swup" class="transition-fade">

        <!-- FLECHA VOLVER -->
        <a class="volver btn boton_complementario" href="../../index.html">Volver a Dogepp.es</a>

        <!-- FORMULARIO ACCESO -->
        <section id="formu_acceso" class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="container">
                        <div class="row fila_formu">
                            <div class="form-body col-md-6 mx-auto p-3">
     
                                <h1>Dogepp</h1>
                                <h2>Formulario de acceso</h2>
                                <form class="mb-3" action="#" method="POST" id="requires-validation" novalidate>

                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="nick" placeholder="Nick o CIF" maxlength="50" required>
                                        <div class="invalid-feedback">Nick o CIF vacío</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="password" name="pass" placeholder="Contraseña" maxlength="32" required>
                                        <div class="invalid-feedback">Contraseña vacía</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input type="checkbox" name="mantener" id="mantener">
                                        <label for="mantener">No cerrar sesión</label>
                                    </div>
                                    
                                    <div class="col-md-12 mt-3">
                                        <div class="mt-3">
                                            <input class='btn boton' type="submit" name="entrar" value="Entrar">
                                        </div>
                                    </div>
                                </form>

                                <span class="me-3">¿Aún no tienes una cuenta?</span><a class="btn boton_analogo" href="./registro_tipos.php">Registrate aquí</a>

                            </div>



                  
            

                            <?php
                                if(isset($_POST["entrar"])){
                                    $nick=trim($_POST["nick"]);
                                    $pass=md5(trim($_POST['pass']));
                                    

                                    $consulta_usuario="SELECT dni,tipo FROM usuario WHERE nick=? and contraseña=? and activo='1'";
                                    $resultado=$conexion->prepare($consulta_usuario);
                                    $resultado->bind_param("ss",$nick, $pass);
                                    $resultado->bind_result($dni,$tipo);
                                    $resultado->execute();
                                    $resultado->store_result();
                                    
                                    $filas_devueltas=$resultado->num_rows;  

                                    // VEO SI DEVUELVE ALGUNA FILA DE USUARIOS
                                    if($filas_devueltas>0){
                            
                                        $resultado->fetch();

                                        $_SESSION["dni"]=$dni;
                                        $_SESSION["tipo"]=$tipo;

                                        if(isset($_POST["mantener"])){
                                            $datos=session_encode();
                                            setcookie("mantenerUsuario",$datos,time()+60*60*24*365,"/");
                                        }

                                        // COMPRUEBO SI TIENE AL MENOS UN AMIGO EN LA LISTA DE AMIGOS PARA LLEVARLO AL TUTORIAL O NO
                                        $consulta_amigos="SELECT id_usuario FROM amigo WHERE id_usuario=?";
                                        $resultado_amigos=$conexion->prepare($consulta_amigos);
                                        $resultado_amigos->bind_param("s",$dni);
                                        $resultado_amigos->bind_result($id);
                                        $resultado_amigos->execute();
                                        $resultado_amigos->store_result();
                                        
                                        $filas_devueltas_amigos=$resultado_amigos->num_rows; 

                                        if($filas_devueltas_amigos>0){
                                            echo "<meta http-equiv='refresh' content='0; url=../dogbook/chats.php'>";
                                        }else{
                                            echo "<meta http-equiv='refresh' content='0; url=../bienvenida/usuarios.php'>";
                                        }

                                    }else{     
                                        $consulta_usuario="SELECT cif FROM empresa WHERE cif=? and contraseña=? and activo='1'";
                                        $resultado=$conexion->prepare($consulta_usuario);
                                        $resultado->bind_param("ss",$nick, $pass);
                                        $resultado->bind_result($cif);
                                        $resultado->execute();
                                        $resultado->store_result();
                                        
                                        $filas_devueltas=$resultado->num_rows;  

                                        
                                        // VEO SI DEVUELVE FILA DE EMPRESAS
                                        if($filas_devueltas>0){
                            
                                            $resultado->fetch();

                                            $_SESSION["cif"]=$cif;
                            
                                            if(isset($_POST["mantener"])){
                                                $datos=session_encode();
                                                setcookie("mantenerEmpresa",$cif,time()+60*60*24*365,"/");
                                            }
                                    
                                            // COMPRUEBO SI TIENE AL MENOS UN EVENTO EN LA LISTA DE EVENTOS PARA LLEVARLO AL TUTORIAL O NO
                                            $consulta_eventos="SELECT id_empresa FROM evento WHERE id_empresa=?";
                                            $resultado_eventos=$conexion->prepare($consulta_eventos);
                                            $resultado_eventos->bind_param("s",$cif);
                                            $resultado_eventos->bind_result($id);
                                            $resultado_eventos->execute();
                                            $resultado_eventos->store_result();
                                            
                                            $filas_devueltas_eventos=$resultado_eventos->num_rows; 

                                            if($filas_devueltas_eventos>0){
                                                echo "<meta http-equiv='refresh' content='0; url=../empresas/panel.php'>";
                                            }else{
                                                echo "<meta http-equiv='refresh' content='0; url=../bienvenida/empresas.php'>";
                                            }
                            
                                        }else{
                                            echo "<h2 class='login-mal'>Nick, CIF o contraseña incorrectos</h2>"; 
                                        }
                                    }

                                    $resultado->close();
                                }
                            ?>
                      </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- FIN FORMULARIO ACCESO -->

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