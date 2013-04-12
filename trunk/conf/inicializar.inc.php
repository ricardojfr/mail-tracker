<?php

/**
 * Archivo para inicializar todo lo necesario para el funcionamiento de la aplicacion
 *
 * Se cargaran todas las constantes necesarias, se creara el objeto de conexion
 * con la BD, y se definira una funcion para la carga automatica de las clases. 
 *
 * @author Ricardo Ramirez <ricardojfr@gmail.com>
 * @copyright 2012 n3dev
 * @license http://www.n3dev.net/licencia/lic.txt PHP License 3.01
 */

/**
 * Incluyendo configuracion de la BD/
 */
include_once './credenciales-bd.inc.php';

/**
 * Definiendo las constantes
 */
foreach ( $C as $nombre => $valor )
{
    define($nombre, $valor);
}

/**
 * Creando el objeto PDO
 */
$dsn = "pgsql:host=" . HOST_BD . ";dbname=" . NOMBRE_BD;
$bdo = new PDO($dsn, USUARIO_BD, CLAVE_BD);
 
/**
 * Definiendo la funcion de carga automatica de clases.
 */
function __autoload($clase)
{
    $fichero = "../clases/class." . strtolower($clase) . ".inc.php";
    if ( file_exists($fichero) )
    {
        include_once $fichero;
    }
}
?>
