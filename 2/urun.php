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
//hata vermemesi i&#231;in i&#351;lem sat&#305;r&#305; bo&#351;sa

$islem = $_GET["islem"];
$id = $_GET["id"];

include("baglanti.php");

//kullan&#305;c&#305; bilgileri al&#305;n&#305;yor
$sorgula2 = mysql_query("SELECT * FROM uyeler WHERE kullanici_adi='".$_COOKIE["kullanici_adi"]."' and parola='".$_COOKIE["parola"]."'") or die (mysql_error());
$uyeler = mysql_fetch_array($sorgula2);  
$asd=$uyeler['id'];

$sorgula3 = mysql_query("SELECT * FROM urun WHERE id='".$id."'") or die (mysql_error());
$urun = mysql_fetch_array($sorgula3);
$dsa=$urun['storeid'];

//ma&#287;aza bilgileri al&#305;n&#305;yor
$sorgula = mysql_query("SELECT * FROM magaza WHERE id='".$dsa."'") or die (mysql_error());
$magaza = mysql_fetch_array($sorgula);

//d&#252;zenlenen ma&#287;azan&#305;n &#252;yeye ait olup olmad&#305;&#287;&#305;na bak&#305;l&#305;yor
if($magaza['userid'] != $asd&&!isset($_SESSION["yetki"]))
{
	echo str_repeat("<br>", 8)."<center><img src=images/hata.gif border=0 />Bu sayfay&#305; g&#246;r&#252;nt&#252;lemek i&#231;in izniniz yok.</center>";
header("Refresh: 2; url= index.php");
return;
}

//Ma&#287;aza ve ma&#287;azaya ait t&#252;m &#252;r&#252;nleri Sil
if($islem=="sil")
{

$urun_sil = "DELETE FROM urun WHERE id='$id'";
$sil_sonuc = mysql_query($urun_sil);	

$kampanya_sil = "DELETE FROM kampanya WHERE urunid='$id'";
$sil_sonuc2 = mysql_query($kampanya_sil);	

echo str_repeat("<br>",8)."<center><img src=images/ok.gif border=0 /> &#220;r&#252;n Silindi.</center>";
header("Refresh: 1; url= magaza.php?islem=duzenle&id=$dsa");
return;
}

