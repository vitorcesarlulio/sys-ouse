<?php 
include '../app/Model/connection-pdo.php';

$querySelectEvent = "SELECT id, title, cor, start, end FROM events";
$searchEvent = $conn->prepare($querySelectEvent);
$searchEvent->execute();

$eventos = [];

while($row_events = $searchEvent->fetch(PDO::FETCH_ASSOC)){
    $id    = $row_events['id'];
    $title = $row_events['title'];
    $color = $row_events['cor'];
    $start = $row_events['start'];
    $end   = $row_events['end'];
    
    $eventos[] = [
        'id'    => $id, 
        'title' => $title, 
        'color' => $color, 
        'start' => $start, 
        'end'   => $end, 
        ];
}

echo json_encode($eventos);

?>