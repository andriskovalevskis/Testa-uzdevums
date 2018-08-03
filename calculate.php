<?php
include('db.php');

$tests=$_POST['test'];
$user=$_POST['user'];

$counter=0; //Skaita visus jautājumus
$corrCounter=0;//Skaita pareizās atbildes
// Atlasa visas lietotāja iesniegtās atbildes no izpildīta testa
$query = mysql_query("select * from Rezultati where lietotajs='".$user."' and tests='".$tests."'", $connection); 
while ($row = mysql_fetch_array($query)) {//Atgriež visas šī lietotāja izvēlētās atbildes
	$queryAnsw = mysql_query("select `pareiza` from VisasAtbildes where jautajums='".$row['jautajums']."' AND id='".$row['atbilde']."'", $connection); 
	while ($rowAnsw = mysql_fetch_array($queryAnsw)) {//Atgriež visas testa atbildes un salīdzina ar lietotāja izvēlētajām 
		if($rowAnsw['pareiza'] == 1){
			$corrCounter++;//Ja lietotāja izvēlētā atbilde sakrīt ar pareizo, pieskaita +1 pareizo atbilžu skaitītājam
		}
	}
	$counter++; //skaita visus testa jautājumus
}

$return[0]=$corrCounter;
$return[1]=$counter;

echo json_encode($return);
?>