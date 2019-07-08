<?php

$dbc = new PDO('mysql:host=localhost;dbname=task', 'data', 'secret', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$sth = $dbc->prepare("SELECT * FROM products");
$sth->execute();

while($result = $sth->fetch(PDO::FETCH_ASSOC)) {
	$products[$result['id']] = $result;
}
