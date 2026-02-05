<?php
session_start();
$data=json_decode(file_get_contents("php://input"),true);

function emptyBoard(){
$b=[];
for($i=0;$i<10;$i++) for($j=0;$j<10;$j++) $b[$i][$j]='';
return $b;
}

function placeShips(&$b){
$sizes=[5,3,2];
foreach($sizes as $s){
while(true){
$x=rand(0,9); $y=rand(0,9); $d=rand(0,1);
$ok=true;
for($i=0;$i<$s;$i++){
$nx=$x+($d?$i:0);
$ny=$y+($d?0:$i);
if($nx>9||$ny>9||$b[$ny][$nx]!='') $ok=false;
}
if($ok){
for($i=0;$i<$s;$i++){
$nx=$x+($d?$i:0);
$ny=$y+($d?0:$i);
$b[$ny][$nx]='S';
}
break;
}
}
}
}

function newGame($diff){
$_SESSION['player']=emptyBoard();
$_SESSION['enemy']=emptyBoard();
placeShips($_SESSION['player']);
placeShips($_SESSION['enemy']);
$_SESSION['aiMem']=[];
$_SESSION['pShots']=0;
$_SESSION['pHits']=0;
$_SESSION['aiShots']=0;
$_SESSION['aiHits']=0;
$_SESSION['diff']=$diff;
}

function aiTurn(){
$board=&$_SESSION['player'];

do{
$x=rand(0,9);$y=rand(0,9);
}while($board[$y][$x]=='H'||$board[$y][$x]=='M');

$_SESSION['aiShots']++;

if($board[$y][$x]=='S'){
$board[$y][$x]='H';
$_SESSION['aiHits']++;
}else{
$board[$y][$x]='M';
}
}

if($data['action']=='new'){
newGame($data['difficulty']);
}

if($data['action']=='fire'){
$x=$data['x'];$y=$data['y'];
$enemy=&$_SESSION['enemy'];

if($enemy[$y][$x]==''||$enemy[$y][$x]=='S'){
$_SESSION['pShots']++;
if($enemy[$y][$x]=='S'){
$enemy[$y][$x]='H';
$_SESSION['pHits']++;
$msg="Hit!";
}else{
$enemy[$y][$x]='M';
$msg="Miss!";
}
aiTurn();
}else{
$msg="Already fired.";
}
}

$out=[
'player'=>$_SESSION['player'],
'enemy'=>array_map(fn($r)=>array_map(fn($c)=>$c=='S'?'':$c,$r),$_SESSION['enemy']),
'pShots'=>$_SESSION['pShots'],
'pHits'=>$_SESSION['pHits'],
'aiShots'=>$_SESSION['aiShots'],
'aiHits'=>$_SESSION['aiHits'],
'message'=>$msg??''
];

echo json_encode($out);
