<?php
session_start();
$plugin->addEvent('request', 'before', function() {
  // Iniziamo con il richiedere gli header
  require "protected/components/header.php";
  
  // Ora lavoriamo sulla richiesta per creare uno shared
?>
  <br><br>
  <h1>Condividi un link</h1>
  <br>
  <form method='post' action='/admin/sharelinks/new'>
   <input type='text' name='link'><br><br>
   <button class='w3-button w3-orange w3-text-white'>Condividi</button>
  </form>
<?php
 die();
}, array('/u/%user%/link'));

$plugin->addEvent('request', 'before', function() {
  // Aggiungiamo il plugin
  $user = $_SESSION["user"];
  $link = filter_var($_POST["link"], FILTER_SANITIZE_STRING);
  
  if (!empty($user) && !empty($link)) {
    $code = rand(1, 9999999) . rand(1, 9999999);
    file_put_contents('protected/sys/ShareLinks/' . $code, $user . '{//}' . $link);
    require "protected/components/header.php";
?>
  <h1>Link condiviso!</h1>
  <br><br>
  ID: <a onclick='copyurl()'><u>https://<?= $_SERVER['SERVER_NAME']; ?>/s/link/<?= $code; ?></u></a><br><br>
  <script>
  function copyurl() {
    navigator.clipboard.writeText('https://<?= $_SERVER['SERVER_NAME']; ?>/s/link/<?= $code; ?>');
  }
  </script>
<?php
  } else {
    die("ARGOM . MANC");
  }
}, array('/admin/sharelinks/new'));

$plugin->addEvent('containRequest', 'before', function() {
  // Iniziamo con il richiedere gli header
  $r = explode("/", $GLOBALS['url']);
  $config = explode('{//}', file_get_contents('protected/sys/ShareLinks/' . end($r)));
  header('Location: ' . $config[1]);
}, array('/s/link/'));
