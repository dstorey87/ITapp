<?php $connection = new mysqli('db', 'eve_user', 'your_password', 'eve_online'); if ($connection->connect_error) { die('Connection failed: ' . $connection->connect_error); } echo 'Connected successfully'; ?>
