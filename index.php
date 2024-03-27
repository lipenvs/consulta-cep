<?php
require_once('connection.php');
include_once('layout/_header.php');
?>

<!-- Lista de Links -->
<ul class="navbar-nav d-flex flex-row gap-4">
  <li class="nav-item">
    <a class="nav-link active" href="index.php">Início</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="ex1.php">Algoritmos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="segunda-avaliacao.php">Sistema Web</a>
  </li>
</ul>
</div>
</nav>

<main class="container mt-5">

  <div class="full-height custom-column">
    <div class="video-frame">
      <iframe class="youtube" width="560" height="315" src="https://www.youtube.com/embed/IjnPOXF0fjY?si=Fvm8BkcuR9o8smUH" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>

    <div class="custom-row mt-5">
      <a href="./ex1.php" class="custom-button">
        <img alt="UltraLIMS Logo" src="./assets/ultra.png" />
        <div class="custom-column">
          <span class="title">Primeira Avaliação</span>
          <span class="subtitle">Algoritmos</span>
        </div>
      </a>

      <a href="./segunda-avaliacao.php" class="custom-button">
        <img alt="UltraLIMS Logo" src="./assets/ultra.png" />
        <div class="custom-column">
          <span class="title">Segunda Avaliação</span>
          <span class="subtitle">Sistema Web</span>
        </div>
      </a>
    </div>
  </div>

  <?php include_once('layout/_footer.php'); ?>