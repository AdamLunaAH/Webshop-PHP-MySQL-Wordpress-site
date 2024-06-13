<!-- index and home/start page of the site -->
<!-- this page code shows all the pages that called to on the other pages 
get_header for the header on a page, and get_footer for the footer on the pages -->
<?php require "eshop/eshopfunctions.php";
/*function loggedInUserData() {
  $mysqli = connect();
    if (isset($_SESSION['user'])) {
  $sql = "SELECT MemberID, Epost FROM medlem WHERE Epost = '{$_SESSION['user']}'";
    $result = $mysqli -> query($sql);
    $row = $result -> fetch_assoc();
    $userid = $row["MemberID"];
    return $userid;
    } else {
      $mysqli->close();}}*/
      function homePage(){
        $pdo = connectPDO();
        if (isset($_SESSION['user'])){
          $userid=$_SESSION['userid'];
          $memberDiscountID = $userid;
          $themeLink = get_bloginfo('template_directory')."/eshop/img/produkter/";
          date_default_timezone_get();
          $datetime = date('y-m-d h:i:s');
          $stmt = $pdo->prepare("SELECT produkter.ProductID, produkter.Bild, produkter.Produktnamn, produkter.Pris, erbjudanden.ErbjudPris, medlemserbjudanden.MemberID, erbjudanden.Starttid, erbjudanden.Sluttid FROM produkter
          INNER JOIN erbjudanden ON erbjudanden.ProductID = produkter.ProductID
          INNER JOIN medlemserbjudanden ON medlemserbjudanden.DiscountID = erbjudanden.DiscountID
          INNER JOIN medlem ON medlem.MemberID = medlemserbjudanden.MemberID
          WHERE medlemserbjudanden.MemberID = ? AND erbjudanden.Starttid < ? AND erbjudanden.Sluttid > ?");
          $stmt->execute([$memberDiscountID, $datetime, $datetime]);
          $discountresult = $stmt->fetchAll();
          if ($discountresult !== false && count($discountresult) > 0) {
            echo "<div class='row'><h2>Erbjudanden</h2><div class='col-3 col-s-3'></div><div class='col-6 col-s-6 productGridList'>";
            foreach($discountresult as $row) {
              echo "<div class='productGrid'><img class='productImg' src='" . $themeLink . $row["Bild"] . "' width='300' height='300' alt='" . $row["Produktnamn"] . "'>" . $row["Produktnamn"]. "<br>" . $row["ProductID"]. "<br><span class='gamPris'>". $row["Pris"]. " kr</span><br>". $row["ErbjudPris"]. " kr<br>". $row["Sluttid"]. "<br><a href='/wpmywebsite/wordpress/ebutik/produkt?produktnr={$row["ProductID"]}'>Länk</a></div>";
            }
            echo "</div></div>";
          } else {
            echo "<div class='row'><h2>Erbjudanden</h2><div class='col-3 col-s-3'></div><div class='col-6 col-s-6 productGridList'><h3>Du har ej några giltiga erbjudanden.</h3></div></div>";}

          } else {
            // shows button with link when the user is not logged in
            echo "<div class='row'></div>
            <div class='col-12 col-s-12'><h2>Välkommen!</h2></div>
            <div class='row'><div class='col-3 col-s-3'></div>
              <div class='col-6 col-s-6'>
              <div class='wp-block-columns'><div class='wp-block-column'><div class='wp-block-buttons'>
                <div class='wp-block-button is-style-fill'>
                  <a class='wp-block-button__link' href='http://192.168.0.6/wpmywebsite/wordpress/ebutik/logga-in/'>Logga in</a></div>
                </div></div><div class='wp-block-column'><div class='wp-block-buttons'><div class='wp-block-button'>
                  <a class='wp-block-button__link' href='http://192.168.0.6/wpmywebsite/wordpress/ebutik/produkter/'>Produkter</a></div>
                </div></div><div class='wp-block-column'><div class='wp-block-buttons'><div class='wp-block-button'>
                  <a class='wp-block-button__link' href='http://192.168.0.6/wpmywebsite/wordpress/ebutik/medlemserbjudanden/'>Erbjudanden</a></div>
                </div></div></div>
              </div>
            </div>";
          }

        }
           
      
// picks a 6 random products to show om home page
function productlist(){
  $pdo = connectPDO();
  $themeLink = get_bloginfo('template_directory')."/eshop/img/produkter/";
  $productList = "SELECT produkter.ProductID , produkter.Produktnamn, produkter.Produktbeskrivning, produkter.Pris, kategorier.Kategorinamn, produkter.Bild FROM produkter
  INNER JOIN kategorier ON kategorier.CategoryID = produkter.CategoryID
  ORDER BY RAND() LIMIT 6";
  $stmt = $pdo->prepare($productList);
  $stmt->execute();
  $result = $stmt->fetchAll();
  if (count($result) > 0) {
    echo "<div class='row'><h2>Utvalda Produkter</h2><div class='col-3 col-s-3'></div><div class='col-6 col-s-6 productGridList'>";
    foreach ($result as $row) {
      echo "<div class='productGrid'>".
      "<img class='productImg' src='" . $themeLink . $row["Bild"] . "' width='300' height='300' alt='" . $row["Produktnamn"] . "'>" .  $row["Produktnamn"]."<br>" .
        "" . $row["ProductID"]. "<br>". $row["Pris"]. " kr<br>". $row["Kategorinamn"]. "<br><a href=\"/wpmywebsite/wordpress/ebutik/produkt?produktnr={$row["ProductID"]}\">Länk</a>
        </div>";
    }
    echo "</div></div>";
  } else {
    echo "0 results";
  }
}
 ?>
 
<?php get_header(); ?>
<main>
<!-- Home page -->
<div class="row"><div class="col-12 col-s-12"><h1>E-Butik</h1></div></div>
<div class="row"><?php homePage().ProductList() ; ?></div>
<!-- page bottom content -->
<div class="row"><div class="col-1 col-s-1"></div><div class="col-10 col-s-10">
<div class="wp-block-columns"><div class="wp-block-column"><div class="wp-block-buttons">
<div class="wp-block-button is-style-fill">
<a class="wp-block-button__link" href="/wpmywebsite/wordpress/ebutik/produkter/">Produkter</a></div>
</div></div><div class="wp-block-column"><div class="wp-block-buttons"><div class="wp-block-button">
<a class="wp-block-button__link" href="/wpmywebsite/wordpress/ebutik/kontakt/">Kontakt</a></div>
</div></div><div class="wp-block-column"><div class="wp-block-buttons"><div class="wp-block-button">
  <a class="wp-block-button__link" href="/wpmywebsite/wordpress/ebutik/medlemskonto/">Medlemskonto</a></div>
</div></div></div></div></div>
</main><?php get_footer(); ?>