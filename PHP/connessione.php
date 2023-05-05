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
  require_once('credenziali.php');
  
  private $connection;
  public function openDBConnection() {
    mysqli_report(MYSQLI_REPORT_ERROR);
    $this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);
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
    $query = "SELECT `prodotti`.`id_prodotto`,`prodotti`.`id_categoria`,`prodotti`.`Nome`,`prodotti`.`Descrizione`,`immagini`.`path`,`immagini`.`alt_img` FROM `prodotti` LEFT JOIN `immagini` on `prodotti`.`id_prodotto` = `immagini`.`id_prodotto` WHERE `prodotti`.`id_prodotto` ='$OKProd'";
    $queryResult = mysqli_query($this->connection, $query);
    $result = array();
    while ($row = mysqli_fetch_assoc($queryResult)) {
        $result[] = $row;
    }
    return $result;
  }

  public function addtoWishList($id_prodotto,$id_categoria,$username) {
    $OKProd=pulisciInput($id_prodotto);
    $OKcat=pulisciInput($id_categoria);
    $OKuser=pulisciInput($username);
    $query = "INSERT INTO `wishlist` (`username`, `id_prodotto`, `id_categoria`) VALUES ('$OKuser', '$OKProd', '$OKcat')";
    $result = mysqli_query($this->connection, $query);
    //POI CONTROLLA SE ITEM è GIA INSERITO IN WISH LIST
    return ($result == true);
  }


  public function closeConnection() {
    mysqli_close($this->connection);
  }
}

?>