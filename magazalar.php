<?php
include("./2/baglanti.php");

$sqlt = mysql_query("SELECT * FROM magaza");
$sqlt2 = mysql_query("SELECT * FROM kampanya");


?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Kampanyam.com</title>
<link href="web/css/style.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<header>
    <div class="wrap">
        <div class="logo"><a href="index.html"><img src="web/images/logo.png" alt="" /></a>
		
		</div>
        
     
        <div class="clear"></div>
		   <li class="menu" id="active"><a href="#">Sehir</a>
                        <ul>
                            <li><a href="magazalar.php?il=12">Bingöl</a></li>
                            <li><a href="magazalar.php?il=41">Kocaeli</a></li>
                            <li><a href="magazalar.php?il=06">Ankara</a></li>
							                    
                            <li><a href="magazalar.php">Türkiye Geneli</a></li>
             
                        </ul>
    </div>
</header>
<div class="wrap">
    <div class="sidebar">
            <ul>
                <li><a href="index.php">Ana Sayfa</a></li>
                <li  class="active"><a href="wallpapers.html">Mağazalar</a></li>
                <li><a href="uye-girisi.html">Üye Girişi</a></li>
 
            </ul>
    
    </div>
        <div class="content">
			
            <div class="clear"></div>
			
			<?php while($dondur = mysql_fetch_array($sqlt)) {			
			if (empty($_GET)) {

								}
			else {
				   
					  $il = $_GET["il"];
				  
                      if($dondur["sehir"]==$il)
					  {} else { continue;}
			     }			
				?>    
            <div class="grid">
                <div class="preview">
                <a href="magaza.php?id=<?php echo $dondur['id']; ?>"><img src="2/images/smallmagaza_<?php echo $dondur['id']; ?>.jpg" alt="" /></a></div>
                <div class="data"><a href="magaza.php?id=<?php echo $dondur['id']; ?>"><?php echo $dondur['isim']; ?></a></div>
                <div class="love">
                <div class="rating" style="width:68%;"></div>
                </div>    
                    <div class="buble"><a href="magaza.php?id=<?php echo $dondur['id']; ?>">Detay..</a></div>
                <div class="clear"></div>
                </div>
			<?php } ?>
            
               
        </div>
        <div class="sidebar-right">
               
    </div>
    <div class="clear"></div>
    <footer>
        
   </footer>
</body>
</html>

