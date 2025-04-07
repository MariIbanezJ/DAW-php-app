<?php
/**
 * Gestor de conexiones a base de datos MySQL
 *
 * Implementa el patrón Singleton para manejar conexiones a la BD.
 * Configuración centralizada para toda la aplicación.
 *
 * @file      Connexio.php
 */




/**
 * Gestiona la conexión a la base de datos `la_meva_botiga` utilizando `mysqli`.
 * Esta clase proporciona una función público para obtener la conexión activa,
 * usada en múltiples partes de la aplicación.
 *
 * @package DAWphpapp
 * @version 1.0
 * @since 1.0
 * @author Carles Canals
 *
 * @see mysqli
 */
class Connexio
{
    /**
     * Nombre del host de la base de datos
     * @var string
     */
    private $host = "localhost";
    /**
     * Nombre de usuario para acceder a la base de datos
     * @var string
     */
    private $usuario = "root";

    /**
     * Contraseña del usuario de la base de datos
     * @var string
     */
    private $contraseña = "";

    /**
     * Nombre de la base de datos a la que se conecta
     * @var string
     */
    private $baseDatos = "la_meva_botiga";

    /**
     * Establece y devuelve una conexión activa con la base de datos
     *
     * Crea una nueva instancia de `mysqli` utilizando los parámetros definidos en la clase.
     * Si ocurre un error de conexión, se detiene la ejecución con un mensaje de error.
     *
     * @return mysqli Conexión activa a la base de datos
     */
    public function obtenirConnexio()
    {
        $conexion = new mysqli($this->host, $this->usuario, $this->contraseña, $this->baseDatos);

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        return $conexion;
    }
}

?>
