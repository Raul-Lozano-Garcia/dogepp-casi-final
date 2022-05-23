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
    <script src="https://unpkg.com/swup@latest/dist/swup.min.js"></script> 
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

        <!-- FLECHA VOLVER -->
        <a class="volver flecha_volver" href="./acceder.php"><i class="fa-solid fa-arrow-left"></i></a>

        <!-- TIPOS ACCESO -->
        <section id="tipos" class="tipos_acceso container py-5">
          <div class="row">
            <div class="col-12">
              <div class="text-center">
                <h2 class="d-inline-block">Tipos de cuenta</h2>
              </div>
              <p class="mb-5">Dentro de nuestra aplicación existen 3 tipos de perfiles, y depende de cada uno de ellos, el usuario podrá tener acceso a ciertas funcionalidades que se adaptan a sus propios intereses.</p>
            </div>
          </div>
            <div class="row gx-5">
              <div class="col-md-4">
                <a href="formularioBasico.php">
                    <div class="tipo_cuenta">
                        <img src="../../assets/imagenes/tipo1.png" alt="tipo de usuario">
                        <h3>Usuario</h3>
                        <p>El tipo de cuenta para cualquier usuario que desea usar la aplicación de forma rápida y sencilla. Es la más recomendada si quieres tener acceso a las funcionalidades más básicas y no tener que profundizar mucho más en otras un poco más complejas.</p>
                    </div>
                </a>
              </div>
              <div class="col-md-4">
                <a href="formularioAdiestrador.php">
                    <div class="tipo_cuenta">
                        <img src="../../assets/imagenes/tipo2.png" alt="tipo de usuario">
                        <h3>Adiestrador</h3>
                        <p>¿Buscas poder anunciarte? Pues este tipo de perfil es el adecuado para tí. En esencia podrás hacer lo mismo que un Usuario, pero con la diferencia de que se te permitirá crear anuncios para que otras personas puedan llegar a contactarte y ganar un dinero extra.</p>
                    </div>
                </a>
              </div>
              <div class="col-md-4">
                <a href="formularioEmpresa.php">
                    <div class="tipo_cuenta">                   
                        <img src="../../assets/imagenes/tipo3.png" alt="tipo de usuario">
                        <h3>Empresa</h3>
                        <p>Si eres una empresa "Dog Friendly", es decir, que permites perros en tu local, crea una cuenta con este perfil para darte a conocer y poder organizar eventos para que otros usuarios puedan acudir a ellos y así ampliar el alcance de tu negocio y mejorar su reputación.</p>               
                    </div>
                </a>
              </div>
            </div>
        </section>
        <!-- FIN TIPOS ACCESO-->

    </main>
    <!-- FIN MAIN -->

    <?php
        crearFooter("../..");
    ?>

</body>
</html>