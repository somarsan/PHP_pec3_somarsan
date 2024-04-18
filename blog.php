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
  <form method="get">
    <label for="ordenarfecha"><?=$lang["ordenarfecha"];?></label>
    <select name="ordenarfecha" id="ordenarfecha">
      <option value="asc"><?=$lang["ascendente"];?></option>
      <option value="desc"><?=$lang["descendente"];?></option>
    </select>
    <input type="hidden" name="lang" value="<?php echo isset($_GET['lang']) ? $_GET['lang'] : 'en'; ?>">
    <button type="submit"><?=$lang["ordenar"];?></button>
  </form>
  <form method="get">
    <label for="ordenartitulo"><?=$lang["ordenartitulo"];?></label>
    <select name="ordenartitulo" id="ordenartitulo">
        <option value="asc"><?=$lang["ascendente"];?></option>
        <option value="desc"><?=$lang["descendente"];?></option>
    </select>
    <input type="hidden" name="lang" value="<?php echo isset($_GET['lang']) ? $_GET['lang'] : 'en'; ?>">
    <button type="submit"><?=$lang["ordenar"];?></button>
  </form>
  <?php

    $news = glob('posts/*.json');

    foreach ($news as $new) {
      $post = json_decode(file_get_contents($new), true);
      $posts[] = $post;
    }

    if (isset($_GET['ordenarfecha'])) {
      $ordenarfecha = $_GET['ordenarfecha'];

      if ($ordenarfecha == $_GET['ordenarfecha']) {
        if ($ordenarfecha == 'asc') {
          usort($posts, function($a, $b) {
            return $a['date'] - $b['date'];
          });
        } elseif ($ordenarfecha == 'desc') {
          usort($posts, function($a, $b) {
            return $b['date'] - $a['date'];
          });
        }
      }
      foreach ($posts as $post) {
        echo "<h2> <a href='/~somarsan/pec3/somarsan_pec3/post.php?id=" . ($post['id']) . "&lang=" . (isset($_GET['lang']) ? $_GET['lang'] : 'en') . "'>" . $post['title'][isset($_GET['lang']) ? $_GET['lang'] : 'en'] . "</a></h2>";
        echo date('d/m/Y', ($post['date'])) . "</p>";
        echo "<p>" . substr($post['description'][isset($_GET['lang']) ? $_GET['lang'] : 'en'], 0, 120) . "...</p>";
        echo "<img src='" . $post['image'] . "'><br><br>";
      }

    } else if (isset($_GET['ordenartitulo'])) {
      $ordenartitulo = $_GET['ordenartitulo'];

      if ($ordenartitulo == $_GET['ordenartitulo']) {
        if ($ordenartitulo == 'asc') {
          usort($posts, function($a, $b) {
            return strcmp($a['title']['en'], $b['title']['en']);
          });
        } elseif ($ordenartitulo == 'desc') {
          usort($posts, function($a, $b) {
            return strcmp($b['title']['en'], $a['title']['en']);
          });
        }
      }
      foreach ($posts as $post) {
        echo "<h2> <a href='/~somarsan/pec3/somarsan_pec3/post.php?id=" . ($post['id']) . "&lang=" . (isset($_GET['lang']) ? $_GET['lang'] : 'en') . "'>" . $post['title'][isset($_GET['lang']) ? $_GET['lang'] : 'en'] . "</a></h2>";
        echo date('d/m/Y', ($post['date'])) . "</p>";
        echo "<p>" . substr($post['description'][isset($_GET['lang']) ? $_GET['lang'] : 'en'], 0, 120) . "...</p>";
        echo "<img src='" . $post['image'] . "'><br><br>";
      }

    } else {
      foreach ($posts as $post) {
        echo "<h2> <a href='/~somarsan/pec3/somarsan_pec3/post.php?id=" . ($post['id']) . "&lang=" . (isset($_GET['lang']) ? $_GET['lang'] : 'en') . "'>" . $post['title'][isset($_GET['lang']) ? $_GET['lang'] : 'en'] . "</a></h2>";
        echo date('d/m/Y', ($post['date'])) . "</p>";
        echo "<p>" . substr($post['description'][isset($_GET['lang']) ? $_GET['lang'] : 'en'], 0, 120) . "...</p>";
        echo "<img src='" . $post['image'] . "'><br><br>";
      }
    }
  ?>
</body>
</html>