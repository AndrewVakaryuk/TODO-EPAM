<?php
/** @var PDO $pdo */
require_once '../pdo_ini.php';

if (isset($_POST['id'])) {
  //require '../db_conn.php';

  $id = $_POST['id'];

  if (empty($id)) {
    echo 0;
  } else {
    $stmt = $pdo->prepare("DELETE FROM todo_tasks WHERE id=?");
    $res = $stmt->execute([$id]);

    if ($res) {
      echo 1;
    } else {
      echo 0;
    }
    $pdo = null;
    exit();
  }
} else {
  header("Location: ../index.php?mess=error");
}
