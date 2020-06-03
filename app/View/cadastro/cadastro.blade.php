@extends('templates.default')

@section('title', 'Cadastro')

@section('css')
<style>
  .line-title{
    border-bottom: 2px solid red;
  }
</style>
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- jquery validation -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
        </div>
        <!-- form start -->
        <form role="form" id="quickForm" action="/cadastrar" novalidate="novalidate" autocomplete="off" method="post">
          <div class="card-body">
            <div class="row">

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Tipo de Cadastro</label>
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="optionRegisterBasic" name="typeregister" onclick="selTypeRegister();" checked="">
                    <label for="optionRegisterBasic" class="custom-control-label">Basico</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="optionRegisterComplete" name="typeregister" onclick="selTypeRegister();">
                    <label for="optionRegisterComplete" class="custom-control-label">Completo</label>
                  </div>
                </div>
              </div>


              <div class="col-sm-2">
                <div class="form-group">
                  <label for="exampleInputNome1">Nome</label>
                  <input type="text" name="name" class="form-control" id="exampleInputNome1" placeholder="Entre com o Nome">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="exampleInputSurname1">Sobrenome</label>
                  <input type="text" name="surname" class="form-control" id="exampleInputSurname1" placeholder="Entre com o Sobrenome">
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label for="exampleInputCellPhone1">Celular</label>
                  <input type="text" name="cellphone" class="form-control" id="exampleInputCellPhone1" data-inputmask="&quot;mask&quot;: &quot;(99) 99999-9999&quot;" data-mask="" value="19" placeholder="Entre com o Celular">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="exampleInputTelephone1">Telefone</label>
                  <input type="text" name="telephone" class="form-control" id="exampleInputTelephone1" data-inputmask="&quot;mask&quot;: &quot;(99) 9999-9999&quot;" data-mask="" value="19" placeholder="Entre com o Telefone">
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Entre com o Email">
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label>CEP</label>
                  <a href="http://www.buscacep.correios.com.br/sistemas/buscacep/buscaCepEndereco.cfm" target="_blank"> <i class="fas fa-question-circle"></i> </a>
                  <input type="text" class="form-control" name="cep" id="cep" data-inputmask="'mask': ['99999-999']" data-mask="" placeholder="Entre com o CEP" value="13">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="logradouro">Logradouro</label>
                  <input type="text" name="street" class="form-control" style="cursor: not-allowed;" id="logradouro" placeholder="Entre com o Logradouro" disabled>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="bairro">Bairro</label>
                  <input type="text" name="neighborhood" class="form-control" style="cursor: not-allowed;" id="bairro" placeholder="Entre com o Bairro" disabled>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="localidade">Cidade</label>
                  <input type="text" name="city" class="form-control" style="cursor: not-allowed;" id="localidade" placeholder="Entre com a Cidade" disabled>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="uf">Estado</label>
                  <input type="text" name="surname" class="form-control" style="cursor: not-allowed;" id="uf" placeholder="Entre com o Estado" disabled>
                </div>
              </div>


              <div class="col-sm-2">
                <div class="form-group">
                  <label>Tipo de Residencia</label>
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="optionHome" name="typeresidence" onclick="selTypeResidence();">
                    <label for="optionHome" class="custom-control-label">Casa</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="optionBuilding" name="typeresidence" onclick="selTypeResidence();">
                    <label for="optionBuilding" class="custom-control-label">Apartamento</label>
                  </div>
                </div>
              </div>


              <div id="number" class="col-sm-2" style="display:none">
                <div class="form-group">
                  <label for="exampleInputNumber1">Número</label>
                  <input type="text" name="number" class="form-control" id="exampleInputNumber1" placeholder="Entre com o Número">
                </div>
              </div>

              <div id="edifice" class="col-sm-2" style="display:none">
                <div class="form-group">
                  <label for="exampleInputEdifice1">Edifício</label>
                  <input type="text" name="edifice" class="form-control" id="exampleInputEdifice1" placeholder="Entre com o Edifício">
                </div>
              </div>
              <div id="block" class="col-sm-2" style="display:none">
                <div class="form-group">
                  <label for="exampleInputBlock1">Bloco</label>
                  <input type="text" name="block" class="form-control" id="exampleInputBlock1" placeholder="Entre com o Bloco">
                </div>
              </div>
              <div id="apartment" class="col-sm-2" style="display:none">
                <div class="form-group">
                  <label for="exampleInputApartment1">Apartamento</label>
                  <input type="text" name="apartment" class="form-control" id="exampleInputApartment1" placeholder="Entre com o Apartamento">
                </div>
              </div>


              <!-- Opção Tipo de Pessoa -->
              <div id="optinPerson" class="col-sm-2" style="display:none">
                <div class="form-group">
                  <label>Tipo de Pessoa</label>
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="optionPhysicalPerson" name="typeperson" onclick="selTypePerson();" checked="">
                    <label for="optionPhysicalPerson" class="custom-control-label">Pessoa Física</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="optionPhysicalLegal" name="typeperson" onclick="selTypePerson();">
                    <label for="optionPhysicalLegal" class="custom-control-label">Pessoa Jurídica</label>
                  </div>
                </div>
              </div>

              <!-- Tipo de Pessoa -->
              <div id="physicalPerson" class="col-sm-2" style="display:none">
                <div class="form-group">
                  <label for="cpf">CPF</label>
                  <input type="text" name="cpf" class="form-control" id="cpf" data-inputmask="'mask': ['999.999.999.99']" data-mask="" placeholder="Enter CPF">
                </div>
              </div>

              <div id="physicalLegal" class="col-sm-2" style="display: none;">
                <div class="form-group">
                  <label for="cnpj">CNPJ</label>
                  <input type="text" name="cnpj" class="form-control" id="cnpj" data-inputmask="'mask': ['99.999.999/9999-99']" data-mask="" placeholder="Entre com CNPJ">
                </div>
              </div>

              <h3 class="line-title"><b>Contato</b></h3>

              <div class="col-sm-12">
              <div class="card-header">
                <h3 class="card-title"><b>Contato</b></h3>
              </div>
              </div>


              <div class="col-sm-1">
                <div class="form-group">
                  <label>Cadastro:</label>
                  <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" value="{{date('d/m/Y')}}">
                </div>
              </div>

            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /.row -->
</div>
@endsection

@section('script')

<!-- Scripts para opçoes (simples, completo, pessoa fisica) -->
<script src="<?= DIRPLUGINS . 'cadastro-cliente/options-cadastro-cliente.js' ?>"></script>

<!-- InputMask (MASCARAS) -->
<script src="<?= DIRPLUGINS . 'moment/moment.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'inputmask/min/jquery.inputmask.bundle.min.js' ?>"></script>

<!-- Busca endereço pelo CEP -->
<script src="<?= DIRJS . 'busca-cep.js' ?>"></script>

<!-- jquery-validation (PRECISO PARA DAR A MENSAGEM e validar CPF, CPNJ EMAIL etc) -->
<script src="<?= DIRPLUGINS . 'jquery-validation/jquery.validate.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'jquery-validation/additional-methods.min.js' ?>"></script>

<!-- Mensagem de validação -->
<script src="<?= DIRPLUGINS . 'cadastro-cliente/msg-validacao.js' ?>"></script>

<!-- Page script (mascaras) -->
<script>
  $(function() {
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', {
      'placeholder': 'dd/mm/yyyy'
    })

    //Money Euro E AS MACARAS TAMBEM SAI SE VC TIRAR
    $('[data-mask]').inputmask()

  })
</script>

@endsection