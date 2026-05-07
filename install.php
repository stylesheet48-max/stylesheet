<?php
$pdo=new PDO('mysql:host=127.0.0.1','root','root',[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
$sql=file_get_contents(__DIR__.'/install.sql');$pdo->exec($sql);echo 'Installation completed';
