<?php
!defined("guvenlik") ? die("Bu sayfaya erişim yasaklanmıştır.") : NULL;
function sef_links($baslik)
{
	$baslik = str_replace(array("&quot;","&#39;"), NULL, $baslik);
	$bul = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '-');
	$yap = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', ' ');
	$perma = strtolower(str_replace($bul, $yap, $baslik));
	$perma = preg_replace("@[^A-Za-z0-9\-_]@i", ' ', $perma);
	$perma = trim(preg_replace('/\s+/',' ', $perma));
	$perma = str_replace(' ', '-', $perma);
	return $perma;
}
 
function kdv_ekle($tutar,$oran){
$kdv = $tutar * ($oran / 100);
$ytutar = $tutar + $kdv;
 
return $ytutar;
 
}

 include("./includes/fonksiyonlar.php"); ?>
<?php
include("./ayarlar/veritabani.php");

$projeler = @$_GET['i'];

switch ($projeler){
    case "":
		echo '<table width="100%" style="margin: 0 auto;">
				<tr><td align="center"><div id="dis_bolme" style="margin: 0 auto; padding-left:17px;">
				';	

		$sayfa = @$_GET['s'];
		if($sayfa < 1){
		$baslangic = 0;
		}else{
		$baslangic = (($sayfa-1)*2);
		}
		$sirala = mysql_query("SELECT * FROM urun_satis ORDER BY id DESC LIMIT $baslangic, 3");
			
			$tablo_sutunu = 0;                      
		$sira = $baslangic+1;
			while ($bul = mysql_fetch_array($sirala)){ 
		$id = $bul["0"]; 
		$resim = $bul["resim"];
		$adi = $bul["1"];
		$fiyat = $bul["3"];
		$stok = $bul["4"];
		$ad2 = sef_links($adi);
		echo '
		<div class="price-table">
			<h4>'.$adi.'</h4>
			<h5>'.$fiyat.'<span>TL/Ay</span></h5>
			<ul style="list-style: none;margin: 0px;padding: 0px;">';
			$liste_sql = mysql_query("SELECT * FROM urun_ozellikleri WHERE urunId='".$id."'");
			while($veriYaz = mysql_fetch_array($liste_sql))
			{
					echo '<li class="active1"><a href="">'.$veriYaz['ozellik'].'</a></li>';
			}
			if(isset($_SESSION['karakter']))
			{
				echo '<a class="price-button" href="urun-satinal-'.$id.'-'.$ad2.'.html">Satın Al</a>';
			}
			echo'
			</ul>
		</div>
		<div class="ic_bolme" style="display:none;">
		<fieldset>
		<table>
		<tr>
		<td>
		<b>'.$adi.'</b><ul>	';
		$liste_sql = mysql_query("SELECT * FROM urun_ozellikleri WHERE urunId='".$id."'");
		while($veriYaz = mysql_fetch_array($liste_sql))
		{
				echo '<li><strong><span style="font-size: 1em;" class="bbc_size"><span style="font-family: Tahoma, Calibri, Verdana, Geneva, sans-serif;" class="bbc_font">'.$veriYaz['ozellik'].'</span></span></strong></li>';
		}
		echo '</ul></td>
		<td>
		<img src="'.$resim.'" width="105px">
		</td>
		</tr>
		<tr>
		<td colspan="2">
		<center>
		Stok Durumu: <b>'.$stok.'</b>
		Ürün Fiyatı: <b>'.$fiyat.'</b>';
		if(isset($_SESSION['karakter']))
		{
			echo '<input type="image" onclick="location.href=\'urun-satinal-'.$id.'-'.$ad2.'.html\'" src="./includes/temalar/'.$tema.'/resimler/butonlar/satinal.png">';
		}
		echo '</center>
		</td>
		</tr>
		</table>
		</fieldset>
		</div>
		';
		}

		echo '</div></td></tr></table>';
		echo '<table align="center"><tr><td align="center" colspan="3"><br><br>';
		function sayfala($sayfa){
$sayfa = temizledegel(@$_GET['s']);
$sqltoplamkisi =  mysql_query("SELECT * FROM urun_satis"); 
$toplamkisi = mysql_num_rows($sqltoplamkisi );
if($sayfa >= 2){
echo '<li><a href="market-'.($sayfa-1).'.html">Önceki Sayfa</a></li> ';
}
else {
echo '<li class="disabled"><a>Önceki Sayfa</a></li> ';

}
for ($j = 1; $j <= ceil($toplamkisi /3); $j++){
if($sayfa == $j){
echo '<li class="active"><a>'.$sayfa.'</a></li>';
}else{
echo '<li><a href="market-'.$j.'.html">'.$j.'</a></li>';
}
}

if($sayfa < ceil($toplamkisi /3)){
echo '<li><a href="market-'.($sayfa+1).'.html" >Sonraki Sayfa</a></li>';
}
else {
echo '<li class="disabled"><a>Sonraki Sayfa</a></li> ';

}
}
		
		echo '</td></tr></table>'; 
		echo '<div style="float:right;">
		<ul class="pagination pagination-sm">';
		sayfala($sayfa);
		echo '</ul></div>';
    break;
    
    case "satinal":
		if(isset($_SESSION['karakter']))
		{
			echo '<table heidght="480px">
			<tr>
			<td valign="top" width="100%">
			<b>Ürün Özellikleri :</b><br>
			<ul class="bbc_list">';

			$liste_sql = mysql_query("SELECT * FROM urun_ozellikleri WHERE urunId='".$_GET['id']."'");
			while($veriYaz = mysql_fetch_array($liste_sql))
			{
					echo '<li><strong><span style="font-size: 1em;" class="bbc_size"><span style="font-family: Tahoma, Calibri, Verdana, Geneva, sans-serif;" class="bbc_font">'.$veriYaz["ozellik"].'</span></span></strong></li>';
			}
			$ayrinti_sql = mysql_query("SELECT * FROM urun_satis WHERE id='".$_GET['id']."'");
			$veriYaz2 = mysql_fetch_array($ayrinti_sql);
			$ad2 = sef_links($veriYaz2['urun_adi']);
			echo '</ul>
			</td>
			<td valign="top">
			<img src="'.$veriYaz2["resim"].'" width="250">
			</td>
			</tr>
			<tr height="100%">
			<td colspan="2" align="center">
			<b>Ürün Fiyatı : '.$veriYaz2["urun_fiyati"].' TL + Kdv (%8)</b><br>
			<b>Stok Adedi :<u>'.$veriYaz2["stok_durumu"].'</u> </b><br>
			<input type="button" class="btn btn-info" onclick="location.href=\'urun-odeme-'.$_GET['id'].'-'.$ad2.'.html\'" value="Satın Al">
			<input type="button" class="btn btn-info" onclick="location.href=\'market.html\'" value="< Geri">
			</td>
			</tr>
			</table>
			';
		} else {
			header("Location:market.html");
		}
    break;
	
	case "odeme":
		if(isset($_SESSION['karakter']))
		{
			$urun = @$_GET["id"];
			$ayrinti_sql = mysql_query("SELECT * FROM urun_satis WHERE id='".$urun."'");
			$urunYaz = mysql_fetch_array($ayrinti_sql);
			
			echo '
			<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Sepetiniz</h3>
  </div>
  <div class="panel-body" >
			<div class="panel panel-default" style="width: 35%;float:left;margin: auto;margin-left: 10%;margin-right:10%;">
  <div class="panel-heading">'.$urunYaz['urun_adi'].'</div>
  <div class="panel-body">	  
			 '.$urunYaz['urun_fiyati'].' TL
			 <table align="center" width="100%">
				<tr>
					<td>Toplam </td><td>: '.$urunYaz['urun_fiyati'].' TL</td>
				</tr>
				<tr>
					<td style="text-align:right;color:red;">Kdv </td><td>: %8</td>
				</tr>
				<tr>
					<td>
						<b>Bugün ödenmesi gereken</b> </td><td>:<b> '.kdv_ekle($urunYaz['urun_fiyati'], 8).' TL</b></td>
				</tr>
				<tr>
					<td colspan="2" align="right">
					<form method="POST" action="">
					<input type="hidden" value="'.$urunYaz['id'].'" name="urunid">
					<input type="submit" class="btn btn-primary" name="satinal" value="Satın Al">
					</form>
					</td>
				</tr>
			</table>
			</div>				
			</div>
			<div class="panel panel-info" style="width:40%;float:left;">
  <div class="panel-heading">
    <h3 class="panel-title">Bilgilendirme</h3>
  </div>
  <div class="panel-body">
    Bir ürünü satın aldıktan sonra hesabınıza "Onay Bekleniyor" olarak eklenmektedir. Ürünü satın aldıktan sonra Destek sistemimizden bildirim atarak ödeme yaptığınıza dair bilgi veriniz. Aksi takdirde Ürün dikkate alınmayacak ve 7 gün içerisinde ödeme olmazsa hesabınızdan silinecektir.
  </div>
</div>
  </div>
';
			if(isset($_POST['urunid']))
			{
				$ekle = mysql_query("INSERT INTO uye_urunleri(urun_Id,uye_Id) values('".$_POST['urunid']."','".$_SESSION['id']."')");
				if($ekle)
				{
					echo '<script>alert("Ürün Alındı. Lütfen ödeme yapınca Destek Talebi Oluşturunuz.");</script>';
					header("Refresh:2; url=index.html");
				}
			}
		}
	break;
}

?>