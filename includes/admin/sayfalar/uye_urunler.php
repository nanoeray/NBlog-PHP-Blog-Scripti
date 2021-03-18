<?php

$sayfa = @$_GET["sayfa"];
echo '<div id="wrapper">
        <div id="page-wrapper">
		<div class="panel panel-default" >
                        <div class="panel-heading">
                            Üye Ürün Yönetimi
                        </div>
                        <div class="panel-body">';
switch($sayfa)
{
	default:
	
		echo 'Merhaba, Buradan Üyelerin ürünlerini yönetebilirsin. Detaylar için ürünlerini listelemek istediğin üye kullanıcı adını aşağıya yazınız.<br>
		<br>
		<form method="POST" action="index.php?admin=uye_urunler&sayfa=urun_detay">
			<input type="text" name="uye" placeholder="Üye Kullanıcı Adını Giriniz" class="form-control"><br>
			<center><input type="submit" name="ara" class="btn btn-outline btn-success" value="Üye Ara"></center>
		</form>';
		
		$urunListeleSql = mysql_query("SELECT * FROM uye_urunleri WHERE durum='0' ORDER by alimTarihi DESC");
			echo '<table class="table table-striped">
									<caption><center><strong>Onay Bekleyen Son Siparişler</strong></center></caption>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ürün Adı</th>
                                            <th>Sipariş Tarihi</th>
                                            <th>Sipariş Eden</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>';
			if(mysql_num_rows($urunListeleSql) > 0)
			{
				while($bul = mysql_fetch_array($urunListeleSql))
				{
					$urunAdiBul = mysql_fetch_array(mysql_query("SELECT * FROM urun_satis WHERE id='".$bul['urun_Id']."'"));
					$urunUyeBul = mysql_fetch_array(mysql_query("SELECT * FROM uyeler WHERE id='".$bul['uye_Id']."'"));
					echo '<tbody>
											<tr>
												<td>'.$bul['id'].'</td>
												<td>'.$urunAdiBul['urun_adi'].'</td>
												<td>'.$bul['alimTarihi'].'</td>
												<td>'.$urunUyeBul['nick'].'</td>
												<td><a href="index.php?admin=uye_urunler&sayfa=onayla&urun='.$bul['id'].'">Onayla</a> - <a href="index.php?admin=uye_urunler&sayfa=onaylama&urun='.$bul['id'].'">Red Et</a></td>
											</tr>
								</tbody>';
				}
			} else {
				echo '<tbody>
											<tr>
												<td colspan="5" align="center">Yeni Sipariş Bulunmamaktadır.</td>
											</tr>
								</tbody>';
			}
			echo '</table>';
	break;
	
	case "urun_detay":
		if(isset($_POST['ara']))
		{
			$uye = @$_POST['uye'];
			$bulUye = mysql_fetch_array(mysql_query("SELECT * FROM uyeler WHERE nick='".$uye."'"));
			$uyeId = $bulUye["id"];
			$urunListeleSql = mysql_query("SELECT * FROM uye_urunleri WHERE uye_Id='".$uyeId."'");
			echo '<table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ürün Adı</th>
                                            <th>Sipariş Tarihi</th>
                                            <th>Durum</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>';
			if(mysql_num_rows($urunListeleSql) > 0)
			{
				while($bul = mysql_fetch_array($urunListeleSql))
				{
					if($bul['durum'] == 0)
					{
						$urun_durumu = "<b style='color:orange'>Onay Bekleniyor</b>";
					}
					else if($bul['durum'] == 1)
					{
						$urun_durumu = "<b style='color:gray'>Ürün İptal Edilmiştir</b>";
					}
					else if($bul['durum'] == 2)
					{
						$urun_durumu = "<b style='color:red'>Ürün Onaylanmadı</b>";
					}
					else if($bul['durum'] == 3)
					{
						$urun_durumu = "<b style='color:green'>Ürün Aktif</b>";
					}
					$urunAdiBul = mysql_fetch_array(mysql_query("SELECT * FROM urun_satis WHERE id='".$bul['urun_Id']."'"));
					echo '<tbody>
											<tr>
												<td>'.$bul['id'].'</td>
												<td>'.$urunAdiBul['urun_adi'].'</td>
												<td>'.$bul['alimTarihi'].'</td>
												<td>'.$urun_durumu.'</td>
												<td><a href="index.php?admin=uye_urunler&sayfa=onayla&urun='.$bul['id'].'">Onayla</a> - <a href="index.php?admin=uye_urunler&sayfa=onaylama&urun='.$bul['id'].'">Red Et</a> - <a href="index.php?admin=uye_urunler&sayfa=iptal&urun='.$bul['id'].'">İptal Et</a></td>
											</tr>
								</tbody>';
				}
			} else {
					echo '<tbody>
											<tr>
												<td colspan="5" align="center">Üyenin Siparişi Bulunmamaktadır.</td>
											</tr>
								</tbody>';
			}
			echo '</table>';
		}
		else {
			echo 'Bu sayfaya erişmek için üye aramalısınız...';
		}
	
	break;
	
	case "onayla":
		$urun = @$_GET["urun"];
		$onayla = mysql_query("UPDATE uye_urunleri SET durum=3 WHERE id='".$urun."'");
		if($onayla)
		{
			echo 'Ürün Onaylandı.';
			$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
			header("Refresh:2; url= ".$url);
		} else {
			echo 'Hata Oluştu.';
			$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
			header("Refresh:2; url= ".$url);
		}
	break;
	
	case "onaylama":
		$urun = @$_GET["urun"];
		$onayla = mysql_query("UPDATE uye_urunleri SET durum=2 WHERE id='".$urun."'");
		if($onayla)
		{
			echo 'Ürün Red Edildi.';
			$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
			header("Refresh:2; url= ".$url);
		} else {
			echo 'Hata Oluştu.';
			$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
			header("Refresh:2; url= ".$url);
		}
	break;
	
	case "iptal":
		$urun = @$_GET["urun"];
		$onayla = mysql_query("UPDATE uye_urunleri SET durum=1 WHERE id='".$urun."'");
		if($onayla)
		{
			echo 'Ürün İptal Edildi.';
			$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
			header("Refresh:2; url= ".$url);
		} else {
			echo 'Hata Oluştu.';
			$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
			header("Refresh:2; url= ".$url);
		}
	break;
}
echo '</div></div></div>
          </div>';
?>