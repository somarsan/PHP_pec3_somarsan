<?php
  require_once 'config.php';

  if(isset($_GET['lang'])) {
    $lang = $_GET['lang'];
  } else {
    $lang = DEFAULT_LANG;
  }

  include('lang/lang-' . $lang . '.php');

  $usersData = file_get_contents('login/users.json');
  $users = json_decode($usersData, true);

  session_start();
  $username = $_SESSION['username'];

  $user = null;
  foreach ($users as $userData) {
    if ($userData['Username'] === $username) {
      $user = $userData;
      break;
    }
  }

  $password = $user['Password'];

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
  <h2>Perfil de usuario</h2>
  <p><strong>Nombre de usuario:</strong> <?php echo $username; ?></p>
</body>
</html>
