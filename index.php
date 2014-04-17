<html>
<head>

<title>LORCA | The R-Class rule calculator and certificate generator</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="This program will allow a person to enter data for their r-class sloop and the program will generate a rating for their boat." />

<!-- Bootstrap Start -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
<!-- Bootstrap Finish -->

</head>
<body>
<?php
## disable warning errors
error_reporting(0);
?>

<div class= "col-md-12">
<h1> The R-Class Rule rating generator program </h1>
</div>
<div class= "row">
<div class= "col-md-1"></div>
<div class= "col-md-10">
<p> This program is written in php and was made based on the r-class rule as written in 1983 and modified in 2013. This program was written by Ryan Marr, owner of Archer R-15. All dimensions below are ft unless mentioned otherwise. Please only enter numbers in the boxes below. 
Do not enter any symbols, just numbers in ft ie: 24 inch freeboard is 2. If you have any questions related to the calculator please email Ryan at <a href="mailto:info@lakeontariorclass.com">info@lakeontariorclass.com</a>. Feel free to modify your values and resubmit.
 </p>
</div>
<div class= "col-md-1">
</div>
</div>
<br>


<div class= "row">
<!-- This is the inputs form -->
<div class="form-group">
<form class= "form-group" action="index.php" method="post" role="form">
	<div class="col-md-4 col-md-offset-1">    
		<label class="control-label" for="lwl">Waterline Length: </label>
		
			<input class="form-control" type="text" name="lwl" value="<?php echo isset($_POST['lwl']) ? $_POST['lwl'] : '' ?>">
		
	   
		<label class="control-label" for="beam">Beam: </label>
		
			<input class="form-control" type="text" name="beam" value="<?php echo isset($_POST['beam']) ? $_POST['beam'] : '' ?>">
		
	    
		<label class="control-label" for="qbl">Quarter Beam Length: </label>
		
			<input class="form-control" type="text" name="qbl" value="<?php echo isset($_POST['qbl']) ? $_POST['qbl'] : '' ?>">
	    
		<label class="control-label" for="weight">Weight in lbs: </label>
		
			<input class="form-control" type="text" name="weight" value="<?php echo isset($_POST['weight']) ? $_POST['weight'] : '' ?>">
		    
		<label class="control-label" for="draft"> Draft: </label>
		
			<input class="form-control" type="text" name="draft" value="<?php echo isset($_POST['draft']) ? $_POST['draft'] : '' ?>">
		  
		<label class="control-label" for="freeboard">Freeboard: </label>
		
			<input class="form-control" type="text" name="freeboard" value="<?php echo isset($_POST['freeboard']) ? $_POST['freeboard'] : '' ?>">
		   
		<label class="control-label" for="boom">Boom Length: </label>

			<input class="form-control" type="text" name="boom" value="<?php echo isset($_POST['boom']) ? $_POST['boom'] : '' ?>">
		   
		<label class="control-label" for="p1">P1 Length: </label>
	
	<input class="form-control" type="text" name="p1" value="<?php echo isset($_POST['p1']) ? $_POST['p1'] : '' ?>">
	   
		<label class="control-label" for="mast">Mast Height from deck: </label>
		 
			<input class="form-control" type="text" name="mast" value="<?php echo isset($_POST['mast']) ? $_POST['mast'] : '' ?>">
		  
		<label class="control-label" for="j">J Length: </label>
	
			<input class="form-control" type="text" name="j" value="<?php echo isset($_POST['j']) ? $_POST['j'] : '' ?>">
		  
		<label class="control-label" for="p2">P2 Height: </label>
		
			<input class="form-control" type="text" name="p2" value="<?php echo isset($_POST['p2']) ? $_POST['p2'] : '' ?>">
		   
		<label class="control-label" for="spinpole">Spinnaker Pole Length: </label>
		
			<input class="form-control" type="text" name="spinpole" value="<?php echo isset($_POST['spinpole']) ? $_POST['spinpole'] : '' ?>">
<br>	
<div class="col-md-3 col-md-offset-1">
<button type="submit" class="btn btn-default">Submit</button>
</div>
</div>
</form>
<!-- This is the end of the inputs form -->


<!-- The form inputs arrive into the variables here -->
<?php

## Input variables
$lwl = $_POST["lwl"];
$beam = $_POST["beam"];
$qbl = $_POST["qbl"];
$weight = $_POST["weight"];
$draft = $_POST["draft"];
$freeboard = $_POST["freeboard"];
$boom = $_POST["boom"];
$p1 = $_POST["p1"];
$mast = $_POST["mast"];
$j = $_POST["j"];
$p2 = $_POST["p2"];
$spinpole = $_POST["spinpole"];

