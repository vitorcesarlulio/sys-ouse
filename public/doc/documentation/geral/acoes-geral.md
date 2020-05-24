# Sys Ouse

## Efeitos Gerais JS, HTML
**Abrir aba em uma nova guia:**

``` <a href="htttps://www.google.com" target="_blank">Ir para o Google em nova página</a> ```

**Não permitir que guarde informaçoes nos campos, igual quando voce vai inserir um novo cliente e ele pega os dados do ultimo cliente cadastrado como se fosse um cache:**

``` 
<form role="form" id="quickForm" novalidate="novalidate" **autocomplete="off"**>
</form> 
```

**Deixar radio já selecionado:**

```
    <input class="custom-control-input" type="radio" id="optionPhysicalPerson" name="tipopessoa" onclick="tipoPessoaSel();" **checked=""**>              
```



