<?php
    session_start();

    if(isset($_COOKIE["mantenerUsuario"])){
        session_decode($_COOKIE["mantenerUsuario"]);
    }

    if(isset($_COOKIE["mantenerEmpresa"])){
        session_decode($_COOKIE["mantenerEmpresa"]);
    }

    if(isset($_SESSION["cif"])){
        header('Location: empresas.php');
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
    ?>

    <!-- MAIN -->
    <main id="swup" class="transition-fade">

        <?php
            if($_SESSION["tipo"]==='a'){
        ?>
            <a class="volver flecha_volver" href="usuarios1_5.php"><i class="fa-solid fa-arrow-left"></i></a>
        <?php
            }else{
        ?>
                <a class="volver flecha_volver" href="usuarios.php"><i class="fa-solid fa-arrow-left"></i></a>
        <?php
            }
        ?>

        <!-- BIENVENIDA USUARIO -->
        <section id="bienvenida_usuario" class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Somos una comunidad sana</h1>
                    <p>Si tienes constancia de que algún anunciante está haciendo un uso indebido de la aplicación (spam, lenguaje inapropiado...) siempre podrás reportarlo para que desde el equipo de Dogepp tomemos las medidas pertinentes. Para ellos, una vez estés dentro del perfil del anuncio, deberás clicar al botón que dice "Reportar usuario" en la parte superior de la página, y con ello será más que suficiente. Agredecemos de antemano tu colaboración.</p>
                    <form action="#" method="POST">
                            <div class="text-center">
                                <input class='btn boton_complementario' type="submit" name="entrar" value="Entrar">
                            </div>
                        </div>
                    </form>

                    <?php
                        if(isset($_POST["entrar"])){
                            echo "<meta http-equiv='refresh' content='0; url=../dogbook/chats.php'>";
                        }
                    ?>
              
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