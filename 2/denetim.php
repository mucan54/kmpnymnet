<?php


session_start();
ob_start();

include("baglanti.php");

$kullanici_adi = $_POST["kullanici_adi"];
$parola = $_POST["parola"];

//$kullanici_adi = htmlentities(mysql_real_escape_string($_POST["kullanici_adi"]));
//$parola = md5(md5(htmlentities(mysql_real_escape_string($_POST["parola"]))));

$sorgula = mysql_query("SELECT * FROM uyeler WHERE kullanici_adi='{$kullanici_adi}' and parola='{$parola}'") or die (mysql_error());
//$sorgula = mysql_query("SELECT * FROM uyeler WHERE kullanici_adi='$kullanici_adi' and parola='$parola'") or die (mysql_error());
$uye_varmi = mysql_num_rows($sorgula);
if($uye_varmi > 0)
{
$_SESSION["giris"] = "true";
$_SESSION["kullanici_adi"] = $kullanici_adi;
$_SESSION["parola"] = $parola;

setcookie("kullanici_adi",$kullanici_adi,time()+60*60*24);
setcookie("parola",$parola,time()+60*60*24);

echo "true";
//echo str_repeat("<br>", 8)."<center><img src=images/yukleniyor.gif border=0 /> Giriþ baþarýlý, lütfen bekleyiniz..</center>";
//header("Refresh: 2; url=anasayfa.php");
}

else
{
		
echo str_repeat("<br>", 8)."<center><img src=images/hata.gif border=0 /> Kullanýcý adý veya parola hatalý!</center>";
header("Refresh: 2; url=index.php");
	
}
mysql_close();
ob_end_flush();
?>
