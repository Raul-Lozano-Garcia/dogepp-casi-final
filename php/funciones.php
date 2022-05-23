<?php

    function conectarServidor(){
        $conexion=new mysqli("localhost","root","","dogepp");
        $conexion->set_charset("utf8");  
        return $conexion;        
    }

    function formatearFecha($fecha){
        $timestamp=strtotime($fecha);
        $fechaFormateada=date('d/m/Y',$timestamp);
        return $fechaFormateada;
    }

    function formatearHora($hora){
        $timestamp=strtotime($hora);
        $horaFormateada=date('H:i',$timestamp);
        return $horaFormateada;
    }

    function extension_imagen($tipo_imagen){
        $extension="";
        switch($tipo_imagen){
            case "image/jpeg": $extension=".jpg";
            break;
            case "image/png": $extension=".png";
            break;
        }
        return $extension;
    }

    function acortarPalabras($frase){
        $words = str_word_count($frase, 2);
        $pos = array_keys($words);
        $texto = substr($frase, 0, $pos[20]) . '...';
        return $texto;
    }

    function siguienteId($tabla){
        $conexion=conectarServidor();

        $consulta_id="SELECT AUTO_INCREMENT FROM information_schema.TABLES where TABLE_SCHEMA='dogepp' and TABLE_NAME='$tabla'"; 
        $datos_id=$conexion->query($consulta_id);
        $id_siguiente=$datos_id->fetch_array(MYSQLI_ASSOC);
        $resultado=$id_siguiente['AUTO_INCREMENT'];
        return $resultado;

        $conexion->close();
    }

    function crearFooter($ruta){
        echo "
        <footer class='container-fluid py-3'>
            <div class='row'>
                <div class='col-12'>
                    <div class='container-fluid'>
                        <div class='row'>
                            <div class='col-12'>
                                <div class='container'>
                                    <div class='row'>
                                        <div class='col-md-6 col-logo'>
                                            <h2>Dogepp</h2>
                                            <h3 class='h4'>La web favorita de tu perro</h3>
                                        </div>
                                        <div class='col-md-6 col-lista'>
                                            <ul>
                                                <li><a href='$ruta/paginas/legal/aviso.html'>Aviso legal</a></li>
                                                <li><a href='$ruta/paginas/legal/cookies.html'>Política de cookies</a></li>
                                                <li><a href='$ruta/paginas/legal/privacidad.html'>Política de privacidad</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='container-fluid'>
                        <div class='row'>
                            <div class='col-12 text-center col-copyright'>
                                <small>&copy;Copyright 2022 <span>Dogepp</span>. Todos los derechos reservados</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        ";
    }

    function crearHeaderApp($ruta){
        echo "
        <header id='header_app' class='container'>
            <div class='row'>
                <div class='col-12 d-flex'>
                    <a href='$ruta/paginas/dogbook/chats.php' class='logo'>
                        <img src='../../assets/imagenes/logo.png' alt='logo' class='img-fluid'>
                    </a>     
                    <button class='rotacion'>
                        <img src='$ruta/assets/imagenes/ajustes.png' alt='ajustes' class='img-fluid'>
                        <div>
                            <div><a href='$ruta/paginas/perfil/perfil.php'>Editar perfil</a></div>



                            <form action='$ruta/paginas/acceder/acceder.php' method='POST'>
                                <div><input type='submit' name='cerrar_sesion' value='Cerrar sesión'></div>
                            </form>
                   
                    
                        </div>
                    </button>   
                </div>
            </div>
            <div class='row' id='secciones-principales'>
                <div class='col-md-4'>
                    <h2>Dogbook</h2>
                    <div>
                        <a href='$ruta/paginas/dogbook/chats.php'><h3>Chats</h3></a>
                        <a href='$ruta/paginas/dogbook/amigos.php'><h3>Amigos</h3></a>
                        <a href='$ruta/paginas/dogbook/solicitudes.php'><h3>Solicitudes</h3></a>
                    </div>
                </div>
                <div class='col-md-4'>
                <h2>Adiestradores</h2>
                    <div>
                        <a href='$ruta/paginas/adiestradores/anuncios.php'><h3>Anuncios</h3></a>
                        <a href='$ruta/paginas/adiestradores/conversaciones.php'><h3>Conversaciones</h3></a>
                    </div>
                </div>
                <div class='col-md-4'>
                <h2>City Dog</h2>
                    <div>
                    <a href='$ruta/paginas/city_dog/parques.php'><h3>Parques</h3></a>
                    <a href='$ruta/paginas/city_dog/dog_friendly.php'><h3>Dog Friendly</h3></a>
                    <a href='$ruta/paginas/city_dog/rutas.php'><h3>Rutas</h3></a>
                    </div>
                </div>
            </div>
            
        </header>
        ";
    }

    function crearHeaderEmpresa($ruta){
        echo "
        <header id='header_app' class='container'>
            <div class='row'>
                <div class='col-12 d-flex'>
                    <a href='$ruta/paginas/empresas/panel.php' class='logo'>
                        <img src='../../assets/imagenes/logo.png' alt='logo' class='img-fluid'>
                    </a>     
                    <button class='rotacion'>
                        <img src='$ruta/assets/imagenes/ajustes.png' alt='ajustes' class='img-fluid'>
                        <div>
                            <div><a href='$ruta/paginas/empresas/perfil_empresa.php'>Editar perfil</a></div>



                            <form action='$ruta/paginas/acceder/acceder.php' method='POST'>
                                <div><input type='submit' name='cerrar_sesion' value='Cerrar sesión'></div>
                            </form>
                   
                    
                        </div>
                    </button>   
                </div>
            </div>
            
        </header>
        ";
    }

    function crearHeaderAdmin($ruta){
        echo "
        <header id='header_app' class='container'>
            <div class='row'>
                <div class='col-12 d-flex'>
                    <a href='$ruta/paginas/admin/panel.php' class='logo'>
                        <img src='../../assets/imagenes/logo.png' alt='logo' class='img-fluid'>
                    </a>     
                    <button class='rotacion'>
                        <img src='$ruta/assets/imagenes/ajustes.png' alt='ajustes' class='img-fluid'>
                        <div>
                            <form action='$ruta/paginas/acceder/acceder.php' method='POST'>
                                <div><input type='submit' name='cerrar_sesion' value='Cerrar sesión'></div>
                            </form>                   
                        </div>
                    </button>   
                </div>
            </div>

            <div class='row'>
                <div class='col-12'>
                    <a class='btn boton' href='$ruta/paginas/admin/panel.php'>Usuarios</a>
                    <a class='btn boton' href='$ruta/paginas/admin/empresas.php'>Empresas</a>
                    <a class='btn boton' href='$ruta/paginas/admin/reportes.php'>Reportes</a>
                    <a class='btn boton' href='$ruta/paginas/admin/anuncios.php'>Anuncios</a>
                    <a class='btn boton' href='$ruta/paginas/admin/rutas.php'>Rutas</a>
                    <a class='btn boton' href='$ruta/paginas/admin/parques.php'>Parques</a>
                </div>
            </div>
            
        </header>
        ";
    }

?>