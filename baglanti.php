<?php

$sunucu = "mysql7.000webhost.com"; //sunucu
$kullanici = "a5524595_usr"; //veritabani kullanici adi
$parola = "123123qwe"; // veritabani sifresi
$veritabani = "a5524595_db";// veritabani ismi 
$baglanti = mysql_connect($sunucu, $kullanici, $parola); 

if(!$baglanti) die("MySQL sunucusuna baglanti saglanamadi!"); 

mysql_select_db($veritabani, $baglanti) or die ("Veritabanina baglanti saglanamadi!");
?>