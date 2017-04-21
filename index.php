<?php
session_start();
ob_start();
if(isset($_SESSION["giris"]))
{
header("Refresh: 0; url= anasayfa.php");
return;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<title>Giriş Sayfası</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
	<script type="text/javascript">
$(document).ready(function(){
	$("#add_err").css('display', 'none', 'important');
	 $("#button").click(function(){	
		  username=$("#kullanici_adi").val();
		  password=$("#parola").val();
		  $.ajax({
		   type: "POST",
		   url: "denetim.php",
		   data: "kullanici_adi="+username+"&parola="+password,
		   success: function(html){    
			if(html=='true')    {
			 window.location="anasayfa.php";
			}
			else    {
			$("#add_err").css('display', 'inline', 'important');
			 $("#add_err").html("Yanlış Kullanıcı adı ve şifre");
			}
		   },
		   beforeSend:function()
		   {
			$("#add_err").css('display', 'inline', 'important');
			$("#add_err").html("Giriş Başarılı")
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
<form name="giris_form" method="post" id="login">
<table width="300" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr>
    <td><div class="err" id="add_err"></div></td>
    <td class="giris_td"><img src="images/keys.gif" width="81" height="89" /></td>
  </tr>
  <tr>
    <td>Kullanıcı adı:</td>
    <td><input type="text" name="kullanici_adi" id="kullanici_adi" class="input"/></td>
  </tr>
  <tr>
    <td>Şifre:</td>
    <td><input type="password" name="parola" id="parola" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="gonder" value="Giriş Yap" class="gonder" id="button" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><a href="uyelik.php">&Uuml;ye Ol</a></td>
  </tr>
  </table>
</form>
</body>
</html>