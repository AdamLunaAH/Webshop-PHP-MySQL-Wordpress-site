<?php 
/* Template Name: Admin Products page og*/
	require "eshopfunctions.php";

  // creates the product list
  if (!isset($_SESSION['admin']) ) {
		header("location: wordpress/ebutik/administration_login/");
		exit();} 

    function adminProductList() {
      // connect to connectPDO()
      $pdo = connectPDO();
      //creates the base link to the product pictures
      $themeLink = get_bloginfo('template_directory')."/eshop/img/produkter/";
      //SELECT statment used to select the data that will be presented on the page. FROM statment says what table the data is from and INNER JOIN  
      $stmt = $pdo->prepare("SELECT produkter.ProductID , produkter.Produktnamn, produkter.Produktbeskrivning,
      produkter.Pris, kategorier.CategoryID, kategorier.Kategorinamn, produkter.Bild FROM produkter
      INNER JOIN kategorier ON kategorier.CategoryID = produkter.CategoryID");
      $stmt->execute();
      $result = $stmt->fetchAll();
      //check if there are any resluts and presents them
      if ($result !== false && count($result) > 0) {
      echo "<div class='productListPage'>";
      foreach ($result as $row) {
      echo "<div class='productPageGrid kategori-". htmlspecialchars($row['CategoryID']) ."'>
      <h3 class='productName '>" . htmlspecialchars($row["Produktnamn"]). "</h3><br>" .
      "<img class='productImg' src='" . $themeLink . htmlspecialchars($row["Bild"]) . "' width='300' height='300' alt='" . htmlspecialchars($row["Produktnamn"]) . "'>" .
      "<br>" . htmlspecialchars($row["ProductID"]). "<br>" . htmlspecialchars($row["Produktbeskrivning"]). "<br>".
      htmlspecialchars($row["Pris"]). "<br>". htmlspecialchars($row["Kategorinamn"]). "<br>
      <a href='/wpmywebsite/wordpress/ebutik/produkt?produktnr={$row['ProductID']}'>Länk</a>"."<br>
      <a href='/wpmywebsite/wordpress/ebutik/edit-product?produktnr={$row['ProductID']}'>Ändra</a>"."</div>";
      }
      echo "</div>";
      } else {
      echo "0 results";
      }
      } ?>
<?php get_header();?>
<main id="maintest">
  <!-- creates the product filter options -->
<!--<nav class="section-nav col-1 col-s-1">
      <h4 class="categorytext">Filtrera bort produkter</h4>
		<ol>
			<li class="scrolltable">
        <button class='catagoryToggle' name='Kategori 1' value='Kategori 1' id='Kategori_1'>Kategori 1</button></li>
			<li class="scrolltable">
        <button class='catagoryToggle' name='Kategori 2' value='Kategori 2' id='Kategori_2'>Kategori 2</button></li>
			<li class="scrolltable">
        <button class='catagoryToggle' name='Kategori 3' value='Kategori 3' id='Kategori_3'>Kategori 3</button></li>
			<li class="scrolltable">
        <button class='catagoryToggle' name='Kategori 4' value='Kategori 4' id='Kategori_4'>Kategori 4</button></li>
			<li class="scrolltable">
        <button class='catagoryToggle' name='Kategori 5' value='Kategori 5' id='Kategori_5'>Kategori 5</button></li>
			<li class="scrolltable">
        <button class='catagoryToggle' name='Kategori 6' value='Kategori 6' id='Kategori_6'>Kategori 6</button></li>
      <li class="scrolltable">
        <button class='catagoryToggle' name='Kategori All' value='Kategori All' id='Kategori_All'>Visa alla</button></li>
		</ol>
</nav>
  -->
  <div class="col-1 col-s-1"></div>
<div class="row"><div class="col-10 col-s-10">
  <!-- product list -->
    <h1>Visar produkter</h1>
    <?php adminProductList(); ?>
</div></div></main>
<?php get_footer();?>