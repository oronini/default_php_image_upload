<?php
require_once "../classes/dbc.php";

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$result = imageDelete($id);

if ($result) {
  echo '削除に成功しました。';
} else {
  echo '削除に失敗しました。';
}
?>
<p>
  <a href="./upload_form.php">戻る</a>
</p>