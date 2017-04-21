<?php
session_start();
ob_start();

if(!$_GET["id"])
{
	header("Refresh: 0; url= magazalar.php");
return;
}

include("./2/baglanti.php");

$sqlmagaza = mysql_query("SELECT * FROM magaza WHERE id=".$_GET["id"]."");
$magaza = mysql_fetch_array($sqlmagaza);

$sqlurun = mysql_query("SELECT * FROM urun WHERE storeid=".$_GET["id"]."");
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
<!DOCTYPE HTML>
<html>
<head>	
<meta charset="utf-8">
<title>Kampanyam.Com</title>
<link href="web/css/style.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<header>
    <div class="wrap">
        <div class="logo"><a href="index.html"><img src="web/images/logo.png" alt="" /></a></div>
        
        <div class="clear"></div>
    </div>
</header>
    <div class="wrap">
        <div class="sidebar">
                <ul>
                    <li class="active"><a href="index.php">Ana Sayfa</a></li>
                    <li><a href="magazalar.php">Mağazalar</a></li>
                    <li><a href="uye-girisi.html">Uye Girisi</a></li>

                </ul>
            
        </div>
            <div class="content">
                
            
             <div class="clear"></div>
 
			            
               
                <div class="preview"><a href="songs.html"><img src="2/images/magaza_<?php echo $_GET["id"]; ?>.jpg" alt="" /></a>
				</div>
                <div class="data">
                    <ul>
					<div class="song-grid">
                        <div class="preview">
                        </div>
                        <div class="data">
                            <h3><?php echo $magaza['isim']; ?></h3>
                            <span>Adres : <?php echo $magaza['adres']; ?>     <?php echo plaka($magaza['sehir']); ?></span>
                       </div>
                <div class="clear"></div>
                </div>
                        
                    </ul>
                </div><div class="clear"></div>
				   <h3>ÜRÜNLER</h3>
				<div class="clear"></div>
         <?php while($urun = mysql_fetch_array($sqlurun)) { ?>
         <div class="ring-grid">
                <div class="preview">
                <a href="urun.php?id=<?php echo $urun['id']; ?>"><img src="2/images/urun_<?php echo $urun["id"]; ?>.jpg" width=50px height=50px alt=""></a></div>
                <div class="data"><a href="urun.php?id=<?php echo $urun['id']; ?>"><?php echo $urun['name']; ?></a></div>
                <div class="tags">
                        <ul>
                            <li><a href="urun.php?id=<?php echo $urun['id']; ?>">Fiyat:<?php echo $urun['cost']; ?></a></li>
                            
                        </ul>
                    </div>
                <div class="clear"></div>
		 </div> <?php } ?>
          
               <div class="clear"></div>
            </div></div>
    <div class="clear"></div>
    <footer>
        <div class="wrap">
            <div class="copy"><p>&copy;2012 All Rights Reserved | Designed by - <a href="http://w3layouts.com">W3layouts.com</a></p></div>
           
            </div>
   </footer>
</body>
</html>
<?php

mysql_close();
ob_end_flush();	
?>