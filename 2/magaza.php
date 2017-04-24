<?php
session_start();
ob_start();
// sayfaya eri&#351;im yapan ki&#351;inin admin yetkisini kontrol ediyoruz
if(!isset($_SESSION["giris"]))
{
echo str_repeat("<br>", 8)."<center><img src=images/hata.gif border=0 />Bu sayfay&#305; g&#246;r&#252;nt&#252;lemek i&#231;in giri&#351; yapmal&#305;s&#305;n&#305;z.</center>";
header("Refresh: 2; url= index.php");
return;
}
$yetki="0";
if(isset($_SESSION["yetki"]))
{
$yetki="1";
$id2 = $_GET["id"];
}

$islem = $_GET["islem"];
$id = $_GET["id"];

include("baglanti.php");

//kullan&#305;c&#305; bilgileri al&#305;n&#305;yor
$sorgula2 = mysql_query("SELECT * FROM uyeler WHERE kullanici_adi='".$_COOKIE["kullanici_adi"]."' and parola='".$_COOKIE["parola"]."'") or die (mysql_error());
$uyeler = mysql_fetch_array($sorgula2);  
//ma&#287;aza bilgileri al&#305;n&#305;yor
$sorgula = mysql_query("SELECT * FROM magaza WHERE id IN (".$id.")") or die (mysql_error());
$magaza = mysql_fetch_array($sorgula);
if(isset($_SESSION["yetki"]))
{
	$uid=$magaza["userid"];
}
//d&#252;zenlenen ma&#287;azan&#305;n &#252;yeye ait olup olmad&#305;&#287;&#305;na bak&#305;l&#305;yor

/* if($uyeler['id'] != $magaza['userid']&&!isset($_SESSION["yetki"]))
{
	echo str_repeat("<br>", 8)."<center><img src=images/hata.gif border=0 />Bu sayfay&#305; g&#246;r&#252;nt&#252;lemek i&#231;in izniniz yok.</center>";
header("Refresh: 2; url= index.php");
return;
} */

//Ma&#287;aza ve ma&#287;azaya ait t&#252;m &#252;r&#252;nleri Sil
if($islem=="sil")
{
$magaza_sil = "DELETE FROM magaza WHERE id='$id'";
$sil_sonuc = mysql_query($magaza_sil);	

$urun_sil = "DELETE FROM urun WHERE storeid='$id'";
$sil_sonuc2 = mysql_query($urun_sil);	
echo str_repeat("<br>",8)."<center><img src=images/ok.gif border=0 /> Ma&#287;aza Silindi.</center>";
if($yetki!="1")
{
header("Refresh: 1; url= anasayfa.php");
}
else if($yetki=="1")
{
header("Refresh: 2; url= admin_islem.php?islem=duzenle&id=$uid");
}
return;
}

//Bilgileri G&#252;ncelle
else
{


$chc=$magaza['id'];
$sqlt = mysql_query("SELECT * FROM urun WHERE storeid='$chc'");
$mid=$magaza['id'];
$dosya = "images/smallmagaza_".$id.".jpg";


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

<form name="guncelle" method="post" id="guncelle">
<table align="center" width="300" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td height="62"><img src="images/uye.png" width="32" height="32" /> <a href="anasayfa.php">Geri</a></td>
    <td height="62" align="right">&nbsp;</td>
  </tr>
                      
  <tr>
    <td> Resim <a href="picdemo.php?islem=magaza&id=<?php echo $mid; ?>"target=_blank>Ekle/Sil</a>
	<?php
	if (file_exists($dosya)) {
    ?> <img src="images/smallmagaza_<?php echo $mid ?>.jpg"></td></tr><tr>
<?php } else{ ?><img src="images/nopic.png" height="70px" width="70px"></td></tr><tr> <?php } ?>
<td><div class="err" id="add_err"></div></td>
			  </tr>
	<tr>		  <td width="114">İşlem:</td>
				<td width="114"><?php echo $islem; ?></td>
	</tr><tr>
    <td width="114">Ma&#287;aza ad&#305;:</td>
    <td width="179"><input type="text" name="isim" value="<?php echo $magaza['isim']; ?>"  /></td>
  </tr>
   <tr>
    <td width="114">&#350;ehir:</td>
    <td width="179"><input type="text" name="sehir" value="<?php echo $magaza['sehir']; ?>"  /></td>
  </tr>
  
  <tr>
    <td width="114">Adres:</td>
    <td width="179"><input type="text" name="adres" value="<?php echo $magaza['adres']; ?>"  /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="button" value="G&#252;ncelle" /></td>
  </tr>
  <tr>

    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	    <td><b><u>Resmi</u></b></td>
    <td><b><u>&#220;r&#252;n Ad&#305;</u></b></td>
    <td><b><u>A&#231;&#305;klamas&#305;</u></b></td>
	    <td><b><u>Fiyat</u></b></td>
		    <td><b><u>Kampanyas&#305;</u></b></td>

  </tr>
    <?php $count=-1; while($dondur = mysql_fetch_array($sqlt))
  {    
		$kmpnychckid=$dondur['id'];
        $kmpny_kontrol = mysql_query("select * from kampanya where urunid='".$kmpnychckid."'") or die (mysql_error());

         $kmpny_varmi = mysql_num_rows($kmpny_kontrol);


	 $count++; 
?>
  </tr><tr>

		     <?php $picd=$dondur['id']; $yol="images/smallurun_".$picd.".jpg";; if (file_exists($yol)) {  ?>
	<td><img src="images/smallurun_<?php echo $dondur['id']; ?>.jpg" height=70px width=70px></td>
	 <?php } else { ?>
	 <td><img src="images/nopic.png" height="70px" width="70px"></td> <?php } ?>
    <td width="10"><?php echo $dondur['name']; ?></td>
    <td width="279"><?php echo $dondur['description']; ?></td>
	    <td width="79"><?php echo $dondur['cost']; ?></td>
		<?php if($kmpny_varmi > 0)
	{ ?> <td width="79"><img src="images/ok.gif" > </td><?php	} else {?><td width="79"> </td> <?php } ?>
    <td>                            </td>
    <td><a href="urun.php?islem=duzenle&id=<?php echo $dondur['id']; ?>">D&#252;zenle</a></td>
    <td><a href="urun.php?islem=sil&id=<?php echo $dondur['id']; ?>">Sil</a></td></tr>

    <?php 
	
	} ?> 
	<td><a href="urun_ekle.php?storeid=<?php echo $mid; ?>">&#220;r&#252;n Ekle</a></tr></td>
		

<?php 


	 
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	
$g_id = $_GET["id"];
$g_name = $_POST["isim"];
$g_sehir = $_POST["sehir"];	
$g_adres = $_POST["adres"];	

$guncelle = mysql_query("Update magaza Set isim='$g_name', sehir='$g_sehir', adres='$g_adres' Where id='$g_id'");

	if($guncelle)
	{
	
	echo "<center><img src=images/ok.gif border=0 /> Bilgileriniz G&#252;ncellendi.</center>";

	header("Refresh: 0; url= magaza.php?islem=duzenle&id=$g_id");

	}
	else
	{

	echo "<center><img src=images/hata.gif border=0 /> Bilgileriniz g&#252;ncellenmedi!</center>";

	header("Refresh: 2; url= magaza.php?islem=duzenle&id=$g_id");

	}
}

mysql_close();
ob_end_flush();	
}?>
