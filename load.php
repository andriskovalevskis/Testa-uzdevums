<?php
include('db.php');
//atgriež nākamā jautājuma kārtas numuru
if(isset($_POST['counter']) && $_POST['counter']!="" ){
	$cntr=0; //Skaita katra jautājuma visas iespējamās atbildes 
	//Atgriež jautājuma visas atbildes
	$queryAnsw = mysql_query("select * from VisasAtbildes where jautajums='".$_POST['nextQuestionID']."'", $connection); // Atlasa visus testus no datubāzes un pievieno dropdown izvēlnei
	while ($rowAnsw = mysql_fetch_array($queryAnsw)) {
		//Piešķir masīvam atbildes id, Atbildes tekstu, jautājuma id un testa id
		$nextQuestinArray[$cntr]['id']=$rowAnsw['id'];
		$nextQuestinArray[$cntr]['atbilde']=$rowAnsw['atbilde'];
		$nextQuestinArray[$cntr]['jautajums']=$rowAnsw['jautajums'];
		$nextQuestinArray[$cntr]['tests']=$rowAnsw['tests'];
		$cntr++;
	}
	//Ja nākamajam jautājumam nav atbilžu, tad tests ir beidzies un funkcija atgriež 'finish'.
	if($cntr==0){echo "finish";}else{
		//Ja nākamajam jautājumam ir atbilžu, tad atgriež masīvu ar visu atbilžu informāciju
		echo json_encode($nextQuestinArray, JSON_UNESCAPED_UNICODE);
	}
}else{
	echo"Nav jipiii :( ";
	//Nav sesija. jāatgriež uz index.php
}
	