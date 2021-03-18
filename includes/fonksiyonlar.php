<?php $ayarlar = mysql_query("SELECT * FROM ayarlar");
$bul222 = mysql_fetch_array($ayarlar);
$title = $bul222["title"];
$tema = $bul222["tema"];
$facebook = $bul222["facebook"];
$twitter = $bul222["twitter"];
$google = $bul222["google"];
$youtube = $bul222["youtube"];
$metatag = $bul222["metatag"];
$metatanim = $bul222["metatanim"];
$metaauthor = $bul222["metaauthor"];
$analytics = $bul222["analytics"];
$domain = $bul222["site_link"];
function parcala($q) {
 $q = ereg_replace(" ",",",$q);
 $q = ereg_replace("'",",",$q);
 $q = ereg_replace("\"",",",$q);  
 $q = strtolower($q);
 $q=trim($q);
 return $q;
}
include("inc.php");

function sef_link($baslik)
{
	$baslik = str_replace(array("&quot;","&#39;"), NULL, $baslik);
	$bul = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '-');
	$yap = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', ' ');
	$perma = strtolower(str_replace($bul, $yap, $baslik));
	$perma = preg_replace("@[^A-Za-z0-9\-_]@i", ' ', $perma);
	$perma = trim(preg_replace('/\s+/',' ', $perma));
	$perma = str_replace(' ', '_', $perma);
	return $perma;
}
function dduzelt($text)
{
	$g_karakter    = array("&#39;");
    $c_karakter    = array("'");
	
    $degisen = str_replace($g_karakter, $c_karakter, $text);
    return $degisen;
}
function temizledegel($string) 
{ 
if(get_magic_quotes_gpc()) 
{ 
$string = stripslashes($string); 
} 
elseif(!get_magic_quotes_gpc()) 
{ 
$string = addslashes($string); 
} 
$string = @mysql_real_escape_string($string); 
return $string; 
} 
$gunler=array('Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi');
$aylar=array(' ', 'Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos',
'Eylül',  'Ekim',  'Kasım',  'Aralık');
?>
<html>
<head>
	<title><?php echo $title ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	if(@$_GET['sayfa'] == "blog" AND isset($_GET['yazi']))
	{
		$vericek = mysql_query("SELECT * FROM blog where id='".$_GET['yazi']."'");
		$bul = mysql_fetch_array($vericek);
?>
	<meta name="keywords" content="<?php echo parcala(strip_tags($bul['k_aciklama'])); ?>" />
	<meta name="description" content="<?php echo$bul['k_aciklama']; ?>" />
<?php
	} else { ?>
	<meta name="description" content="<?php echo $metatanim; ?>" />
<?php
	}
?>
	<meta name="keywords" content="<?php echo $metatag ?>" />
	<meta name="author" content="<?php echo $metaauthor ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<script src="includes/html5shiv.js"></script>
	<script src="includes/respond.min.js"></script>
	<script src="includes/jquery-2.1.0.min.js"></script>
	<script src="includes/bootstrap.min.js"></script>
	<?php if(isset($_SESSION['tema'])) { ?>
	<link rel="stylesheet" type="text/css" href="./includes/temalar/<?php echo $_SESSION['tema'] ?>/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="./includes/temalar/<?php echo $_SESSION['tema'] ?>/stil.css" />
	<?php } else { ?>
	<link rel="stylesheet" type="text/css" href="./includes/temalar/<?php echo $tema ?>/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="./includes/temalar/<?php echo $tema ?>/stil.css" />	
	<?php } ?>
	<?php echo dduzelt($analytics) ?>
	<?php include"./includes/jscriptkod.php"; ?>
	
