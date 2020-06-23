<?php
include '../app/Model/connection-mysqli.php';

//Receber a requisão da pesquisa 
$requestData = $_REQUEST;


//Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
$columns = array(
    0 => 'start',
    1 => 'title',
    2 => 'end'
);

//Obtendo registros de número total sem qualquer pesquisa
$result_user = "SELECT start, title, end FROM events";
$resultado_user = mysqli_query($conn, $result_user);
$qnt_linhas = mysqli_num_rows($resultado_user);

//Obter os dados a serem apresentados
$result_usuarios = "SELECT id, start, title, end FROM events WHERE 1=1";
if (!empty($requestData['search']['value'])) {   // se houver um parâmetro de pesquisa, $requestData['search']['value'] contém o parâmetro de pesquisa
    $result_usuarios .= " AND ( start LIKE '" . $requestData['search']['value'] . "%' ";
    $result_usuarios .= " OR title LIKE '" . $requestData['search']['value'] . "%' ";
    $result_usuarios .= " OR end LIKE '" . $requestData['search']['value'] . "%' )";
}

$resultado_usuarios = mysqli_query($conn, $result_usuarios);
$totalFiltered = mysqli_num_rows($resultado_usuarios);

//Ordenar o resultado
$result_usuarios .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
$resultado_usuarios = mysqli_query($conn, $result_usuarios);

// Ler e criar o array de dados
$dados = array();
while ($row_usuarios = mysqli_fetch_array($resultado_usuarios)) {
    $dado = array();
    $dado[] = $row_usuarios["start"];
    $dado[] = $row_usuarios["title"];
    $dado[] = $row_usuarios["end"];
    $dado[] = 
    '<td class="text-right py-0 align-middle">
    <div class="btn-group btn-group-sm">
     <a href="/agenda/eventos/editar?id='.$row_usuarios["id"].'" class="btn btn-warning" name="viewEvent"><i class="fas fa-edit"></i></a>
      <a href="#" class="btn btn-info" name="viewEvent"><i class="fas fa-eye"></i></a>
      <button type="button" name="deleteEvent" class="btn btn-danger" id="'.$row_usuarios["id"].'"><i class="fas fa-trash"></i></button>
    </div>
  </td>';
    $dados[] = $dado;
}


//Cria o array de informações a serem retornadas para o Javascript
$json_data = array(
    "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
    "recordsTotal" => intval($qnt_linhas),  //Quantidade de registros que há no banco de dados
    "recordsFiltered" => intval($totalFiltered), //Total de registros quando houver pesquisa
    "data" => $dados   //Array de dados completo dos dados retornados da tabela 
);

echo json_encode($json_data);  //enviar dados como formato json