//Bilgileri G&#252;ncelle
else
{


$chc=$magaza['id'];
$sqlt = mysql_query("SELECT * FROM urun WHERE storeid='$chc'");
$mid=$magaza['id'];
$dosya = "images/smallurun_".$id.".jpg";

$sqlt2 = mysql_query("SELECT * FROM kampanya WHERE urunid='$id'");
$kim=mysql_fetch_array($sqlt2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title>Kontrol Paneli</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$('#aktif').change(function(){
   $("#newcost").prop("disabled", !$(this).is(':checked'));
   $("#descs").prop("disabled", !$(this).is(':checked'));
});
</script>
</head>
<p>&nbsp;</p>
<p>&nbsp;</p>
<body>
<form name="guncelle" method="post" action="urun.php?islem=duzenle&id=<?php echo $urun['id']; ?>">
<table align="center" width="300" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td height="62"><img src="images/uye.png" width="32" height="32" /> <a href="magaza.php?islem=duzenle&id=<?php echo $mid; ?>">Geri</a></td>
    <td height="62" align="right">&nbsp;</td>
  </tr>
                      
  <tr>
    <td> Resim <a href="picdemo.php?islem=urun&id=<?php echo $urun['id']; ?>"target=_blank>Ekle/Sil</a>
	  <?php $picd=$urun['id']; $yol="images/smallurun_".$picd.".jpg";; if (file_exists($yol)) { ?></td>
	<td><img src="images/smallurun_<?php echo $picd; ?>.jpg"></td>
	 <?php } else { ?>
	 <td><img src="images/nopic.png" height="70px" width="70px"></td> <?php } ?>
	 </tr>
    <td width="114">&#220;r&#252;n ad&#305;:</td>
    <td width="179"><input type="text" name="isim" value="<?php echo $urun['name']; ?>"  /></td>
   <tr>
    <td width="114">A&#231;&#305;klama:</td>
    <td width="179"><input type="text" name="desc" value="<?php echo $urun['description']; ?>"  /></td>
  </tr>
   <tr>
    <td width="114">Fiyat:</td>
    <td width="179"><input type="text" name="cost" value="<?php echo $urun['cost']; ?>"  /></td>
  </tr>
     
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="button" value="G&#252;ncelle" /></td>
  </tr>
  <tr>

    <td>&nbsp;</td>
    <td>&nbsp;</td>
 </tr>
  <?php 
  $kmpny_kontrol = mysql_query("select * from kampanya where urunid='".$id."'") or die (mysql_error());

$kmpny_varmi = mysql_num_rows($kmpny_kontrol);
if($kmpny_varmi > 0)
{ ?> <td>Kampanya Aktif<input type="checkbox" class="check" id="aktif" name="aktif" checked></td> <?php } else {
?> <td>Kampanya Aktif<input type="checkbox" class="check" id="aktif" name="aktif"></td> <?php } ?>
  </body><body>

  <tr>
	    <td><b><u>&#304;ndirim</u></b></td>
			    <td><b><u>Kampanya A&#231;&#305;klamas&#305;</u></b></td>
					    

  </tr>



    <td width="179"><input type="text" id="newcost" name="newcost" value="<?php echo $kim['newcost']; ?>"  /></td>
    <td width="179"><input type="text" id="descs" name="descs" value="<?php echo $kim['acikla']; ?>"  /></td>
                            
</table></form> 
</body>
<?php 


	 
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	
$g_id = $_GET["id"];
$g_name = $_POST["isim"];
$g_desc = $_POST["desc"];	
$g_cost = $_POST["cost"];

$g_newcost = $_POST["newcost"];	
$g_descs = $_POST["descs"];

$yenikayitt = "Update kampanya Set newcost='$g_newcost', acikla='$g_descs'  Where urunid='$g_id'";
//$yenikayitt = "INSERT INTO kampanya (newcost, acikla, urunid)values('$g_newcost', '$g_descs', '$g_id')";

$sorguu = mysql_query($yenikayitt);

if(isset($_POST['aktif'])) { // checkbox seçilmişse "on" değeri gönderiliyor
    $kmpny_kontrol = mysql_query("select * from kampanya where urunid='".$id."'") or die (mysql_error());

$kmpny_varmi = mysql_num_rows($kmpny_kontrol);
if($kmpny_varmi > 0)
	{	
	$yenikayitt = "Update kampanya Set newcost='$g_newcost', acikla='$g_descs'  Where urunid='$g_id'"; 
	$sorguu = mysql_query($yenikayitt);
	}
else {
	$yenikayitt = "INSERT INTO kampanya (newcost, acikla, urunid)values('$g_newcost', '$g_descs', '$g_id')";

	$sorguu = mysql_query($yenikayitt);
	}
} else { // seçilmemişse bu değer sayfaya hiç gönderilmiyor
    $kmpny_sil = "DELETE FROM kampanya WHERE urunid='$id'";
    $sil_sonuc = mysql_query($kmpny_sil);	
}


$guncelle = mysql_query("Update urun Set name='$g_name', description='$g_desc', cost='$g_cost' Where id='$g_id'");

	if($guncelle)
	{
	
	echo "<center><img src=images/ok.gif border=0 /> Bilgileriniz G&#252;ncellendi.</center>";

	header("Refresh: 0; url= urun.php?islem=duzenle&id=$g_id");

	}
	else
	{

	echo "<center><img src=images/hata.gif border=0 /> Bilgileriniz g&#252;ncellenmedi!</center>";

	header("Refresh: 2; url= urun.php?islem=duzenle&id=$g_id");

	}
}

mysql_close();
ob_end_flush();	
}?>