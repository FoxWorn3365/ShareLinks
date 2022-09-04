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
}, array('/u/' . $_SESSION['user'] . '/link'));

