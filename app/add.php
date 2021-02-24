<?php
/** @var PDO $pdo */
require_once '../pdo_ini.php';
session_start();

if (isset($_POST['title'])) {

  $title = $_POST['title'];
  //$todo_list_id = $_SESSION['todo_list_id'];

  if (empty($title)) {
    header("Location: ../index.php?mess=error");
  } else {
    $stmt = $pdo->prepare("INSERT INTO todo_tasks (title, todo_list_id) VALUES (:title, :todo_list_id)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':todo_list_id', $_SESSION['todo_list_id']);
    $res = $stmt->execute();

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
