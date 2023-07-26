<?php
    session_start();
    if (isset($_SESSION['user'])) {
        echo '
            <script>
                window.location = "./dashboard";
            </script>
        ';
        exit;
    }
    if(isset($_GET['courseId']) && isset($_GET['divisionId'])){
        include('./connection.php');
        $curso = $_GET['courseId'];
        $division = $_GET['divisionId'];
        $query = "
        SELECT subjects.*, subjects_names.name
            FROM subjects_names 
            INNER JOIN subjects
            ON subjects.name_id = subjects_names.id
            WHERE course = $curso AND division = $division
        ";

        $result = $conn -> query($query);
    }
    if(isset($_GET['file_id'])){
        include('./connection.php');
        if(isset($_SESSION['user'])){
            $rol = $_SESSION['user']['rol_id'];
        }
        $result = $conn->query("SELECT * FROM files WHERE subject_id = $_GET[file_id]");

        $validExt = array('png', 'jpg', 'jpeg', 'svg', 'pdf', 'mp3', 'wav' ,'mp4');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <title>Tesla</title>
</head>
<body>
    <div class="video-bg">
        <video width="320" height="240" autoplay loop muted>
            <source src="https://assets.codepen.io/3364143/7btrrd.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <div class="dark-light">
        <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
        </svg>
    </div>
    <div class="app">
        <div class="header">
            <div class="menu-circle fit"></div>
            <div class="header-menu">
                <h1>Bienvenido a Tesla</h1>
            </div>
            <div class="search-bar fit">
                <input type="text" placeholder="Search">
            </div>
            <div class="header-profile fit">
                <a class="access" href="./auth/">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="24" height="24" fill="#3ea6ff"><path d="M 25 2.0078125 C 12.309296 2.0078125 2.0000002 12.317108 2 25.007812 C 2 37.698518 12.309295 48.007812 25 48.007812 C 37.690705 48.007812 48 37.698518 48 25.007812 C 48 12.317108 37.690704 2.0078125 25 2.0078125 z M 25 4.0078125 C 36.609824 4.0078125 46 13.397988 46 25.007812 C 46 30.740509 43.703999 35.925856 39.988281 39.712891 C 38.158498 38.369571 35.928049 37.69558 34.039062 37.023438 C 32.975192 36.644889 32.018651 36.269758 31.320312 35.851562 C 30.651504 35.451051 30.280089 35.039466 30.083984 34.566406 C 29.992134 33.419545 30.010738 32.496253 30.017578 31.40625 C 30.13873 31.285594 30.294155 31.200823 30.417969 31.054688 C 30.709957 30.710058 31.007253 30.29128 31.291016 29.820312 C 31.777604 29.012711 32.131673 28.024913 32.330078 27.023438 C 32.63305 26.869 32.956699 26.835578 33.203125 26.521484 C 33.658098 25.941577 33.965233 25.125482 34.101562 23.988281 C 34.222454 22.984232 33.898957 22.29366 33.482422 21.763672 C 33.930529 20.298851 34.48532 17.969341 34.296875 15.558594 C 34.193203 14.232288 33.859467 12.897267 33.056641 11.787109 C 32.290173 10.727229 31.045786 9.9653642 29.453125 9.6894531 C 28.441568 8.5409775 26.834704 8 24.914062 8 L 24.904297 8 L 24.896484 8 C 20.593741 8.078993 17.817552 9.8598398 16.628906 12.576172 C 15.498615 15.159149 15.741603 18.37477 16.552734 21.722656 C 16.116708 22.25268 15.775146 22.95643 15.898438 23.988281 C 16.035282 25.125098 16.34224 25.94153 16.796875 26.521484 C 17.043118 26.835604 17.366808 26.868911 17.669922 27.023438 C 17.868296 28.024134 18.222437 29.01059 18.708984 29.818359 C 18.992747 30.289465 19.289737 30.707821 19.582031 31.052734 C 19.705876 31.198874 19.861128 31.285522 19.982422 31.40625 C 19.988922 32.49568 20.007396 33.418614 19.916016 34.566406 C 19.720294 35.037723 19.34937 35.449526 18.681641 35.851562 C 17.984409 36.271364 17.029015 36.648577 15.966797 37.029297 C 14.079805 37.705631 11.85061 38.384459 10.015625 39.716797 C 6.2976298 35.929423 4 30.742497 4 25.007812 C 4.0000002 13.397989 13.390176 4.0078125 25 4.0078125 z M 24.921875 10.001953 C 26.766001 10.003853 27.92628 10.549863 28.244141 11.107422 L 28.488281 11.535156 L 28.974609 11.601562 C 30.230788 11.776108 30.932655 12.263579 31.435547 12.958984 C 31.938439 13.654389 32.217535 14.624895 32.302734 15.714844 C 32.473134 17.894741 31.849129 20.468905 31.453125 21.660156 L 31.201172 22.416016 L 31.882812 22.830078 C 31.813472 22.787858 32.203297 23.018609 32.115234 23.75 C 32.008564 24.639799 31.781184 25.093017 31.628906 25.287109 C 31.476629 25.481202 31.411442 25.45641 31.427734 25.455078 L 30.603516 25.523438 L 30.515625 26.345703 C 30.440195 27.052169 30.04285 28.015793 29.578125 28.787109 C 29.345762 29.172767 29.098543 29.516317 28.890625 29.761719 C 28.682707 30.00712 28.461282 30.159117 28.544922 30.115234 L 28.009766 30.394531 L 28.009766 31 C 28.009766 32.324321 27.955813 33.407291 28.095703 34.949219 L 28.107422 35.082031 L 28.154297 35.207031 C 28.547829 36.266071 29.369275 37.013258 30.292969 37.566406 C 31.216662 38.119555 32.276387 38.519377 33.369141 38.908203 C 35.170096 39.549023 37.047465 40.179657 38.478516 41.111328 C 34.832228 44.16545 30.135566 46.007812 25 46.007812 C 19.866422 46.007812 15.171083 44.167232 11.525391 41.115234 C 12.964568 40.188909 14.844735 39.556492 16.642578 38.912109 C 17.73461 38.520704 18.79156 38.119183 19.712891 37.564453 C 20.634221 37.009723 21.452728 36.262662 21.845703 35.207031 L 21.892578 35.082031 L 21.904297 34.949219 C 22.043042 33.408482 21.990234 32.325309 21.990234 31 L 21.990234 30.394531 L 21.455078 30.113281 C 21.538828 30.157091 21.317362 30.005196 21.109375 29.759766 C 20.901388 29.514336 20.654237 29.172879 20.421875 28.787109 C 19.957151 28.015571 19.559775 27.05118 19.484375 26.345703 L 19.396484 25.523438 L 18.572266 25.455078 C 18.587716 25.456378 18.523206 25.481158 18.371094 25.287109 C 18.218979 25.093064 17.991921 24.640183 17.884766 23.75 C 17.797356 23.01846 18.191557 22.784891 18.117188 22.830078 L 18.751953 22.445312 L 18.566406 21.724609 C 17.705952 18.412902 17.575833 15.399621 18.460938 13.376953 C 19.345167 11.356284 21.116417 10.074289 24.921875 10.001953 z"/></svg>
                    Acceder</button>
                </a>
            </div>
        </div>
        <div class="main-container">
            <div class="main-header">
                <div class="header-menu">
                    <a class="main-header-link is-active" href="#biblioteca">Biblioteca</a>
                    <a class="main-header-link" href="#exposicion">Ver exposición</a>
                </div>
            </div>
            <div class="content-wrapper" id="biblioteca">
                <div class="content-section">
                    <ul>
                        <?php if(isset($_GET["courseId"]) && isset($_GET["divisionId"])){
                                if ($result -> num_rows > 0) {
                                    while ($row = $result -> fetch_assoc()) { ?>
                                        <li><a href="?file_id=<?php echo $row['id'] ?>"><span><?php echo $row["name"] ?></span></a></li>
                                <?php
                                    }
                                }
                                ?>
                        <?php  } else if (isset($_GET["file_id"])) { ?>
                            <table>
      <tr>
        <th>Nombre</th>
        <th>Tipo de archivo</th>
        <th>Opciones</th>
      </tr>
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row["name"] ?></td>
            <td><?php echo $row["file_type"] ?></td>
            <td>
              <?php
                if (in_array($row['file_type'], $validExt)) {
              ?>
            <a href="#" class="link--visualizar" id="<?php echo $row['id'] ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                </svg>
            </a>
              <?php
                }else{
              ?>
              <a href="#" class="link--disabled" title="Este archivo no se puede visualizar"">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                  <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                  <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>
                </svg>
              </a>
              <?php
                }
              ?>
            <a href="./uploads/<?php echo $row['name'] ?>.<?php echo $row['file_type'] ?>" download class="link--descargar" title="Descargar">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-cloud-download-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.5a.5.5 0 0 1 1 0V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0zm-.354 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V11h-1v3.293l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z"/>
                </svg>
            </a>
            <a href="../actions/delete.php?id=<?php echo $row['id'] ?>&table=files&id_materia=<?php echo $_GET['file_id'] ?>"
                class="link--eliminar link_delete"
                title="Eliminar">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                  <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                </svg>
            </a>
            </td>
          </tr>
      <?php }
      }
      ?>
    </table>
                        <?php }else{ for ($c = 1; $c <= 7; $c++) { ?>
                            <li class="adobe-product"><span><?php echo $c ?>º año</span></li>
                            <ul>
                                <?php
                                for ($d = 1; $d <= 6; $d++) { 
                                    if ($d == 7 && $d > 4)
                                        break;
                                    ?>
                                    <li>
                                        <a href="./?courseId=<?php echo $c ?>&divisionId=<?php echo $d ?>">
                                            <div class="card">
                                                <span><?php echo $c ?>º<?php echo $d ?></span>
                                            </div>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        <?php }
                        } ?>
                    </ul>
                </div>
            </div>
            <div class="content-wrapper" id="exposicion">
                <h2>Exposición</h2>
            </div>
        </div>
    </div>
    <script>
        $('.main-header .header-menu a').on('click', function (e) {
            e.preventDefault();
            $(this).addClass('is-active');
            $(this).siblings().removeClass('is-active');
            target = $(this).attr('href');

            $('.main-container > div + div').not(target).hide();

            $(target).fadeIn(600);

        });
        document.querySelectorAll(".content-section ul li").forEach((dropdown) => {
            dropdown.addEventListener("click", (e) => {
                e.stopPropagation();
                document.querySelectorAll(".content-section ul li").forEach((c) => c.classList.remove("is-active"));
                dropdown.classList.add("is-active");
            });
        });
        document.querySelector('.dark-light').addEventListener('click', () => {
            document.body.classList.toggle('light-mode');
        });
    </script>
</body>
</html>