</head>
<body style="overflow-x:hidden;">
<?php
if(isset($_POST['girisyap'])){ 

		$kadi = $_POST['nick']; 
		$sifre = md5($_POST['sifre']); 
		$sql = mysql_query("Select * from uyeler where nick='$kadi' and sifre='$sifre'"); 
		$say = mysql_num_rows($sql); 
		$row = mysql_fetch_array($sql); 
		$durum = $row['durum']; 

		if($kadi == "" || $sifre == "")
		{
		echo 'Tüm Alanları Doldurunuz';
			header("refresh:2"); 
		}
		elseif($durum == 1){ 
				 echo'Hesabınız Kapatılmıştır. Eğer Haksız yere hesabınızın kapatıldığını<br> düşünüyor iseniz <b>İletişim</b>Sayfasından bize ulaşabilirsiniz.<br>'; 
				header("refresh:2"); 
				 }              
		elseif($say > 0){ 
				$_SESSION['karakter'] = true; 
				$_SESSION['kadi'] = $kadi; 
				$_SESSION['id'] = $row['id']; 
			header("Location:kullanici-paneli.html");
			 
			} else{ 
					echo 'Kullanıcı Adı veya Şifre Yanlış. Lütfen Tekrar Deneyin.<br>'; 
			} 
    }
	if(isset($_GET['cikisyap'])) 
	{
		unset($_SESSION["kadi"]);
		unset($_SESSION["id"]);
		unset($_SESSION["karakter"]);
	header("Location: index.html"); 
	}
?>
<div class="navbar navbar-default menu" style="width: 96%;margin-left: 2%;margin-top: 10px;">
<div class="row">
  <div class="navbar-header col-md-6">
    <h3 style="font-size: 19px;margin-left: 15;text-shadow: 1px 1px 1px black;color:orange;"><b style="color:red">&lt;?php</b> <b style="color:lightblue">echo "</b><?php echo $title; ?><b style="color:lightblue">";</b> <b style="color:red">?&gt;</b></h3>
  </div>
  <div class="navbar-collapse collapse navbar-responsive-collapse  col-md-6" style="float: right;
position: absolute;
right: 0;">
      <form class="navbar-form navbar-right" method="POST">
		<select name="tema" class="form-control" onchange="this.form.submit()">
			<option>Tema Seçiniz</option>
			<?php
			$ayarlar = mysql_query("SELECT * FROM ayarlar");
			$listele = mysql_fetch_array($ayarlar);
			$dizin = opendir('includes/temalar');
			while($dosya = readdir($dizin)) {
				if($dosya != "." && $dosya != ".." && $dosya != "index.php") {
					echo "<option value='".$dosya."' ";
					if(isset($_SESSION['tema'])) {
						if($_SESSION["tema"] == $dosya)
						{ echo 'selected'; }
					} else {
						if($listele["tema"] == $dosya)
						{ echo 'selected'; }
					}
					echo ">".$dosya."</option>"; 
				}
			}
			if(isset($_POST['tema']))
			{
				$dizin = opendir('includes/temalar');
				while($dosya = readdir($dizin)) {
					if($dosya != "." && $dosya != ".." && $dosya != "index.php")
					{
						if($dosya != $_POST['tema'])
						{
							
						} 
						else {
							$_SESSION['tema'] = $_POST['tema'];
							header("Refresh: 0");
						}	
					}					
				}
			}
			?>
		</select>
	  </form>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="index.php">Anasayfa</a></li>
      <li><a href="blog.html">Blog</a></li>
      <li><a href="dosyalar.html">Dosyalar</a></li>
      <li><a href="market.html">Market</a></li>
      <?php if(isset($_SESSION['karakter'])) {
		$yeniMesajSay = mysql_query("SELECT * FROM ozel_mesaj WHERE durum='0' AND uyeid='".$_SESSION['id']."'");
		$sayiMesaj = mysql_num_rows($yeniMesajSay);
	  ?>
	  <li class="dropdown">
        <a href="kullanici-paneli.html" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Kullanıcı Paneli<b class="caret"></b></a>
        <ul class="dropdown-menu" style="">
          <li><a href="ozel-mesajlar.html" style="color: #;">Mesajlar <span class="badge" style="float: right;"><?php echo $sayiMesaj; ?></span></a></li>
          <li><a href="kullanici-paneli.html" style="color: #;">Profile Git</a></li>
          <li><a href="kullanici-ayarlari.html" style="color: #;">Profili Düzenle</a></li>
          <li><a href="destek.html" style="color: #;">Destek Bildirimleri</a></li>
          <li><a href="index.php?cikisyap" style="color: #;">Çıkış Yap</a></li>
        </ul>
      </li>	  
	  <?php }else { ?>
	  <li><a href="#" onclick="$('#uyegiris').modal('show');">Üye Girişi</a></li>
	  <?php } ?>
    </ul>
  </div>
  </div>
