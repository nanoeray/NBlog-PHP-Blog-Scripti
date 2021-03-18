<?php
ob_start();
session_start();
define("guvenlik", true);
//error_reporting(0);
if(file_exists(".krlm"))
{
	include("sayfalar/kurulum.php");
}
else {
	$go = @$_GET['sayfa'];
	include("ayarlar/veritabani.php");
	switch ($go){
		default:
		include("sayfalar/anasayfa.php");
		break;
		
		case "kategori":
		include("sayfalar/kategorile.php");
		break;
		
		case "projelerim":
		include("sayfalar/projeler.php");
		break;
		
		case "hakkimizda":
		include("sayfalar/hakkimda.php");
		break;
		
		case "market":
		include("sayfalar/urunler.php");
		break;
		
		case "blog":
		include("sayfalar/blog.php");
		break;
		
		case "uye":
		include("sayfalar/uye.php");
		break;
		
		case "uyeol":
		include("sayfalar/uye_ol.php");
		break;
		
		case "profil":
		include("sayfalar/profil.php");
		break;
		
		case "uye-om":
		include("sayfalar/uye-om.php");
		break;
		
		case "destek":
		include("sayfalar/destek.php");
		break;
		
	}

	include("includes/footer.php");
}
?>