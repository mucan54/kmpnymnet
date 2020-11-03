<?php 
session_start();
ob_start();
// sayfaya erişim yapan kişinin admin yetkisini kontrol ediyoruz
if(!isset($_SESSION["giris"]))
{
echo str_repeat("<br>", 8)."<center><img src=images/hata.gif border=0 />Bu sayfayı görüntülemek için giriş yapmalısınız.</center>";
header("Refresh: 2; url= index.php");
return;
}
include("baglanti.php");
$sorgula2 = mysql_query("SELECT * FROM uyeler WHERE kullanici_adi='".$_COOKIE["kullanici_adi"]."' and parola='".$_COOKIE["parola"]."'") or die (mysql_error());
$uyeler = mysql_fetch_array($sorgula2);  
$uid=$uyeler["id"];

$sorgula3 = mysql_query("SELECT * FROM urun WHERE id='".$_GET["urunid"]."'") or die (mysql_error());
$urun = mysql_fetch_array($sorgula3);  
$magazaid=$urun["storeid"];
$sorgula4 = mysql_query("SELECT * FROM magaza WHERE id='".$magazaid."'") or die (mysql_error());
$magaza = mysql_fetch_array($sorgula4); 

if($magaza["userid"]!=$uid&&!isset($_SESSION["yetki"]))
{
	echo str_repeat("<br>", 8)."<center><img src=images/hata.gif border=0 />Bu sayfayı görüntülemek için giriş yapmalısınız.</center>";
header("Refresh: 2; url= index.php");
return;
}
$id = $_GET["urunid"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title>Kontrol Paneli</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" />

</head>

<body>
<p>&nbsp;</p>
<p>&nbsp;</p>

<form name="guncelle" method="post" action="kampanya.php?urunid=<?php echo $_GET["urunid"]; ?>">
<table align="center" width="300" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td height="62"><img src="images/uye.png" width="32" height="32" /> <a href="urun.php?islem=duzenle&id=<?php echo $_GET["urunid"]; ?>">Geri</a></td>
    <td height="62" align="right">&nbsp;</td>
  </tr>
                      
   <tr>
    <td width="114">Açıklama:</td>
    <td width="179"><input type="text" name="desc" value=""  /></td>
  </tr>
   <tr>
    <td width="114">Fiyat:</td>
    <td width="179"><input type="text" name="cost" value=""  /></td>
  </tr>
    
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="button" value="Güncelle" /></td>
  </tr>
  <tr>

    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	    


<?php 

	 
error_reporting(0);

$change="";
$abc="";


 define ("MAX_SIZE","400");
 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

 $errors=0;
  
 if($_SERVER["REQUEST_METHOD"] == "POST")
 {


include("baglanti.php");
$id = $_GET["urunid"];
$desc = $_POST["desc"];	
$cost = $_POST["cost"];	

$guncelle2 = "INSERT INTO kampanya (acikla, newcost, urunid)values('".$desc."', '".$cost."', '".$id."')";
$guncelle = mysql_query($guncelle2);

	
	mysql_close();
ob_end_flush();	

	if($guncelle)
	{
	
	echo "<center><img src=images/ok.gif border=0 /> Bilgileriniz Güncellendi.</center>";

	header("Refresh: 2; url= kampanya.php?urunid=$id");

	}
	else
	{

	echo "<center><img src=images/hata.gif border=0 /> Bilgileriniz güncellenmedi!</center>";

	header("Refresh: 2; url= kampanya.php?urunid=$id");

	}
	
}


 


?>