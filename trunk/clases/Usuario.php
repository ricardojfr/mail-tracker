<?php
/**
 * Clase para el manejo de Usuario.
 *
 * @author Ricardo Ramirez, <ricardojfr@gmail.com>
 * @access public
 */
class Usuario {
    // --- ATRIBUTOS ---

    /**
     * El identificador del usuario
     *
     * @access public
     * @var Integer
     */
    public $idUsuario = null;

    /**
     * El identificador de la persona a quien pertence el usuario.
     *
     * @access public
     * @var Integer
     */
    public $idPersona = null;

    /**
     * El identificador del tipo de usuario
     *
     * @access public
     * @var Integer
     */
    public $idTipoUsuario = null;

    /**
     * La fecha de registro del usuario
     *
     * @access public
     * @var String
     */
    public $fechaRegistro = null;

    /**
     * El login de usuario
     *
     * @access public
     * @var String
     */
    public $login = null;

    /**
     * La clave de acceso del usuario
     *
     * @access public
     * @var String
     */
    public $clave = null;

    /**
     * Define si el usuario esta activo o inactivo para el uso del sistema.
     *
     * @access public
     * @var Boolean
     */
    public $activo = null;

    // --- OPERACIONES ---

    /**
     * Constructor para poder definir los valores de un nuevo usuario
     *
     * @access public
     * @param  Array $usuario Arreglo con los datos del usuario
     * @return void
     */
    public function __construct($usuario = NULL)
    {
        if (is_array($usuario)) {
            $this->idUsuario = (isset($usuario['id_usuario']) ? $usuario['id_usuario'] : NULL);
            $this->idEmpleado = $usuario['id_empleado'];
            $this->idTipoUsuario = $usuario['id_tipo_usuario'];
            $this->fechaRegistro = (isset($usuario['fecha_registro']) ? $usuario['fecha_registro'] : NULL);
            $this->login = $usuario['login'];
            $this->clave = (isset($usuario['clave']) ? $usuario['clave'] : NULL);
            $this->activo = $usuario['activo'];
        }
    }

    /**
     * Si un identificador de usuario es provisto, se cargan los datos del
     * usuario en el objeto, si no, se devuelve un array con los datos de todos
     * los usuarios registrados en el sistema.
     *
     * @access public
     * @param  Integer $idUsuario Opcional. El identificador del usuario para consultar datos.
     * @return Array
     */
    public function consultarUsuario($idUsuario = NULL)
    {
        $datosUsuario = NULL;

        $consulta = "SELECT * FROM usuario";

        if (isset($idUsuario)) {
            $consulta .= " WHERE id_usuario = $idUsuario";

            $resultado = pg_query($consulta);

            $datosUsuario = pg_fetch_assoc($resultado);

            /**
             * Llenando el objeto usuario.
             */
            $this->idUsuario = $datosUsuario['id_usuario'];
            $this->idEmpleado = $datosUsuario['id_empleado'];
            $this->idTipoUsuario = $datosUsuario['id_tipo_usuario'];
            $this->fechaRegistro = $datosUsuario['fecha_registro'];
            $this->login = $datosUsuario['login'];
            $this->clave = $datosUsuario['clave'];
            $this->activo = $datosUsuario['activo'];
        }
        else {
            $consulta .= " ORDER BY id_usuario";

            $resultado = pg_query($consulta);

            $datosUsuario = pg_fetch_all($resultado);
        }

        /**
         * Retornando array de datos por si se desea utilizar de otra forma.
         */
        return $datosUsuario;
    }

    /**
     * Registra los datos de un nuevo usuario.
     *
     * @access public
     * @return Boolean
     */
    public function registrarUsuario()
    {
        $ok = TRUE;

        $c_registrar = "INSERT INTO usuario VALUES (DEFAULT, " . $this->idPersona . ", " . $this->idTipoUsuario . ", LOCALTIMESTAMP(0), '" . $this->login . "', md5('" . $this->clave . "'), '" . $this->activo . "')";
        $r_registrar = pg_query($c_registrar);

        if (!$r_registrar) {
            $ok = FALSE;
        }

        return $ok;
    }

