<?php
require_once 'db.php';

$poker = $db->query('SELECT * FROM poker ORDER BY UserName ASC');
$users = $poker->fetch_all(MYSQLI_ASSOC);

if(isset($_GET['add'])){
    $add = $db->query('INSERT poker (UserName) VALUES("'.$_GET['username'].'")');
    // $add->execute();
    header("Location: maintenance.php");
    exit();
}

if(isset($_GET['remove'])){
    $remove = $db->prepare('DELETE FROM poker WHERE UserName="'.$_GET['username'].'";');
    $remove->execute();
    header("Location: maintenance.php");
    exit();
}

?>


<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    body{
        font-family: 'Roboto Slab';
        background-color: #2d2d2d;
        color: white;
    }
    .table-theme{
        font-size: 30px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 50px;
        margin-bottom: 50px;
    }
    .table-theme tr td{
        padding: 5px 10px;
    }
    a{
        text-decoration: none;
        color: #d0d0d0;
    }        
    a:hover{
        color: #888888;
    }
</style>
</head>
<body>
    <div style="width: 100%;">
        <table class="table-theme">
            <?php if(!empty($users)) : ?>
            <?php foreach($users AS $user) :?>
                <tr>
                    <td style="width:250px;"><?=$user['UserName']?></td>
                    <td>
                        <a href="?remove=1&username=<?=$user['UserName']?>">Remove</a>
                    </td>
                </tr>
            <?php endforeach;?>
            <?php else: ?>
                <tr>
                    <td style="width:250px; text-align: center">Empty!</td>
                </tr>
            <?php endif; ?>
            <tr>
                <form>
                <td><input type="hidden" name="add" value="1"><input type="text" name="username" style="width: 100%; padding: 5px; font-size: 25px;" autofocus></td>
                <td>
                    <button>Add</button>
                </td>
                </form>
            </tr>
        </table>
    </div>
</body>
</html>