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
    public function getAllProducts() {
    $query = "SELECT `id_prodotto`, `prodotti`.`id_categoria`, `prodotti`.`Descrizione`, `categoria`.`Nome` AS Cat_Nome, `prodotti`.`Nome` AS Prod_Nome FROM `prodotti` 
      JOIN `categoria` on `prodotti`.`id_categoria` = `categoria`.`id_categoria` ";
    $queryResult = mysqli_query($this->connection, $query);
    $result = array();
    while ($row = mysqli_fetch_assoc($queryResult)) {
        $result[] = $row;
    }
    return $result;
  }

  public function modifyProduct($id_prodotto, $id_categoria, $nome, $descrizione) {
    $OKId=pulisciInput($id_prodotto);
    $OKCat=pulisciInput($id_categoria);
    $OKNome=pulisciInput($nome);
    $OKDes=pulisciInput($descrizione);
    
    $query = "UPDATE `prodotti` SET `id_categoria` = '$OKCat', `Nome` = '$OKNome', `Descrizione` = '$OKDes' WHERE `id_prodotto` = '$OKId'";

    return mysqli_query($this->connection, $query);
  }
  
    public function getProductName($id_prodotto, $id_categoria) {
    $OKProd=pulisciInput($id_prodotto);
    $OKCat=pulisciInput(($id_categoria));

    $query = "SELECT DISTINCT `Nome` FROM `prodotti` WHERE `prodotti`.`id_prodotto` = '$id_prodotto' AND `prodotti`.`id_categoria` = '$id_categoria'";
    $queryResult = mysqli_query($this->connection, $query);

    if($queryResult == false) 
      return null;
    else {
      $result = mysqli_fetch_array($queryResult);
      return $result['Nome'];
    }
  }

public function getMessages() {  //funzione per prendere messaggi da DB
    $query = "SELECT messaggi.id_messaggio, utente.email, messaggi.data, messaggi.msg, messaggi.letto, prodotti.id_prodotto, prodotti.Nome, utente.email
    FROM messaggi LEFT JOIN prodotti ON messaggi.id_prodotto = prodotti.id_prodotto
    INNER JOIN utente ON messaggi.username = utente.username ORDER BY letto"; 
  
    $queryResult = mysqli_query($this->connection, $query); 
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
  
  public function delete_Message($id_messaggio) {
    $OKId = pulisciInput($id_messaggio);

    $query = "DELETE FROM messaggi WHERE id_messaggio = '$OKId'";
    $success = mysqli_query($this->connection, $query);

    return $success;
  }

  public function addtoWishList($id_prodotto,$id_categoria,$username) {
    $OKProd=pulisciInput($id_prodotto);
    $OKcat=pulisciInput($id_categoria);
    $query = "INSERT INTO `wishlist` (`username`, `id_prodotto`, `id_categoria`) VALUES ('$username', '$OKProd', '$OKcat')";
    $result = mysqli_query($this->connection, $query);
    return $result;
  }

 
  public function removeFromWishList($id_prodotto,$id_categoria,$username) {
    $OKProd=pulisciInput($id_prodotto);
    $OKcat=pulisciInput($id_categoria);
    $query = "DELETE FROM wishlist WHERE `wishlist`.`username` = '$username' AND `wishlist`.`id_prodotto` = '$OKProd' AND `wishlist`.`id_categoria`='$OKcat'";
    $result = mysqli_query($this->connection, $query);
    return $result;
  }
  
  public function isInWishList($idprod,$idcat,$user){
    $OKprod=pulisciInput($idprod);
    $OKcat=pulisciInput($idcat);
    $query = "SELECT * FROM `wishlist` WHERE `username`='$user' AND `id_prodotto`='$OKprod' AND `id_categoria`='$OKcat'"; 
    $queryResult = mysqli_query($this->connection, $query);
    $row = mysqli_fetch_assoc($queryResult);
    return isset($row);
  }
  public function checkLogin($user,$pass){
    $OKuser=pulisciInput($user);
    $OKpass=pulisciInput($pass);
    /*
    $user = mysqli_real_escape_string(stripslashes($user));
    $pass = mysqli_real_escape_string(stripslashes($pass));
    $query = $dbConnection->prepare("SELECT * FROM utente WHERE username = ? AND password = ?");
    $query->bind_param('ss', $user, $pass);
    $query->execute();
    $queryResult = $query->get_result();
    */
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

    public function checkOldPassword($user, $old) {
      $OKUser = pulisciInput($user);
      $OKOld = pulisciInput($old);

      $query = "SELECT username FROM utente WHERE username = '$OKUser' AND password = 'OKOld'";
      $queryResult = mysqli_query($this->connection, $query);

      if(isset($queryResult))
        return true;
      else  
        return false;
    }


    public function ChangePassword($user, $old, $new) {
    $OKUser = pulisciInput($user);
    $OKOld = pulisciInput($old);
    $OKNew = pulisciInput($new);

    $query = "UPDATE utente SET password = '$OKNew' WHERE username = '$OKUser' AND password = '$OKOld'";
    $queryResult = mysqli_query($this->connection, $query);

    if(isset($queryResult))
        return true;
      else  
        return false;
     
      }


  public function getUtenti() {
    $query = "SELECT * FROM utente WHERE ruolo = 'user'";
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

  public function checkUsern($user){
    $OKuser=pulisciInput($user);
    $query = "SELECT `username` FROM `utente` WHERE `username`='$OKuser'"; 
    $queryResult = mysqli_query($this->connection, $query);
    $row = mysqli_fetch_assoc($queryResult);
    return isset($row["username"])?$row["username"]:null;
  }

  public function checkEmail($email){
    $OKEmail=pulisciInput($email);
    $query = "SELECT `email` FROM `utente` WHERE `email`='$OKEmail'"; 
    $queryResult = mysqli_query($this->connection, $query);
    $row = mysqli_fetch_assoc($queryResult);
    return isset($row["email"])?$row["email"]:null;
  }

  public function registraNuovoUtente($pass_reg,$username_reg,$email_reg){
    $OKEmail=pulisciInput($email_reg);
    $OKPw=password_hash($pass_reg, PASSWORD_DEFAULT);
    echo $OKPw;die;
    $OKuser=pulisciInput($username_reg);
    $query = "INSERT INTO `utente` (`username`, `password`, `email`, `ruolo`, `data_creazione`) VALUES ('$OKuser', '$OKPw', '$OKEmail', 'user', current_timestamp())";
    $result = mysqli_query($this->connection, $query);
    return $result;
  }


  public function closeConnection() {
    mysqli_close($this->connection);
  }
}

?>
