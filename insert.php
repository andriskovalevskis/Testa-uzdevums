<?php
include('db.php');

$tests=$_POST['test'];
$jautajums=$_POST['question'];
$atbilde=$_POST['answer'];
$user=$_POST['user'];
//Ievada datubāzē lietotāja vārdu, testa id, jautājuma id un izvēlētās atbildes id.
$sql = "INSERT INTO Rezultati (tests,jautajums,atbilde,lietotajs) VALUES ('".$tests."','".$jautajums."','".$atbilde."','".$user."')";
$retval = mysql_query( $sql, $connection );
?>