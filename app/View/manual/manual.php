<?php 

header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=manual-sys-ouse.pdf");
@readfile('doc/manual-sys-ouse.pdf');

?>