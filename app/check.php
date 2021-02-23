<?php

/** @var PDO $pdo */
require_once '../pdo_ini.php';

if (isset($_POST['id'])) {
  //require '../db_conn.php';

  $id = $_POST['id'];

  if (empty($id)) {
    echo 'error';
  } else {
    $todos = $pdo->prepare("SELECT id, is_done FROM todo_tasks WHERE id=?");
    $todos->execute([$id]);

    $todo = $todos->fetch();
    $uId = $todo['id'];
    $checked = $todo['is_done'];

    $uChecked = $checked ? 0 : 1;

    $res = $pdo->query("UPDATE todo_tasks SET is_done=$uChecked WHERE id=$uId");

    if($res) {
      echo $checked;
    } else {
      echo "error";
    }
    $pdo = null;
    exit();
  }
} else {
  header("Location: ../index.php?mess=error");
}
