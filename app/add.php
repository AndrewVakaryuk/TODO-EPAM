<?php
/** @var PDO $pdo */
require_once '../pdo_ini.php';

if (isset($_POST['title'])) {
  //require '../pdo_ini.php';

  $title = $_POST['title'];

  if (empty($title)) {
    header("Location: ../index.php?mess=error");
  } else {
    $stmt = $pdo->prepare("INSERT INTO todo_tasks(title) VALUE(?)");
    $res = $stmt->execute([$title]);

    if ($res) {
      header("Location: ../index.php?mess=success");
    } else {
      header("Location: ../index.php");
    }
    $pdo = null;
    exit();
  }
} else {
  header("Location: ../index.php?mess=error");
}
