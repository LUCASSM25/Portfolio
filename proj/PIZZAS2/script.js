let modalQt = 1; // quantidade
let cart = []; // carrinho
modalKey = 0; // posicao da pizza selecionada

const c=function(el){
    return document.querySelector(el);
}

const cs = (el)=>document.querySelectorAll(el);

pizzaJson.map((item,index)=>{

    let pizzaItem = c('.models .pizza-item').cloneNode(true);  //cloneNode - clona o elemento

    pizzaItem.setAttribute('data-key', index);
    pizzaItem.querySelector('.pizza-item--img img').src=item.img;
    pizzaItem.querySelector('.pizza-item--name').innerHTML = item.name;
    pizzaItem.querySelector('.pizza-item--desc').innerHTML = item.description;
    pizzaItem.querySelector('.pizza-item--price').innerHTML = 'R$'+item.price.toFixed(2);
    pizzaItem.querySelector('a').addEventListener('click', (e)=>{  //addEventListener - (quando ocorrer um evento(click), executar funcao)
        e.preventDefault();
        let key = e.target.closest('.pizza-item').getAttribute('data-key');
        modalQt = 1;
        modalKey = key;
        
        c('.pizzaInfo h1').innerHTML = pizzaJson[key].name;
        c('.pizzaInfo--desc').innerHTML = pizzaJson[key].description;
        c('.pizzaBig img').src = pizzaJson[key].img;
        c('.pizzaInfo--actualPrice').innerHTML = 'R$ '+pizzaJson[key].price.toFixed(2); // toFixed - quantas casas decimais deve ter
        c('.pizzaInfo--size.selected').classList.remove('selected');
        cs('.pizzaInfo--size').forEach ((size, sizeIndex) =>{  //O forEach()método chama uma função uma vez para cada elemento em uma matriz(item, indice)
           
           if(sizeIndex == 2)
           { 
               size.classList.add('selected');
                } // adiciona uma classe chamada selected
            size.querySelector('span').innerHTML = pizzaJson[key].sizes[sizeIndex];
        });

        c('.pizzaInfo--qt').innerHTML = modalQt;

        c('.pizzaWindowArea').style.opacity=0;
        c('.pizzaWindowArea').style.display='flex';
        setTimeout(                                                          //setTimeout - (funcao, tempo para ser executada)
            ()=>{c('.pizzaWindowArea').style.opacity=1;}, 200);
    });
    
    c('.pizza-area').append(pizzaItem);  // append - adiciona o item

})

function sair(){
    c('.pizzaWindowArea').style.opacity=0;
    
    setTimeout(function()
    {
        c('.pizzaWindowArea').style.display='none';
    },200);

   }

cs('.pizzaInfo--cancelButton, .pizzaInfo--cancelMobileButton').forEach((item)=>{

        item.addEventListener('click',sair);
});

c('.pizzaInfo--qtmenos').addEventListener('click', function(){
    (modalQt>1)?modalQt--:modalQt;
    c('.pizzaInfo--qt').innerHTML = modalQt;
});

c('.pizzaInfo--qtmais').addEventListener('click', function(){
    modalQt++;
    c('.pizzaInfo--qt').innerHTML = modalQt;

});

cs('.pizzaInfo--size').forEach((size,sizeIndex)=>{
    size.addEventListener('click', ()=>{
        c('.pizzaInfo--size.selected').classList.remove('selected');
        size.classList.add('selected');
    });
});

c('.pizzaInfo--addButton').addEventListener('click', function(){
    
    let size = c('.pizzaInfo--size.selected').getAttribute('data-key');

    let identifier = pizzaJson[modalKey].id+'@'+size;

    let key = cart.findIndex(item =>{
        return item.identifier == identifier;
    })
    if(key >-1){
        cart[key].qt += modalQt;
    }else{

    cart.push({
        id:pizzaJson[modalKey].id,
        size,
        qt: modalQt
    });
}
    closeModal();
});
//PAREI AULA 10