<?php

namespace DB;

class DBAccess {
  require_once('credenziali.php');
  
  private $connection;
  public function openDBConnection() {

    mysqli_report(MYSQLI_REPORT_ERROR)

    $this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);

    if(mysqli_connect_errno()) {return false;}
    else {return true;}
  
  }

  public function closeConnection() {
    mysqli_close($this->connection)
  }
}

?>