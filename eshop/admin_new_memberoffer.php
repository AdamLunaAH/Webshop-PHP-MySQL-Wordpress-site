<?php 
/* Template Name: Admin New Member Offer page */
	require "eshopfunctions.php";
	if (!isset($_SESSION['admin']) /*|| ( $_SESSION['userid'])*/) {
		header("location: wordpress/ebutik/administration_login/");
		exit();} 

    		
	/* registration function */
	function newOffer($MemberID, $DiscountID){
		$pdo = connectPDO();
		$args = func_get_args();
		$args = array_map(function ($value) {
			return trim($value);
		}, $args);
		
		foreach ($args as $value) {
			if(empty($value)){
				return "All fields must be filled in";
			}
			if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
				return "Special characters are not allowed";
			}
		}
	
		if (!is_numeric($MemberID)){
			return "MemberID is not a number";
		}
		if (!is_numeric($DiscountID)){
			return "DiscountID is not a number";
		}
	
		$stmt = $pdo->prepare("INSERT INTO medlemserbjudanden(MemberID, DiscountID)  VALUES(?,?)");
		$stmt->execute([$MemberID, $DiscountID]);
		
		if ($stmt->rowCount() != 1) {
			return "An error occurred. Please try again";
		} else {
			return "success";
		}
	}


	function responseHTML() {
	if (isset($_POST['submit'])) {
  $response = newOffer($_POST['MemberID'], $_POST['DiscountID']  );}
 /* if statement for a for a correct account creation or else for incorrect creation and what show what the fault is. */
	if (@$response == "success") {
		if (isset($_POST['submit'])) { ?>
			<p class="success registrationSuccess">
			<span class="registrationSuccessHead">Medlemserbjudanden skapat</span>
			<br><br>
					</p>
			<?php }	} else {?><p class="registrationError"><?php echo htmlspecialchars(@$response); ?></p><?php }} ?>
<?php get_header();?>


<main>
<div class="col-12 col-s-12">
	<!-- account creation form -->
	<form class="registrationForm" action="#" method="post" autocomplete="on">
		<div class="col-12 col-s-12">
		<h1>Nytt medlemserbjudande</h1>
		<p class="topText">
      Fyll i formuläret för att skapa ett nytt medlemserbjudande.<br>
			Alla fälten måste fyllas i.<br>
			<!--Har du redan ett konto?
			<a class="topText" href="wordpress/ebutik/logga-in/">Logga in här</a>-->
	</p></div>
<div class="row"></div><div class="row"><div class="col-3 cols-s-3"></div><div class="col-6 col-s-6">
			<div class="registrationField">
				<label>MemberID *</label><input class="registrationInput" type="text" name="MemberID" value="<?php echo htmlspecialchars(@$_POST['MemberID']); ?>" ></div>
			<div class="registrationField">
				<label>DiscountID *</label>
				<input class="registrationInput" type="text" name="DiscountID" value="<?php echo htmlspecialchars(@$_POST['DiscountID']); ?>" ></div>

		<div class="rowThings">
		<button class="registrationSubmit" type="submit" name="submit">Skapa medlemserbjudande</button><?php responseHTML(); ?>	</div></div></div></form></div>
		</main>
		<?php get_footer();?>
