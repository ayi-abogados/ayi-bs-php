<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    echo "<script>window.parent.postMessage('closeModal', '*');</script>";
    exit;
}

require_once "config/database.php";
mysqli_set_charset($conn, "utf8mb4");

// Obtener la página del parámetro GET o usar la última página editada
$lastPage = isset($_GET['page']) ? $_GET['page'] : 'index';
$userId = $_SESSION["id"];

// Actualizar la última página en la base de datos
$stmt = $conn->prepare("INSERT INTO user_state (user_id, last_page) VALUES (?, ?) ON DUPLICATE KEY UPDATE last_page = VALUES(last_page)");
$stmt->bind_param("is", $userId, $lastPage);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <style>
        .bg-primary { background-color: #b32424; }
        .hover\:bg-primary-dark:hover { background-color: #9b1f1f; }
        .text-primary { color: #f03c02; }
        body { 
            margin: 0; 
            padding: 0;
            overflow-x: hidden;
        }
        .h-screen { height: 100vh; }

        /* Sidebar styles */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        
        /* Editor styles */
        #editor-container .ql-editor {
            min-height: 500px;
            font-size: 16px;
        }
        .ql-toolbar.ql-snow {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            position: sticky;
            top: 0;
            background: white;
            z-index: 10;
        }
        .ql-container.ql-snow {
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                z-index: 40;
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            #editor-container {
                margin: 0.5rem;
            }
            .ql-toolbar.ql-snow {
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="sidebar w-64 bg-primary text-white">
            <br/>
            <div style="display: flex; justify-content: center; align-items: center;">
                <img src="../assets/img/logo-dash.jpg" style="width: 150px; box-shadow: 4px 4px 20px rgba(0, 0, 0, 0.5);">
            </div>
            <div class="p-4" style="text-align: center;">
                <h2 class="text-2xl font-bold">Panel de Administración</h2>
            </div>
            <nav class="mt-4" style="text-align: center;">
                <?php
                $pages = [
                    'index' => 'Inicio',
                    'about' => 'Acerca',
                    'services' => 'Servicios',
                    'testimonials' => 'Testimonios',
                    'faqs' => 'FAQs',
                    'contact' => 'Contacto'
                ];
                
                foreach ($pages as $slug => $title) {
                    $activeClass = $slug === $lastPage ? 'bg-primary-dark' : '';
                    echo "<a href='#' onclick='loadPage(\"$slug\")' class='block py-2 px-4 hover:bg-primary-dark transition-colors duration-200 $activeClass'>$title</a>";
                }
                ?>
                <a href="#" onclick="logout()" class="block py-2 px-4 hover:bg-primary-dark mt-4 text-white font-semibold">Cerrar Sesión</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-1 overflow-y-auto p-4">
            <!-- Toggle Sidebar Button (visible on mobile) -->
            <button id="sidebarToggle" class="md:hidden bg-primary text-white p-2 rounded mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            
            <div id="editor-container" class="bg-white rounded-lg shadow p-6">
                <h2 id="page-title" class="text-2xl font-bold mb-4 text-primary">Selecciona una página para editar</h2>
                <div id="editor-wrapper" class="hidden">
                    <textarea id="content" name="content"></textarea>
                    <div class="mt-4 flex justify-end">
                        <button onclick="savePage()" class="bg-primary text-white px-6 py-2 rounded hover:bg-primary-dark transition-colors duration-200">
                            Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    let currentPage = '<?php echo $lastPage; ?>';
    let editor = null;

    // Inicializar CKEditor
    CKEDITOR.replace('content', {
        height: 500,
        removePlugins: 'about,maximize,showblocks,print,preview,find,flash,iframe,newpage,pagebreak,save,selectall,smiley,specialchar,templates',
        removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor,Strike,Subscript,Superscript',
        toolbarGroups: [
            { name: 'basicstyles', groups: ['basicstyles'] },
            { name: 'paragraph', groups: ['list'] },
            { name: 'styles' },
            { name: 'colors' }
        ],
        allowedContent: true,
        extraAllowedContent: 'i(*)[*]{*}; div(*)[*]{*}',
        entities: false,
        basicEntities: false,
        entities_latin: false,
        entities_greek: false,
        protectedSource: [/<i[^>]*><\/i>/g],
        filebrowserUploadUrl: 'upload_image.php',
        filebrowserUploadMethod: 'form'
    });

    // Cargar la última página al iniciar
    document.addEventListener('DOMContentLoaded', function() {
        if (currentPage) {
            loadPage(currentPage);
        }
    });

    function loadPage(slug) {
        currentPage = slug;
        fetch('get_page_content.php?slug=' + slug)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('page-title').textContent = data.title;
                    let content = data.content;
                    CKEDITOR.instances.content.setData(content);
                    document.getElementById('editor-wrapper').classList.remove('hidden');
                    
                    // Guardar el estado actual
                    fetch('save_state.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            last_page: slug
                        })
                    });
                    
                    // Actualizar clase activa en el menú
                    document.querySelectorAll('nav a').forEach(link => {
                        if (link.getAttribute('onclick')?.includes(slug)) {
                            link.classList.add('bg-primary-dark');
                        } else {
                            link.classList.remove('bg-primary-dark');
                        }
                    });
                } else {
                    alert('Error al cargar la página: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar la página');
            });
    }

    function savePage() {
        const editor = CKEDITOR.instances.content;
        const content = editor.getData();

        const formData = new FormData();
        formData.append('content', content);
        formData.append('slug', currentPage);

        fetch('save_page.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Enviar mensaje al padre para cerrar el modal y recargar
                window.parent.postMessage('closeModal', '*');
                // Esperar un momento antes de recargar para que el modal se cierre suavemente
                setTimeout(() => {
                    window.parent.location.reload();
                }, 500);
            } else {
                alert('Error al guardar: ' + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al guardar los cambios');
        });
    }

    function logout() {
        fetch('logout.php')
            .then(() => {
                window.parent.postMessage('closeModal', '*');
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Agregar el código del sidebar toggle
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('active');
    });
    </script>
</body>
</html>
