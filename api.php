<?php
require_once 'db.php';

$query = 'SELECT p.UserName, HasVote, IF(vote.NoVote > 0, "?", p.Points) AS Points FROM poker p, (SELECT COUNT(*) AS NoVote FROM poker WHERE HasVote = 0) vote';
$poker = $db->query($query);
$hasVoted = $poker->fetch_all(MYSQLI_ASSOC);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($hasVoted);

