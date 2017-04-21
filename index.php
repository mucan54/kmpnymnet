<?php
include("./2/baglanti.php");
$sqlt = mysql_query("SELECT * FROM urun");
$sqlt2 = mysql_query("SELECT * FROM kampanya");
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
		        <li class="menu" id="active"><a href="#">Sehir</a>
                        <ul>
                            <li><a href="index.php?il=12">Bingöl</a></li>
                            <li><a href="index.php?il=41">Kocaeli</a></li>
                            <li><a href="index.php?il=06">Ankara</a></li>
                            <li><a href="index.php">Türkiye Geneli</a></li>
             
                        </ul>
    </div>
</header>
    <div class="wrap">
        <div class="sidebar">
                <ul>
                    <li class="active"><a href="index.php">Ana Sayfa</a></li>
                    <li><a href="magazalar.php">Mağazalar</a></li>
                    <li><a href="uye-girisi.html">Uye Girişi</a></li>
                </ul>
            
        </div>
            <div class="content">
               
              <div class="clear"></div>
			<?php while($dondur = mysql_fetch_array($sqlt)) {
				 $il=0;
				if (empty($_GET)) {

                
				$sqlt2 = mysql_query("SELECT * FROM kampanya WHERE urunid='".$dondur['id']."'");
				$kmpny = mysql_fetch_array($sqlt2);  
				$sqlt3 = mysql_query("SELECT * FROM magaza WHERE id='".$dondur['storeid']."'");
				$mgz = mysql_fetch_array($sqlt3);  
			   }
			   else {
				   
				   $il = $_GET["il"];
				   $sqlt2 = mysql_query("SELECT * FROM kampanya WHERE urunid='".$dondur['id']."'");
				$kmpny = mysql_fetch_array($sqlt2);  
				$sqlt3 = mysql_query("SELECT * FROM magaza WHERE id='".$dondur['storeid']."' AND sehir='".$il."'");
				$mgz_varmi = mysql_num_rows($sqlt3);
                      if($mgz_varmi > 0)
					  {$mgz = mysql_fetch_array($sqlt3); } else { continue;}
			   }
				
				?>    
			            
                <div class="list2">
                <div class="preview"><a href="urun.php?id=<?php echo $dondur["id"]; ?>"><img src="2/images/smallurun_<?php echo $dondur['id']; ?>.jpg" height=128px width=180px alt="" /></a>
				<?php if($kmpny['newcost']!="") {?>
                <span> <?php echo $kmpny['newcost'];} ?></span></div>
                <div class="data">
                    <ul>
                        <span><a href="urun.php?id=<?php echo $dondur["id"]; ?>"><?php echo $dondur['name']; ?></a></span>
                        <li><h2>Fiyat : <?php echo $dondur['cost']; ?></h2></li>
                        <li><?php echo $dondur['description']; ?></li>
						<li><a href="magaza.php?id=<?php echo $mgz["id"]; ?>">Mağaza : <?php echo $mgz['isim']; ?></a></li>

                    </ul>
                </div>
				<div class="clear"></div>
            </div>
         
            <?php } ?>
               <div class="clear"></div>
            </div></div>
    <div class="clear"></div>
    <footer>
        <div class="wrap">
           
            </div>
   </footer>
</body>
</html>
