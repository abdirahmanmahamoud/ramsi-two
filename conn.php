<?php
$db = new mysqli('localhost','root','','rasmi');

if($db->connect_error){
    echo $db->error;
}else{
}   