<?php
session_start();
ob_start();
if(!isset($_SESSION["giris"]))
{
echo str_repeat("<br>", 8)."<center><img src=images/hata.gif border=0 />Bu sayfayı görüntülemek için giriş yapmalısınız.</center>";
header("Refresh: 2; url= index.php");
return;
}
$yetki="0";
if(isset($_SESSION["yetki"]))
{
$yetki="1";
$id2 = $_GET["id"];
}

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
<?php if($yetki=="1") { ?>
<form name="guncelle"  enctype="multipart/form-data" method="post" action="magaza_ekle.php?id=<?php echo $_GET["id"]; ?>"><?php } else {?>
<form name="guncelle"  enctype="multipart/form-data" method="post" action="magaza_ekle.php"> <?php } ?>
<table align="center" width="300" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td height="62"><img src="images/uye.png" width="32" height="32" /> <a href="AnaSayfa.php">Geri</a></td>
    <td height="62" align="right">&nbsp;</td>
  </tr>
                      
  <tr>
    <td> Resim  <input size="25" name="file" type="file" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10pt" class="box"/>
</td></tr>

    <td width="114">Mağaza adı:</td>
    <td width="179"><input type="text" name="isim" /></td>
  </tr>
   <tr>
    <td width="114">Şehir:</td>
    <td width="179"><input type="text" name="sehir" /></td>
  </tr>
  
  <tr>
    <td width="114">Adres:</td>
    <td width="179"><input type="text" name="adres" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Kaydet" /></td>
  </tr>
  <tr>

    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 

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
if($yetki=="0")
{
$sorgula2 = mysql_query("SELECT * FROM uyeler WHERE kullanici_adi='".$_COOKIE["kullanici_adi"]."' and parola='".$_COOKIE["parola"]."'") or die (mysql_error());
$uyeler = mysql_fetch_array($sorgula2);  
$id=$uyeler["id"];
}
else if($yetki=="1")
{
	$id=$id2;
}
$isim = $_POST["isim"];
$sehir = $_POST["sehir"];	
$adres = $_POST["adres"];	

$guncelle2 = "INSERT INTO magaza (isim, sehir, adres, userid)values('".$isim."', '".$sehir."', '".$adres."', '".$id."')";
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


	$_FILES['file']['name']="magaza_$bid.jpg";

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
	if($yetki!="1")
	{header("Refresh: 2; url= anasayfa.php");}
	else if($yetki=="1")
	{
	header("Refresh: 2; url= admin_islem.php?islem=duzenle&id=$id");
}

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