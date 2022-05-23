<?php
    session_start();

    if(isset($_COOKIE["mantenerUsuario"])){
        session_decode($_COOKIE["mantenerUsuario"]);
    }

    if(isset($_COOKIE["mantenerEmpresa"])){
        session_decode($_COOKIE["mantenerEmpresa"]);
    }

    if(isset($_SESSION["dni"])){
        header('Location: usuarios.php');
    }

    if(!isset($_SESSION["cif"])){
        header('Location: ../acceder/acceder.php');        
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

        // COMPRUEBO SI YA ESTABA REGISTRADA
        $conexion=conectarServidor();
        $cif=$_SESSION["cif"];
        $consulta_empresa="SELECT localizacion FROM empresa WHERE cif=?";
        $resultado_empresa=$conexion->prepare($consulta_empresa);
        $resultado_empresa->bind_param("s",$cif);
        $resultado_empresa->bind_result($localizacion);
        $resultado_empresa->execute();

        if($localizacion!==null){
            header('Location: ../empresas/panel.php');     
        }
        $conexion->close();
    ?>

    <!-- MAIN -->
    <main id="swup" class="transition-fade">

        <!-- BIENVENIDA USUARIO -->
        <section id="bienvenida_usuario" class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Bienvenido a Dogepp</h1>
                    <p>Al ser la primera vez que inicias sesión en la siguiente página debes rellenar un formulario para completar tu perfil. Una vez hecho tendrás total acceso a todo lo relacionado con los permisos de tu tipo de usuario y no se mostrará mas esta pantalla.</p>
                    <div class='text-center'><a class='btn boton_complementario' href='empresas2.php'>Siguiente</a></div>
                </div>
            </div>

        </section>
        <!-- FIN BIENVENIDA USUARIO -->

    </main>
    <!-- FIN MAIN -->

    <?php
        crearFooter("../..");
    ?>

</body>
</html>