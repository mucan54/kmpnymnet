<?php


session_start();
ob_start();
// sayfaya eri&#351;im yapan ki&#351;inin admin yetkisini kontrol ediyoruz
if(!isset($_SESSION["yetki"]))
{
echo str_repeat("<br>", 8)."<center><img src=images/hata.gif border=0 /> Y&#246;netim Paneli sadece yetkili kullan&#305;c&#305;lara a&#231;&#305;kt&#305;r!</center>";
header("Refresh: 2; url= anasayfa.php");
return;
}

$islem = $_GET["islem"];
$id = $_GET["id"];

include("baglanti.php");

$sorgula = mysql_query("SELECT * FROM uyeler WHERE id='".$id."'") or die (mysql_error());
$uyeler = mysql_fetch_array($sorgula);

//&#220;ye Sil
if($islem=="sil")
{

$uye_sil = "DELETE FROM uyeler WHERE id='$id'";
$sil_sonuc = mysql_query($uye_sil);	
echo str_repeat("<br>",8)."<center><img src=images/ok.gif border=0 /> &#220;ye Silindi.</center>";
header("Refresh: 1; url= admin.php");
return;
}

//Bilgileri G&#252;ncelle
elseif($islem=="guncelle")
{

$g_id = $_GET["id"];
$g_kullanici_adi = $_POST["kullanici_adi"];
$g_parola = md5(md5($_POST["parola"]));
$g_eposta = $_POST["eposta"];
$g_yetki = $_POST["yetki"];
$g_button = $_POST["button"];


if($g_button){

if(!$_POST["parola"]=="")
{
$guncelle = mysql_query("Update uyeler Set kullanici_adi='$g_kullanici_adi', parola='$g_parola', eposta='$g_eposta', yetki='$g_yetki' Where id='$g_id'");
$_SESSION["parola"] = $g_parola;
setcookie("parola",$g_parola,time()+60*60*24);
}
else
{
$guncelle = mysql_query("Update uyeler Set kullanici_adi='$g_kullanici_adi', eposta='$g_eposta' , yetki='$g_yetki' Where id='$g_id'");
}
	if($guncelle)
	{
	
	echo str_repeat("<br>",8)."<center><img src=images/ok.gif border=0 /> &#220;ye Bilgileri G&#252;ncellendi.</center>";

	header("Refresh: 1; url= admin.php");
	return;
	}
	else
	{

	echo "<center><img src=images/hata.gif border=0 /> &#220;ye Bilgileri G&#252;ncellenmedi!</center>";

	header("Refresh: 2; url= admin.php");

	}

}
	
}
$sqlt = mysql_query("SELECT * FROM magaza WHERE userid='$id'");
$dosya = "images/smalluye_".$id.".jpg";

