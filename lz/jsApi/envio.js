let selec = false;
let nome = "";
let cel = "";
let data
let cart = [];
let Ent = ['Nao'];

function openEnt() {
    let open = document.querySelector('.openEnt').style.display;
    if (open == 'none') {
        document.querySelectorAll('.openEnt').forEach((e) => {
            e.style.display = "flex";
            Ent['0'] = 'Sim';
        });
    } else
        if (open == 'flex') {
            document.querySelectorAll('.openEnt').forEach((e) => {
                e.style.display = "none";
                Ent['0']  = 'Nao';
            });
        }
}

document.querySelectorAll('.BTNmenos').forEach((e) => {
    e.addEventListener("click", function (e) {
        let areaQuant = e.target.parentNode
        let produto = areaQuant.parentNode.parentNode
        menos = parseInt(areaQuant.querySelector('.qt').textContent);
        if (menos > 0 && menos != '')
            areaQuant.querySelector('.qt').textContent = menos - 1;
    });
});

document.querySelectorAll('.BTNmais').forEach((e) => {
    e.addEventListener("click", function (e) {
        let areaQuant = e.target.parentNode;
        let produto = areaQuant.parentNode.parentNode
        mais = parseInt(areaQuant.querySelector('.qt').textContent);
        areaQuant.querySelector('.qt').textContent = mais + 1;
    });
});

function envCart() {
    //Quantidade e produto
    document.querySelectorAll('.produtos').forEach((e) => {
        if (parseInt(e.querySelector('.qt').textContent) > 0) {
            let id = parseInt(e.getAttribute('data-id'));
            let qt = parseInt(e.querySelector('.qt').textContent);
            cart.push(id + '&' + qt); // Adiciona 
            selec = true;
        }
    });
    // MODAL: PEGA DATA, NOME, CEL
    if (selec) {
        let i = 0;
        document.querySelectorAll('input').forEach((e) => {
            i++;
            switch (i) {
                case 1:
                    data = e.value;
                    break
                case 2:
                    nome = e.value;
                    break
                case 3:
                    cel = e.value;
                    break
            }
        });
        if (Ent == 'Sim') { //SE FOR ENTREGA
            document.querySelectorAll('.openEnt').forEach((e) => { 
                Ent.push(e.querySelector('input').value) 
            });
        }
        cadastrar(data, nome, cel, cart, Ent);// ENVIA
        cart = [];
        selec = true;
    }
}

async function cadastrar(data, nome = 'Cliente', cel, cart, Ent) {
    let url = "./pag/registro.php";
    let dados = {
        data: data,
        nome: nome,
        cel: cel,
        cart: cart,
        Ent: Ent
    }
    let result = await fetch(url,
        {
            method: 'POST',
            body: JSON.stringify({
                data: data,
                nome: nome,
                cel: cel,
                cart: cart,
                Ent: Ent
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        });

    if (result.ok) {
        // A requisição foi bem-sucedida
        console.log('Requisição bem-sucedida');
        console.log(result.text());
    } else {
        // A requisição falhou
        console.log('Erro na requisição');
    }

}