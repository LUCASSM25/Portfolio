//Dados iniciais
let square = {
    a1: '', a2:'', a3:'',
    b1: '', b2:'', b3:'',
    c1: '', c2:'', c3:''
};

let vez = '';

let warning = '';
let playinfg = false;

reset();
//Eventos

document.querySelector('.reset').addEventListener('click', reset);
//Primeira opção
document.querySelectorAll('.item').forEach(item=>{
    item.addEventListener('click',itemClick);

});

//Funções
function itemClick(event){
    let item = event.target.getAttribute('data-item');

    if(playing && square[item] === ''){
        square[item] = player;
        renderSquare(); // colocar na tela
        togglePlayer(); //funcao para mudar jogador
    }
}
function reset(){
    warning = '';

    let random = Math.floor(Math.random()*2);

    if(random === 0){ //Escolher vez do jogador aleatorio
        player = 'x';
    }else{
        player ='o';
    }

    for(let i in square){ // limpa o jogo
        square[i] = '';
    }

    playing =  true;

    renderSquare();
    renderInfo();
}

function renderSquare(){
    for(let i in square){
        console.log(i);
        let item = document.querySelector('div[data-item='+i+']');
        item.innerHTML = square[i];
    }
    checkGame();
}

function renderInfo(){
    document.querySelector('.vez').innerHTML = player;
    document.querySelector('.resultado').innerHTML = warning;
}

function  togglePlayer(){
    player = (player === 'x')?'o':'x';
    renderInfo();
}
function checkGame(){
    if(checkWinnerFor('x')){
        warning = 'O "x" venceu';
        playing = false;

    }else if(checkWinnerFor('o')){
        warning = 'O "o" venceu';
        playing = false;
    }else if(isFull()){
        warning = 'Deu empate';
        playing = false;
    }
}

function checkWinnerFor(player){
    let pos = [
        'a1,a2,a3',
        'b1,b2,b3',
        'c1,c2,c3',

        'a1,b1,c1',
        'a2,b2,c2',
        'a3,b3,c3',

        'a1,b2,c3',
        'a3,b2,c1',
    ]

    for(let w in pos){
        let pArray = pos[w].split(',');
        //FORMA MINIMIZADA
        let hasWon = pArray.every(option=>square[option] === player);
        if(hasWon){
            return true;
        }
    /* FORMA EXPANDIDA

        pArray.every((option)=>{
            if(square[option] === player){
                return true;
            }   else{
                return false;
            } 
        });
    */
    }
    return false;
}
function isFull(){
    for(let i in square)
    {
        if(square[i] ==='')
        {
            return false;
        }
    }
    return true;
}