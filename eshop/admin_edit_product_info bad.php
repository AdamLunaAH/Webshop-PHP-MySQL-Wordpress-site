<?php 
/* Template Name: Admin Edit Product Info */
	require "eshopfunctions.php";

	if (!isset($_SESSION['admin']) /*|| ( $_SESSION['userid'])*/) {
		header("location: wordpress/ebutik/administration_login/");
		exit();}
		
?>
<?php


function adminProductInfoHead() {
	$mysqli = connect();
		$proPageNr = htmlspecialchars($_GET["produktnr"]);
		$imagesLink = get_bloginfo('template_directory') . "/eshop/img/produkter/";
		$proInfo = "SELECT produkter.ProductID , produkter.Produktnamn, produkter.Produktbeskrivning,
		 produkter.Pris, produkter.Bild, kategorier.Kategorinamn FROM produkter
		INNER JOIN kategorier ON kategorier.CategoryID = produkter.CategoryID WHERE produkter.ProductID = '$proPageNr'";
		$proInfoResult = $mysqli->query($proInfo);
		if ($proInfoResult !== false && $proInfoResult->num_rows > 0) {
			// output data of each row
			while ($row = $proInfoResult->fetch_assoc()) {
				echo "<h1>". $row["Produktnamn"] . "</h1>" . "
				<img class='productImg' src='" . $imagesLink . $row["Bild"] . "' width='200' height='200' alt='" . $row["Produktnamn"] . "'><br>"
        ;}
			echo "";
		} else {
			echo "0 results";}
		$mysqli->close();}


		/* Product old info */
