<?php
/**
 * Componente Footer - Plantilla HTML reutilizable
 *
 * Genera el pie de página común para todas las páginas de la aplicación,
 * incluyendo scripts JS necesarios y derechos de autor.
 *
 * @file      Footer.php
 */


/**
 * Clase Footer para mostrar el pie de página de la aplicación
 *
 * Esta clase genera el pie de página HTML común para toda la aplicación,
 * incluyendo los scripts necesarios de Bootstrap y un script personalizado
 * para inicializar el carrusel.
 *
 * @package DAWphpapp
 * @version 1.0
 * @since 1.0
 * @author Carles Canals
 *
 */
class Footer {

   // Método para mostrar el pie de página
   public function mostrarFooter() {
        // Imprime el HTML del pie de página
        echo '<div class="footer text-center bg-dark text-white py-2">
                <p>&copy; 2023 CIFP Pau Casesnoves · Centro de Formación Profesional</p>
              </div>';

        // Imprime los scripts de Bootstrap desde su repositorio remoto y el script personalizado para activar el carrusel
        echo '<!-- Scripts de Bootstrap desde su repositorio remoto y script personalizado para activar el carrusel -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener(\'DOMContentLoaded\', function () {
    
        // Inicializar el carrusel utilizando Bootstrap
        var myCarousel = new bootstrap.Carousel(document.getElementById(\'carrusel\'), {
            interval: 2000, // Cambiar la velocidad del carrusel (en milisegundos)
            wrap: true // Repetir el carrusel al llegar al final
        });
    });
</script>';
        
        // Cierra la etiqueta </body> y </html>
        echo '</body></html>';
    }
}

// Crea una instancia del pie de página y lo muestra
/** @var Footer $footer */
$footer = new Footer();

// Muestra pie de página
/** @see Footer::mostrarFooter()*/
$footer->mostrarFooter();

?>
