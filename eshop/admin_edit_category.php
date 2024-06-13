<?php 
/* Template Name: Admin Edit category Info */
	require "eshopfunctions.php";

	if (!isset($_SESSION['admin']) ) {
		header("location: wordpress/ebutik/administration_login/");
		exit();}
		
?>
<?php

function adminCategoryInfoHead() {
  $pdo = connectPDO();
  $categoryPageNr = htmlspecialchars($_GET["categoryid"]);
  //$imagesLink = get_bloginfo('template_directory') . "/eshop/img/produkter/";
  $categoryInfo = "SELECT CategoryID, Kategorinamn FROM kategorier WHERE CategoryID = :categoryPageNr";
  $stmt = $pdo->prepare($categoryInfo);
  $stmt->bindParam(':categoryPageNr', $categoryPageNr);
  $stmt->execute();
  $categoryInfoResult = $stmt->fetchAll();
  if ($categoryInfoResult !== false && count($categoryInfoResult) > 0) {
    // output data of each row
    foreach ($categoryInfoResult as $row) {
      echo "<h1>". $row["Kategorinamn"] . "</h1>" . "<br>"
      ;}
    echo "";
  } else {
    echo "0 results";}
  $pdo = null;
}


function adminCategoryInfoOld() {
  $pdo = connectPDO();
  $categoryPageNr = htmlspecialchars($_GET["categoryid"]);
  $categoryInfo = "SELECT CategoryID, Kategorinamn FROM kategorier WHERE CategoryID = :categoryid";
  $stmt = $pdo->prepare($categoryInfo);
  $stmt->bindParam(':categoryid', $categoryPageNr);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($result !== false) {
    echo "<h2 class='h2text'>Nuvarande data</h2><div class='col-6 col-s-6'><ul class='proMainList'>
    <li>CategoryID</li><li class='proPageInfo'>" . $result["CategoryID"] . "</li>
    <li>Kategorinamn</li><li class='proPageInfo'>" . $result["Kategorinamn"] . "</li>
    </ul></div>";
  } else {
    echo "0 results";
  }
}

function editCategoryName($Kategorinamn){
  $pdo = connectPDO();
  $categoryPageNr = htmlspecialchars($_GET["categoryid"]);
  $args = func_get_args();
  $args = array_map(function ($value) {
    return trim($value);
  }, $args);
  $checkStmt = $pdo->prepare("SELECT Kategorinamn FROM kategorier WHERE Kategorinamn = ?");
  $checkStmt->bindParam(1, $Kategorinamn);
  $checkStmt->execute();
  $checkResult = $checkStmt->fetch(PDO::FETCH_ASSOC);
  if ($checkResult != NULL){
    return "Kategorinamnet används redan";
  }
  foreach ($args as $value) {
    if(empty($value)){
      return "Kategorinamnet måste fyllas i!";
    }
    if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
      return "Specialtecken får inte användas";
    }
  }
  if (strlen($Kategorinamn) > 40) {
    return "Kategorinamnet är för långt (max 40 tecken)";
  }
  $updateStmt = $pdo->prepare("UPDATE kategorier SET Kategorinamn=:kategorinamn WHERE CategoryID = :categoryid");
  $updateStmt->bindParam(':kategorinamn', $Kategorinamn);
  $updateStmt->bindParam(':categoryid', $categoryPageNr);
  $updateStmt->execute();
  if ($updateStmt->rowCount() != 1) {
    return "Ett fel uppstod. Var god försök igen";
  } else {
    return "success";
  }
}
	
	
	
		function responseEditCategoryName() {
			$categoryPageNr = htmlspecialchars($_GET["categoryid"]);
		if (isset($_POST['submitEditCategoryName'])) {
		$response = editCategoryName($_POST['Kategorinamn'] );}
	 /* if statement for a for a correct account creation or else for incorrect creation and what show what the fault is. */
		if (@$response == "success") {
			if (isset($_POST['submitEditCategoryName'])) { 
				echo "<script>alert('Kategorinamnet har ändrats till: " . htmlspecialchars($_POST['Kategorinamn']) . "')</script>";
				echo "<meta http-equiv='refresh' content='0;url/wpmywebsite/wordpress/ebutik/edit-category/?categoryid=" . $categoryPageNr . "'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["Kategorinamn"]) . "</span><br>Produktnamnet har ändrats.<br></p>";
				}	} else { 
					echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
				 }}

	
?>


<?php get_header();?>
<main>

	<div class="row">
    <div class="col-4 col-s-4"></div>
    <div class="col-4 col-s-4">
      <?php 
        adminCategoryInfoHead();
      ?>
    </div>
  </div>
	<div class="row">
		<div class="col-1 col-s-1"></div>
	<div class="col-5 col-s-5">
	<div class="products">
		
		<!-- creates product info page -->
    <?php adminCategoryInfoOld(); ?>
  </div></div>


	<div class="col-5 col-s-5">
	<div class="productform">
	<!-- edit product form -->
	<form class="registrationForm" action="#" method="post" autocomplete="on">
		<div class="col-12 col-s-12">
		<h2 class='h2text'>Ändra kategoriinformation</h2>
		<p class="topText">
			
	</p></div>
<div class="row"></div><div class="row">
			<div class="registrationField">
				<label>Kategorinamn</label>
				<div class="formInputButtonRow"><input class="registrationInput" type="text" name="Kategorinamn" value="<?php echo htmlspecialchars(@$_POST['Kategorinamn']); ?>" >
				</div>
			</div>
		<div class="rowThings">
		<div class="formInputButton"><button class="registrationSubmit" type="submit" name="submitEditProductAll">Ändra</button></div><?php responseEditCategoryName(); ?>	</div></div></div></form></div>
		</div></div>
		
</main>
		<?php get_footer();?>