    /**
     * Modifica los datos del usuario con el id de usuario cargado en el objeto.
     *
     * @access public
     * @return Boolean
     */
    public function modificarUsuario()
    {
        $ok = TRUE;
        $clave = NULL;

        if (isset($this->clave)) {
            $clave = "clave = md5('" . $this->clave . "'),";
        }

        $c_modificar = "UPDATE usuario SET id_persona = " . $this->idPersona . ", id_tipo_usuario = " . $this->idTipoUsuario . ", login = '" . $this->login . "', $clave activo = '" . $this->activo . "' WHERE id_usuario = " . $this->idUsuario;
        $r_modificar = pg_query($c_modificar);

        if (!$r_modificar) {
            $ok = FALSE;
        }

        return $ok;
    }

    /**
     * Elimina los datos de un usuario.
     *
     * @access public
     * @param  Integer $idUsuario El identificador del usuario a eliminar.
     * @return Boolean
     */
    public function eliminarUsuario($idUsuario)
    {
        $ok = TRUE;

        /**
         * Comprobando si el usuario tiene alguna asociacion con encabezado_factura,
         * historial_inventario, historial_sesion, nota_credito_debito u orden_produccion .
         */
        $c_facturas = "SELECT 1 FROM encabezado_factura WHERE id_usuario = " . $idUsuario;
        $r_facturas = pg_num_rows(pg_query($c_facturas));

        $c_historial_inventario = "SELECT 1 FROM historial_inventario WHERE id_usuario = " . $idUsuario;
        $r_historial_inventario = pg_num_rows(pg_query($c_historial_inventario));

        $c_historial_sesion = "SELECT 1 FROM historial_sesion WHERE id_usuario = " . $idUsuario;
        $r_historial_sesion = pg_num_rows(pg_query($c_historial_sesion));

        $c_nota_cd = "SELECT 1 FROM nota_credito_debito WHERE id_usuario = " . $idUsuario;
        $r_nota_cd = pg_num_rows(pg_query($c_nota_cd));

        $c_orden_produccion = "SELECT 1 FROM orden_produccion WHERE id_usuario = " . $idUsuario;
        $r_orden_produccion = pg_num_rows(pg_query($c_orden_produccion));

        if ($r_facturas == 0 && $r_historial_inventario == 0 && $r_historial_sesion == 0
            && $r_nota_cd == 0 && $r_orden_produccion == 0) {
            $c_eliminar = "DELETE FROM usuario WHERE id_usuario = " . $idUsuario;
            $r_eliminar = pg_query($c_eliminar);

            if (!$r_eliminar) {
                $ok = FALSE;
            }
        }
        else {
            throw new Exception("El usuario que intenta eliminar tiene registros que lo referencian.");
        }

        return $ok;
    }

    /**
     * Devuelve array con todos los usuarios registrados en el sistema.
     *
     * @access public
     * @return Array
     */
    public function listarUsuarios()
    {
        /**
         * Llamamos a la consulta de usuario sin parametros para que devuelta todos.
         */
        return $this->consultarUsuario();
    }

    /**
     * Devuelve informacion solicitada de la tabla usuario.
     *
     * @access public
     * @return String
     */
    function obtenerInfo($info, $campo, $valor_campo)
    {
        $q_info_usuario = "SELECT $info AS info FROM usuario us INNER JOIN tipo_usuario tu USING(id_tipo_usuario) INNER JOIN persona pe ON pe.id_empleado = us.id_persona WHERE $campo = '$valor_campo'";
        $rs_info_usuario = pg_query($q_info_usuario);

        if (pg_num_rows($rs_info_usuario) > 0) {
            $rg_info = pg_fetch_array($rs_info_usuario);
            return $rg_info['info'];
        }
        else {
            return FALSE;
        }
    }
}
?>