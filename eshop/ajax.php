<?php
//Including Database configuration file.
include "eshopfunction";



//Getting value of "search" variable from "script.js".
if (isset($_POST['search'])) {
  $Name = $_POST['search'];
  $Query = "SELECT Produktnamn FROM produkter WHERE Produktnamn LIKE :Name LIMIT 5";
  $stmt = $pdo->prepare($Query);
  $stmt->execute(array(':Name' => '%'.$Name.'%'));
  echo '
      <ul>
  ';
  while ($Result = $stmt->fetch()) {
      ?>
      <li onclick="fill('<?php echo $Result['Produktnamn']; ?>')">
      <a>
          <?php echo $Result['Produktnamn']; ?>
      </a>
      </li>
      <?php
  }
  echo '
      </ul>
  ';
}