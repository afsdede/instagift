<?php

if ($_SERVER['SERVER_ADDR'] == "127.0.0.1"){ 
    $dataBase = "instagift";
    $host = "localhost";
    $user = "instagift";
    $pass = "instaDB";
	
}else if($_SERVER['SERVER_ADDR'] == "::1"){ //Fix para IP v6 que o MAMP usa
	$dataBase = "instagift";
    $host = "localhost";
    $user = "instagift";
    $pass = "instaDB";
    
}else {
    $dataBase = "instagift";
    $host = "mysql.instagift.com.br";
    $user = "instagift";
    $pass = "instaDB";
	
}

$conn = mysql_connect($host, $user, $pass);

if (!$conn){
    die ("Erro ao estabelecer conexão com o banco de dados! " . mysql_errno() . ": " . mysql_error());
}

$db_selected = mysql_select_db($dataBase, $conn);

if (!$db_selected){
    die ("Erro ao selecionar banco de dados!");
}

?>