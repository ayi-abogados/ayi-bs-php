<?php
require_once "config/database.php";

// Establecer la codificación de caracteres
mysqli_set_charset($conn, "utf8mb4");

// Contenido completo de la página principal
$mainContent = '<main class="main">
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

      <hr class="red-line" />

      <!-- Services Section -->
      <section id="services" class="services section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Servicios</h2>
          <p>
            Ofrecemos una amplia gama de soluciones legales adaptadas a las
            necesidades de nuestros clientes, con un enfoque personalizado y
            comprometido en cada área del derecho.
          </p>
        </div>
        <!-- End Section Title -->

        <div class="container">
          <div class="row gy-4">
            <div
              class="col-lg-4 col-md-6"
              data-aos="fade-up"
              data-aos-delay="100"
            >
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="bi bi-shield-lock"></i>
                </div>
                <a href="services.html#penal" class="stretched-link">
                  <h3>Derecho Penal</h3>
                </a>
                <p>
                  Ofrecemos defensa legal en procedimientos penales, asegurando
                  una representación estratégica y eficaz para proteger los
                  derechos de nuestros clientes en cada fase del proceso
                  judicial.
                </p>
              </div>
            </div>
            <!-- End Service Item -->

            <div
              class="col-lg-4 col-md-6"
              data-aos="fade-up"
              data-aos-delay="200"
            >
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="bi bi-people"></i>
                </div>
                <a href="services.html#civil" class="stretched-link">
                  <h3>Derecho Civil y Familiar</h3>
                </a>
                <p>
                  Brindamos asesoría y representación en asuntos civiles y
                  familiares, como herencias, divorcios, custodia de menores, y
                  contratos. Nuestro enfoque se centra en alcanzar soluciones
                  equitativas y justas para todas las partes.
                </p>
              </div>
            </div>
            <!-- End Service Item -->

            <div
              class="col-lg-4 col-md-6"
              data-aos="fade-up"
              data-aos-delay="300"
            >
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="bi bi-building"></i>
                </div>
                <a href="services.html#corporativo" class="stretched-link">
                  <h3>Derecho Corporativo</h3>
                </a>
                <p>
                  Asesoramos a empresas en la creación de sociedades, redacción
                  de contratos, y cumplimiento normativo. Nuestro objetivo es
                  garantizar que nuestros clientes corporativos tomen decisiones
                  estratégicas dentro del marco legal.
                </p>
              </div>
            </div>
            <!-- End Service Item -->

            <div
              class="col-lg-4 col-md-6"
              data-aos="fade-up"
              data-aos-delay="400"
            >
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="bi bi-briefcase"></i>
                </div>
                <a href="services.html#laboral" class="stretched-link">
                  <h3>Derecho Laboral</h3>
                </a>
                <p>
                  Defendemos los derechos tanto de empleadores como de empleados
                  en temas laborales, desde la redacción de contratos hasta la
                  resolución de disputas laborales, siempre con un enfoque en la
                  protección de los intereses de nuestros clientes.
                </p>
              </div>
            </div>
            <!-- End Service Item -->

            <div
              class="col-lg-4 col-md-6"
              data-aos="fade-up"
              data-aos-delay="500"
            >
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="bi bi-globe"></i>
                </div>
                <a href="services.html#extranjeria" class="stretched-link">
                  <h3>Derecho de Extranjería e Inmigración</h3>
                </a>
                <p>
                  Ofrecemos asistencia integral en trámites de visados, permisos
                  de residencia, y defensa en procesos de deportación. Ayudamos
                  a personas y empresas a cumplir con los requisitos legales de
                  inmigración de forma ágil y segura.
                </p>
              </div>
            </div>
            <!-- End Service Item -->

            <div
              class="col-lg-4 col-md-6"
              data-aos="fade-up"
              data-aos-delay="600"
            >
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="bi bi-chat-dots"></i>
                </div>
                <a href="services.html#mediacion" class="stretched-link">
                  <h3>Resolución de Conflictos y Mediación</h3>
                </a>
                <p>
                  Promovemos soluciones alternativas a los conflictos legales,
                  mediante la mediación y la negociación, evitando largos
                  procesos judiciales y buscando acuerdos que beneficien a ambas
                  partes.
                </p>
              </div>
            </div>
            <!-- End Service Item -->
          </div>
        </div>
      </section>
      <!-- /Services Section -->

      <!-- Clients Section -->
      <section id="clients" class="clients section">
        <div class="container">
          <div class="swiper init-swiper" style="background-color: var(--surface-color); padding: 30px; border-radius: 18px; box-shadow: 0px 5px 90px 0px rgba(0, 0, 0, 0.1);">
            <script type="application/json" class="swiper-config">
              {
                "loop": true,
                "speed": 600,
                "autoplay": {
                  "delay": 3000
                },
                "slidesPerView": "auto",
                "pagination": {
                  "el": ".swiper-pagination",
                  "type": "bullets",
                  "clickable": true
                },
                "breakpoints": {
                  "320": {
                    "slidesPerView": 2,
                    "spaceBetween": 40
                  },
                  "480": {
                    "slidesPerView": 3,
                    "spaceBetween": 60
                  },
                  "640": {
                    "slidesPerView": 4,
                    "spaceBetween": 80
                  },
                  "992": {
                    "slidesPerView": 6,
                    "spaceBetween": 120
                  }
                }
              }
            </script>
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
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </section>
      <!-- End Clients Section -->
    </main>';

// Actualizar en la base de datos
$stmt = $conn->prepare("UPDATE pages SET content = ? WHERE slug = 'index'");
$stmt->bind_param("s", $mainContent);

if ($stmt->execute()) {
    echo "Página principal restaurada exitosamente con todas las secciones";
} else {
    echo "Error al restaurar la página principal: " . $conn->error;
}
?>
