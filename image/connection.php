<?php
try{
 $conn=mysqli_connect("127.0.0.1","root","","db_etec2");
}catch(Exception $e){
    echo $e->getMessage();
}
?>