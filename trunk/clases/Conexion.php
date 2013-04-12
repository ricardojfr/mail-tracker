<?php
/**
 * Conexion
 *
 * Clase para manejar la conexion con la base de datos
 *
 * @author Ricardo Ramirez <ricardojfr@gmail.com>
 * @copyright 2012 n3dev
 * @license http://www.n3dev.net/licencia/lic.txt PHP License 3.01
 */
class Conexion {
    /**
     * Almacena el objeto de la base de datos
     *
     * @var string Objeto de la base de datos
     */
    protected $bd;
    
    /**
     * Verifica si ya existe una conexion a la bd o crea un nueva conexion.
     *
     * @param object $bdo Objeto de la base de datos
     * @return void
     */
    protected function __construct($bdo = NULL)
    {
        if ( is_object($bd) )
        {
            $this->bd = $bd;
        }
        else
        {
            //Constantes son definidas en /sistema/configuracion/credenciales-bd.inc.php
            $dsn = "pgsql:host=" . HOST_BD . ";dbname=" . NOMBRE_BD;
            try
            {
                $this->bd = new PDO($dsn, USUARIO_BD, CLAVE_BD);
            }
            catch ( Exception $e )
            {
                //Si la conexion falla, se envia error.
                die ( $e->getMessage() );
            }
        }
        
    }

}
?>