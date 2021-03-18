<?php
!defined("guvenlik") ? header("location: /index.php") : true;
include('includes/fonksiyonlar.php');

		 
                     
    if(isset($_SESSION['karakter']))
	{
		$s = @$_GET['yer'];
		switch($s)
		{
			case "duzenle":
			$uyeBilgi = mysql_query("SELECT * FROM uyeler WHERE nick='".$_SESSION['kadi']."'"); 
			$uyeRow = mysql_fetch_array($uyeBilgi); 
			$kadi = $uyeRow['nick']; 
			$ad = $uyeRow['ad']; 
			$soyad = $uyeRow['soyad']; 
			$email = $uyeRow['email']; 
			$puan = $uyeRow['puan']; 
			$d_tarihi = $uyeRow['d_tarih']; 
			$avatar = $uyeRow['avatar']; 
			$uyesifre = $uyeRow['sifre']; 
			$hakkinda = $uyeRow['hakkinda']; 
			
			echo '
			<div class="panel panel-danger">
			  <div class="panel-heading">
				<h3 class="panel-title">Profili Düzenle</h3>
			  </div>
			  <div class="panel-body">			 
			<table height="116" border="0" cellpadding="2" cellspacing="2" align="center" style="border-spacing: 2;border-collapse: separate;">
			<form action="" method="POST">
			  <tr>
				<td width="170" height="23">Adınız</td>
				<td width="10" align="center">:</td>
				<td width="280"><input type="text" class="form-control" name="ad" value="'.$ad.'"></td>
			  </tr>
			  <tr>
				<td  height="23">Soyadınız</td>
				<td width="10" align="center">:</td>
				<td ><input type="text" class="form-control" name="soyad" value="'.$soyad.'"></td>
			  </tr>
			  <tr>
				<td height="21">E-Posta Adresiniz</td>
				<td align="center">:</td>
				<td><input type="text" class="form-control" name="email" value="'.$email.'"></td>
			  </tr>
			  <tr>
				<td height="21">Doğum Tarihiniz</td>
				<td align="center">:</td>
				<td><input type="date" class="form-control" name="dtarihi" value="'.$d_tarihi.'"></td>
			  </tr>
			  <tr>
				<td height="21">Bize Kendinizden Bahsedin</td>
				<td align="center">:</td>
				<td><textarea name="hakkinda" class="form-control" rows="2" style="height:75px;resize: none;">'.$hakkinda.'</textarea></td>
			  </tr>
			  <tr>
				<td colspan="3">
				<div class="panel panel-success">
				  <div class="panel-heading">
					<h3 class="panel-title">Şifre Değiştir (Değiştirmeyecek iseniz boş geçiniz.)</h3>
				  </div>
				  <div class="panel-body">
					<table style="border-spacing: 2;border-collapse: separate;">
					  <tr>
						<td width="180" height="21">Şu anki Şifreniz</td>
						<td align="center">:</td>
						<td width="270"><input type="password" class="form-control" name="sifre" value="" placeholder="Şifreniz"></td>
					  </tr>
					  <tr>
						<td height="21">Yeni Şifreniz</td>
						<td align="center">:</td>
						<td><input type="password" class="form-control" name="ysifre" value="" placeholder="Yeni Şifre"></td>
					  </tr>
					  <tr>
						<td height="21">Yeni Şifre Tekrar</td>
						<td align="center">:</td>
						<td><input type="password" class="form-control" name="ysifret" value="" placeholder="Yeni Şifre Tekrar"></td>
					  </tr>
					  </table>
					  </div>
					</div>
					</td>
				</tr>
			  <tr>
				<td align="center" colspan="3" valign="top">
				<input type="submit" name="kaydet" value="Profili Güncelle" class="btn btn-success"></td>
			  </tr>
			  </form>
			</table><center>';
			if(isset($_POST['kaydet']))
			{
				$adi = $_POST['ad'];
				$soyadi = $_POST['soyad'];
				$maili = $_POST['email'];
				$dtarihi = $_POST['dtarihi'];
				$sifresi = md5($_POST['sifre']);
				$sifresik = $_POST['sifre'];
				$ysifresi = $_POST['ysifre'];
				$ysifresit = $_POST['ysifret'];
				$yhakkinda = $_POST['hakkinda'];
				if($sifresik == "" || $ysifresi == "" || $ysifresit == "")
				{
					$guncelle = mysql_query("UPDATE uyeler SET hakkinda='".$yhakkinda."', ad='".$adi."',soyad='".$soyadi."',email='".$maili."',d_tarih='".$dtarihi."' WHERE nick='".$_SESSION['kadi']."' ");
					if($guncelle)
					{
						echo 'Üyelik Bilgileriniz Başarıyla Kaydedildi!';
						header("refresh:2");
					}
					else {
						echo 'Bilgileriniz kaydedilirken bir sorun oluştu.';
					}
				}
				else {
					if($sifresi != $uyesifre)
					{
						echo 'Şifrenizi Yanlış Girdiniz.';
					}
					else if($ysifresi != $ysifresit)
					{
						echo 'Yeni şifreler bir biri ile aynı değil.';
					}
					else {
						
						$guncelle = mysql_query("UPDATE uyeler SET hakkinda='".$yhakkinda."', sifre='".md5($ysifresi)."',ad='".$adi."',soyad='".$soyadi."',email='".$maili."',d_tarih='".$dtarihi."' WHERE nick='".$_SESSION['kadi']."' ");
						if($guncelle)
						{
							echo 'Üyelik Bilgileriniz Başarıyla Kaydedildi!';
							header("refresh:2");
							
						}
						else {
							echo 'Bilgileriniz kaydedilirken bir sorun oluştu.';
						}
					}
			
				}
				echo ' 
			</center>';
			}
			echo ' </div>
			</div>';
			break;
			
			default:
			//Burası Üye Panelinde olacaklar
			$uyeBilgi = mysql_query("SELECT * FROM uyeler WHERE nick='".$_SESSION['kadi']."'"); 
			$uyeRow = mysql_fetch_array($uyeBilgi); 
			$kadi = $uyeRow['nick']; 
			$ad = $uyeRow['ad']; 
			$soyad = $uyeRow['soyad']; 
			$email = $uyeRow['email']; 
			$puan = $uyeRow['puan']; 
			$d_tarihi = $uyeRow['d_tarih']; 
			$avatar = $uyeRow['avatar']; 
			
			echo '<ul class="nav nav-tabs">
  <li class="active"><a href="#kullanicipaneli" data-toggle="tab">Kullanıcı Bilgileriniz</a></li>
  <li><a href="#urunler" data-toggle="tab">Satın Aldığınız Ürünler</a></li>
  <li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
      İşlemler <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
      <li><a href="kullanici-ayarlari.html">Profili Düzenle</a></li>
      <li class="divider"></li>
      <li><a href="?cikisyap">Çıkış Yap</a></li>
    </ul>
  </li>
</ul>
<div id="myTabContent" class="tab-content">
  <div class="tab-pane fade active in" id="kullanicipaneli">
		
		<div class="panel panel-info">
		  <div class="panel-heading">
			<h3 class="panel-title">Hoşgeldiniz Sayın '.$ad.' '.$soyad.'</h3>
		  </div>
		  <div class="panel-body">
			<br>
			<table>
				<tr>
					<td rowspan="5"><img src="'.$avatar.'" width="180" border="0" alt="'.$kadi.' ,'.$ad.' '.$soyad.', NBlog KSS"></td>
				</tr>
				<tr>
					<td  height="23">Kullanıcı Adınız</td>
					<td width="10" align="center">:</td>
					<td >'.$kadi.'</td>
				  </tr>
				  <tr>
					<td height="21">E-Posta Adresiniz</td>
					<td align="center">:</td>
					<td>'.$email.'</td>
				  </tr>
				  <tr>
					<td height="21">Doğum Tarihiniz</td>
					<td align="center">:</td>
					<td>'.$d_tarihi.'</td>
				  </tr>
				  <tr>
					<td height="21">Toplam Puanınız</td>
					<td align="center">:</td>
					<td>'.$puan.'</td>
				  </tr>
			</table>
		  </div>
		</div>
		
		
  </div>
 <div class="tab-pane fade" id="urunler">
 <div class="panel panel-warning">
  <div class="panel-heading">
    <h3 class="panel-title">Ürünleriniz</h3>
  </div>
  <div class="panel-body">';
				
				echo '<table class="table table-striped table-hover ">
  <thead>
    <tr class="info">
      <th>#</th>
      <th>Ürün Adı</th>
      <th>Ürün Durumu</th>
      <th>Sipariş Tarihi</th>
      <th>İşlemler</th>
    </tr>
  </thead>
  ';
				$uyeUrunSql = mysql_query("SELECT * FROM uye_urunleri WHERE uye_Id='".$_SESSION["id"]."' ORDER BY alimTarihi DESC LIMIT 5");
				if(mysql_num_rows($uyeUrunSql) > 0)
				{
					while($urunYaz = mysql_fetch_array($uyeUrunSql))
					{
						$urunSql = mysql_query("SELECT * FROM urun_satis WHERE id='".$urunYaz['urun_Id']."' ");
						$urunuYaz = mysql_fetch_array($urunSql);
						$durum = $urunYaz['durum'];
						if($durum == 0)
						{
							$urun_durumu = "<b style='color:orange'>Onay Bekleniyor</b>";
						}
						else if($durum == 1)
						{
							$urun_durumu = "<b style='color:gray'>Ürün İptal Edilmiştir</b>";
						}
						else if($durum == 2)
						{
							$urun_durumu = "<b style='color:red'>Ürün Onaylanmadı</b>";
						}
						else if($durum == 3)
						{
							$urun_durumu = "<b style='color:green'>Ürün Aktif</b>";
						}
						echo '
						<tbody>
							<tr class="active">
							  <td>'.$urunuYaz['id'].'</td>
							  <td>'.$urunuYaz['urun_adi'].'</td>
							  <td>'.$urun_durumu.'</td>
							  <td>'.$urunYaz['alimTarihi'].'</td>
							  <td>Detaylar</td>
							</tr>
						</tbody>';
					}
				}
				else {
					echo '<tr>
								<td colspan="4" align="center">Satın Aldığınız Ürün Bulunmamaktadır.</td>
							</tr>';
				}
				echo '</table>
				  </div>
				</div>';

				 echo '</div>
				</div>';
				
			break;
		}
	}
	else
	{ 
		include('uye_ol.php');
	}
?>