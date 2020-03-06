<?php
require_once 'db.php';

$poker = $db->query('SELECT p.UserName, HasVote, IF(vote.NoVote > 0, "?", p.Points) AS Points FROM poker p, (SELECT COUNT(*) AS NoVote FROM poker WHERE HasVote = 0) vote ORDER BY p.UserName ASC');
$users = $poker->fetch_all(MYSQLI_ASSOC);
$reset = $_GET['reset'] ?? null;
if($reset){
    $db->query("UPDATE poker SET points='?', HasVote = 0");
    header("location:show.php");
}
?>

<html>
<head>
    <style>
        body{
            font-family: 'Roboto Slab';
            background-color: #2d2d2d;
            color: white;
            padding: 0;
            margin: 0;
        }
        .poker-wrapper {
            width: 982px;
            text-align: center;
            font-size: 40px;
            margin-left: auto;
            margin-right: auto;
        }        
        .table-theme{
            font-size: 35px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 50px;
            margin-bottom: 50px;
        }
        ul.employee-list{
            padding: 0;
            margin: 0;
            display: block;
            columns: 2;
            -webkit-columns: 2;
            -moz-columns: 2;
            list-style: none;
            margin-top: 25px;
            margin-bottom: 50px;
        }
        ul.employee-list li{
            position: relative;
            padding-left: 40px;
            padding-right: 40px;
            margin-bottom: 23px;
        }
        .btn{
            font-size: 25px;
            color: #000;
            background: #e0e0e0; 
            text-decoration: none; 
            border: 1px solid #b9b9b9; 
            padding: 10px 50px; 
        } 
        .btn:hover{
            background: #ffffff;
        }
        .table-theme tr td{
            padding: 10px;
        }
        .text-green{
            color: #6eff6e;
        }
        .voted{
            color: #6eff6e;
        }
        .text-center{
            text-align: center;
        }
        .vote-status{
            position: absolute;
            left: 80px;
        }
        .vote-points{
            position: absolute;
            right: 80px;
        }
    </style>
</head>
<body>
    <div class="poker-wrapper">
        <?php 
            $votes = array_column($users, 'Points');
            $allVote = in_array('0', $votes);
        ?>
        <ul class="employee-list">
        <?php foreach($users AS $user) :?>
            <li <?= (empty($user['HasVote']) ? '' : 'class="voted"' ) ?>>
                <?php if(empty($user['HasVote'])) : ?>
                    <span class="vote-status" id="<?=$user['UserName']?>_vote">○</span>
                <?php else : ?>
                    <span class="vote-status" id="<?=$user['UserName']?>_vote">●</span>
                <?php endif; ?>
                <?=$user['UserName']?>
                <span class="vote-points" id="<?=$user['UserName']?>_points"><?= $allVote ? '0' : $user['Points'] ?></span>
            </li>
        <?php endforeach;?>	
        </ul>	
        <a href="show.php?reset=1" class="btn">Reset</a>
    </div>
	<script  src="jquery/dist/jquery.min.js"></script>
  <script>
	var apiChecker = setInterval(function() {
        $.ajax({
            url: "api.php",
            error: function(){
                // will fire when timeout is reached
            },
            success: function(e){
                var allVote = true;
                $.each(e, function(k,v){
                    if(v.Points == '?') {
                        allVote = false;
                    }
                });
                $.each(e, function(k,v){
                    var voter = v.UserName;
                    var hasVote = v.HasVote;
                    var points = v.Points;
                    var user = '#'+v.UserName+'_vote';
                    var container = $('#'+v.UserName+'_vote');
                    if(hasVote === '1'){
                        $('#'+v.UserName+'_vote').html('●');
                        $('#'+v.UserName+'_vote').parent().addClass('voted');
                        $('#'+v.UserName+'_vote').addClass('voted');
                    }else{
                        $('#'+v.UserName+'_vote').html('○');
                        $('#'+v.UserName+'_vote').parent().removeClass('voted');
                        $('#'+v.UserName+'_vote').removeClass('voted');
                    }
                });
                if(allVote){
                    $.each(e, function(k,v){
                        var points = v.Points;
                        $('#'+v.UserName+'_points').html(points);
                    });
                    clearInterval(apiChecker);
                    sortPoints ();
                }				
            },
        });	
	}, 800); //5 seconds

    function sortPoints () {
        $(".listitems li").sort(sort_li).appendTo('.listitems');
        console.log('teste');
        function sort_li(a, b){
            console.log(sort_li);
            // return ($(b).data('position')) < ($(a).data('position')) ? 1 : -1;    
        }
    }

    function play(){
        var audio = document.getElementById("audio");
        audio.play();
        return false;
    }
  </script>
</body>
</html>