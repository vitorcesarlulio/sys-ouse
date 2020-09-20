@extends('templates.default')

@section('title', 'Editar Orçamento')

@section('css')
@endsection
@section('content')
<?php
include '../app/Model/connection-pdo.php';

$idBudget = filter_input(INPUT_GET, 'budget', FILTER_SANITIZE_NUMBER_INT);

?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary collapsed-card">
        <div class="card-header">
          <h3 class="card-title">Dados do Cliente</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
          </div>
        </div>
        <form role="form" id="formFilters" autocomplete="off" enctype="multipart/form-data">
          <div class="card-body">
            <div class="row">

              <div class="col-sm-2">
                <div class="form-group">
                  <label for="exampleInputNome1">Nome</label>
                  <input type="text" name="name" class="form-control" id="exampleInputNome1" autofocus placeholder="Entre com o Nome">
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
                  <label>Tipo de Residência</label>
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
                  <input type="text" name="number" class="form-control" placeholder="Entre com o Número">
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

            </div>
          </div>
        </form>
        <div class="card-footer">
          <button type="reset" class="btn btn-default" value="Reset"><i class="fas fa-times"></i></button>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <a class="btn btn-app btn-new-topic">
      <i class="fas fa-paragraph"></i> Add Topico
    </a>

    <a class="btn btn-app btn-new-environment">
      <i class="far fa-square"></i> Add Ambiente
    </a>
  </div>

  <div class="row" id="addTopic" style="display: none;">
    <div id="registerTopic" class="col-sm-2">
      <div class="form-group">
        <label>Topico</label>
        <input type="text" name="registerTopic" class="form-control" id="registerTopic">
      </div>
    </div>
  </div>

  <div class="row" id="addEnvironment" style="display: none;">
    <div id="registerEnvironment" class="col-sm-2">
      <div class="form-group">
        <label>Ambiente</label>
        <input type="text" name="registerEnvironment" class="form-control" id="registerEnvironment">
      </div>
    </div>

    <div id="registerEnvironment" class="col-sm-1">
      <div class="form-group">
        <label>Medida 1</label>
        <input type="text" name="registerEnvironment" class="form-control" id="registerEnvironment">
      </div>
    </div>

    <div id="registerEnvironment" class="col-sm-1">
      <div class="form-group">
        <label>Medida 2</label>
        <input type="text" name="registerEnvironment" class="form-control" id="registerEnvironment">
      </div>
    </div>

    <div id="registerEnvironment" class="col-sm-1">
      <div class="form-group">
        <label style="text-align: center;">Total: M²</label>
        <input type="text" name="registerEnvironment" class="form-control" id="registerEnvironment">
      </div>
    </div>

    <button type="button" class="btn btn-block btn-success">Salvar</button>
    <button type="button" class="btn btn-block btn-danger">Cancelar</button>

  </div>

  <div class="card">
              <div class="card-header">
                <h3 class="card-title">Striped Full Width Table</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Nº</th>
                      <th>Descrição</th>
                      <th>Medida 1</th>
                      <th>Medida 2</th>
                      <th>M²</th>
                      <th>Total</th>
                      <th>Açoes</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr style="background-color: green;">
                      <td>1</td>
                      <td>PAVIMENTO SUPERIOR</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="background-color: greenyellow;">
                      <td>1.1</td>
                      <td>Sala</td>
                      <td>2.00</td>
                      <td>2.00</td>
                      <td>4.00</td>
                      <td>R$ 200,00</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>1.1.1</td>
                      <td>Forro de Gesso Acartonado Tabicado</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>1.1.2</td>
                      <td>Sanca Fechada Tabicada</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>1.1.3</td>
                      <td>Molduras</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="background-color: green;">
                      <td>2</td>
                      <td>PAVIMENTO TERREO</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="background-color: greenyellow;">
                      <td>2.1</td>
                      <td>Quarto</td>
                      <td>3.00</td>
                      <td>3.00</td>
                      <td>9.00</td>
                      <td>R$ 450,00</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>2.1.1</td>
                      <td>Forro de Gesso Acartonado Tabicado</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>2.1.2</td>
                      <td>Sanca Fechada Tabicada</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>2.1.3</td>
                      <td>Molduras</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

</div>
@endsection

@section('script')

<!-- Scripts para opçoes (simples, completo, pessoa fisica) -->
<script src="<?= DIRPLUGINS . 'cadastro-cliente/options-cadastro-cliente.js' ?>"></script>

<!-- InputMask (MASCARAS) -->
<script src="<?= DIRPLUGINS . 'moment/moment.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'inputmask/min/jquery.inputmask.bundle.min.js' ?>"></script>

<!-- Busca endereço pelo CEP -->
<script src="<?= DIRPLUGINS . 'search-zip/search-zip.js' ?>"></script>

<!-- Mensagem de validação -->
<script src="<?= DIRPLUGINS . 'cadastro-cliente/msg-validacao.js' ?>"></script>

<!-- Page script (mascaras) -->
<script>
  $(document).on('click', '.btn-new-topic', function() {
    $("#addTopic").show();
    $("#addEnvironment").hide();
  });

  $(document).on('click', '.btn-new-environment', function() {
    $("#addEnvironment").show();
    $("#addTopic").hide();
});
</script>

@endsection