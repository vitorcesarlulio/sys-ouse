# Sys Ouse

## Efeitos Javascript/JQuery
**Ao clicar no botao ele oculta, se clicar de novo ele mostra:**

```<!DOCTYPE html>
<html>
<head>
<style> 
#myDIV {
  width: 500px;
  height: 500px;
  background-color: lightblue;
}
</style>
</head>
<body>

<p>Click the "Try it" button to toggle between hiding and showing the DIV element:</p>

<button onclick="myFunction()">Try it</button>

<div id="myDIV">
This is my DIV element.
</div>

<p><b>Note:</b> The element will not take up any space when the display property set to "none".</p>

<script>
function myFunction() {
  var x = document.getElementById('myDIV');
  if (x.style.display === 'none') {
    x.style.display = 'block';
  } else {
    x.style.display = 'none';
  }
}
</script>

</body>
</html>```

**Ao clicar na opção "Cadastro Completo" ou "Cadastro Simples" adicona ou retira componentes (Exemplo: uma div, no caso a div CPF):**

```
	<div class="col-sm-2">
                        <div class="form-group">
                            <label>Tipo de Cadastro</label>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio1" name="customRadio">
                                <label for="customRadio1" class="custom-control-label">Basico</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio2" name="customRadio" checked="">
                                <label for="customRadio2" class="custom-control-label">Completo</label>
                            </div>
                        </div>
	</div>

<!-- Função para ocultar campos -->
<script>
    function functionRegisterBasic() {
    document.getElementById("divRecordTypec").style.display = "none";
    }
</script>

<!-- Função para mostrar campos -->
<script>
    function functionRegisterComplete() {
    document.getElementById("divRecordTypec").style.display = "block";
    }
</script>```

**Ao abrir o formulario o campo CPF ja vem oculto, se clicar na opção "Completo | Basico" ele mostra o campo CPF e se clicar de novo ele oculta:**

``` 
<div class="col-sm-2" id="minhaDiv" style="display:none">
                        <div class="form-group">
                            <label>CPF</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                </div>
                                <input type="text" class="form-control" data-inputmask="'mask': ['999.999.999.99']" data-mask="" im-insert="true">
                            </div>
                        </div>
                    </div>

<script>
function Mudarestado(el) {
  var display = document.getElementById(el).style.display;
  if (display == "none")
    document.getElementById(el).style.display = 'block';
  else
    document.getElementById(el).style.display = 'none';
}
</script>
```


**Mesmo campo aceita CPF e CNPJ se o usuario digitar mais digitos que o CPF se torna um CNPJ:**
```$("input[id*='cpfcnpj']").inputmask({
  mask: ['999.999.999-99', '99.999.999/9999-99'],
  keepStatic: true
});
<script src="https://code.jquery.com/jquery-1.10.0.min.js"></script>
<script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>


<input id="cpfcnpj" placeholder="CPF ou CNPJ" />```

**Ou se estiver utilizando o template adminLTE3 somente coloque isso:**
```<input type="text" class="form-control" data-inputmask="'mask': ['999.999.999-99', '99.999.999/9999-99']" data-mask="" im-insert="true">```

**Cursor do mouse focado no elemento:**
```<input type="text" class="form-control" placeholder="Enter ..." autofocus>```

**Deixar elemento nao editavel:**
```<input type="text" class="form-control" id="uf" placeholder="Enter ..." **disabled**>```

