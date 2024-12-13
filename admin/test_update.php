<?php
require_once "config/database.php";

// El contenido exacto que queremos para la sección del hero
$heroContent = '<main class="main">
      <!-- Hero Section -->
      <section id="hero" class="hero section dark-background">
        <div
          id="hero-carousel"
          class="carousel slide carousel-fade"
          data-bs-ride="carousel"
          data-bs-interval="5000"
        >
          <div class="carousel-item active">
            <img src="assets/img/hero-carousel/hero-carousel-1.jpg" alt="" />
            <div class="container">
              <h2>Asesoría Legal Integral</h2>
              <p>
                "Brindamos orientación y soluciones en todas las ramas del
                derecho, garantizando una representación sólida y confiable en
                cada etapa del proceso legal."
              </p>
              <a href="#services" class="btn-get-started">Acerca</a>
            </div>
          </div>
          <!-- End Carousel Item -->

          <div class="carousel-item">
            <img src="assets/img/hero-carousel/hero-carousel-2.jpg" alt="" />
            <div class="container">
              <h2>Defensa y Representación Efectiva</h2>
              <p>
                "Protegemos tus derechos con un enfoque estratégico y
                personalizado, adaptándonos a las necesidades de cada caso y
                área legal, tanto en litigios como en negociaciones."
              </p>
              <a href="#services" class="btn-get-started">Acerca</a>
            </div>
          </div>
          <!-- End Carousel Item -->

          <div class="carousel-item">
            <img src="assets/img/hero-carousel/hero-carousel-3.jpg" alt="" />
            <div class="container">
              <h2>Experiencia en Todas las Áreas del Derecho</h2>
              <p>
                "Con profundo conocimiento en derecho civil, penal, laboral,
                empresarial, extranjería, inmigración y más, estamos preparados
                para ofrecer una defensa integral y asesoramiento completo en
                cualquier ámbito jurídico."
              </p>
              <a href="#services" class="btn-get-started">Acerca</a>
            </div>
          </div>
          <!-- End Carousel Item -->

          <a
            class="carousel-control-prev"
            href="#hero-carousel"
            role="button"
            data-bs-slide="prev"
          >
            <span
              class="carousel-control-prev-icon bi bi-chevron-left"
              aria-hidden="true"
            ></span>
          </a>

          <a
            class="carousel-control-next"
            href="#hero-carousel"
            role="button"
            data-bs-slide="next"
          >
            <span
              class="carousel-control-next-icon bi bi-chevron-right"
              aria-hidden="true"
            ></span>
          </a>

          <ol class="carousel-indicators"></ol>
        </div>
      </section>
      <!-- /Hero Section -->';

// Obtener el contenido actual
$stmt = $conn->prepare("SELECT content FROM pages WHERE slug = 'index'");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$currentContent = $row['content'];

// Reemplazar solo la sección del hero
$pattern = '/<section id="hero".*?<!-- \/Hero Section -->/s';
preg_match($pattern, $currentContent, $matches);

if ($matches) {
    // Reemplazar la sección del hero manteniendo el resto del contenido
    $newContent = preg_replace($pattern, $heroContent, $currentContent);
    
    // Actualizar en la base de datos
    $stmt = $conn->prepare("UPDATE pages SET content = ? WHERE slug = 'index'");
    $stmt->bind_param("s", $newContent);
    
    if ($stmt->execute()) {
        echo "Contenido del hero actualizado exitosamente.<br>";
        
        // Verificar los enlaces en el contenido actualizado
        echo "<h3>Enlaces en el contenido actualizado:</h3>";
        preg_match_all('/<a href="([^"]*)" class="btn-get-started">Acerca<\/a>/', $newContent, $matches);
        echo "<pre>";
        print_r($matches[1]);
        echo "</pre>";
    } else {
        echo "Error al actualizar el contenido: " . $conn->error;
    }
} else {
    echo "No se encontró la sección del hero en el contenido actual";
}
?>
