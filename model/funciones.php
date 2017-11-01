<?php 
function altaProducto($nombre,$marca,$codigo_barra,$stock,$stock_minimo,$categoria,$proveedor,$precio_venta_unitario,$descripcion,$fecha_alta){
	include 'conectarDB.php';
	$dbh = new PDO("mysql:host=$db_host;dbname=$db_base",$db_user,$db_pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$sql = $dbh->prepare("INSERT INTO producto (nombre, marca, codigo_barra, stock, stock_minimo, categoria_id, proveedor, precio_venta_unitario, descripcion, fecha_alta) 
	VALUES (:nombre, :marca, :codigo_barra, :stock, :stock_minimo, :categoria_id, :proveedor, :precio_venta_unitario, :descripcion, :fecha_alta)");
	$sql->bindParam(':nombre', $nombre);
	$sql->bindParam(':marca', $marca);
	$sql->bindParam(':codigo_barra', $codigo_barra);
	$sql->bindParam(':stock', $stock);
	$sql->bindParam(':stock_minimo', $stock_minimo);
	$sql->bindParam(':categoria_id', $categoria);
	$sql->bindParam(':proveedor', $proveedor);
	$sql->bindParam(':precio_venta_unitario', $precio_venta_unitario);
	$sql->bindParam(':descripcion', $descripcion);
	$sql->bindParam(':fecha_alta', $fecha_alta);

	
	if($sql->execute()) return true;
	else return false;
}

function verificarProducoExistente($nombre){
	include 'conectarDB.php';
	$dbh = new PDO("mysql:host=$db_host;dbname=$db_base",$db_user,$db_pass);
	$stmt = $dbh->prepare("SELECT * FROM Producto WHERE nombre = :nombre");
	$stmt->bindParam(':nombre', $nombre);
	$stmt->execute();
	if($stmt->rowCount() > 0) return true;
	else return false;
}
?>