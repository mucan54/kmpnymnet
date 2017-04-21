<?php

session_start();
ob_start();

if(!isset($_SESSION["giris"]))
{
echo str_repeat("<br>", 8)."<center><img src=images/hata.gif border=0 />Bu sayfay&#305; g&#246;r&#252;nt&#252;lemek i&#231;in giri&#351; yapmal&#305;s&#305;n&#305;z.</center>";
header("Refresh: 2; url= index.php");
return;
}
include("baglanti.php");

$sorgula = mysql_query("SELECT * FROM uyeler WHERE kullanici_adi='".$_COOKIE["kullanici_adi"]."' and parola='".$_COOKIE["parola"]."'") or die (mysql_error());

$uyeler = mysql_fetch_array($sorgula);

// giri&#351; yapan &#252;ye admin yetkisine sahip ise y&#246;netim paneline y&#246;nlendiriyoruz
if($uyeler['yetki']=="1")
{
$_SESSION["yetki"]="true";	
echo str_repeat("<br>", 8)."<center><img src=images/yukleniyor.gif border=0 /> Admin Paneline y&#246;ndiriliyorsunuz, l&#252;tfen bekleyiniz..</center>";	
header("Refresh: 2; url= admin.php");
return;
}
$chc=$uyeler['id'];
$sqlt = mysql_query("SELECT * FROM magaza WHERE userid='$chc'");
$dosya = "images/smalluye_".$chc.".jpg";

function plaka($num){
	
$iller =array("iller" => array("1" => "Adana",

"2" => "Ad&#305;yaman",

"3" => "Afyon",

"4" => "A&#287;r&#305;",

"5" => "Amasya",

"6" => "Ankara",

"7" => "Antalya",

"8" => "Artvin",

"9" => "Ayd&#305;n",

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
<title>Kontrol Paneli</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
	<script type="text/javascript">
$(document).ready(function(){
	$("#add_err").css('display', 'none', 'important');
	 $("#out").click(function(){	
		  $.ajax({
		   type: "POST",
		   url: "cikis.php",
		   success: function(){
			 window.location="index.php";
			},
		   
		  });
		return false;
	});
	
		 $("#button").click(function(){	
		 var data = $("#guncelle").serialize();
		  $.ajax({
			  
		   type: "POST",
		   url: "anasayfa.php?id=<?php echo $uyeler['id']; ?>",
		   data: data,
		   success: function(){
			 $("#add_err").css('display', 'none', 'important');
			},
		   beforeSend:function()
		   {
			$("#add_err").css('display', 'inline', 'important');
			$("#add_err").html("Güncelleme Başarılı")
		   }
		  });
		return false;
	});
});
	</script>
</head>

<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<form name="guncelle" id="guncelle" method="post">
<table align="center" width="300" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td height="62"><div id="out"><img src="images/uye.png" width="32" height="32" /><a href=#> &#199;&#305;k&#305;&#351;</div></a></td>
    <td height="62" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td> Resim <a href="picdemo.php?islem=uye&id=<?php echo $chc; ?>"target=_blank>Ekle/Sil</a>
	<?php
	if (file_exists($dosya)) {
    ?> <img src="images/smalluye_<?php echo $uyeler['id']; ?>.jpg"></td></tr><tr>
<?php } else{ ?><img src="images/nopic.png" height="70px" width="70px"></td></tr><tr> <?php } ?>
<td><div class="err" id="add_err"></div></td>
			  </tr>
			  
  <tr>
    <td width="114">Kullan&#305;c&#305; ad&#305;:</td>
    <td width="179"><?php echo $uyeler['kullanici_adi']; ?></td>
  </tr>
   <tr>
    <td width="114">&#304;sim:</td>
    <td width="179"><input type="text" name="name" value="<?php echo $uyeler['name']; ?>"  /></td>
  </tr>
   <tr>
    <td width="114">Soy &#304;sim:</td>
    <td width="179"><input type="text" name="surname" value="<?php echo $uyeler['surname']; ?>"  /></td>
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
    <td>&Uuml;yelik Tarihi:</td>
    <td>
	<?php echo $uyeler['tarih'];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="button" value="G&#252;ncelle" id="button"/></td>
  </tr>
  <tr>

    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	    <td><b><u>Resim</u></b></td>
    <td><b><u>Ma&#287;aza Ad&#305;</u></b></td>
    <td><b><u>&#350;ehir</u></b></td>
	    <td><b><u>&#220;r&#252;nler</u></b></td>
		  

  </tr>
    <?php while($dondur = mysql_fetch_array($sqlt))
  {?>
<tr>
      
     <?php 
	 $sqlt2 = mysql_query("SELECT COUNT(*) AS nums FROM urun WHERE storeid='".$dondur['id']."'");
	 $nums = mysql_fetch_array($sqlt2);
	 
	 $picd=$dondur['id']; $yol="images/smallmagaza_".$picd.".jpg";; if (file_exists($yol)) { ?>
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
	<tr><td align="center"><a href="magaza_ekle.php">Ma&#287;aza Ekle</a></td></tr>
</table>
</form>
</body>
</html>
<?php 


if($_SERVER['REQUEST_METHOD'] == "POST")
{
	
$g_id = $_GET["id"];
$g_parola = md5(md5($_POST["parola"]));
$g_eposta = $_POST["eposta"];	
$g_name = $_POST["name"];	
$g_surname = $_POST["surname"];	
	

if(!$_POST["parola"]=="")
{
$guncelle = mysql_query("Update uyeler Set parola='$g_parola', name='$g_name', surname='$g_surname', eposta='$g_eposta' Where id='$g_id'");
$_SESSION["parola"] = $g_parola;
setcookie("parola",$g_parola,time()+60*60*24);
}
else
{
$guncelle = mysql_query("Update uyeler Set eposta='$g_eposta', name='$g_name', surname='$g_surname' Where id='$g_id'");
}
	if($guncelle)
	{
	
	echo "<center><img src=images/ok.gif border=0 /> Bilgileriniz G&#252;ncellendi.</center>";

	header("Refresh: 1; url= anasayfa.php");

	}
	else
	{

	echo "<center><img src=images/hata.gif border=0 /> Bilgileriniz g&#252;ncellenmedi!</center>";

	header("Refresh: 2; url= anasayfa.php");

	}

}
mysql_close();
ob_end_flush();	
?>