function adminProductInfoOld() {
	$mysqli = connect();
		$proPageNr = htmlspecialchars($_GET["produktnr"]);
		//$imagesLink = get_bloginfo('template_directory') . "/eshop/img/produkter/";
		$proInfo = "SELECT produkter.ProductID , produkter.Produktnamn, produkter.Produktbeskrivning,
		 produkter.Pris, produkter.Bild, kategorier.CategoryID FROM produkter
		INNER JOIN kategorier ON kategorier.CategoryID = produkter.CategoryID WHERE produkter.ProductID = '$proPageNr'";
		$proInfoResult = $mysqli->query($proInfo);
		if ($proInfoResult !== false && $proInfoResult->num_rows > 0) {
			// output data of each row
			while ($row = $proInfoResult->fetch_assoc()) {
				echo 
				"<h2 class='h2text'>Nuvarande data</h2><div class='col-6 col-s-6'><ul class='proMainList'>
        <li>Produktnummer</li><li class='proPageInfo'>" . $row["ProductID"] . "</li>
        <li>Produktnamn</li><li class='proPageInfo'>" . $row["Produktnamn"] . "</li>
				<li>Pris</li><li class='proPageInfo'>" . $row["Pris"] . " kr</li>
				<li>Produktbeskrivning</li><li class='proPageInfo'>" . $row["Produktbeskrivning"] . "</li>
				<li>Kategori</li><li class='proPageInfo'>" . $row["CategoryID"] . "</li>
        <li>Bild</li><li class='proPageInfo'>" . $row["Bild"] . "</li>
        </ul></div>";}
			echo "";
		} else {
			echo "0 results";}
		$mysqli->close();}

    
    function adminProductInfoNew2(){
      $mysqli = connect();
		$proPageNr = htmlspecialchars($_GET["produktnr"]);
		//$imagesLink = get_bloginfo('template_directory') . "/eshop/img/produkter/";
		$proInfo = "SELECT produkter.ProductID , produkter.Produktnamn, produkter.Produktbeskrivning,
		 produkter.Pris, produkter.Bild, kategorier.Kategorinamn FROM produkter
		INNER JOIN kategorier ON kategorier.CategoryID = produkter.CategoryID WHERE produkter.ProductID = '$proPageNr'";
		$proInfoResult = $mysqli->query($proInfo);
		if ($proInfoResult !== false && $proInfoResult->num_rows > 0) {
			// output data of each row
			while ($row = $proInfoResult->fetch_assoc()) {
				echo 
				"<h2 class='h2text'>Ny data</h2><div class='col-6 col-s-6'><ul class='proMainList'>
        
        <li>Produktnamn</li><li class='proPageInfo'>" . $row["Produktnamn"] . "</li>
				<li>Produktnummer</li><li class='proPageInfo'>" . $row["ProductID"] . "</li>
				<li>Pris</li><li class='proPageInfo'>" . $row["Pris"] . " kr</li>
				<li>Produktbeskrivning</li><li class='proPageInfo'>" . $row["Produktbeskrivning"] . "</li>
				<li>Kategori</li><li class='proPageInfo'>" . $row["Kategorinamn"] . "</li>
        <li>Bild</li><li class='proPageInfo'>" . $row["Bild"] . "</li>
        </ul></div>";}
			echo "";
		} else {
			echo "0 results";}
		$mysqli->close();
  }


  function adminProductInfoNew($Produktnamn, $Produktbeskrivning, $CategoryID, $Pris, $Bild){
		$mysqli = connect();

    $proPageNr = htmlspecialchars($_GET["produktnr"]);

		$args = func_get_args();
		$args = array_map(function ($value) {
			return trim($value);
		}, $args);
		foreach ($args as $value) {
			if(empty($value)){
				return "Alla fälten måste fyllas i";}}
		foreach ($args as $value) {
			if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
				return "Specialtecken får inte användas";}}
		$stmt = $mysqli->prepare("SELECT Produktnamn FROM produkter WHERE ProductID != $proPageNr");
		$stmt->bind_param("s", $Produktnamn);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = $result->fetch_assoc();
		if ($data != NULL){
			return "Produktnamnet används redan";}
    if (is_numeric($CategoryID) == false){
      return "CategoryID är inte ett nummer";}
		if (strlen($Produktnamn) > 40) {
			return "Produktnamnet är för långt (max 40 tecken)";}
		if (strlen($Produktbeskrivning) > 400) {
			return "Produktbeskrivningen är för lång (max 400 tecken)";}
    if (is_numeric($Pris) == false){
      return "Pris är inte ett nummer";}
		if (strlen($Bild) > 40) {
			return "Bild-URL:en är för lång (max 40 tecken)";}


		$stmt = $mysqli->prepare("UPDATE produkter SET Produktnamn = ?, Produktbeskrivning= ? , CategoryID= ? , Pris= ? , Bild = ? Where ProductID = $proPageNr))");
	  $stmt->bind_param("sssss", $Produktnamn, $Produktbeskrivning, $CategoryID, $Pris, $Bild);
		$stmt->execute();
		if ($stmt->affected_rows != 1) {
			return "Ett fel uppstod. Var god försök igen";
		} else {
			return "success";}}


    	function responseHTML() {
        if (isset($_POST['submit'])) {
        $response = adminProductInfoNew($_POST['Produktnamn'], $_POST['Produktbeskrivning'], $_POST['CategoryID'], $_POST['Pris'], $_POST['Bild'] );}
       /* if statement for a for a correct account creation or else for incorrect creation and what show what the fault is. */
        if (@$response == "success") {
          if (isset($_POST['submit'])) { ?>
            <p class="success registrationSuccess">
            <span class="registrationSuccessHead"><?php echo htmlspecialchars($_POST["Produktnamn"]); ?></span>
            <br>Produktdatan har ändrats.<br>
                </p>
            <?php }	} else {?><p class="registrationError"><?php echo htmlspecialchars(@$response); ?></p><?php }} ?>


<?php get_header();?>
<main>
  <div class="row">
    <div class="col-4 col-s-4"></div>
    <div class="col-4 col-s-4">
      <?php 
        adminProductInfoHead();
      ?>
    </div>
  </div>
<div class="row">
<div class="col-1 col-s-1"></div>
	<div class="col-5 col-s-5">
	<div class="products">
		
		<!-- creates product info page -->
    <?php adminProductInfoOld(); ?>
  </div></div>
	<div class="col-5 col-s-5">
	<div class="productform">

  <form class="registrationForm" action="#" method="post" autocomplete="off">
		<div class="col-12 col-s-12">
		<h2 class="h2text">Ny data</h2>
		<p class="topText">
			<br>
			<!--Har du redan ett konto?
			<a class="topText" href="wordpress/ebutik/logga-in/">Logga in här</a>-->
	</p></div>
<div class="row"></div><div class="row"><div class="col-3 cols-s-3"></div><div class="col-6 col-s-6">
      <div class="registrationField">
				<label>Produktnummer</label><input class="registrationInput" type="text" name="ProduktID" value="<?php  $proPageNr = htmlspecialchars($_GET["produktnr"]); echo $proPageNr; ?>" disabled="disabled" ></div>
			<div class="registrationField">
				<label>Produktnamn *</label><input class="registrationInput" type="text" name="Produktnamn" value="<?php echo htmlspecialchars(@$_POST['Produktnamn']); ?>" ></div>
			<div class="registrationField">
				<label>Produktbeskrivning *</label>
				<input class="registrationInput" type="text" name="Produktbeskrivning" value="<?php echo htmlspecialchars(@$_POST['Produktbeskrivning']); ?>" ></div>
			<div class="registrationField">
				<label>CategoryID *</label>
				<input class="registrationInput" type="text" name="CategoryID" value="<?php echo htmlspecialchars(@$_POST['CategoryID']); ?>" ></div>
			<div class="registrationField">
				<label>Pris *</label>
				<input class="registrationInput" type="text" name="Pris" value="<?php echo htmlspecialchars(@$_POST['Pris']); ?>" ></div>
			<div class="registrationField">
				<label>Bild *</label>
				<input class="registrationInput" type="text" name="Bild" value="<?php echo htmlspecialchars(@$_POST['Bild']); ?>" ></div>
		<div class="rowThings">
		<button class="registrationSubmit" type="submit" name="submit">Ändra produktdata</button><?php responseHTML(); ?>	</div></div></div></form></div>
		<!-- creates product info page -->
    

  </div></div>
 

</div>
</main>
		<?php get_footer();?>














		<?php 
/* Template Name: Admin Edit Product Info */
	require "eshopfunctions.php";

	if (!isset($_SESSION['admin']) /*|| ( $_SESSION['userid'])*/) {
		header("location: wordpress/ebutik/administration_login/");
		exit();}
		
?>
<?php


function adminProductInfoHead() {
	$mysqli = connect();
		$proPageNr = htmlspecialchars($_GET["produktnr"]);
		$imagesLink = get_bloginfo('template_directory') . "/eshop/img/produkter/";
		$proInfo = "SELECT produkter.ProductID , produkter.Produktnamn, produkter.Produktbeskrivning,
		 produkter.Pris, produkter.Bild, kategorier.Kategorinamn FROM produkter
		INNER JOIN kategorier ON kategorier.CategoryID = produkter.CategoryID WHERE produkter.ProductID = '$proPageNr'";
		$proInfoResult = $mysqli->query($proInfo);
		if ($proInfoResult !== false && $proInfoResult->num_rows > 0) {
			// output data of each row
			while ($row = $proInfoResult->fetch_assoc()) {
				echo "<h1>". $row["Produktnamn"] . "</h1>" . "
				<img class='productImg' src='" . $imagesLink . $row["Bild"] . "' width='200' height='200' alt='" . $row["Produktnamn"] . "'><br>"
        ;}
			echo "";
		} else {
			echo "0 results";}
		$mysqli->close();}


		/* Product old info */
function adminProductInfoOld() {
	$mysqli = connect();
		$proPageNr = htmlspecialchars($_GET["produktnr"]);
		//$imagesLink = get_bloginfo('template_directory') . "/eshop/img/produkter/";
		$proInfo = "SELECT produkter.ProductID , produkter.Produktnamn, produkter.Produktbeskrivning,
		 produkter.Pris, produkter.Bild, kategorier.CategoryID FROM produkter
		INNER JOIN kategorier ON kategorier.CategoryID = produkter.CategoryID WHERE produkter.ProductID = '$proPageNr'";
		$proInfoResult = $mysqli->query($proInfo);
		if ($proInfoResult !== false && $proInfoResult->num_rows > 0) {
			// output data of each row
			while ($row = $proInfoResult->fetch_assoc()) {
				echo 
				"<h2 class='h2text'>Nuvarande data</h2><div class='col-6 col-s-6'><ul class='proMainList'>
        <li>Produktnummer</li><li class='proPageInfo'>" . $row["ProductID"] . "</li>
        <li>Produktnamn</li><li class='proPageInfo'>" . $row["Produktnamn"] . "</li>
				<li>Pris</li><li class='proPageInfo'>" . $row["Pris"] . " kr</li>
				<li>Produktbeskrivning</li><li class='proPageInfo'>" . $row["Produktbeskrivning"] . "</li>
				<li>Kategori</li><li class='proPageInfo'>" . $row["CategoryID"] . "</li>
        <li>Bild</li><li class='proPageInfo'>" . $row["Bild"] . "</li>
        </ul></div>";}
			echo "";
		} else {
			echo "0 results";}
		$mysqli->close();}


    function adminProductInfoNameNew($Produktnamn){
      $mysqli = connect();
		  $proPageNr = htmlspecialchars($_GET["produktnr"]);
      $args = func_get_args();
      $args = array_map(function ($value) {
        return trim($value);
      }, $args);
      foreach ($args as $value) {
        if(empty($value)){
          return "Alla fälten måste fyllas i";}}
      foreach ($args as $value) {
        if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
          return "Specialtecken får inte användas";}}
        if (strlen($Produktnamn) > 40) {
          return "Produktnamnet är för långt (max 40 tecken)";}


          $stmt = $mysqli->prepare("UPDATE produkter SET Produktnamn = ? Where ProductID = $proPageNr))");
          $stmt->bind_param("s", $Produktnamn);
          $stmt->execute();
          if ($stmt->affected_rows != 1) {
            return "Ett fel uppstod. Var god försök igen";
          } else {
            return "success";}

      $mysqli->close();
    }

    function responseHTML() {
      if (isset($_POST['submit'])) {
      $response = adminProductInfoNameNew($_POST['Produktnamn']);}
     /* if statement for a for a correct account creation or else for incorrect creation and what show what the fault is. */
      if (@$response == "success") {
        if (isset($_POST['submit'])) { ?>
          <p class="success registrationSuccess">
          <span class="registrationSuccessHead"><?php echo htmlspecialchars($_POST["Produktnamn"]); ?></span>
          <br>Produktdatan har ändrats.<br>
              </p>
          <?php }	} else {?><p class="registrationError"><?php echo htmlspecialchars(@$response); ?></p><?php }} 

    /*
    function adminProductInfoNew2(){
      $mysqli = connect();
		$proPageNr = htmlspecialchars($_GET["produktnr"]);
		//$imagesLink = get_bloginfo('template_directory') . "/eshop/img/produkter/";
		$proInfo = "SELECT produkter.ProductID , produkter.Produktnamn, produkter.Produktbeskrivning,
		 produkter.Pris, produkter.Bild, kategorier.Kategorinamn FROM produkter
		INNER JOIN kategorier ON kategorier.CategoryID = produkter.CategoryID WHERE produkter.ProductID = '$proPageNr'";
		$proInfoResult = $mysqli->query($proInfo);
		if ($proInfoResult !== false && $proInfoResult->num_rows > 0) {
			// output data of each row
			while ($row = $proInfoResult->fetch_assoc()) {
				echo 
				"<h2 class='h2text'>Ny data</h2><div class='col-6 col-s-6'><ul class='proMainList'>
        
        <li>Produktnamn</li><li class='proPageInfo'>" . $row["Produktnamn"] . "</li>
				<li>Produktnummer</li><li class='proPageInfo'>" . $row["ProductID"] . "</li>
				<li>Pris</li><li class='proPageInfo'>" . $row["Pris"] . " kr</li>
				<li>Produktbeskrivning</li><li class='proPageInfo'>" . $row["Produktbeskrivning"] . "</li>
				<li>Kategori</li><li class='proPageInfo'>" . $row["Kategorinamn"] . "</li>
        <li>Bild</li><li class='proPageInfo'>" . $row["Bild"] . "</li>
        </ul></div>";}
			echo "";
		} else {
			echo "0 results";}
		$mysqli->close();
  }


  function adminProductInfoNew($Produktnamn, $Produktbeskrivning, $CategoryID, $Pris, $Bild){
		$mysqli = connect();

    $proPageNr = htmlspecialchars($_GET["produktnr"]);

		$args = func_get_args();
		$args = array_map(function ($value) {
			return trim($value);
		}, $args);
		foreach ($args as $value) {
			if(empty($value)){
				return "Alla fälten måste fyllas i";}}
		foreach ($args as $value) {
			if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
				return "Specialtecken får inte användas";}}
		    if (is_numeric($CategoryID) == false){
      return "CategoryID är inte ett nummer";}
		if (strlen($Produktnamn) > 40) {
			return "Produktnamnet är för långt (max 40 tecken)";}
		if (strlen($Produktbeskrivning) > 400) {
			return "Produktbeskrivningen är för lång (max 400 tecken)";}
    if (is_numeric($Pris) == false){
      return "Pris är inte ett nummer";}
		if (strlen($Bild) > 40) {
			return "Bild-URL:en är för lång (max 40 tecken)";}


		$stmt = $mysqli->prepare("UPDATE produkter SET Produktnamn = ?, Produktbeskrivning= ? , CategoryID= ? , Pris= ? , Bild = ? Where ProductID = $proPageNr))");
	  $stmt->bind_param("sssss", $Produktnamn, $Produktbeskrivning, $CategoryID, $Pris, $Bild);
		$stmt->execute();
		if ($stmt->affected_rows != 1) {
			return "Ett fel uppstod. Var god försök igen";
		} else {
			return "success";}}

*//*
    	function responseHTML() {
        if (isset($_POST['submit'])) {
        $response = adminProductInfoNew($_POST['Produktnamn'], $_POST['Produktbeskrivning'], $_POST['CategoryID'], $_POST['Pris'], $_POST['Bild'] );}*/
       /* if statement for a for a correct account creation or else for incorrect creation and what show what the fault is. */
    /*    if (@$response == "success") {
          if (isset($_POST['submit'])) { ?>
            <p class="success registrationSuccess">
            <span class="registrationSuccessHead"><?php echo htmlspecialchars($_POST["Produktnamn"]); ?></span>
            <br>Produktdatan har ändrats.<br>
                </p>
            <?php }	} else {?><p class="registrationError"><?php echo htmlspecialchars(@$response); ?></p><?php }} */?>


<?php get_header();?>
<main>
  <div class="row">
    <div class="col-4 col-s-4"></div>
    <div class="col-4 col-s-4">
      <?php 
        adminProductInfoHead();
      ?>
    </div>
  </div>
<div class="row">
<div class="col-1 col-s-1"></div>
	<div class="col-5 col-s-5">
	<div class="products">
		
		<!-- creates product info page -->
    <?php adminProductInfoOld(); ?>
  </div></div>
	<div class="col-5 col-s-5">
	<div class="productform">

  <form class="registrationForm" action="#" method="post" autocomplete="off">
		<div class="col-12 col-s-12">
		<h2 class="h2text">Ny data</h2>
		<p class="topText">
			<br>
			<!--Har du redan ett konto?
			<a class="topText" href="wordpress/ebutik/logga-in/">Logga in här</a>-->
	</p></div>

  
<div class="row"></div><div class="row"><div class="col-6 col-s-6">
      <div class="registrationField">
				<label>Produktnummer</label><input class="registrationInput" type="text" name="ProduktID" value="<?php  $proPageNr = htmlspecialchars($_GET["produktnr"]); echo $proPageNr; ?>" disabled="disabled" ></div>
			<div class="registrationField">
				<label>Produktnamn *</label><input class="registrationInput" type="text" name="Produktnamn" value="<?php echo htmlspecialchars(@$_POST['Produktnamn']); ?>" ><button class="registrationSubmit" type="submit" name="submit">Ändra</button><?php responseHTML(); ?></div>
			<div class="registrationField">
				<label>Produktbeskrivning *</label>
				<input class="registrationInput" type="text" name="Produktbeskrivning" value="< ?php echo htmlspecialchars(@$_POST['Produktbeskrivning']); ?>" ></div>
			<div class="registrationField">
				<label>CategoryID *</label>
				<input class="registrationInput" type="text" name="CategoryID" value="< ?php echo htmlspecialchars(@$_POST['CategoryID']); ?>" ></div>
			<div class="registrationField">
				<label>Pris *</label>
				<input class="registrationInput" type="text" name="Pris" value="< ?php echo htmlspecialchars(@$_POST['Pris']); ?>" ></div>
			<div class="registrationField">
				<label>Bild *</label>
				<input class="registrationInput" type="text" name="Bild" value="< ?php echo htmlspecialchars(@$_POST['Bild']); ?>" ></div>
		<div class="rowThings">
		<button class="registrationSubmit" type="submit" name="subsmit">Ändra produktdata</button>< ?php responseHTML(); ?>	</div></div></div></form></div>
		<!-- creates product info page -->
    

  </div></div>
 

</div>
</main>
		<?php get_footer();?>