#Maximum Spin Pole
$maxspinpole = 0.5*($boom+$j);
#Spin Pole Penalty
$spinpolepenalty = ((max($maxspinpole, $spinpole))-$maxspinpole);
$j = $j+$spinpolepenalty;

#sailareaCalculationsPrePenalty
$mainsailarea = ($boom*$p1)/2;
$headsailarea = 0.85*(($p2*$j)/2);
$sailarea = $mainsailarea+$headsailarea;

##Max Mast Calculation
$sqrtofsailarea = sqrt($sailarea);
$maxmast = (1.7*$sqrtofsailarea)+5;
$p1 = $p1+(((max($maxmast, $mast))-$maxmast)*2);


##Calculations
$dispinft = $weight/62.4;
$sqrtlwl = sqrt($lwl);
$maxcbdrtdisp = 0.2*$lwl+0.5;
$cbdrtdisp = pow($dispinft, 1/3);
$minfreeboard = 0.06*$lwl+0.6;
$freeboarddfct = $minfreeboard-$freeboard;
$freeboardpenalty = $freeboarddfct*2;
$maxmainsailarea = 0.82*$sailarea;
$maxdraft = (0.16*$lwl)+1.75;
$maxlwl = 27;

#sailareaCalculationsPostPenalty
$mainsailarea = ($boom*$p1)/2;
$headsailarea = 0.85*(($p2*$j)/2);
$sailarea = $mainsailarea+$headsailarea;


##Penalties
$draftpenalty = ((max($maxdraft, $draft))-$maxdraft)*3;
$lwlpenalty = ((max($maxlwl, $lwl))-$maxlwl);
$totalpenalties = $lwlpenalty+$draftpenalty;
$mastpenalty = $p1 = ((max($maxmast, $mast))-$maxmast);



#sqrt of sail area is used in formula
$sqrtofsailarea = sqrt($sailarea);

#length is used in formula
$length = $lwl+0.5*($qbl-$lwl*(100-$sqrtlwl)/100);

#cubed root displacement used is used in formula
$cbdrtdispusd = min($cbdrtdisp, $maxcbdrtdisp);

#RULE CALCULATION
$rating = 0.18*$length*$sqrtofsailarea/$cbdrtdispusd;

#Total rating after penalties
$ratingwpenalty = $rating+$totalpenalties;

?>

</div>
<div class= "col-md-6">	
<p>

<?php
print "<br>Length is equal to: ";
print $length;
print " ft";

print "<br>The mainsail area is: ";
print $mainsailarea;
print " ft";
print "<br>The headsail area is: ";
print $headsailarea;
print " ft";
print "<br>The total sail area is: ";
print $sailarea;
print " ft";

print "<br>The square root of sailarea is equal to: ";
print $sqrtofsailarea;
print "<br>The Cubed root of displacement is equal to: ";
print $cbdrtdispusd;

#colour changing and output for rating
if ($rating > 20)
  {	
$colour = "'text-danger'";
  }
else
  {	
$colour = "'text-success'";
}


print "<br><br><p class=";
print $colour;
print ">Your rating = ";
print $rating;
print " ft </p>";

#colour changing and output for rating with penalty
if ($ratingwpenalty > 20)
  {	
$colourwpen = "'text-danger'";
  }
else
  {	
$colourwpen = "'text-success'";
}

print "<br>Draft Penalty: ";
print $draftpenalty;
print "<br>LWL Penalty: ";
print $lwlpenalty;

print "<br>Mast Penalty: ";
print $mastpenalty;
print "<br><i>Mast Penalty is not added directly to Rule the mast height penalty is multiplied by 2 and added to the P1 measurement and calculated as part of the sailarea measurement.</i>";


print "<br><br><p class=";
print $colourwpen;
print ">Your rating after all penalties = ";
print $ratingwpenalty;
print " ft </p>";


#spin pole output
print "<br><br>Your Max Spin Pole Length = ";
print $maxspinpole;
print " ft";

print "<br>Spinnaker Pole Penalty: ";
print $spinpolepenalty;
print "<br><i>Spin Pole Penalty is not added directly to the Rule. The Spinnaker Pole Penalty is added directly to the J measurement and calculated as part of the sailarea measurement.</i>";


?>
</p>
</div>

<div class="row">
</div>
<br><br>





</body>
</html>
