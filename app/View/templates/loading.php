<?php
$usuario = USER;
$senha = PASSWORD;
$dbname = DATABASE;
$checkUtf = true;
$con = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
mysqli_select_db($con, $dbname) or die(mysqli_connect_errno());
$back = fopen('backup_' . date("d_m_Y") . ".sql", "w");
$res = mysqli_query($con, "SHOW TABLES FROM $dbname");
fwrite($back, "set foreign_key_checks=0;\n\n");
$regex1 = <<<'END'
/
  ( [\x00-\x7F]                 # single-byte sequences   0xxxxxxx
  | [\xC0-\xDF][\x80-\xBF]      # double-byte sequences   110xxxxx 10xxxxxx
  | [\xE0-\xEF][\x80-\xBF]{2}   # triple-byte sequences   1110xxxx 10xxxxxx * 2
  | [\xF0-\xF7][\x80-\xBF]{3}   # quadruple-byte sequence 11110xxx 10xxxxxx * 3 
  )
| .                             # anything else
/x
END;
while ($row = mysqli_fetch_array($res)) {
  $table = $row[0];
  $res2 = mysqli_query($con, "SHOW CREATE TABLE $table");
  while ($lin = mysqli_fetch_array($res2)) {
    fwrite($back, "\n#\n# //Criação da Tabela : $table\n#\n\n");
    fwrite($back, "$lin[1] ;\n\n#\n# //Dados a serem incluídos na tabela\n#\n\n");
    $res3 = mysqli_query($con, "SELECT * FROM $table");
    $first = true;
    while ($r = mysqli_fetch_row($res3)) {
      if ($first) {
        $sql = "INSERT INTO $table VALUES";
        $first = false;
      } else {
        $sql .= ',';
      }
      $sql .= "('";
      $imploded = '';
      $firstImplode = true;
      foreach ($r as $index => $reg) {
        if ($firstImplode) {
          $firstImplode = false;
        } else {
          $imploded .= "', '";
        }
        if ($checkUtf) {
          $escaped = str_replace('\'', "\\'", str_replace('\\', "\\\\", preg_replace($regex1, '$1', $reg)));
        } else {
          $escaped = str_replace('\'', "\\'", str_replace('\\', "\\\\", $reg));
        }
        $imploded .= $escaped;
      }
      $sql .= $imploded;
      $sql .= "')\n";
    }
    if (!$first) {
      $sql .= ";\n";
      fwrite($back, $sql);
    }
  }
}
fclose($back);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <title>Sys Ouse | Carregando...</title>
  <link rel="stylesheet" href="<?= DIRCSS . 'loading.min.css' ?>">
</head>

<body>
  <div class='container'>
    <div class='loader'>
      <div class='loader--dot'></div>
      <div class='loader--dot'></div>
      <div class='loader--dot'></div>
      <div class='loader--dot'></div>
      <div class='loader--dot'></div>
      <div class='loader--dot'></div>
      <div class='loader--text'></div>
    </div>
  </div>
  <script>
    setTimeout(function() {
      window.location.href = '/home';
    }, 3100);
  </script>
</body>

</html>