</div>
<div class="tasarim-notu col-md-9 mobil-uyumluluk">
<div class="alert alert-dismissable alert-info">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>Çözünürlüğünüzden dolayı sitemizi Portable Tasarımda görmektesiniz. Daha Gelişmiş görünüm için 1280x768 ve daha büyük çözünürlükte sitemizi ziyaret ediniz.</strong>
</div>
</div>
<div class="mobil-menu col-md-9 mobil-uyumluluk">
<div class="panel panel-default">
  <div class="panel-body" style="text-align: center;">
    <b style="font-size: 19px;text-shadow: 1px 1px 1px black;color:orange;text-align: center;"><b style="color:red">&lt;?php</b> <b style="color:lightblue">echo "</b><?php echo $title; ?><b style="color:lightblue">";</b> <b style="color:red">?&gt;</b></b>
  </div>
</div>
	<div class="list-group" style="width:100%;">
	  <a href="index.php" class="list-group-item">Anasayfa</a>
      <a href="blog.html" class="list-group-item">Blog</a>
      <a href="dosyalar.html" class="list-group-item">Dosyalar</a>
      <a href="market.html" class="list-group-item">Market</a>
	  <?php if(isset($_SESSION['karakter'])) { ?>
	  <a href="kullanici-paneli.html" class="list-group-item">Profile Git</a>
	  <a href="destek.html" class="list-group-item">Destek Bildirimleri</a>
	  <a href="index.php?cikisyap" class="list-group-item">Çıkış Yap</a>
	  <?php } else { ?>
	  <a href="#" onclick="$('#uyegiris').modal('show');" class="list-group-item">Üye Girişi</a>
	  <?php } ?>
	</div>
</div>
<div class="modal fade" id="uyegiris">
  <div class="modal-dialog" style="width: 450px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Üye Girişi</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="">
		
		  <table align="center">
			<tr>
				<td>Kullanıcı Adınız</td><td><input type="text" class="form-control" name="nick" placeholder="Kullanıcı Adınızı Giriniz" style="margin-left: 20px;width: 90%;"></td>
			</tr>
			<tr>
				<td>Şifreniz </td><td><input type="password" class="form-control" name="sifre" placeholder="Şifrenizi Giriniz" style="margin-left: 20px;margin-top:5px;width: 90%;"></td>
			</tr>
			<tr>
				<td colspan="2" align="right"><a href="uye-ol.html" class="btn btn-success" style="margin-top:5px;">Kayıt Ol</a> <a href="#" class="btn btn-default" style="margin-top:5px;">Şifremi Unuttum</a> <input type="submit" name="girisyap" class="btn btn-primary" value="Giriş Yap" style="margin-top:5px;"></td>
			</tr>
		  </table>
		  
		
		</form>
      </div>
    </div>
  </div>
