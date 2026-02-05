const SIZE=10;

function draw(board,id,clickable){
const div=document.getElementById(id);
div.innerHTML='';
div.className='grid';

board.forEach((row,y)=>{
row.forEach((c,x)=>{
const d=document.createElement('div');
d.className='cell';
if(c=='S') d.classList.add('ship');
if(c=='H') d.classList.add('hit');
if(c=='M') d.classList.add('miss');
if(clickable) d.onclick=()=>fire(x,y);
div.appendChild(d);
});
});
}

async function api(data){
const r=await fetch('server/api.php',{
method:'POST',
headers:{'Content-Type':'application/json'},
body:JSON.stringify(data)
});
return r.json();
}

async function newGame(){
const diff=document.getElementById('difficulty').value;
const res=await api({action:'new',difficulty:diff});
render(res);
}

async function fire(x,y){
const res=await api({action:'fire',x,y});
render(res);
}

function render(state){
draw(state.player,'player',false);
draw(state.enemy,'enemy',true);

document.getElementById('stats').innerHTML=
`Player Shots: ${state.pShots}<br>
Player Hits: ${state.pHits}<br>
AI Shots: ${state.aiShots}<br>
AI Hits: ${state.aiHits}<br>
${state.message}`;
}

newGame();
