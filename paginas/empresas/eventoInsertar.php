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
 
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    require_once("../../php/funciones.php");
    
    $conexion=conectarServidor();

    $nombre=trim($_POST['nombre']);
    $descripcion=trim($_POST['descripcion']);
    $imagen=trim($_POST['imagen']);
    $localizacion=trim($_POST['localizacion']);
    $fecha=trim($_POST['fecha']);
    $id_empresa=$_SESSION["cif"];

    $consulta_insercion="INSERT INTO evento values (null,?,?,?,?,?,?)";
    $resultado_insercion=$conexion->prepare($consulta_insercion);

    

    $resultado_insercion->bind_param("ssssss", $nombre, $imagen, $descripcion, $localizacion, $fecha, $id_empresa);
    $resultado_insercion->execute();
    echo "$conexion->insert_id";
    $resultado_insercion->close();
    $conexion->close();

   
 ?>