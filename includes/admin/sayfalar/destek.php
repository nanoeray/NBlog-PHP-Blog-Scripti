<?php

echo '<div id="wrapper">
        <div id="page-wrapper">';
$gelen = @$_GET["yer"];

switch($gelen)
{

	default:
		$listeleSql = mysql_query("SELECT * FROM destek_sistemi WHERE durum = 0 ORDER by aciliyet DESC");
		echo '<div class="panel panel-primary">
                        <div class="panel-heading">
                            Destek Talepleri
                        </div>
                        <div class="panel-body">';
			$sayi = mysql_num_rows($listeleSql);
			if($sayi > 0)
			{
				echo '<table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Talep Konusu</th>
                                            <th>Aciliyet</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>';
				while($bul = mysql_fetch_array($listeleSql))
				{
					if($bul['aciliyet'] == 0) {
						$aciliyet= "Düşük";
					}elseif($bul['aciliyet'] == 1) {
						$aciliyet= "Orta";
					}elseif($bul['aciliyet'] == 2) {
						$aciliyet= "Yüksek";
					}
					echo '     <tbody>
                                        <tr>
                                            <td>'.$bul['id'].'</td>
                                            <td>'.$bul['konu'].'</td>
                                            <td>'.$aciliyet.'</td>
                                            <td><a href="index.php?admin=destek&yer=oku&talep='.$bul['id'].'">Yanıtla</a> <a href="index.php?admin=destek&yer=kapat&talep='.$bul['id'].'">Kapat</a></td>
                                        </tr> ';
				}
				echo '</tbody>
                      </table>';
			}
			else {
				echo '<center><strong>Henüz Yeni Destek Talebi Yok</strong></center>';
			}
	break;
	
	case "oku":
			$mesajid = @$_GET['talep'];
			if(isset($_POST['yanitla']))
			{
				if(empty($_POST['yanit']))
				{
					echo '<div class="alert alert-dismissable alert-warning">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <h4>Hata!</h4>
							  <p>Boş Mesaj Gönderemezsiniz.</p>
							</div>';
				}
				else {
					function duzelt($text)
					{
						$g_karakter    = array("<",">","\\","\"","\'","‘","’","´","'");
						$c_karakter    = array("&lt;","&gt;","&#92;","&quot;","&#39;","&lsquo;","&rsquo;","&#180;","&quot;");
						
						$degisen = str_replace($g_karakter, $c_karakter, $text);
						return $degisen;
					}
					$ekle_sql = mysql_query("INSERT INTO destek_mesaji (destek_id,yanit,yanitlayan) values('".$mesajid."','".nl2br(duzelt($_POST['yanit']))."','0')");
					if($ekle_sql) {
						mysql_query("UPDATE destek_sistemi SET durum=2 WHERE id='".$mesajid."'");
						header("Refresh:0");
					}
					else {
						echo '<div class="alert alert-dismissable alert-warning">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <h4>Hata!</h4>
							  <p>Bir Hata Oluştu</p>
							</div>';
					}
				}
			}
			$destekSql = mysql_query("SELECT * FROM destek_sistemi WHERE id='".$mesajid."'"); 
			$cekDestek = mysql_fetch_array($destekSql);
			
				if($cekDestek['urun'] == 0)
				{
					$urun = "Ürün Seçilmedi";
				} else {
					$urunbil = mysql_query("SELECT * FROM urun_satis WHERE id='".$cekDestek['urun']."'"); 
					$urunbilgi = mysql_fetch_array($urunbil);
					$urun = $urunbilgi['urun_adi'];
				}
				$durum = $cekDestek['durum'];
				if($durum == 0)
				{
					$ddurum = "<b style='color:lightblue'>Yanıt Bekleniyor</b>";
				}
				elseif($durum == 1)
				{
					$ddurum = "<b style='color:orange'>Müşteri Yanıtı</b>";
				}
				elseif($durum == 2)
				{
					$ddurum = "<b style='color:green'>Yanıtlandı</b>";
				}
				elseif($durum == 3)
				{
					$ddurum = "<b style='color:red'>Kapandı</b>";
				}
				echo '<table class="table table-striped table-hover ">
				  <thead>
					<tr>
					  <th>İşlemler</th>
					  <th>Destek Konusu</th>
					  <th>İlgili Ürün</th>
					  <th>Durum</th>
					  <th>Oluşturma Tarihi</th>
					</tr>
				  </thead>
				  <tbody>
					<tr>
						<td>
						<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"';
						if($cekDestek['urun'] == 0)
						{
							echo 'style="display:none;"';
						}
						echo '>
							<i class="fa fa-gear"></i> Ürün İşlemleri  <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu" style="top: inherit;left: initial;">
							<li><a href="index.php?admin=uye_urunler&sayfa=onayla&urun='.$cekDestek['urun'].'">Ürünü Onayla</a>
							</li>
							<li><a href="index.php?admin=uye_urunler&sayfa=onaylama&urun='.$cekDestek['urun'].'">Ürünü Red Et</a>
							</li>
							<li><a href="index.php?admin=uye_urunler&sayfa=iptal&urun='.$cekDestek['urun'].'">Ürünü İptal Et</a>
							</li>
						</ul>
						<a href="index.php?admin=destek&yer=kapat&talep='.$cekDestek['id'].'" class="btn btn-danger btn-sm">Destek Mesajını Kapat</a>
						</td>
						<td>'.$cekDestek['konu'].'</td>
						<td>'.$urun.'</td>
						<td>'.$ddurum.'</td>
						<td>'.$cekDestek['tarih'].'</td>
					</tr>
					</tbody>
				</table>';
				$ozelmesaj = mysql_query("SELECT * FROM destek_mesaji WHERE destek_id='".$mesajid."' ORDER by tarih ASC"); 
				$konu = $cekDestek['konu'];
				while($mesajRow = mysql_fetch_array($ozelmesaj))
				{
					$tarih = $mesajRow['tarih']; 
					$mesaj = $mesajRow['yanit']; 
					$kullanicisql = mysql_query("SELECT * FROM uyeler WHERE id='".$cekDestek['uid']."'"); 
					$kullaniciBak = mysql_fetch_array($kullanicisql);
					if($mesajRow['yanitlayan'] == 0){
						$yanitiveren = "Destek Ekibi Yanıtı";
						$imza = "<br><br>Bizi Tercih Ettiğiniz için teşekkürler.<hr><b>NBlog Kss Destek Ekibi<br>
										info@nanoeray.com<br>
										www.nanoeray.com Web Tasarım - Hosting Hizmetleri</b>";
						$giris = "Merhaba Sayın ".$kullaniciBak['ad']." ".$kullaniciBak['soyad'].";<br>";
						echo '<div class="panel panel-success">';
					} else {
						$yanitiveren = "Müşteri Yanıtı - ".$_SESSION["kadi"];
						$imza = "";
						$giris = "";
						echo '<div class="panel panel-warning">';
					}
					
					
					
					echo'<div class="panel-heading">
						<h3 class="panel-title">'.$yanitiveren.'</h3><b style="float:right;top: -20px;position: relative;">'.$tarih.'</b>
						</div>
						<div class="panel-body">
							'.$giris.'
							'.$mesaj.'
							<br>
							'.$imza.'
						</div>
						</div>';
				}
				echo '
				<div class="panel panel-info">
				  <div class="panel-heading">
					<h3 class="panel-title" style="cursor: pointer;" onclick="yorum.style.display=\'\';yorumac.style.display=\'none\';yorumkapat.style.display=\'\';" name="yorumac" id="yorumac">Yanıt Ver (Açmak için Tıklatın)</h3>
						<h3 class="panel-title" style="cursor: pointer;display:none;" onclick="yorum.style.display=\'none\';yorumac.style.display=\'\';yorumkapat.style.display=\'none\';" name="yorumkapat" id="yorumkapat">Yanıt Ver (Kapatmak için Tıklatın)</h3>
					</div>
					<div class="panel-body" style="display:none;" name="yorum" id="yorum">
					<form action="" method="POST">
					<textarea class="form-control" rows="5" name="yanit" placeholder="Yanıtınızı Giriniz"></textarea><br>
					<center><input type="submit" class="btn btn-success" name="yanitla" value="Yanıtla"></center>
					</form>
				  </div>
				</div>
				';
	break;
	
	case "kapat":
			$mesaj_sil = mysql_query("UPDATE destek_sistemi SET durum='3' WHERE id='".$_GET['talep']."'");
			if($mesaj_sil)
			{
				echo '<script language="JavaScript">
						alert("Destek Mesajı Kapatıldı.") 
					</script>';
				header("refresh: 0; url=index.php?admin=destek");
			}
			else 
			{
				echo '<script language="JavaScript">
						alert("Hata") 
						</script>';
				header("refresh:1;");
			}
	break;

}
echo '</div></div>';
?>