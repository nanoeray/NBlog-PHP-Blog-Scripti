<?php
include("inc/fonksiyonlar.php");
if(isset($_SESSION['admin']))
{
	include("inc/menu.php");
	$go = @$_GET['admin'];
	define("guvenlik", true);
	switch ($go){
		case "":
		include("sayfalar/anasayfa.php");
		break;
		
		case "blogs":
		include("sayfalar/blogs.php");
		break;
		
		case "projeler":
		include("sayfalar/proje.php");
		break;
		
		case "slider":
		include("sayfalar/d_index.php");
		break;
		
		case "iletisim":
		include("sayfalar/iletisim.php");
		break;
		
		case "kategoriler":
		include("sayfalar/kategoriler.php");
		break;

		case "destek":
		include("sayfalar/destek.php");
		break;
			
		case "urunler":
		include("sayfalar/urunler.php");
		break;
			
		case "uye_urunler":
		include("sayfalar/uye_urunler.php");
		break;
			
		case "ayarlar":
		include("sayfalar/site_ayarlari.php");
		break;
	}
} else {
echo '<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">';
	if(isset($_POST['giris']))
	{
		$kadi = $_POST["kadi"];
		$sifre = $_POST["sifre"];
		$sql = mysql_query("Select * from ayarlar WHERE acpsifre='$sifre'"); 
		$say = mysql_num_rows($sql); 
		$row = mysql_fetch_array($sql);
		if($kadi == "admin" AND $say > 0)
		{
		$_SESSION['admin'] = true; 
		echo '<div class="alert alert-success" style="width: 92%;margin: auto;top: 2%;position: absolute;">
                                Başarıyla Giriş Yaptınız. Hoşgeldiniz...
                   </div>';
		header("refresh:2; url=index.php");
		}
		else {
		echo '<div class="alert alert-danger" style="width: 92%;margin: auto;top: 2%;position: absolute;">
                                Yanlış Şifre Girdiniz
                   </div>';
			//header("refresh:2; url=index.php");
		}
	}

	echo ' <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lütfen Giriş Yapın</h3>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Kullanıcı Adı" name="kadi" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Şifre" name="sifre" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" value="Giriş Yap" class="btn btn-lg btn-success btn-block" name="giris">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	';
}



?>