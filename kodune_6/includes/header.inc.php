<?php
$hourNow   = date("H");
// hommik 6-12, päev 12-18, õhtu 18-23, öö 23-6
if ($hourNow >= 6 and $hourNow < 12) {
  $partOfDay = "Tere hommikust ";
} elseif ($hourNow >= 12 and $hourNow < 18) {
  $partOfDay = "Tere päevast ";
} elseif ($hourNow >= 18 and $hourNow < 23) {
  $partOfDay = "Tere õhtust ";
} else {
  $partOfDay = "Head ööd ";
}


?>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-4">
  <a class="navbar-brand mr-3"
    href="https://tigu.hk.tlu.ee/~reino.ristissaar/HK-veebirakendused-2020/kodune_5/home.php">Veebirakendused 2020</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03"
    aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExample03">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item mr-3">
        <a class="nav-link" href="home.php">
          <svg class="bi bi-house-fill" width="1em" height="1em" viewBox="0 0 19 19" fill="currentColor"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M8 3.293l6 6V13.5a1.5 1.5 0 01-1.5 1.5h-9A1.5 1.5 0 012 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 01.5-.5h1a.5.5 0 01.5.5z"
              clip-rule="evenodd" />
            <path fill-rule="evenodd"
              d="M7.293 1.5a1 1 0 011.414 0l6.647 6.646a.5.5 0 01-.708.708L8 2.207 1.354 8.854a.5.5 0 11-.708-.708L7.293 1.5z"
              clip-rule="evenodd" />
          </svg>
          Avaleht
        </a>
      </li>
      <li class="nav-item dropdown mr-3">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false">
          <svg class="bi bi-newspaper" width="1em" height="1em" viewBox="0 0 19 19" fill="currentColor"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M0 2A1.5 1.5 0 011.5.5h11A1.5 1.5 0 0114 2v12a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 010 14V2zm1.5-.5A.5.5 0 001 2v12a.5.5 0 00.5.5h11a.5.5 0 00.5-.5V2a.5.5 0 00-.5-.5h-11z"
              clip-rule="evenodd" />
            <path fill-rule="evenodd"
              d="M15.5 3a.5.5 0 01.5.5V14a1.5 1.5 0 01-1.5 1.5h-3v-1h3a.5.5 0 00.5-.5V3.5a.5.5 0 01.5-.5z"
              clip-rule="evenodd" />
            <path
              d="M2 3h10v2H2V3zm0 3h4v3H2V6zm0 4h4v1H2v-1zm0 2h4v1H2v-1zm5-6h2v1H7V6zm3 0h2v1h-2V6zM7 8h2v1H7V8zm3 0h2v1h-2V8zm-3 2h2v1H7v-1zm3 0h2v1h-2v-1zm-3 2h2v1H7v-1zm3 0h2v1h-2v-1z" />
          </svg>
          Uudised
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdown03">
          <a class="dropdown-item" href="addnews.php">Lisamine</a>
          <a class="dropdown-item" href="news.php">Lugemine</a>
        </div>
      </li>
      <li class="nav-item dropdown mr-3">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false">
          <svg class="bi bi-stopwatch-fill" width="1em" height="1em" viewBox="0 0 19 19" fill="currentColor"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M5.5.5A.5.5 0 016 0h4a.5.5 0 010 1H9v1.07A7.002 7.002 0 018 16 7 7 0 017 2.07V1H6a.5.5 0 01-.5-.5zm3 4.5a.5.5 0 00-1 0v3.5h-3a.5.5 0 000 1H8a.5.5 0 00.5-.5V5z"
              clip-rule="evenodd" />
          </svg>
          Õppimise logi
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdown03">
          <a class="dropdown-item" href="study.php">Lisamine</a>
          <a class="dropdown-item" href="log.php">Vaata logi</a>
        </div>
      </li>
      <li class="nav-item dropdown mr-3">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false">
          <svg class="bi bi-card-image" width="1em" height="1em" viewBox="0 0 19 19" fill="currentColor"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M14.5 3h-13a.5.5 0 00-.5.5v9a.5.5 0 00.5.5h13a.5.5 0 00.5-.5v-9a.5.5 0 00-.5-.5zm-13-1A1.5 1.5 0 000 3.5v9A1.5 1.5 0 001.5 14h13a1.5 1.5 0 001.5-1.5v-9A1.5 1.5 0 0014.5 2h-13z"
              clip-rule="evenodd" />
            <path
              d="M10.648 7.646a.5.5 0 01.577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 01.63-.062l2.66 1.773 3.71-3.71z" />
            <path fill-rule="evenodd" d="M4.502 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd" />
          </svg>
          Fotod
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdown03">
          <a class="dropdown-item" href="photoUpload.php">Lisamine</a>
          <a class="dropdown-item" href="galleryPrivate.php?limit=8&offset=0">Minu fotod</a>
          <a class="dropdown-item" href="semipublicgallery.php?page=1">Semipublic gallery</a>
          <a class="dropdown-item disabled" href="#">Kasutajate fotod</a>
          <a class="dropdown-item disabled" href="galleryPublic.php">Avalikud fotod</a>
        </div>
      <li class="nav-item mr-3">
        <a class="nav-link" href="variables.php">
          <svg class="bi bi-braces" width="1em" height="1em" viewBox="0 0 19 19" fill="currentColor"
            xmlns="http://www.w3.org/2000/svg">
            <path
              d="M2.114 8.063V7.9c1.005-.102 1.497-.615 1.497-1.6V4.503c0-1.094.39-1.538 1.354-1.538h.273V2h-.376C3.25 2 2.49 2.759 2.49 4.352v1.524c0 1.094-.376 1.456-1.49 1.456v1.299c1.114 0 1.49.362 1.49 1.456v1.524c0 1.593.759 2.352 2.372 2.352h.376v-.964h-.273c-.964 0-1.354-.444-1.354-1.538V9.663c0-.984-.492-1.497-1.497-1.6zM13.886 7.9v.163c-1.005.103-1.497.616-1.497 1.6v1.798c0 1.094-.39 1.538-1.354 1.538h-.273v.964h.376c1.613 0 2.372-.759 2.372-2.352v-1.524c0-1.094.376-1.456 1.49-1.456V7.332c-1.114 0-1.49-.362-1.49-1.456V4.352C13.51 2.759 12.75 2 11.138 2h-.376v.964h.273c.964 0 1.354.444 1.354 1.538V6.3c0 .984.492 1.497 1.497 1.6z" />
          </svg>
          Muutujad
        </a>
      </li>
      </li>

    </ul>
    <ul class="navbar-nav mr-0">
      <li class="nav-item dropdown mr-3">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false">
          <?php echo $partOfDay . " " . $_SESSION["userFirstName"];?>
          <svg class="bi bi-person-fill" width="1em" height="1em" viewBox="0 0 19 19" fill="currentColor"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 100-6 3 3 0 000 6z"
              clip-rule="evenodd" />
          </svg>
        </a>
        <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdown03">
          <a class="dropdown-item disabled" href="photoUpload.php">
            <svg class="bi bi-person-fill" width="1em" height="1em" viewBox="0 0 19 19" fill="currentColor"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 100-6 3 3 0 000 6z"
                clip-rule="evenodd" />
            </svg>
            Profiil
          </a>
          <a class="dropdown-item disabled" href="#">
            <svg class="bi bi-lock-fill" width="1em" height="1em" viewBox="0 0 19 19" fill="currentColor"
              xmlns="http://www.w3.org/2000/svg">
              <rect width="11" height="9" x="2.5" y="7" rx="2" />
              <path fill-rule="evenodd" d="M4.5 4a3.5 3.5 0 117 0v3h-1V4a2.5 2.5 0 00-5 0v3h-1V4z"
                clip-rule="evenodd" />
            </svg>
            Vaheta salasõna
          </a>
          <a class="dropdown-item" href="?logout=1">
            <svg class="bi bi-box-arrow-in-right" width="1em" height="1em" viewBox="0 0 19 19" fill="currentColor"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M8.146 11.354a.5.5 0 010-.708L10.793 8 8.146 5.354a.5.5 0 11.708-.708l3 3a.5.5 0 010 .708l-3 3a.5.5 0 01-.708 0z"
                clip-rule="evenodd" />
              <path fill-rule="evenodd" d="M1 8a.5.5 0 01.5-.5h9a.5.5 0 010 1h-9A.5.5 0 011 8z" clip-rule="evenodd" />
              <path fill-rule="evenodd"
                d="M13.5 14.5A1.5 1.5 0 0015 13V3a1.5 1.5 0 00-1.5-1.5h-8A1.5 1.5 0 004 3v1.5a.5.5 0 001 0V3a.5.5 0 01.5-.5h8a.5.5 0 01.5.5v10a.5.5 0 01-.5.5h-8A.5.5 0 015 13v-1.5a.5.5 0 00-1 0V13a1.5 1.5 0 001.5 1.5h8z"
                clip-rule="evenodd" />
            </svg>
            Logi välja
          </a>
        </div>
      </li>
    </ul>


  </div>
</nav>