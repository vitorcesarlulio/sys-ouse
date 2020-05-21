

<?php $__env->startSection('description', 'sistema ouse'); ?>
<?php $__env->startSection('keywords', 'sistema, ousadia'); ?>

<?php $__env->startSection('title', 'Cadastro'); ?>

<?php $__env->startSection('content'); ?>
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
        <form role="form" id="quickForm" novalidate="novalidate">
          <div class="card-body">
          <div class="row">
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
              <input type="text" name="cellphone" class="form-control" id="exampleInputCellPhone1" data-inputmask="&quot;mask&quot;: &quot;(99) 9999-99999&quot;" data-mask="" value="19" placeholder="Entre com o Celular" >
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
              <label>CEP</label>
              <a href="http://www.buscacep.correios.com.br/sistemas/buscacep/buscaCepEndereco.cfm" target="_blank"> <i class="fas fa-question-circle"></i> </a>
              <input type="text" class="form-control" name="cep" id="cep" data-inputmask="'mask': ['99999-999']" data-mask="" placeholder="Entre com o CEP" value="13">
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label for="logradouro">Logradouro</label>
              <input type="text" name="street" class="form-control" id="logradouro" placeholder="Entre com o Logradouro" disabled>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label for="bairro">Bairro</label>
              <input type="text" name="neighborhood" class="form-control" id="bairro" placeholder="Entre com o Bairro" disabled>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label for="localidade">Cidade</label>
              <input type="text" name="city" class="form-control" id="localidade" placeholder="Entre com a Cidade" disabled>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label for="uf">Estado</label>
              <input type="text" name="surname" class="form-control" id="uf" placeholder="Entre com o Estado" disabled>
            </div>
          </div>

          <div class="col-sm-2">
            <div class="form-group">
              <label for="Número">Número</label>
              <input type="text" name="number" class="form-control" id="exampleInputNumber1" placeholder="Entre com o Número">
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
              <label for="exampleInputCnpj1">CNPJ</label>
              <input type="text" name="cnpj" class="form-control" id="exampleInputCnpj1" data-inputmask="'mask': ['99.999.999/9999-99']" data-mask="" placeholder="Entre com CNPJ">
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label for="exampleInputCpf1">CPF</label>
              <input type="text" name="cpf" class="form-control" id="exampleInputCpf1" data-inputmask="'mask': ['999.999.999.99']" data-mask="" placeholder="Enter CPF">
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
          </div>
            <div class="form-group mb-0">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" name="terms" class="custom-control-input" id="exampleCheck1">
                <label class="custom-control-label" for="exampleCheck1">I agree to the <a href="#">terms of service</a>.</label>
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

    <!-- right column -->
    <div class="col-md-6">

    </div>

  </div>
  <!-- /.row -->
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<!-- Busca endereço por CEP -->
<script src="<?= DIRJS . 'busca-cep.js' ?>"></script> 

<!-- jquery-validation (PRECISO PARA DAR A MENSAGEM e validar CPF, CPNJ EMAIL etc) -->
<script src="<?= DIRPLUGINS . 'jquery-validation/jquery.validate.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'jquery-validation/additional-methods.min.js' ?>"></script>

<!-- Mensagem de validação -->
<script type="text/javascript">
  $(document).ready(function() {
    $.validator.setDefaults({
      submitHandler: function() {
        alert("Form successful submitted!");
      }
    });
    $('#quickForm').validate({
      rules: {
        name: {
          required: true
        },
        surname: {
          required: true
        },
        cellphone: {
          required: true
        },
        telephone: {
          required: true
        },
        cep: {
          required: true
        },
        number: {
          required: true
        },
        email: {
          required: true,
          email: true,
        },
        cnpj: {
          required: true,
          cnpjBR: true,
        },
        cpf: {
          required: true,
          cpfBR: true,
        },
        password: {
          required: true,
          minlength: 5
        },
        terms: {
          required: true
        },
      },
      messages: {
        name: "Digite um Nome",
        surname: "Digite um Sobrenome",
        cellphone: "Digite um Celular",
        telephone: "Digite um Telefone",
        cep: "Digite um CEP",
        number: "Digite um Número",
        email: {
          required: "Digite um endereço de e-mail",
          email: "Digite um endereço de e-mail válido"
        },
        cnpj: {
          required: "Digite um CNPJ",
          cnpjBR: "Digite um CNPJ válido"
        },
        cpf: {
          required: "Digite um CPF",
          cpfBR: "Digite um CPF válido"
        },
        password: {
          required: "Please provide a password",
          minlength: "Your password must be at least 5 characters long"
        },
        terms: "Please accept our terms"
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
  });
</script>

<!-- InputMask (MASCARAS) -->
<script src="<?= DIRPLUGINS . 'moment/moment.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'inputmask/min/jquery.inputmask.bundle.min.js' ?>"></script>

<!-- Page script -->
<script>
  $(function() {
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', {
      'placeholder': 'dd/mm/yyyy'
    })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', {
      'placeholder': 'mm/dd/yyyy'
    })
    //Money Euro E AS MACARAS TAMBEM SAI SE VC TIRAR
    $('[data-mask]').inputmask()

  })
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Apache24\htdocs\sys-ouse\app\View/cadastro/cadastro.blade.php ENDPATH**/ ?>