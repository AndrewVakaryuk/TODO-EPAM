<?php

/** @var PDO $pdo */
require_once './pdo_ini.php';

session_start();

if (!isset($_SESSION['todo_list_id'])) {
  $stmt = $pdo->prepare("
			INSERT INTO todo_lists (created_at)
			VALUES (NOW())
		");
  $stmt->execute();
  $_SESSION['todo_list_id'] = $pdo->lastInsertId();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>To-Do List</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="main-section">

    <div class="add-section">
      <form action="app/add.php" method="POST" autocomplete="off">
        <?php if (isset($_GET['mess']) && $_GET['mess'] == 'error') { ?>
          <input type="text" name="title" style="border-color: #ff6666;" placeholder="This field is required">
          <button type="submit">Add &nbsp; <span>&#43</span></button>
        <?php } else { ?>
          <input type="text" name="title" placeholder="What do you need to do">
          <button type="submit">Add &nbsp; <span>&#43</span></button>
        <?php } ?>
      </form>
    </div>

    <?php
    $todos = $pdo->query("SELECT * FROM todo_tasks WHERE todo_list_id = {$_SESSION['todo_list_id']} ORDER BY id DESC");
    ?>

    <div class="show-todo-section">
      <?php if ($todos->rowCount() <= 0) { ?>
        <div class="todo-item">
          <div class="empty">
            <img src="img/f.png" alt="main image" width="100%">
            <img src="img/Ellipsis.gif" width="80px">
          </div>
        </div>
      <?php } ?>

      <?php while ($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
        <div class="todo-item">
          <span id="<?php echo $todo['id']; ?>" class="remove-to-do">x</span>

          <?php if ($todo['is_done']) { ?>
            <input type="checkbox" class="check-box" data-todo-id="<?php echo $todo['id']; ?>" checked>
            <h2 class="checked"><?php echo $todo['title']; ?></h2>

          <?php } else { ?>
            <input type="checkbox" class="check-box" data-todo-id="<?php echo $todo['id']; ?>">
            <h2><?php echo $todo['title']; ?></h2>
          <?php } ?>

          <small>created: <?php echo $todo['created_at']; ?></small>

        </div>
      <?php } ?>

    </div>

  </div>


  <script src="js/jquery-3.2.1.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.remove-to-do').click(function() {
        const id = $(this).attr('id');

        $.post("app/remove.php", {
            id: id
          },
          (data) => {
            if (data) {
              $(this).parent().hide(600);
            }
          }
        );
      });

      $('.check-box').click(function(e) {
        const id = $(this).attr('data-todo-id');

        $.post('app/check.php', {
            id: id
          },
          (data) => {
            if (data != 'error') {
              const h2 = $(this).next();
              if (data === '1') {
                h2.removeClass('checked');
              } else {
                h2.addClass('checked');
              }
            }
          }
        );
      });
    });
  </script>
</body>

</html>