function plaka($num){
	
$iller =array("iller" => array("01" => "Adana",

"02" => "Ad&#305;yaman",

"03" => "Afyon",

"04" => "A&#287;r&#305;",

"05" => "Amasya",

"06" => "Ankara",

"07" => "Antalya",

"08" => "Artvin",

"09" => "Ayd&#305;n",

"10" => "Bal&#305;kesir",

"11" => "Bilecik",

"12" => "Bing&#246;l",

"13" => "Bitlis",

"14" => "Bolu",

"15" => "Burdur",

"16" => "Bursa",

"17" => "&#199;anakkale",

"18" => "&#199;ank&#305;r&#305;",

"19" => "&#199;orum",

"20" => "Denizli",

"21" => "Diyarbak&#305;r",

"22" => "Edirne",

"23" => "Elaz&#305;&#287;",

"24" => "Erzincan",

"25" => "Erzurum",

"26" => "Eski&#351;ehir",

"27" => "Gaziantep",

"28" => "Giresun",

"29" => "G&#252;m&#252;&#351;hane",

"30" => "Hakkari",

"31" => "Hatay",

"32" => "Isparta",

"33" => "&#304;&#231;el",

"34" => "&#304;stanbul",

"35" => "&#304;zmir",

"36" => "Kars",

"37" => "Kastamonu",

"38" => "Kayseri",

"39" => "K&#305;rklareli",

"40" => "K&#305;r&#351;ehir",

"41" => "Kocaeli",

"42" => "Konya",

"43" => "K&#252;tahya",

"44" => "Malatya",

"45" => "Manisa",

"46" => "K.mara&#351;",

"47" => "Mardin",

"48" => "Mu&#287;la",

"49" => "Mu&#351;",

"50" => "Nev&#351;ehir",

"51" => "Ni&#287;de",

"52" => "Ordu",

"53" => "Rize",

"54" => "Sakarya",

"55" => "Samsun",

"56" => "Siirt",

"57" => "Sinop",

"58" => "Sivas",

"59" => "Tekirda&#287;",

"60" => "Tokat",

"61" => "Trabzon",

"62" => "Tunceli",

"63" => "&#350;anl&#305;urfa",

"64" => "U&#351;ak",

"65" => "Van",

"66" => "Yozgat",

"67" => "Zonguldak",

"68" => "Aksaray",

"69" => "Bayburt",

"70" => "Karaman",

"71" => "K&#305;r&#305;kkale",

"72" => " Batman",

"73" => "&#350;&#305;rnak",

"74" => "Bart&#305;n",

"75" => "Ardahan",

"76" => "I&#287;d&#305;r",

"77" => "Yalova",

"78" => "Karab&#252;k",

"79" => "Kilis",

"80" => "Osmaniye",

"81" => "D&#252;zce",

"0" => "Undefined"
));
$iladi= $iller["iller"][$num];
return $iladi;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<title>&#220;ye Bilgi G&#252;ncelle</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<form name="guncelle" method="post" action="admin_islem.php?islem=guncelle&id=<?php echo $uyeler['id']; ?>">
<table align="center" width="300" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td height="62"><img src="images/uye.png" width="32" height="32" /> <a href="admin.php">Geri</a></td>
    <td height="62" align="right">&nbsp;</td>
  </tr>
  <tr>
  <td> Resim <a href="picdemo.php?islem=uye&id=<?php echo $id; ?>"target=_blank>Ekle/Sil</a>
	<?php
	if (file_exists($dosya)) {
    ?> <img src="images/smalluye_<?php echo $uyeler['id']; ?>.jpg"></td></tr><tr>
<?php } else{ ?><img src="images/nopic.png" height="70px" width="70px"></td></tr><tr> <?php } ?>
			  </tr>
			  
    <td width="114">Kullan&#305;c&#305; ad&#305;:</td>
    <td width="179"><input type="text" name="kullanici_adi" value="<?php echo $uyeler['kullanici_adi']; ?>" /></td>
  </tr>
  <tr>
    <td>&#350;ifre De&#287;i&#351;tir:</td>
    <td><input type="password" name="parola" value=""  /></td>
  </tr>
  <tr>
    <td>E-Posta:</td>
    <td><input type="text" name="eposta" value="<?php echo $uyeler['eposta']; ?>"  /></td>
  </tr>
    <tr>
    <td>Yetki:</td>
    <td><select name="yetki">
	<?php if($uyeler['yetki'] =="0")
	echo "<option value=\"0\" selected=\"selected\" style=\"background-color:#FF9;\">&#220;ye</option>
	<option value=\"1\">Admin</option>";
	elseif($uyeler['yetki'] =="1")
	echo "<option value=\"1\" selected=\"selected\" style=\"background-color:lightyellow;\">Admin</option>
	<option value=\"0\">&#220;ye</option>";
	?>

	</select></td>
  </tr>
  <tr>
    <td>&Uuml;yelik Tarihi:</td>
    <td>
	<?php echo $uyeler['tarih'];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="button" value="G&#252;ncelle" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	 <?php while($dondur = mysql_fetch_array($sqlt))
  {?>
<tr>
	     <?php 
		 	 $sqlt2 = mysql_query("SELECT COUNT(*) AS nums FROM urun WHERE storeid='".$dondur['id']."'");
	 $nums = mysql_fetch_array($sqlt2);
		 $picd=$dondur['id']; $yol="images/smallmagaza_".$picd.".jpg";; if (file_exists($yol)) {  ?>
	<td><img src="images/smallmagaza_<?php echo $dondur['id']; ?>.jpg" height=70px width=70px></td>
	 <?php } else { ?>
	 <td><img src="images/nopic.png" height="70px" width="70px"></td> <?php } ?>
    <td><?php echo $dondur['isim']; ?></td>
    <td><?php echo plaka($dondur['sehir']); ?></td>
    <td><?php echo $nums['nums']; ?></td>	
    <td>                            </td>
    <td><a href="magaza.php?islem=duzenle&id=<?php echo $dondur['id']; ?>">D&#252;zenle</a></td>
    <td><a href="magaza.php?islem=sil&id=<?php echo $dondur['id']; ?>">Sil</a></td>
  </tr>
    <?php } ?>
	<tr><td align="center"><a href="magaza_ekle.php?id=<?php echo $id; ?>">Ma&#287;aza Ekle</a></td></tr>
</table>
</form>
</body>
</html>
  </tr>
</table>
</form>
</body>
</html>

<?php 
mysql_close();
ob_end_flush();	
?>