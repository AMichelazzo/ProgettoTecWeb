<?php
session_start();
$eliminazione=isset($_SESSION["profiloeliminato"])?$_SESSION["profiloeliminato"]:null;
session_destroy();
if (isset($eliminazione)) {
    header("Location: index.php?elim=true");
} else {
    header("Location: index.php");
}
?>
