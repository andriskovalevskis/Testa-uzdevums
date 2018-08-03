$(document).ready(function(){
	 
	//Iet uz nākamo jautājumu
	$("#next").click(function(){
		//Pārbauda, vai atbilde ir izvēlēta.
		if($(".answerflag").attr('id')=="false"){
			alert("Izvēlies atbildi");
		}else{
			//Nolasa izvēlētās atbildes id, ko ievadīt datu bāzē
			var answer = $(".answerflag").attr("id");
			//Pārejot uz nākamo jautājumu izvēlētās atbildes id atgriež uz false, lai nebūtu iespējams pāriet uz nākamo jautājumu bez izvēlētas atbildes
			$(".answerflag").attr("id","false");
			//Jautājumu skaitītājs, kurš sākas ar 0
			var counter = $('#next').attr('name');			
			var next = parseInt(counter)+1;
			var question = parseInt(counter)+2;
			
			//Aprēķina cik procenti no testa ir izpildīts
			var percent=((parseInt(question)/parseInt(total))*100).toFixed(2);
			if(percent<=100){
				//izvada procentus kā tekstu
				$('.barin').text(percent+"%");
				//Iekrāso izpildīto procentu
				$('.barin').css("width", percent+"%");
			}
			
			//Ievada atbildi datu bāzē
			$.post('insert.php', {answer:answer,question:questionArrayID[counter],user:user,test:test});
			//Ielādē nākamo jautājumu un atbildes
			$.post('load.php', {counter:counter,currentQuestinID:questionArrayID[counter],nextQuestionID:questionArrayID[next]},load_return); 
		}
	});
	$(".atbildeleft, .atbilderight").click(function(){
		 $('#insideContainer div').each(function(){
			//Pirms iekrāso izvēlēto atbildi visām atbildēm atgriež noklusēto balto fonu
			$(this).css("background-color", "white");
		});  
		//iekrāso izvēlēto atbildi
		$(this).css("background-color", "#4CAF50");
		//Piešķir izvēlētās atbildes id
		$(".answerflag").attr("id",this.id);
	});			
});