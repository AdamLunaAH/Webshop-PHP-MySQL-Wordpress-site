<?php 
/* Template Name: Admin New Category page */
	require "eshopfunctions.php";
	if (!isset($_SESSION['admin']) /*|| ( $_SESSION['userid'])*/) {
		header("location: wordpress/ebutik/administration_login/");
		exit();} 

    		
	/* registration function */
	function newCategory($Kategorinamn) {
		$pdo = connectPDO();
		$args = func_get_args();
		$args = array_map(function ($value) {
			return trim($value);
		}, $args);
		foreach ($args as $value) {
			if (empty($value)) {
				return "All fields must be filled in";
			}
		}
		foreach ($args as $value) {
			if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
				return "Special characters are not allowed";
			}
		}
		
			$stmt = $pdo->prepare("SELECT Kategorinamn FROM kategorier WHERE Kategorinamn = ?");
			$stmt->execute([$Kategorinamn]);
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($data != NULL) {
				return "Category name already in use";
			}
			$stmt = $pdo->prepare("INSERT INTO kategorier (Kategorinamn) VALUES (?)");
			$stmt->execute([$Kategorinamn]);
			if ($stmt->rowCount() != 1) {
				return "An error occurred. Please try again";
			} else {
				return "success";
			}
	}



	function responseHTML() {
	if (isset($_POST['submit'])) {
  $response = newCategory($_POST['Kategorinamn'] /*, $_POST['mobilnr'], $_POST['gatuadress'], $_POST['postnr'], $_POST['ort']*/ );}
 /* if statement for a for a correct account creation or else for incorrect creation and what show what the fault is. */
	if (@$response == "success") {
		if (isset($_POST['submit'])) { ?>
			<p class="success registrationSuccess">
			<span class="registrationSuccessHead"><?php echo htmlspecialchars($_POST["Kategorinamn"]); ?></span>
			<br>Kategorin är skapad<br></p>
			<?php }	} else {?><p class="registrationError"><?php echo htmlspecialchars(@$response); ?></p><?php }} ?>
<?php get_header();?>


<main>
<div class="col-12 col-s-12">
	<!-- account creation form -->
	<form class="registrationForm" action="#" method="post" autocomplete="on">
		<div class="col-12 col-s-12">
		<h1>Ny produkt</h1>
		<p class="topText">
			Fyll i formuläret för att lägga till en ny kategori.<br>
			Alla fälten måste fyllas i.<br>
			<!--Har du redan ett konto?
			<a class="topText" href="wordpress/ebutik/logga-in/">Logga in här</a>-->
	</p></div>
<div class="row"></div><div class="row"><div class="col-3 cols-s-3"></div><div class="col-6 col-s-6">
			<div class="registrationField">
				<label>Kategorinamn *</label><input class="registrationInput" type="text" name="Kategorinamn" value="<?php echo htmlspecialchars(@$_POST['Kategorinamn']); ?>" ></div>
			
			<!--<div class="registrationField">
				<label>Gatuadress *</label>
				<input class="registrationInput" type="text" name="gatuadress" value="" ></div>
			<div class="registrationField">
				<label>Postnummer *</label>
				<input class="registrationInput" type="text" name="postnr" value="" ></div>
			<div class="registrationField">
				<label>Ort *</label>
				<input class="registrationInput" type="text" name="ort" value="" ></div>-->
		<div class="rowThings">
		<button class="registrationSubmit" type="submit" name="submit">Lägg till kategori</button><?php responseHTML(); ?>	</div></div></div></form></div>
		</main>
		<?php get_footer();?>
