<?php

namespace DB;

function pulisciInput($value) {
  // elimina gli spazi
  $value = trim($value);
  // rimuove tag html (non sempre è una buona idea!)
  $value = strip_tags($value);
  // converte i caratteri speciali in entità html (ex. &lt;)
  $value = htmlentities($value);
  return $value;
}

class DBAccess {
  //require_once "credenziali.php";
  
  private $connection;
  public function openDBConnection() {
    mysqli_report(MYSQLI_REPORT_ERROR);
    $this->connection = mysqli_connect("127.0.0.1", "root", "", "tecweb");
    //$this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);
    if (mysqli_connect_errno()) {return false;}
    return true;
  }
  
  public function getCategories() {
    $query = "SELECT * FROM `categoria` ";
    $queryResult = mysqli_query($this->connection, $query);
    $result = array();
    while ($row = mysqli_fetch_assoc($queryResult)) {
        $result[] = $row;
    }
    return $result;
  }
  public function getProductListANDCheckCategory($id_categ) {
  $OKCateg=pulisciInput($id_categ);
  $query = "SELECT * FROM `prodotti` WHERE id_categoria ='$OKCateg'";
  $queryResult = mysqli_query($this->connection, $query);
  $result = array();
  while ($row = mysqli_fetch_assoc($queryResult)) {
      $result[] = $row;
  }
  return $result;
}

  public function getProduct($id_prodotto) {
  $OKProd=pulisciInput($id_prodotto);
    $query = "SELECT * FROM `prodotti` LEFT JOIN `immagini` on `prodotti`.`id_prodotto` = `immagini`.`id_prodotto` WHERE `prodotti`.`id_prodotto` ='$OKProd'";
    $queryResult = mysqli_query($this->connection, $query);
    $result = array();
    while ($row = mysqli_fetch_assoc($queryResult)) {
        $result[] = $row;
    }
    return $result;
  }

  public function getMessages() {
    $query = "SELECT id_messaggio, username, 'data', id_prodotto, msg, letto FROM messaggi";  // da implementare con il resto dei parametri di messaggi
    $queryResult = mysqli_query($this->connection, $query);
    $result ="";

    while($row = mysqli_fetch_assoc($queryResult))
    {
        $result .= "<tr>";
      
        $result .= "<td><input type=\"checkbox\" name=\"form_msg[]\" value=" . $row["id_messaggio"] .
        "\"/></td>";

        foreach($row as $value)
          $result .= "<td>" . $value . "</td>";
        
        $result .= "</tr>";
    }

    return $result;
  }

  public function Message_Read($id_messaggio) {
    $OKId = pulisciInput($id_messaggio);
    $query = "UPDATE messaggi SET letto = '1' WHERE id_messaggio = '$OKId' AND  letto = '0'";
    mysqli_query($this->connection, $query);
  }

  public function addtoWishList($id_prodotto,$id_categoria,$username) {
    $OKProd=pulisciInput($id_prodotto);
    $OKcat=pulisciInput($id_categoria);
    $OKuser=pulisciInput($username);
    $query = "INSERT INTO `wishlist` (`username`, `id_prodotto`, `id_categoria`) VALUES ('$OKuser', '$OKProd', '$OKcat')";
    $result = mysqli_query($this->connection, $query);
    return $result;
  }

 
  public function removeFromWishList($id_prodotto,$id_categoria,$username) {
    $OKProd=pulisciInput($id_prodotto);
    $OKcat=pulisciInput($id_categoria);
    $OKuser=pulisciInput($username);
    $query = "DELETE FROM wishlist WHERE `wishlist`.`username` = '$OKuser' AND `wishlist`.`id_prodotto` = '$OKProd' AND `wishlist`.`id_categoria`='$OKcat'";
    $result = mysqli_query($this->connection, $query);
    return $result;
  }
  
  public function isInWishList($idprod,$idcat,$user){
    $query = "SELECT * FROM `wishlist` WHERE `username`='$user' AND `id_prodotto`='$idprod' AND `id_categoria`='$idcat'"; 
    $queryResult = mysqli_query($this->connection, $query);
    $result = array();
    $row = mysqli_fetch_assoc($queryResult);
    return isset($row);
  }



  public function closeConnection() {
    mysqli_close($this->connection);
  }
}

?>
