<?php
require_once 'db.php';

$poker = $db->query('SELECT * FROM poker');
$users = $poker->fetch_all(MYSQLI_ASSOC);
?>


<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
        body{
            font-family: 'Roboto Slab';
        }
</style>
</head>
<body>
    <div style="width: 100%;">
        <?php foreach($users AS $user) :?>
        <a href="user.php?username=<?=$user['UserName']?>"><h1 style="text-align: center;"><?=$user['UserName']?></h1></a>
        <?php endforeach;?>
    </div>
</body>
</html>