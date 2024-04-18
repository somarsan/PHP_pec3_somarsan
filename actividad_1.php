<?php
  require_once 'config.php';

  if(isset($_GET['lang'])) {
    $lang = $_GET['lang'];
  } else {
    $lang = DEFAULT_LANG;
  }

  include('lang/lang-' . $lang . '.php');
  
  session_start();

  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    echo "Hola, " . $username;
  }
?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>PEC 3</title>
  <base href="/">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <header>
    <nav>
      <ul>
		    <li><a href="/~somarsan/pec3/somarsan_pec3/blog.php?ordenarfecha=desc&lang=es"><?=$lang["Home"];?></a></li>
        <li><a href="/~somarsan/pec3/somarsan_pec3/actividad_1.php"><?=$lang["Act 1"];?></a></li>
        <li><a href="/~somarsan/pec3/somarsan_pec3/api/noticias.php?lang=<?php echo isset($_GET['lang']) ? $_GET['lang'] : 'en'; ?>"><?=$lang["API"];?></a></l>
        <?php if (!isset($_SESSION['username'])) : ?>
          <li><a href="/~somarsan/pec3/somarsan_pec3/login.php"><?=$lang["Login"];?></a></li>
        <?php else : ?>
          <li><a href="/~somarsan/pec3/somarsan_pec3/profile.php"><?=$lang["Perfil"];?></a></li>
          <li><a href="/~somarsan/pec3/somarsan_pec3/logout.php"><?=$lang["Log out"];?></a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    <select name="lang" onchange="this.form.submit()">
      <option value="en" <?php if(isset($_GET['lang']) && $_GET['lang'] == 'en') { echo 'selected';} ?>><?=$lang["English"];?></option>
      <option value="es" <?php if(isset($_GET['lang']) && $_GET['lang'] == 'es') { echo 'selected';} ?>><?=$lang["Spanish"];?></option>
    </select>
  </form>

  <?php

    $post = json_decode(file_get_contents('posts/post_3.json'), true);

    echo "Title (en): " . $post['title']['en'] . "<br>";
    echo "Description (en): " . $post['description']['en'] . "<br>";
    echo "Título (es): " . $post['title']['es'] . "<br>";
    echo "Descripción (es): " . $post['description']['es'] . "<br>";

  ?>
</body>
</html>
