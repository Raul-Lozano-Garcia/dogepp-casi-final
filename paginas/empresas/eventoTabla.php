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

	//Cabeceras
	header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
	require_once("../../php/funciones.php");
    
    $conexion=conectarServidor();
    
    $datos=[];
    $sentencia=$conexion->query("SELECT * FROM evento WHERE id_empresa='$_SESSION[cif]'");

    if($sentencia->num_rows>0){

        while($fila=$sentencia->fetch_array(MYSQLI_ASSOC)){ 
        	$datos[]=$fila;
        }
    
        echo json_encode($datos);

    }

    $conexion->close();
 ?>