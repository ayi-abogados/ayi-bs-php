<?php
session_start();
require_once "admin/config/database.php";

// Establecer la codificación de caracteres
mysqli_set_charset($conn, "utf8mb4");

// Obtener el contenido de la base de datos
$stmt = $conn->prepare("SELECT content FROM pages WHERE slug = 'contact'");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Error: No se encontró el contenido en la base de datos");
}

$dynamicContent = $row['content'];

// Verificar que el contenido no esté vacío
if (empty($dynamicContent)) {
    die("Error: El contenido está vacío");
}

// Obtener el template
$htmlTemplate = file_get_contents('contact.html');

// Definir el estilo del enlace con el color rojo específico
$style = '<style>
.admin-link { color: #f03c02 !important; } 
.admin-link:hover { color: #9b1f1f !important; }
/* Modal de Login */
#loginModal .modal-dialog {
    max-width: 450px;
}
#loginModal .modal-content {
    margin: 1.75rem auto;
}
/* Modal de Dashboard */
#dashboardModal .modal-dialog {
    max-width: 95%;
    height: 90vh;
}
#dashboardModal .modal-content {
    height: 100%;
}
#dashboardModal .modal-body {
    padding: 0;
}
.modal-iframe {
    width: 100%;
    border: none;
}
#loginFrame {
    height: 450px;
}
#dashboardFrame {
    height: calc(90vh - 60px); /* 60px es el alto del header del modal */
}
</style>';
$htmlTemplate = str_replace('</head>', $style . '</head>', $htmlTemplate);

// Agregar el enlace al dashboard con atributos para el modal
$dashboardLink = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true
    ? '<a href="#" class="admin-link" data-bs-toggle="modal" data-bs-target="#dashboardModal" onclick="loadAdminContent(\'dashboard\')">Dashboard</a>'
    : '<a href="#" class="admin-link" data-bs-toggle="modal" data-bs-target="#loginModal" onclick="loadAdminContent(\'login\')">Admin</a>';

// Agregar los modales al final del body
$modalHtml = <<<HTML
    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Inicio de Sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="loginFrame" class="modal-iframe" src=""></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Modal -->
    <div class="modal fade" id="dashboardModal" tabindex="-1" aria-labelledby="dashboardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dashboardModalLabel">Panel de Administración</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="dashboardFrame" class="modal-iframe" src=""></iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
    function loadAdminContent(type) {
        if (type === 'login') {
            document.getElementById('loginFrame').src = 'admin/login.php';
        } else {
            document.getElementById('dashboardFrame').src = 'admin/dashboard.php?page=contact';
        }
    }
    
    // Manejar mensajes para cerrar modales y recargar
    window.addEventListener('message', function(event) {
        if (event.data === 'loginSuccess') {
            // Cerrar el modal de login
            const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
            if (loginModal) {
                loginModal.hide();
                // Recargar la página después de cerrar el modal
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }
        } else if (event.data === 'closeModal') {
            // Cerrar el modal del dashboard
            const dashboardModal = bootstrap.Modal.getInstance(document.getElementById('dashboardModal'));
            if (dashboardModal) {
                dashboardModal.hide();
                // Recargar la página después de cerrar el modal
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }
        }
    });
    </script>
HTML;

// Insertar el modal antes del cierre del body
$htmlTemplate = str_replace('</body>', $modalHtml . '</body>', $htmlTemplate);

// Insertar el enlace justo después de Contacto en la misma línea
$htmlTemplate = preg_replace(
    '/(<li><a href="contact\.php" class="active">Contacto<\/a><\/li>)/',
    '$1' . $dashboardLink,
    $htmlTemplate
);

// Buscar el contenedor main y reemplazar su contenido
if (preg_match('/<main class="main">(.*?)<\/main>/s', $htmlTemplate, $matches)) {
    $newContent = '<main class="main">' . $dynamicContent . '</main>';
    $htmlTemplate = str_replace($matches[0], $newContent, $htmlTemplate);
}

// Imprimir el HTML final
echo $htmlTemplate;
?>
