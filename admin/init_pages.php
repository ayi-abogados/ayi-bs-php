<?php
require_once "config/database.php";

$pages = [
    ['file' => 'index.html', 'title' => 'Inicio', 'slug' => 'index'],
    ['file' => 'about.html', 'title' => 'Acerca', 'slug' => 'about'],
    ['file' => 'services.html', 'title' => 'Servicios', 'slug' => 'services'],
    ['file' => 'testimonials.html', 'title' => 'Testimonios', 'slug' => 'testimonials'],
    ['file' => 'faqs.html', 'title' => 'FAQs', 'slug' => 'faqs'],
    ['file' => 'contact.html', 'title' => 'Contacto', 'slug' => 'contact']
];

foreach ($pages as $page) {
    $filename = "../" . $page['file'];
    if (file_exists($filename)) {
        $content = file_get_contents($filename);
        
        // Check if page already exists
        $stmt = $conn->prepare("SELECT id FROM pages WHERE slug = ?");
        $stmt->bind_param("s", $page['slug']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            // Insert new page
            $stmt = $conn->prepare("INSERT INTO pages (title, content, slug) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $page['title'], $content, $page['slug']);
            $stmt->execute();
            echo "Added page: " . $page['title'] . "<br>";
        } else {
            echo "Page already exists: " . $page['title'] . "<br>";
        }
    }
}

echo "Done initializing pages!";
?>