</div>
<div class="row " style="margin-left: 1%;">
<div class="mobil-uyumluluk col-md-9" style="" >
 <div class="panel panel-default ">
  <div class="panel-heading">
  <?php 
	if(@$_GET['sayfa'] == "blog" AND isset($_GET['yazi']))
	{
		$vericek = mysql_query("SELECT * FROM blog where id='".$_GET['yazi']."'");
		$bul = mysql_fetch_array($vericek);
		echo "<b>".$bul['blog_adi']."</b>";
		
		echo '<ul class="breadcrumb" style="float: right;margin-top: -10;margin-bottom: 0px;padding-bottom: 0px;">
				  <li><a href="#">Anasayfa</a></li>
				  <li><a href="#">Blog</a></li>
				  <li class="active">'.$bul['blog_adi'].'</li>
				</ul>';
	}
	else if(@$_GET['sayfa'] == "uye-om" AND @$_GET['yer'] == "mesajgonder")
	{
		echo "<b>Yeni Mesaj Gönder</b>";
		
		echo '<ul class="breadcrumb" style="float: right;margin-top: -10;margin-bottom: 0px;padding-bottom: 0px;">
				  <li><a href="index.html">Anasayfa</a></li>
				  <li><a href="ozel-mesajlar.html">Mesajlar</a></li>
				  <li class="active">Yeni Mesaj Gönder</li>
				</ul>';
	}
	else if(@$_GET['sayfa'] == "uye-om")
	{
		echo "<b>Özel Mesajlar</b>";
		
		echo '<ul class="breadcrumb" style="float: right;margin-top: -10;margin-bottom: 0px;padding-bottom: 0px;">
				  <li><a href="index.html">Anasayfa</a></li>
				  <li><a href="kullanici-paneli.html">Kullanıcı Paneli</a></li>
				  <li class="active">Özel Mesajlar</li>
				</ul>';
	}
	else if(@$_GET['sayfa'] == "uye")
	{
		echo "<b>Kullanıcı Paneli</b>";
		
		echo '<ul class="breadcrumb" style="float: right;margin-top: -10;margin-bottom: 0px;padding-bottom: 0px;">
				  <li><a href="index.html">Anasayfa</a></li>
				  <li class="active">Kullanıcı Paneli</li>
				</ul>';
	}
	else if(@$_GET['sayfa'] == "blog")
	{
		echo "<b>Blog</b>";
		
		echo '<ul class="breadcrumb" style="float: right;margin-top: -10;margin-bottom: 0px;padding-bottom: 0px;">
				  <li><a href="index.html">Anasayfa</a></li>
				  <li class="active">Blog</li>
				</ul>';
	}
	else if(@$_GET['sayfa'] == "projelerim")
	{
		echo "<b>Dosyalar</b>";
		
		echo '<ul class="breadcrumb" style="float: right;margin-top: -10;margin-bottom: 0px;padding-bottom: 0px;">
				  <li><a href="index.html">Anasayfa</a></li>
				  <li class="active">Dosyalar</li>
				</ul>';
	}
	else if(@$_GET['sayfa'] == "market")
	{
		echo "<b>Ürünler</b>";
		
		echo '<ul class="breadcrumb" style="float: right;margin-top: -10;margin-bottom: 0px;padding-bottom: 0px;">
				  <li><a href="index.html">Anasayfa</a></li>
				  <li class="active">Ürünler</li>
				</ul>';
	}
	else if(@$_GET['sayfa'] == "destek" AND @$_GET['yer'] == "yeni")
	{
		echo "<b>Yeni Bildirim Oluştur</b>";
		
		echo '<ul class="breadcrumb" style="float: right;margin-top: -10;margin-bottom: 0px;padding-bottom: 0px;">
				  <li><a href="index.html">Anasayfa</a></li>
				  <li><a href="destek.html">Destek</a></li>
				  <li class="active">Yeni Bildirim Oluştur</li>
				</ul>';
	}
	else if(@$_GET['sayfa'] == "destek" AND @$_GET['yer'] == "mesaj")
	{
		echo "<b>Bildirim Görüntüleniyor</b>";
		
		echo '<ul class="breadcrumb" style="float: right;margin-top: -10;margin-bottom: 0px;padding-bottom: 0px;">
				  <li><a href="index.html">Anasayfa</a></li>
				  <li><a href="destek.html">Destek</a></li>
				  <li class="active">Bildirimi Görüntüle</li>
				</ul>';
	}
	else if(@$_GET['sayfa'] == "destek")
	{
		echo "<b>Destek Sistemi</b>";
		
		echo '<ul class="breadcrumb" style="float: right;margin-top: -10;margin-bottom: 0px;padding-bottom: 0px;">
				  <li><a href="index.html">Anasayfa</a></li>
				  <li class="active">Destek Sistemi</li>
				</ul>';
	}
	else {
		echo $title.' - Anasayfa';
	}
  ?>
  </div>
  <div class="panel-body">
