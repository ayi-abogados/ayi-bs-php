<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Definir el estilo del enlace con el color rojo específico
$style = '<style>
.admin-link { color: #f03c02 !important; } 
.admin-link:hover { color: #9b1f1f !important; }

/* Modal de Login */
#loginModal .modal-dialog {
    max-width: 450px;
    margin: 1.75rem auto;
}

/* Modal de Dashboard */
#dashboardModal .modal-dialog {
    max-width: 95%;
    height: 90vh;
    margin: 1rem auto;
}

#dashboardModal .modal-content {
    height: 100%;
    border-radius: 0.5rem;
}

#dashboardModal .modal-body {
    padding: 0;
    height: calc(100% - 56px);
    overflow: hidden;
}

#dashboardFrame {
    width: 100%;
    height: 100%;
    border: none;
}

/* Responsive styles */
@media (max-width: 768px) {
    #dashboardModal .modal-dialog {
        max-width: 100%;
        height: 100vh;
        margin: 0;
    }
    
    #dashboardModal .modal-content {
        height: 100vh;
        border-radius: 0;
    }

    #dashboardModal .modal-body {
        height: calc(100vh - 56px);
    }

    #dashboardFrame {
        height: 100%;
    }
}

@media (max-width: 480px) {
    #loginModal .modal-dialog {
        max-width: 100%;
        margin: 0.5rem;
    }
}
</style>';

// Agregar el enlace al dashboard con atributos para el modal
$dashboardLink = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true
    ? '<li><a href="#" class="admin-link" data-bs-toggle="modal" data-bs-target="#dashboardModal" onclick="loadAdminContent(\'dashboard\')">Dashboard</a></li>'
    : '<li><a href="#" class="admin-link" data-bs-toggle="modal" data-bs-target="#loginModal" onclick="loadAdminContent(\'login\')">Admin</a></li>';

// Modal HTML
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
            document.getElementById('dashboardFrame').src = 'admin/dashboard.php';
        }
    }
    
    // Manejar la respuesta del iframe para cerrar el modal
    window.addEventListener('message', function(event) {
        if (event.data === 'closeModal') {
            const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
            const dashboardModal = bootstrap.Modal.getInstance(document.getElementById('dashboardModal'));
            
            if (loginModal) loginModal.hide();
            if (dashboardModal) dashboardModal.hide();
            
            // Recargar la página para actualizar el estado de la sesión
            window.location.reload();
        }
    });

    // Ajustar el tamaño del iframe cuando cambia el tamaño de la ventana
    window.addEventListener('resize', function() {
        const dashboardFrame = document.getElementById('dashboardFrame');
        if (dashboardFrame) {
            const modalBody = dashboardFrame.closest('.modal-body');
            if (modalBody) {
                dashboardFrame.style.height = modalBody.clientHeight + 'px';
            }
        }
    });
    </script>
HTML;
