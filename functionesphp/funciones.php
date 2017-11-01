<?php 

function convertirGanancias($ganacia){
	foreach ($ganacia as $key) {
		$ganancias[] = array(strtotime($key[0]) * 1000, $key[1]);
	}

	return $ganancias;
}


function convertirProductos($productos){
	for($i=0; $i < sizeof($productos); $i++) {
		$prod[] = array($productos[$i][1], $productos[$i][0]);
	}

	return $prod;
}

?>
