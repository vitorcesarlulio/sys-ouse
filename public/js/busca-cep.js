const cep =  document.querySelector("#cep")

const showData = (result)=>{
    for(const campo in result){ //para cada um dos campos que veio nesse obj, result traz (cap, endereco etc) e para cada um deles armazena o nome dele na var campo
        if(document.querySelector("#"+campo)){ //se existir o campo
            document.querySelector("#"+campo).value = result[campo]//console.log(campo) //ele traz tds os campo, so que eu n quero todos
        }
    }
}

//blur = perdeu o foco, tab, vai no via cep faz a busca, traz o formato .json, trata o .json e mostra no console
cep.addEventListener("blur",(e)=>{
    let search = cep.value.replace("-", "")
    const options = {
        method: 'GET',
        modo: 'cors',
        cache: 'default'
    }

    fetch(`https://viacep.com.br/ws/${search}/json/`, options)
    .then(response=>{ response.json() //se der certo
        .then(data => showData(data)) //e se der certo
    }) 
    .catch(e => console.log('Deu erro:'+ e,message))//se der errado
})