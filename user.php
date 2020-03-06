<?php
require_once 'db.php';

$user = $_GET['username'] ?? null;

if($_POST){
    $db->query("UPDATE poker SET points='".$_POST['points']."', HasVote = '1' WHERE UserName='".$_POST['username']."' ");
    header("location:user.php?username=".$_POST['username']);
}

?>


<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body{
            font-family: 'Roboto Slab';
        }
        label{
            width: 100%;
            height: 35px;
            display: inline-block;
            background: #e4e4e4;
            font-size: 20px;
            border: 1px solid #9b9b9b;
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <h1><?=$user?></h1>
    <form action="user.php?username=<?=$user?>" method="post">
        <label><input type="radio" name="points" value="0.1">0.1</label><br>
        <label><input type="radio" name="points" value="0.2">0.2</label><br>
        <label><input type="radio" name="points" value="0.3">0.3</label><br>
        <label><input type="radio" name="points" value="0.5">0.5</label><br>
        <label><input type="radio" name="points" value="1" checked="checked"> 1</label><br>
        <label><input type="radio" name="points" value="2"> 2</label><br>
        <label><input type="radio" name="points" value="3"> 3</label><br>
        <label><input type="radio" name="points" value="5"> 5</label><br>
        <label><input type="radio" name="points" value="8"> 8</label><br>
        <label><input type="radio" name="points" value="13"> 13</label><br>
        <label><input type="radio" name="points" value="21"> 21</label><br>
        <input type="hidden" name="username" value="<?=$user?>">
        <input type="submit" value="Submit" style="height: 50px; width: 150px; width: 100%;">
    </form>
</body>
</html>