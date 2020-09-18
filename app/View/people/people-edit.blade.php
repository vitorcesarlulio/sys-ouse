<?php

if (isset($_GET) && !empty($_GET)) {

  /* Descriptografando o ID */
$string1 = str_replace("FJFVSD-JHBN-LASDQF-WEFG", "", $_GET['id']); 
$string2 = str_replace("SKD-HAKUSBCBJ-DMG-WSSDASD", "", $string1); 
$idPeople = ($string2 / 9625) / 10101010;

include_once '../app/Model/connection-pdo.php';

$querySelectPeople = " SELECT * FROM tb_pessoas WHERE pess_codigo = :id ";
$searchPeople = $connectionDataBase->prepare($querySelectPeople);
$searchPeople->bindParam(':id', $idPeople);
$searchPeople->execute();
$searchPeople = $searchPeople->fetch(PDO::FETCH_ASSOC);
}
?>
@extends('templates.default')

@section('title', 'Editar Pessoas')

@section('head')
@endsection

@section('css')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="/pessoas">Pessoas</a></li>
<li class="breadcrumb-item">Editar</li>
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
              <div class="col-sm-2">
                <div class="form-group">
                  <label>Tipo de Pessoa</label>
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="optionPhysicalPerson" name="typePerson" onclick="selTypePerson();" value="F">
                    <label for="optionPhysicalPerson" class="custom-control-label">Pessoa Física</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="optionPhysicalLegal" name="typePerson" onclick="selTypePerson();" value="J">
                    <label for="optionPhysicalLegal" class="custom-control-label">Pessoa Jurídica</label>
                  </div>
                </div>
              </div>

              <!-- Tipo de Pessoa -->
              <div id="divPhysicalPerson" class="col-sm-2">
                <div class="form-group">
                  <label for="cpf">CPF</label>
                  <input type="text" name="cpf" class="form-control" id="cpf" autofocus data-inputmask="'mask': ['999.999.999.99']" data-mask="" placeholder="Entre com CPF" onblur="findCPF();" >
                </div>
              </div>

              <div id="physicalLegal" class="col-sm-2" style="display: none;">
                <div class="form-group">
                  <label for="cnpj">CNPJ</label>
                  <input type="text" name="cnpj" class="form-control" id="cnpj" data-inputmask="'mask': ['99.999.999/9999-99']" data-mask="" placeholder="Entre com CNPJ" onblur="ckeckCnpj(this.value);">
                </div>
              </div>

              <div class="col-sm-2" id="divName">
                <div class="form-group">
                  <label for="name">Nome</label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="Entre com o Nome">
                </div>
              </div>
              <div class="col-sm-2" id="divSurname">
                <div class="form-group">
                  <label for="surname">Sobrenome</label>
                  <input type="text" name="surname" class="form-control" id="surname" placeholder="Entre com o Sobrenome">
                </div>
              </div>


              <div class="col-sm-2" style="display:none;" id="divCompanyName">
                <div class="form-group">
                  <label>Razão Social</label>
                  <input type="text" name="companyName" class="form-control" id="companyName" placeholder="Entre com a Razão Social">
                </div>
              </div>

              <div class="col-sm-2" style="display:none;" id="divFantasyName">
                <div class="form-group">
                  <label>Nome Fantasia</label>
                  <input type="text" name="fantasyName" class="form-control" id="fantasyName" placeholder="Entre com o Nome Fantasia">
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label>CEP</label>
                  <a href="http://www.buscacep.correios.com.br/sistemas/buscacep/buscaCepEndereco.cfm" target="_blank"> <i class="fas fa-question-circle"></i> </a>
                  <input type="text" class="form-control" name="cep" id="cep" data-inputmask="'mask': ['99999-999']" data-mask="" placeholder="Entre com o CEP" value="">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="logradouro">Logradouro</label>
                  <input type="text" name="logradouro" class="form-control" style="cursor: not-allowed;" id="logradouro" placeholder="Entre com o Logradouro" readonly=“true”>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="bairro">Bairro</label>
                  <input type="text" name="bairro" class="form-control" style="cursor: not-allowed;" id="bairro" placeholder="Entre com o Bairro" readonly=“true”>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="localidade">Cidade</label>
                  <input type="text" name="localidade" class="form-control" style="cursor: not-allowed;" id="localidade" placeholder="Entre com a Cidade" readonly=“true”>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="uf">Estado</label>
                  <input type="text" name="uf" class="form-control" style="cursor: not-allowed;" id="uf" placeholder="Entre com o Estado" readonly=“true”>
                </div>
              </div>


              <div class="col-sm-2" id="divTypeResidence">
                <div class="form-group">
                  <label>Tipo de Residencia</label>
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="optionHome" name="typeResidence" onclick="optionTypeResidence();" value="casa">
                    <label for="optionHome" class="custom-control-label">Casa</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="optionBuilding" name="typeResidence" onclick="optionTypeResidence();" value="apartamento">
                    <label for="optionBuilding" class="custom-control-label">Apartamento</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="optionCondominium" name="typeResidence" onclick="optionTypeResidence();" value="condominio">
                    <label for="optionCondominium" class="custom-control-label">Condomínio</label>
                  </div>
                </div>
              </div>


              <div id="divStreetCondominium" class="col-sm-2" style="display:none">
                <div class="form-group">
                  <label>Rua do Condomínio</label>
                  <input type="text" name="streetCondominium" id="streetCondominium" class="form-control">
                </div>
              </div>

              <div id="divNumber" class="col-sm-2" style="display:none">
                <div class="form-group">
                  <label>Número</label>
                  <input type="text" name="number" id="number" class="form-control">
                </div>
              </div>

              <div id="divEdifice" class="col-sm-2" style="display:none">
                <div class="form-group">
                  <label>Edifício</label>
                  <input type="text" name="edifice" id="edifice" class="form-control">
                </div>
              </div>
              <div id="divBlock" class="col-sm-2" style="display:none">
                <div class="form-group">
                  <label>Bloco</label>
                  <input type="text" name="block" id="block" class="form-control">
                </div>
              </div>
              <div id="divApartment" class="col-sm-2" style="display:none">
                <div class="form-group">
                  <label>Apartamento</label>
                  <input type="text" name="apartment" id="apartment" class="form-control">
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Observações:</label>
                  <textarea class="form-control" rows="3" name="observation" id="observation" style="height: 70px;"></textarea>
                </div>
              </div>

            </div>
          </div>
          <div class="card-footer">
            <button type="reset" class="btn btn-default" value="Limpar formulário"> Limpar </button>
            <button type="submit" class="btn btn-success btn-register-people" id="btnRegisterPeople">Cadastrar</button>
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