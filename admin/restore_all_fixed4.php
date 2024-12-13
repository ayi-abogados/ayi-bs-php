<?php
require_once "config/database.php";

// Establecer la codificación de caracteres
mysqli_set_charset($conn, "utf8mb4");

// Contenido completo de la página principal
$mainContent = '      <!-- Hero Section -->
      <section id="hero" class="hero section dark-background">
        <div
          id="hero-carousel"
          class="carousel slide"
          data-bs-ride="carousel"
          data-bs-interval="5000"
        >
          <div class="carousel-inner">
            <!-- Carousel Item 1 -->
            <div class="carousel-item active">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-lg-8 text-center">
                    <h2 class="animate__animated animate__fadeInDown">
                      Experiencia y Compromiso en Derecho
                    </h2>
                    <p class="animate__animated animate__fadeInUp">
                      "En AYI Abogados, combinamos años de experiencia con un
                      profundo conocimiento del sistema jurídico y procesal del
                      derecho, garantizando una representación sólida y confiable en
                      cada etapa del proceso legal."
                    </p>
                    <a href="#services" class="btn-get-started">Acerca</a>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Carousel Item -->

            <!-- Carousel Item 2 -->
            <div class="carousel-item">
              <div class="container">
                <div class="col-lg-8 text-center">
                  <h2 class="animate__animated animate__fadeInDown">
                    Servicio Legal Integral
                  </h2>
                  <p class="animate__animated animate__fadeInUp">
                    "Ofrecemos un servicio legal integral con un enfoque
                    personalizado, adaptándonos a las necesidades de cada caso y
                    área legal, tanto en litigios como en negociaciones."
                  </p>
                  <a href="#services" class="btn-get-started">Acerca</a>
                </div>
              </div>
            </div>
            <!-- End Carousel Item -->

            <!-- Carousel Item 3 -->
            <div class="carousel-item">
              <div class="container">
                <div class="col-lg-8 text-center">
                  <h2 class="animate__animated animate__fadeInDown">
                    Equipo Multidisciplinario
                  </h2>
                  <p class="animate__animated animate__fadeInUp">
                    "Nuestro equipo multidisciplinario trabaja en colaboración
                    para ofrecer una defensa integral y asesoramiento completo en
                    cualquier ámbito jurídico."
                  </p>
                  <a href="#services" class="btn-get-started">Acerca</a>
                </div>
              </div>
            </div>
            <!-- End Carousel Item -->
          </div>

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
        </div>
      </section>
      <!-- /Hero Section -->

      <hr class="red-line" />

      <!-- Services Section -->
      <section id="services" class="services section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Servicios</h2>
          <p>
            Ofrecemos servicios legales integrales en diversas áreas del derecho,
            con un enfoque personalizado y compromiso con la excelencia.
          </p>
        </div>
        <!-- End Section Title -->

        <div class="container">
          <div class="row gy-4">
            <div
              class="col-lg-6"
              data-aos="fade-up"
              data-aos-delay="100"
            >
              <div class="service-item d-flex">
                <div class="icon flex-shrink-0">
                  <i class="bi bi-briefcase"></i>
                </div>
                <div>
                  <h4 class="title">
                    <a href="#" class="stretched-link"
                      >Derecho Civil y Comercial</a
                    >
                  </h4>
                  <p class="description">
                    Asesoramiento integral en contratos, responsabilidad civil,
                    derechos reales y litigios comerciales.
                  </p>
                </div>
              </div>
            </div>
            <!-- End Service Item -->

            <div
              class="col-lg-6"
              data-aos="fade-up"
              data-aos-delay="200"
            >
              <div class="service-item d-flex">
                <div class="icon flex-shrink-0">
                  <i class="bi bi-card-checklist"></i>
                </div>
                <div>
                  <h4 class="title">
                    <a href="#" class="stretched-link"
                      >Derecho Laboral</a
                    >
                  </h4>
                  <p class="description">
                    Representación en conflictos laborales, negociaciones y
                    asesoría en cumplimiento normativo.
                  </p>
                </div>
              </div>
            </div>
            <!-- End Service Item -->

            <div
              class="col-lg-6"
              data-aos="fade-up"
              data-aos-delay="300"
            >
              <div class="service-item d-flex">
                <div class="icon flex-shrink-0">
                  <i class="bi bi-bar-chart"></i>
                </div>
                <div>
                  <h4 class="title">
                    <a href="#" class="stretched-link"
                      >Derecho Corporativo</a
                    >
                  </h4>
                  <p class="description">
                    Asesoramiento en constitución de empresas, fusiones,
                    adquisiciones y gobierno corporativo.
                  </p>
                </div>
              </div>
            </div>
            <!-- End Service Item -->

            <div
              class="col-lg-6"
              data-aos="fade-up"
              data-aos-delay="400"
            >
              <div class="service-item d-flex">
                <div class="icon flex-shrink-0">
                  <i class="bi bi-binoculars"></i>
                </div>
                <div>
                  <h4 class="title">
                    <a href="#" class="stretched-link"
                      >Derecho Administrativo</a
                    >
                  </h4>
                  <p class="description">
                    Representación ante entidades públicas y gestión de
                    procedimientos administrativos.
                  </p>
                </div>
              </div>
            </div>
            <!-- End Service Item -->
          </div>
        </div>
      </section>
      <!-- End Services Section -->

      <!-- Clients Section -->
      <section id="clients" class="clients">
        <div class="container" data-aos="zoom-out">
          <div class="clients-slider swiper">
            <div class="swiper-wrapper align-items-center">
              <div class="swiper-slide">
                <img
                  src="assets/img/clients/client-1.png"
                  class="img-fluid"
                  alt=""
                />
              </div>
              <div class="swiper-slide">
                <img
                  src="assets/img/clients/client-2.png"
                  class="img-fluid"
                  alt=""
                />
              </div>
              <div class="swiper-slide">
                <img
                  src="assets/img/clients/client-3.png"
                  class="img-fluid"
                  alt=""
                />
              </div>
              <div class="swiper-slide">
                <img
                  src="assets/img/clients/client-4.png"
                  class="img-fluid"
                  alt=""
                />
              </div>
              <div class="swiper-slide">
                <img
                  src="assets/img/clients/client-5.png"
                  class="img-fluid"
                  alt=""
                />
              </div>
              <div class="swiper-slide">
                <img
                  src="assets/img/clients/client-6.png"
                  class="img-fluid"
                  alt=""
                />
              </div>
              <div class="swiper-slide">
                <img
                  src="assets/img/clients/client-7.png"
                  class="img-fluid"
                  alt=""
                />
              </div>
              <div class="swiper-slide">
                <img
                  src="assets/img/clients/client-8.png"
                  class="img-fluid"
                  alt=""
                />
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End Clients Section -->';

// Actualizar en la base de datos
$stmt = $conn->prepare("UPDATE pages SET content = ? WHERE slug = 'index'");
$stmt->bind_param("s", $mainContent);

if ($stmt->execute()) {
    echo "Contenido actualizado exitosamente";
    
    // Verificar el contenido actualizado
    $stmt = $conn->prepare("SELECT content FROM pages WHERE slug = 'index'");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row) {
        // Verificar los enlaces
        preg_match_all('/<a href="([^"]*)"[^>]*class="btn-get-started"[^>]*>/', $row['content'], $matches);
        echo "<h3>Enlaces encontrados:</h3>";
        echo "<pre>";
        print_r($matches[1]);
        echo "</pre>";
    }
} else {
    echo "Error al actualizar el contenido: " . $conn->error;
}
?>
