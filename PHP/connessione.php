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

  public function getMessages() {  //funzione per prendere messaggi da DB
    $query = "SELECT id_messaggio, username, data, msg, letto, messaggi.id_prodotto, Nome FROM messaggi , prodotti
     WHERE `messaggi`.`id_prodotto` = `prodotti`.`id_prodotto` ORDER BY letto";  
    $queryResult = mysqli_query($this->connection, $query);
    $result = array();
    while ($row = mysqli_fetch_assoc($queryResult)) {
        $result[] = $row;
    }
    return $result;
  }
  
    public function new_Message($username, $product_id, $messag)  { // aggiunta messaggio a DB
    $currentDate = date("Y-m-d");
    $query = "INSERT INTO messaggi(msg, data, username) VALUES ('$messag', '$currentDate', '$username')"; // da implementare con id prodotto e categoria
    $success = mysqli_query($this->connection, $query);

    return $success;
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
    $row = mysqli_fetch_assoc($queryResult);
    return isset($row);
  }
  public function checkLogin($user,$pass){
    $OKuser=pulisciInput($user);
    $OKpass=pulisciInput($pass);
    $query = "SELECT * FROM `utente` WHERE `username`='$OKuser' AND `password`='$OKpass'"; 
    $queryResult = mysqli_query($this->connection, $query);
    $row = mysqli_fetch_assoc($queryResult);
    if(isset($row))
    {
      if($row["ruolo"]==true)
      {
          return array("username"=>$row["username"],
                      "ruolo"=> $row["ruolo"]);
      }
      else
      {
          return array("username"=>$row["username"],
                      "ruolo"=> null);
      }
    }
    else
    {
      return null;
    }
  }
    public function checkAndChangePassword($user, $old, $new) {
    $OKUser = pulisciInput($user);
    $OKOld = pulisciInput($old);
    $OKNew = pulisciInput($new);

    $query = "SELECT password FROM utente WHERE username = '$OKUser'";
    $queryResult = mysqli_query($this->connection, $query);

    if($queryResult != $OKOld)
      return "old_wrong";
    else
      {
        $query = "UPDATE utente SET password = '$OKNew' WHERE username = '$OKUser' AND password = '$OKOld'";
        $queryResult = mysqli_query($this->connection, $query);

        if($queryResult)
          return "success";
        else
          return "error";
      }
  }

  public function getUtenti() {
    $query = "SELECT * FROM utente";
    $queryResult = mysqli_query($this->connection, $query) or die("Errore database:" . mysqli_error($this->connection));
    if (mysqli_num_rows($queryResult) == 0) {
      return null;
    } else {
      $result = array();
      while ($row = mysqli_fetch_assoc($queryResult)) {
        array_push($result, $row);
      }
      $queryResult->free();
      return $result;
    }
  }

  public function closeConnection() {
    mysqli_close($this->connection);
  }
}

?>
