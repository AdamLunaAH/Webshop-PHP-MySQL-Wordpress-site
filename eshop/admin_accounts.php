<?php 
/* Template Name: Admin Accounts page */
	require "eshopfunctions.php";

  // creates the product list
  if (!isset($_SESSION['admin']) ) {
		header("location: wordpress/ebutik/administration_login/");
		exit();} 

    function adminMemberList() {
      $pdo = connectPDO();
      $stmt = $pdo->prepare("SELECT MemberID, Fornamn, Efternamn,
      Epost, Mobilnr, Gatuadress, Postnr, Ort, Skapad FROM medlem");
      $stmt->execute();
      $result = $stmt->fetchAll();
      if ($result !== false && count($result) > 0) {
        echo "<div class='itemTable'><table class='dbResult'><tr class ='dbResultRow'><th class='tableHead'>MemberID</th><th class='tableHead'>Förnamn</th><th class='tableHead'>Efternamn</th><th class='tableHead'>E-post</th><th class='tableHead'>Mobilnr</th><th class='tableHead'>Gatuadress</th><th class='tableHead'>Postnr</th><th class='tableHead'>Ort</th><th class='tableHead'>Skapad</th></tr>";
        // output data of each row
        foreach ($result as $row) {
          echo "<tr>
                <td>"
                  .  htmlspecialchars($row["MemberID"]) .
                "</td>
                <td>"
                  . htmlspecialchars($row["Fornamn"]) .
                "</td>
                <td>"
                  .  htmlspecialchars($row["Efternamn"]) .
                "</td>
                <td>"
                  .  htmlspecialchars($row["Epost"]) .
                "</td>
                <td>"
                  . htmlspecialchars($row["Mobilnr"]) .
                "</td>
                <td>"
                  . htmlspecialchars($row["Gatuadress"]) .
                "</td>
                <td>"
                  . htmlspecialchars($row["Postnr"]) .
                "</td>
                <td>"
                  . htmlspecialchars($row["Ort"]) .
                "</td>
                <td>"
                  . htmlspecialchars($row["Skapad"]) .
                "</td>
          </tr>     
        ";}
        echo "</table>";
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
    <h1>Visar Medlemmar</h1>
    <?php adminMemberList(); ?>
</div></div></main>
<?php get_footer();?>