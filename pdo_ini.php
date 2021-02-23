<?php
$config = [
    'host' => 'localhost',
    'dbname' => 'todoepam',
    'user' => 'root',
    'pass' => '',
];

try {
    $pdo = new PDO(
        sprintf('mysql:host=%s;dbname=%s', $config['host'], $config['dbname']),
        $config['user'],
        $config['pass']
    );
    //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $exception) {
        echo $exception->getMessage();
}