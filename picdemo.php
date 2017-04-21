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

$islem = $_GET["islem"];
$id = $_GET["id"];

include("baglanti.php");

//kullanıcı bilgileri alınıyor
$sorgula2 = mysql_query("SELECT * FROM uyeler WHERE kullanici_adi='".$_COOKIE["kullanici_adi"]."' and parola='".$_COOKIE["parola"]."'") or die (mysql_error());
$uyeler = mysql_fetch_array($sorgula2);  
//mağaza bilgileri alınıyor

if($islem=="magaza")
{
$sorgula = mysql_query("SELECT * FROM magaza WHERE id='".$id."'") or die (mysql_error());
$magaza = mysql_fetch_array($sorgula);
//düzenlenen mağazanın üyeye ait olup olmadığına bakılıyor
if($uyeler['id'] != $magaza['userid']&&!isset($_SESSION["yetki"]))  //üyenin mağazanın resmini değiştirme yetkisi var mı diye kontrol ediliyor.
{
	echo str_repeat("<br>", 8)."<center><img src=images/hata.gif border=0 />Bu sayfayı görüntülemek için izniniz yok.</center>";
header("Refresh: 2; url= index.php");
return;
}
}

else if($islem=="urun")
{
$sorgula3 = mysql_query("SELECT * FROM urun WHERE id='".$id."'") or die (mysql_error());
$urun = mysql_fetch_array($sorgula3);
$sorgula4 = mysql_query("SELECT * FROM magaza WHERE id='".$urun['storeid']."'") or die (mysql_error());
$magaza = mysql_fetch_array($sorgula4);

if($uyeler['id'] != $magaza['userid'])     //üyenin ürünü değiştirmeye yetkisi var mı kontrol ediliyor.
{
	echo str_repeat("<br>", 8)."<center><img src=images/hata.gif border=0 />Bu sayfayı görüntülemek için izniniz yok.</center>";
header("Refresh: 2; url= index.php");
return;
}

}

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

if($islem=="magaza")
{
	$_FILES['file']['name']="magaza_$id.jpg";
}
else if($islem=="urun")
{
	$_FILES['file']['name']="urun_$id.jpg";
}
else if($islem=="uye")
{
	$_FILES['file']['name']="uye_$id.jpg";
}
else{
	return;
}

$filename = "images/". $_FILES['file']['name'];

$filename1 = "images/small". $_FILES['file']['name'];



imagejpeg($tmp,$filename,100);

imagejpeg($tmp1,$filename1,100);

imagedestroy($src);
imagedestroy($tmp);
imagedestroy($tmp1);
}}

}

//If no errors registred, print the success message
 if(isset($_POST['Submit']) && !$errors) 
 {
 
   // mysql_query("update {$prefix}users set img='$big',img_small='$small' where user_id='$user'");
 	$change=' <div class="msgdiv">Image Uploaded Successfully!</div>';
	header("Refresh: 0; url= picdemo.php?islem=$islem&id=$id");
	if($islem==uye)
	{
		header("Refresh: 0; url= anasayfa.php");
	}
	if($islem!="uye")
	{header("Refresh: 0; url= $islem.php?islem=duzenle&id=$id");}
	else {header("Refresh: 0; url= anasayfa.php");}
 }
 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en"><head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
<meta content="en-us" http-equiv="Content-Language">
<?php
if($islem=="magaza")
{
	$filename="images/magaza_$id.jpg";
	$filename1="images/smallmagaza_$id.jpg";
}
else if($islem=="urun")
{
	$filename="images/urun_$id.jpg";
	$filename1="images/smallurun_$id.jpg";
}
else if($islem=="uye")
{
	$filename="images/uye_$id.jpg";
	$filename1="images/smalluye_$id.jpg";
}

?>
    <title>picture demo</title>
    
   <link href=".css" media="screen, projection" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery_002.js"></script>
<script type="text/javascript" src="js/displaymsg.js"></script>
<script type="text/javascript" src="js/ajaxdelete.js"></script>
    
	 
  <style type="text/css">
  .help
{
font-size:11px; color:#006600;
}
body {
     color: #000000;
 background-color:#999999 ;
    background:#999999 url(<?php echo $user_row['img_src']; ?>) fixed repeat top left;
	
	
	font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif; 
	
	}
		.msgdiv{
	width:759px;
padding-top:8px;
padding-bottom:8px;
background-color: #fff;
font-weight:bold;
font-size:18px;-moz-border-radius: 6px;-webkit-border-radius: 6px;
}
#container{width:763px;margin:0 auto;padding:3px 0;text-align:left;position:relative; -moz-border-radius: 6px;-webkit-border-radius: 6px; background-color:#FFFFFF }
</style>

  </head><body>
     <div align="center" id="err">
<?php echo $change; ?>  </div>
   <div id="space"></div>
   
 
  
  
  
  <div id="container" >
    
   <div id="con">
   
      
      
        <table width="502" cellpadding="0" cellspacing="0" id="main">
          <tbody>
            <tr>
              <td width="500" height="238" valign="top" id="main_right">
			 
			  <div id="posts">
			  &nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $filename; ?>" />  &nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $filename1; ?>"  />
			    <form method="post" action="" enctype="multipart/form-data" name="form1">
				<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr><Td style="height:25px">&nbsp;</Td></tr>
		<tr>
          <td width="150"><div align="right" class="titles">Picture 
            : </div></td>
          <td width="350" align="left">
            <div align="left">
              <input size="25" name="file" type="file" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10pt" class="box"/>
			  
              </div></td>
			  
        </tr>
		<tr><Td></Td>
		<Td valign="top" height="35px" class="help">Image maximum size <b>400 </b>kb</span></Td>
		</tr>
		<tr><Td></Td><Td valign="top" height="35px"><input type="submit" id="mybut" value="       Upload        " name="Submit"/></Td></tr>
        <tr>
          <td width="200">&nbsp;</td>
          <td width="200"><table width="200" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="200" align="center"><div align="left"></div></td>
                <td width="100">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
      </table>
				</form>
 
  
			  
			  
			  </div>
			  
			  
			  
			  
			  </td>
            
            </tr>
          </tbody>
     </table>
      

      
    
</div>
       
  </div>
  

    
</body></html>
