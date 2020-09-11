<?php
require_once '../app/View/login/check-login.php';
?>
@extends('templates.default')

@section('title', 'Cadastrar Pessoas')

@section('head')
@endsection

@section('css')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="/pessoas">Pessoas</a></li>
<li class="breadcrumb-item">Cadastro</li>
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
        <form role="form" id="formRegisterPeople" method="POST" novalidate="novalidate" autocomplete="off">
          <div class="card-body">
            <div class="row">

              <!-- Opção Tipo de Pessoa -->
              <div id="optinPerson" class="col-sm-2">
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
              <div id="physicalPerson" class="col-sm-2">
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

              <div class="col-sm-2" id="divNameRegister">
                <div class="form-group">
                  <label for="nameRegister">Nome</label>
                  <input type="text" name="nameRegister" class="form-control" id="nameRegister" autofocus placeholder="Entre com o Nome">
                </div>
              </div>
              <div class="col-sm-2" id="divSurnameRegister">
                <div class="form-group">
                  <label for="surnameRegister">Sobrenome</label>
                  <input type="text" name="surnameRegister" class="form-control" id="surnameRegister" placeholder="Entre com o Sobrenome">
                </div>
              </div>


              <div class="col-sm-2" style="display:none;" id="divCompanyNameRegister">
                <div class="form-group">
                  <label>Razão Social</label>
                  <input type="text" name="companyNameRegister" class="form-control" id="companyNameRegister" placeholder="Entre com a Razão Social">
                </div>
              </div>

              <div class="col-sm-2" style="display:none;" id="divFantasyNameRegister">
                <div class="form-group">
                  <label>Nome Fantasia</label>
                  <input type="text" name="fantasyNameRegister" class="form-control" id="fantasyNameRegister" placeholder="Entre com a Razão Social">
                </div>
              </div>

              <!--

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
              </div> -->

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


              <div class="col-sm-2" id="divTypeResidenceRegister">
                <div class="form-group">
                  <label>Tipo de Residencia</label>
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="optionHomeRegister" name="typeResidence" onclick="optionTypeResidenceRegister();">
                    <label for="optionHomeRegister" class="custom-control-label">Casa</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="optionBuildingRegister" name="typeResidence" onclick="optionTypeResidenceRegister();">
                    <label for="optionBuildingRegister" class="custom-control-label">Apartamento</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="optionCondominiumRegister" name="typeResidence" onclick="optionTypeResidenceRegister();">
                    <label for="optionCondominiumRegister" class="custom-control-label">Condomínio</label>
                  </div>
                </div>
              </div>


              <div id="divStreetCondominiumRegister" class="col-sm-2" style="display:none">
                <div class="form-group">
                  <label>Rua do Condomínio</label>
                  <input type="text" name="streetCondominiumRegister" id="streetCondominiumRegister" class="form-control">
                </div>
              </div>

              <div id="divNumberRegister" class="col-sm-2" style="display:none">
                <div class="form-group">
                  <label>Número</label>
                  <input type="text" name="numberRegister" id="numberRegister" class="form-control">
                </div>
              </div>

              <div id="divEdificeRegister" class="col-sm-2" style="display:none">
                <div class="form-group">
                  <label>Edifício</label>
                  <input type="text" name="edificeRegister" id="edificeRegister" class="form-control">
                </div>
              </div>
              <div id="divBlockRegister" class="col-sm-2" style="display:none">
                <div class="form-group">
                  <label>Bloco</label>
                  <input type="text" name="blockRegister" id="blockRegister" class="form-control">
                </div>
              </div>
              <div id="divApartmentRegister" class="col-sm-2" style="display:none">
                <div class="form-group">
                  <label>Apartamento</label>
                  <input type="text" name="apartmentRegister" id="apartmentRegister" class="form-control">
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Observações:</label>
                  <textarea class="form-control" rows="3" name="observationRegister" id="observationRegister" style="height: 70px;"></textarea>
                </div>
              </div>

            </div>
          </div>
          <div class="card-footer">
            <button type="reset" class="btn btn-default" value="Limpar formulário"> Limpar </button>
            <button type="submit" class="btn btn-success btn-register-people">Cadastrar</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="<?= DIRJS . 'people/register-people-validation.js' ?>"></script>
<script src="<?= DIRJS . 'people/people-register.js' ?>"></script>

<!-- Busca endereço pelo CEP -->
<script src="<?= DIRJS . 'search-zip/search-zip.js' ?>"></script>

<!-- InputMask (MASCARAS) -->
<script src="<?= DIRPLUGINS . 'moment/moment.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'inputmask/min/jquery.inputmask.bundle.min.js' ?>"></script>

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