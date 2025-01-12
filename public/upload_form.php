<?php
require_once '../classes/dbc.php';
$files = getAllFile();

?>
<!-- ①フォームの説明 -->
<!-- ②$_FILEの確認 -->
<!-- ③バリデーション -->
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/upload_form_style.css">
    <title>アップロードフォーム</title>
  </head>

  <body>
    <form enctype="multipart/form-data" action="./file_upload.php" method="POST">
      <div class="file-up">
        <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
        <input name="img" type="file" accept="image/*" />
      </div>
      <div>
        <textarea
          name="caption"
          placeholder="キャプション（140文字以下）"
          id="caption"
        ></textarea>
      </div>
      <div class="submit">
        <input type="submit" value="送信" class="btn" />
      </div>
    </form>

    <div class="imgs">
      <ul>
        <?php foreach($files as $file): ?>
          <li>
            <p><?php echo h("{$file['description']}"); ?></p>
            <div class="item">
              <div class="img_wrap">
                <img src="<?php echo '/default_php_image_upload/images/' . basename($file['file_path']); ?>" alt="">
              </div>
              <a href="image_delete.php?id=<?php echo h($file['id']); ?>" onclick="return confirm('削除してもよろしいですか？')">削除</a>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </body>
</html>
