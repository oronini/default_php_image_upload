<?php

  require_once('dbc.php');

  $id = $_GET['id'];
  imageDelete($id);
?>
<p><a href="../public/upload_form.php">戻る</a></p>