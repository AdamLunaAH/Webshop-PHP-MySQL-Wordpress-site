<?php 
/* Template Name: Register page */
	require "eshopfunctions.php";
	if (isset($_SESSION['user'])) {
		header("location: wordpress/ebutik/medlemskonto/");
		exit();
	} 
	function responseHTML() {
	if (isset($_POST['submit'])) {
	$response = registerUser($_POST['fornamn'], $_POST['efternamn'], $_POST['epost'], $_POST['password'], $_POST['confirm_password'], $_POST['mobilnr'], $_POST['gatuadress'], $_POST['postnr'], $_POST['ort']);}
 /* if statement for a for a correct account creation or else for incorrect creation and what show what the fault is. */
	if (@$response == "success") {
		if (isset($_POST['submit'])) { ?>
			<p class="success registrationSuccess">
			<span class="registrationSuccessHead"> Hej <?php echo htmlspecialchars($_POST["fornamn"]); ?>!</span>
			<br>Ditt konto är nu skapat.<br>
			Tryck <a class="registrationSuccess" href="wordpress/ebutik/logga-in/">här</a> för att logga in.
		</p>
			<?php }	} else {?><p class="registrationError"><?php echo htmlspecialchars(@$response); ?></p><?php }} ?>
<?php get_header();?>
<main>
<div class="col-12 col-s-12">
	<!-- account creation form -->
	<form class="registrationForm" action="#" method="post" autocomplete="on">
		<div class="col-12 col-s-12">
		<h1>Skapa konto</h1>
		<p class="topText">
			Fyll i detta formulär för att skapa ett konto.<br>
			Alla fälten måste fyllas i.<br>
			Har du redan ett konto?
			<a class="topText" href="wordpress/ebutik/logga-in/">Logga in här</a>
	</p></div>
<div class="row"></div><div class="row"><div class="col-3 cols-s-3"></div><div class="col-6 col-s-6">
			<div class="registrationField">
				<label>Förnamn *</label><input class="registrationInput" type="text" name="fornamn" value="<?php echo htmlspecialchars(@$_POST['fornamn']); ?>" ></div>
			<div class="registrationField">
				<label>Efternamn *</label>
				<input class="registrationInput" type="text" name="efternamn" value="<?php echo htmlspecialchars(@$_POST['efternamn']); ?>" ></div>
			<div class="registrationField">
				<label>E-post *</label>
				<input class="registrationInput" type="text" name="epost" value="<?php echo htmlspecialchars(@$_POST['epost']); ?>" ></div>
			<div class="registrationField">
				<label>Lösenord *</label>
				<div class="passwordRow">
				<input class="registrationInput" type="password" id="psw" name="password" value="<?php echo htmlspecialchars(@$_POST['password']); ?>" >
				<i class="pswToggle showPass fa-solid fa-eye" onclick="pswShow(this)">Tryck här</i></div></div>
			<div class="registrationField">
				<label>Reppetera Lösenord *</label>
				<div class="passwordRow">
				<input class="registrationInput" type="password" id="reppsw" name="confirm_password" value="<?php echo htmlspecialchars(@$_POST['confirm_password']); ?>" >
				<i class="pswToggle showPass fa-solid fa-eye" onclick="pswShow(this)">Tryck här</i></div></div>
			<div class="registrationField">
				<label>Mobilnummer *</label>
				<input class="registrationInput" type="text" name="mobilnr" value="<?php echo htmlspecialchars(@$_POST['mobilnr']); ?>" ></div>
			<div class="registrationField">
				<label>Gatuadress *</label>
				<input class="registrationInput" type="text" name="gatuadress" value="<?php echo htmlspecialchars(@$_POST['gatuadress']); ?>" ></div>
			<div class="registrationField">
				<label>Postnummer *</label>
				<input class="registrationInput" type="text" name="postnr" value="<?php echo htmlspecialchars(@$_POST['postnr']); ?>" ></div>
			<div class="registrationField">
				<label>Ort *</label>
				<input class="registrationInput" type="text" name="ort" value="<?php echo htmlspecialchars(@$_POST['ort']); ?>" ></div>
		<div class="rowThings">
		<button class="registrationSubmit" type="submit" name="submit">Skapa Konto</button><?php responseHTML(); ?>	</div></div></div></form></div>
		</main>
		<?php get_footer();?>
