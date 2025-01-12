<?php
require_once "../config/env.php";

function dbc() {
  $host = DB_HOST;
  $dbname = DB_NAME;
  $user = DB_USER;
  $pass = DB_PASS;

  $dns = "mysql:host=$host;dbname=$dbname;charset=utf8";

  try {
    $pdo = new PDO($dns, $user, $pass,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    return $pdo;
  } catch(PDOException $e) {
    exit($e->getMessage());
  }
}

/**
 * ファイルデータを保存
 * @param string $filename ファイル名
 * @param string $save_path 保存先のパス
 * @param string $caption 投稿の説明
 * @return bool $result
 */
function fileSave($filename, $save_path, $caption) {
  $result = false;

  $sql = "INSERT INTO file_table (file_name, file_path, description) VALUES (?, ?, ?)";

  try {
    $stmt = dbc()->prepare($sql);
    $stmt->bindValue(1, $filename);
    $stmt->bindValue(2, $save_path);
    $stmt->bindValue(3, $caption);
    $result = $stmt->execute();
    return $result;
  } catch(\Exception $e) {
    echo $e->getMessage();
    return $result;
  }
}

/**
 * ファイルデータを取得
 * @return array $fileData
 */
function getAllFile() {
  $spl = "SELECT * FROM file_table";
  $fileData = dbc()->query($spl);

  return $fileData;
}

/**
 * ファイルデータを削除
 * @param string $id
 * @return bool $result
 */
function imageDelete($id) {
  if (empty($id)) {
    exit('IDが不正です。');
  }

  try {
    $dbh = dbc();
    // 画像ファイルパスを取得
    $sql = "SELECT file_path FROM file_table WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $filepath = $stmt->fetch()['file_path'];

    // 画像ファイルを削除
    if ($filepath && file_exists($filepath)) {
      unlink($filepath);
    }

    // データベースからレコードを削除
    $sql = "DELETE FROM file_table WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $result = $stmt->execute();
    return $result;

  } catch(\Exception $e) {
    echo $e->getMessage();
    return false;
  }
}

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

dbc();