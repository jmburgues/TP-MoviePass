<?php

/**
 * Este action redirecciona a alguna de las 2 opciones de listar cine o listar película 
 * En caso de que el valor recibido sea modificar redirecciona al form cine-modify.php / film-modify.php
 * TO DO:
 *      Modularizar funciones de redirección. Función static. 
 */
if(isset($_POST)){
    if (isset($_POST['cine1'])) {
        echo "Cine 1";
        if ($_POST['cine1'] == "Modificar") {
            //Ver cómo pasar los datos
            require_once('cine-modify.php');
        }else{
            echo "Eliminar cine 1";
        }
    }
    if (isset($_POST['cine2'])) {
        echo "Cine 2";
        if ($_POST['cine2'] == "Modificar") {
            require_once('cine-modify.php');
        }else{
            echo "Eliminar cine 2";
        }
    }
    if (isset($_POST['cine3'])) {
        echo "Cine 3";
        if ($_POST['cine3'] == "Modificar") {
            require_once('cine-modify.php');
        }else{
            echo "Eliminar cine 3";
        }
    }

    if (isset($_POST['pelicula1'])) {
        echo "Pelicula 1";
        if ($_POST['pelicula1'] == "Modificar") {
            require_once('film-modify.php');
        }else{
            echo "Eliminar pelicula 1";
        }
    }
    if (isset($_POST['pelicula2'])) {
        echo "Pelicula 1";
        if ($_POST['pelicula1'] == "Modificar") {
            require_once('film-modify.php');
        }else{
            echo "Eliminar pelicula 1";
        }
    }
    if (isset($_POST['pelicula3'])) {
        echo "Pelicula 1";
        if ($_POST['pelicula1'] == "Modificar") {
            require_once('film-modify.php');
        }else{
            echo "Eliminar pelicula 1";
        }
    }
}


?>