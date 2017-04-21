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

$sorgula3 = mysql_query("SELECT * FROM magaza WHERE id='".$_GET["storeid"]."'") or die (mysql_error());
$magaza = mysql_fetch_array($sorgula3);  

if($magaza["userid"]!=$uid&&!isset($_SESSION["yetki"]))
{
	echo str_repeat("<br>", 8)."<center><img src=images/hata.gif border=0 />Bu sayfayı görüntülemek için giriş yapmalısınız.</center>";
header("Refresh: 2; url= index.php");
return;
}
$id = $_GET["storeid"];
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

<form name="guncelle" method="post"  enctype="multipart/form-data" action="urun_ekle.php?storeid=<?php echo $_GET["storeid"]; ?>">
<table align="center" width="300" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td height="62"><img src="images/uye.png" width="32" height="32" /> <a href="magaza.php?islem=duzenle&id=<?php echo $_GET["storeid"]; ?>">Geri</a></td>
    <td height="62" align="right">&nbsp;</td>
  </tr>
                      
  <tr>
<td> Resim  <input size="25" name="file" type="file" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10pt" class="box"/>
</td></tr>
    <td width="114">Ürün adı:</td>
    <td width="179"><input type="text" name="isim" value=""  /></td>
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
$id = $_GET["storeid"];
$isim = $_POST["isim"];
$desc = $_POST["desc"];	
$cost = $_POST["cost"];	

$guncelle2 = "INSERT INTO urun (name, description, cost, storeid)values('".$isim."', '".$desc."', '".$cost."', '".$id."')";
$guncelle = mysql_query($guncelle2);

$bid=mysql_insert_id();

	
	
	
	mysql_close();
ob_end_flush();	

 	$image =$_FILES["file"]["name"];
	$uploadedfile = $_FILES['file']['tmp_name'];
     
 
 	if ($image) 
 	{
 	
 		$filename = stripslashes($_FILES['file']['name']);
 	
  		$extension = getExtension($filename);
 		$extension = strtolower($extension);
		
		
 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
 		{
		
 			$change='<div class="msgdiv">Unknown Image extension </div> ';
 			$errors=1;
 		}
 		else
 		{

 $size=filesize($_FILES['file']['tmp_name']);


if ($size > MAX_SIZE*1024)
{
	$change='<div class="msgdiv">You have exceeded the size limit!</div> ';
	$errors=1;
}


if($extension=="jpg" || $extension=="jpeg" )
{
$uploadedfile = $_FILES['file']['tmp_name'];
$src = imagecreatefromjpeg($uploadedfile);

}
else if($extension=="png")
{
$uploadedfile = $_FILES['file']['tmp_name'];
$src = imagecreatefrompng($uploadedfile);

}
else 
{
$src = imagecreatefromgif($uploadedfile);
}

echo $scr;

list($width,$height)=getimagesize($uploadedfile);

$newwidth=640;
$newheight=480;
$tmp=imagecreatetruecolor($newwidth,$newheight);


$newwidth1=150;
$newheight1=100;
$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);


	$_FILES['file']['name']="urun_$bid.jpg";

$filename = "images/". $_FILES['file']['name'];

$filename1 = "images/small". $_FILES['file']['name'];




imagejpeg($tmp,$filename,100);

imagejpeg($tmp1,$filename1,100);

imagedestroy($src);
imagedestroy($tmp);
imagedestroy($tmp1);
}}
	if($guncelle)
	{
	
	echo "<center><img src=images/ok.gif border=0 /> Bilgileriniz Güncellendi.</center>";

	header("Refresh: 2; url= magaza.php?islem=duzenle&id=$id");

	}
	else
	{

	echo "<center><img src=images/hata.gif border=0 /> Bilgileriniz güncellenmedi!</center>";

	header("Refresh: 2; url= magaza_ekle.php");

	}
	
}

//If no errors registred, print the success message
 if(isset($_POST['Submit']) && !$errors) 
 {
 
   // mysql_query("update {$prefix}users set img='$big',img_small='$small' where user_id='$user'");
 	$change=' <div class="msgdiv">Image Uploaded Successfully!</div>';
 }
 


?>