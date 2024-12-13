<?php
require_once "config/database.php";

// Establecer la codificación de caracteres
mysqli_set_charset($conn, "utf8mb4");

// Contenido original del carrusel
$carouselContent = '<main class="main">
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
              <a href="#featured-services" class="btn-get-started">Acerca</a>
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
              <a href="#featured-services" class="btn-get-started">Acerca</a>
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
              <a href="#featured-services" class="btn-get-started">Acerca</a>
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
      <!-- /Hero Section -->

      <hr class="red-line" />';

// Actualizar la base de datos con el contenido original
$stmt = $conn->prepare("UPDATE pages SET content = ? WHERE slug = 'index'");
$stmt->bind_param("s", $carouselContent);

if ($stmt->execute()) {
    echo "Carrusel restaurado exitosamente";
} else {
    echo "Error al restaurar el carrusel: " . $conn->error;
}
?>
