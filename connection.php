<?php
$servername='localhost';
$username='root';
$password='';
$dbname='loanmanagementsystem';

$conn=new mysqli($servername, $username, $password, $dbname);
if($conn){
    //echo "successfully connect";
}else{
    echo 'failed';
}
?>