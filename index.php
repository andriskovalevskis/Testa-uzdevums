 <?php
include('db.php'); //Pievieno datu bāzes failu
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Feins tests</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<link rel="stylesheet" type="text/css" href="css.css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="js.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="error">
				<?php
					if(isset($_POST['pickTestButton'])){
						if(trim($_POST['name'])==""){ //Pārbauda, vai ir ievadīts vārds							
							$error="* Ievadiet vārdu";
						}elseif($_POST['pickTest'] == 0){ //Pārbauda, vai ir izvēlēts tests
							$error="* Izvēlieties testu";							
						}else{
							//Pārbauda, vai šis lietotājs šo testu jau nav pildījis
							$query = mysql_query("select id from Rezultati where lietotajs = '".$_POST['name']."' AND tests='".$_POST['pickTest']."' ", $connection);
							if(mysql_num_rows($query)>0){
								//Ja šāds lietotājs šo testu jau ir pildījis, dzēš iepriekšējās atbildes
								$sql = "DELETE FROM Rezultati where lietotajs = '".$_POST['name']."' AND tests='".$_POST['pickTest']."'";
								$retval = mysql_query( $sql, $connection );
							} 
							//Sākot testu izveido sesijas mainīgos ar lietotāja vārdu un testa id
							$_SESSION['name']=$_POST['name'];
							$_SESSION['test']=$_POST['pickTest'];
						}
					}
				?>
			</div>
			<?php
			//Ja ir sesijas mainīgais, sākas tests
			if(!isset($_SESSION['name'])){
			?>
				<span>Testa uzdevums</span>
				<form action="" method="post">	
					<div class="error" style="margin-top:30px;"><?php echo $error;?></div>
					<input class="inputname"  type="text" name="name" placeholder="Ievadi savu vārdu">
					<br>					
					<select class="inputname" name="pickTest">
						<option value="default" selected disabled hidden>Izvēlies testu</option>
						<?php
							// Atlasa visus testus no datubāzes un pievieno dropdown izvēlnei
							$query = mysql_query("select * from testi", $connection); 
							while ($row = mysql_fetch_array($query)) {
								echo "<option value=".$row['id'].">".$row['name']."</option>";
							}
						?>					
					</select>
					<br>
					<input class="startbutton" type="submit" value="Sākt" name="pickTestButton">
				</form>
			<?php
			}else{
			?>
				<span class="answerflag" id="false" style="display:none;"></span>
				<div id="insideContainer">
					
			<?php
					//Atlasa visus izvēlētā testa jautājumus
					$query = mysql_query("select * from Jautajumi where tests='".$_SESSION['test']."' order by id asc", $connection); // Atlasa visus testus no datubāzes un pievieno dropdown izvēlnei					
					$total=mysql_num_rows($query); //Kopējais jautājumu skaits
					$questionArrayID=[];
					$questionArrayName=[];
					$cntr=0;
					while ($row = mysql_fetch_array($query)) {
						$questionArrayID[$cntr]=$row['id']; //Izveido masīvu ar jautājumu id
						$questionArrayName[$cntr]=$row['jautajums']; //Izveido masīvu ar jautājumu tekstu
						$cntr++;
					} 
					$percent=(1/$cntr)*100; //Izrēķina kādu procentu veido pirmais jautājums no kopējā jautājumu skaita
					?>
					<script type="text/javascript">
						var questionArrayID = <?php echo json_encode($questionArrayID); ?>; //izveido javascript masīvu ar jautājumu id
						var questionArrayName = <?php echo json_encode(array_map('utf8_encode',$questionArrayName)); ?>; //izveido javascript masīvu ar jautājuma tekstu
						var user = "<?php echo $_SESSION['name']; ?>";//javascript mainīgajam piešķir lietotāja vārdu					
						var test = "<?php echo $_SESSION['test']; ?>";//javascript mainīgajam piešķir testa id
						var total = "<?php echo $cntr; ?>";//javascript mainīgajam piešķir kopējo jautājumu skaitu
					</script>
					<?php
					//Izvada pirmo jautājumu
					echo $questionArrayName[0]."<br><br>";
					//No datubāzes iegūst visas pirmā jautājuma atbildes
					$queryAnsw = mysql_query("select * from VisasAtbildes where tests='".$_SESSION['test']."' and jautajums='".$questionArrayID[0]."'", $connection); // Atlasa visus testus no datubāzes un pievieno dropdown izvēlnei
					$loopcntr=1;//atbilžu skaitītājs
					//ciklā atgriež visas pirmā jautājuma atbildes
					while ($rowAnsw = mysql_fetch_array($queryAnsw)) {
						if($loopcntr%2 == 0){$answClass="atbilderight"; //Ja jautājuma kārtas skaitlis dalās bez atlikuma ar 2, tad tā ir kreisā kolona
						}else{
							$answClass="atbildeleft";//Ja kārtas skaitlis nedalās bez atlikuma, tad tā ir labā kolonna
						}
						//Izveido tagus ar atbildēm
						echo "<div class='".$answClass."' id='".$rowAnsw['id']."' name='test'>".$rowAnsw['atbilde']."</div>";
						$loopcntr++;
					}
			?>
				</div>
				<div class="barout" ><div class="barin" style="width:<?php echo round($percent,2); ?>%"><?php echo round($percent,2);?>%</div></div>
				<input class="startbutton" id='next' type='submit' name='0' value='Nākamais'>
			<?php 
			}
			?>
		</div>
		<script>
		//load_return atgriež nākamā jautājuma visu atbilžu id, tekstu, jautājuma id un testa id
		function load_return(data){
			//ja atgriež finish, tad tests ir pabeigts un izvada rezultātu
			if(data=="finish"){
				$("#insideContainer").empty();
				$('#next').remove();
				$('.barout').remove();
				//Aprēķinam rezultātu, kuru atgriež funkcija results
				$.post('calculate.php', {user:user,test:test},results);
			}
			else{//Ja load_return atgriež datu masīvu, tad izvada nākamā jautājuma atbildes
				var counter = $('#next').attr('name');//norāda jautājumu skaitu sākot ar 0
				var nextCounter=parseInt(counter)+1;//Nākamā jautājumu kārtas numurs
				$("#insideContainer").empty();//Dzēš iepriekšējo informāciju lai izvadītu nākamo jautājumu un atbildes
				data = $.parseJSON(data);//load_return tiek padoti php kodēts masīvs. Lai iegūtu javascript masīvu dati jāatkodē
				
				var jautajumaID;
				var loopcounter=1;
				$.each(data, function(i, item) { //Iet cauri visiem masīva elementiem
					if(i==0){ //Pirmajā iterācijā izvada jautājumu
						for (var i in questionArrayID) {
							if(item.jautajums == questionArrayID[i]){
								 
								$( "#insideContainer" ).append( ""+questionArrayName[i]+"<br><br>" );
								jautajumaID=questionArrayID[i];
							}
						}
					}
					var currclass="";
					if (loopcounter % 2 === 0) { currclass="atbilderight";
					}else{ currclass="atbildeleft";}
					//Izvada atbildes kreisajā vai labajā kolonnā atkarībā no atbildes kārtas numura	
					$( "#insideContainer" ).append( "<div class='"+currclass+"' id="+item.id+">"+item.atbilde+"</div>" );
					loopcounter++;
				});
				//tags kurš glabā jautājuma kārtas numuru. Piešķir nākamo numuru, kuru pados ielādājot nākamo jautājumu un atbildes
				$('#next').attr('name', nextCounter);
			}
			//funkcija kuru izsauc izvēloties atbildi
			$(".atbildeleft, .atbilderight").click(function(){
				$('#insideContainer div').each(function(){	
					//Izvēloties atbildi vispirms visām atbildēm atgriež noklusēto balto fonu
					$(this).css("background-color", "white");
				});  
				//Iezīmē izvēlēto atbildi
				$(this).css("background-color", "#4CAF50");
				//Saglabā izvēlētās atbildes id tagā "answerflag"
				$(".answerflag").attr("id",this.id);				
			});
		}		
		//Funkcija kura izvada rezultātu no tajā padotajiem datiem
		function results(data){
			data = $.parseJSON(data);
			$( "#insideContainer" ).append( "Paldies, "+user+"!<br><br>");
			$( "#insideContainer" ).append( "Tu atbildēji pareizi uz "+data[0]+" no "+data[1]+" jautājumiem.");	
			$( "#insideContainer" ).append( "<br><input class='startbutton' type='submit'  onclick='toIndex();' value='Uz sākumu'>");				
		}
		function toIndex(){
			//Pēc testa veikšanas nospiežot pogu var atgriezties un sākumu
			window.location.replace("index.php");
		}
		</script>
	</body>
</html>