<?php 
/* Template Name: Products page */
	require "eshopfunctions.php";
  // creates the product list
  function productlist(){
    $pdo = connectPDO();
    $themeLink = get_bloginfo('template_directory')."/eshop/img/produkter/";
    $productList = "SELECT produkter.ProductID , produkter.Produktnamn, produkter.Produktbeskrivning,
    produkter.Pris, kategorier.CategoryID, kategorier.Kategorinamn, produkter.Bild FROM produkter
    INNER JOIN kategorier ON kategorier.CategoryID = produkter.CategoryID";
    $stmt = $pdo->prepare($productList);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($result)) {
      echo "<div class='productListPage'>";
      // output data of each row
      foreach ($result as $row) {
        echo "<div class='productPageGrid kategori-". $row['CategoryID'] ."'>
        <h3 class='productName '>" . $row["Produktnamn"]. "</h3><br>" .
        "<img class='productImg' src='" . $themeLink . $row["Bild"] . "' width='300' height='300' alt='" . $row["Produktnamn"] . "'>" .
         "<br>" . $row["ProductID"]. "<br>" . $row["Produktbeskrivning"]. "<br>".
         $row["Pris"]. "<br>". $row["Kategorinamn"]. "<br>
         <a href='/wpmywebsite/wordpress/ebutik/produkt?produktnr={$row["ProductID"]}'>Länk</a>"."</div>";}
      echo "</div>";
    } else {
      echo "0 results"; } $pdo = null;} ?>
<?php get_header();?>
<main id="maintest">
  <!-- creates the product filter options -->
<nav class="section-nav col-1 col-s-1">
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
</nav><div class="row"><div class="col-10 col-s-10">
  <!-- product list -->
    <h1>Produkter</h1>
    <?php productList(); ?>
</div></div></main>
<?php get_footer();?>