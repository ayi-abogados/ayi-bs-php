<?php
// Inicializar la sesión
session_start();

// Destruir todas las variables de sesión
$_SESSION = array();

// Destruir la cookie de sesión si existe
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destruir la sesión
session_destroy();

// Script para cerrar el modal y recargar la página
echo "<script>
    try {
        // Enviar mensaje al padre inmediato (el modal)
        window.parent.postMessage('closeModal', '*');
        
        // También intentar recargar la página padre
        setTimeout(function() {
            window.parent.location.reload();
        }, 500);
    } catch(e) {
        console.log('Error:', e);
        // Si falla, redirigir a la página principal
        window.location.href = '../index.php';
    }
</script>";
exit;
?>
