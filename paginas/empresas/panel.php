<?php
    session_start();

    if(isset($_COOKIE["mantenerUsuario"])){
        session_decode($_COOKIE["mantenerUsuario"]);
    }

    if(isset($_COOKIE["mantenerEmpresa"])){
        session_decode($_COOKIE["mantenerEmpresa"]);
    }

    if(isset($_SESSION["dni"])){
        header('Location: ../bienvenida/usuarios.php');
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
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swup@latest/dist/swup.min.js" defer></script> 
    <script type="text/javascript" src="../../js/swup.js" defer></script>
    <script type="text/javascript" src="../../js/toast.js"></script>
    <script type="text/javascript" src="../../js/app.js" defer></script>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

    <?php
        require_once("../../php/funciones.php");
        $conexion=conectarServidor();

        crearHeaderEmpresa("../..");
    ?>

    <!-- MAIN -->
    <main id="swup" class="transition-fade">

    <?php
        //SACAMOS EL SIGUIENTE ID
        $id=siguienteId('evento');

        //SACO LA FECHA DE HOY
        $hoy=date("Y-m-d",time());
    ?>

    <!-- FORMULARIO AGREGAR EVENTO -->
    <section id="formu_agregar_evento" class="container-fluid formuGeneral">
            <div class="row">
                <div class="col-12">
                    <div class="container">
                        <div class="row fila_formu">
                            <div class="form-body mx-auto p-3">
     
                                <h1>Dogepp</h1>
                                <h2>Formulario para agregar eventos</h2>
                                <form class="mb-3" action="#" method="POST" id="insertar_evento_form">

                                    <input type="hidden" value="<?php echo $id ?>" id="id_siguiente">

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre" maxlength="100" required>
                                    </div>
                       
                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="text" name="imagen" id="imagen" placeholder="URL de la imagen" maxlength="5000" required>
                                    </div>   
                                    
                                    <div class="col-md-12 mt-3">
                                        <textarea name='descripcion' id="descripcion" maxlength='5000' placeholder='Escribe la descripción de tu evento' rows='3' required></textarea>  
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="text" name="localizacion" id="localizacion" placeholder="Localización (Ej: C/ Granada Nº1)" maxlength="1000" required>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label for="fecha">Fecha</label>
                                        <input class="form-control" type="date" name="fecha" id="fecha" min="<?php echo $hoy?>" required>
                                    </div>
                                    
                                    <div class="col-md-12 mt-3">
                                            <input class='btn boton' type="submit" id="enviarEvento" name="enviarEvento" value="Enviar">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    <section id="eventosPagina" class="container">
        <div class="row w-100">
            <div id='lista_eventos' class="col-12"></div>; 
        </div>
    </section>

    <!-- MENSAJE EMERGENTE-->
    <div id="mensaje" style="z-index: 9999;" class="fixed-top  mx-auto mt-5 toast text-center" data-delay="3000"
      role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header w-100">
        <strong class="w-100 mr-auto">Mensaje informativo</strong>
      </div>
    </div>

    <?php
    if(isset($_POST["borrar"])){
        $idBorrar=$_POST["id"];
        $consulta_borrar="DELETE FROM evento WHERE id=?";
        $resultado_borrar=$conexion->prepare($consulta_borrar);
        $resultado_borrar->bind_param("i", $idBorrar);
        $resultado_borrar->execute();
        $resultado_borrar->close();
        echo "<meta http-equiv='refresh' content='0; url=panel.php'>";
    }
    ?>

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