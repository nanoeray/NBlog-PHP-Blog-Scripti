<?php
function post_time($tarih, $simdi=null)
        {
            //aradan geçen süreyi bul
            if(!$simdi) $simdi=time();
            $sure=$simdi-strtotime($tarih);
 
            //eğer geçen süre negatif ise boş metin döndür.
            if($sure<0) return "";
 
            //dönüş metninin oluşturulduğu yer
            //3600: 60*60, yani 1 saat;
            //86400: 60*60*24 yani 1 gün demektir.
            if($sure<60)return round($sure). " saniye önce";
            else if($sure<3600) return round($sure/60). " dakika önce";
            else if($sure<86400) return round($sure/3600). " saat önce";
            else if($sure<86400*7) return round($sure/(86400)). " gün önce";
            else if($sure<86400*30) return round($sure/(86400*7)). " hafta önce";
            else if($sure<86400*365) return round($sure/(86400*30)). " ay önce";
            else  return round($sure/(86400*365)). " yıl önce";
            }
//!defined("guvenlik") ? die("Bu sayfaya erişim yasaklanmıştır.") : NULL;
!defined("guvenlik") ? header("location: /index.php") : true;
include("./includes/fonksiyonlar.php") ?>
<?php
$yer = @$_GET['yer'];
switch($yer)
		{
				case "yeni":
					if(isset($_SESSION['karakter'])){ 
							if(isset($_POST['yanitla']))
							{
								if(empty($_POST['yanit']))
								{
									echo '<div class="alert alert-dismissable alert-warning">
											  <button type="button" class="close" data-dismiss="alert">×</button>
											  <h4>Hata!</h4>
											  <p>Boş Destek Mesajı Gönderemezsiniz.</p>
											</div>';
								}
								elseif(empty($_POST['konu']))
								{
									echo '<div class="alert alert-dismissable alert-warning">
											  <button type="button" class="close" data-dismiss="alert">×</button>
											  <h4>Hata!</h4>
											  <p>Konu Başlığı Girmelisiniz</p>
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
									$ekle_sql = mysql_query("INSERT INTO destek_sistemi (uid,urun,konu,aciliyet) values('".$_SESSION['id']."','".duzelt($_POST['urun'])."','".nl2br(duzelt($_POST['konu']))."','".duzelt($_POST['aciliyet'])."')");
									$mesajid = mysql_insert_id();
									if($ekle_sql) {
										$ekle_sql2 = mysql_query("INSERT INTO destek_mesaji (destek_id,yanit,yanitlayan) values('".$mesajid."','".nl2br(duzelt($_POST['yanit']))."','".$_SESSION['id']."')");
										if($ekle_sql2)
										{
											echo '<div class="alert alert-dismissable alert-info">
												  <button type="button" class="close" data-dismiss="alert">×</button>
												  <h4>Destek Mesajı Oluşturuldu!</h4>
												  <p>Bildirimi Görüntülemek için <a href="destek-mesaj-'.$mesajid.'.html">Tıklayınız</a></p>
												</div>';
										}
										else {
											echo '<div class="alert alert-dismissable alert-warning">
											  <button type="button" class="close" data-dismiss="alert">×</button>
											  <h4>Hata!</h4>
											  <p>Bir Hata Oluştu</p>
											</div>';
										}
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
							echo '
								<div class="panel panel-success">
								  <div class="panel-heading">
									<h3 class="panel-title">Yeni Bildirim Gönder</h3>
									</div>
									<div class="panel-body">
									<form action="" method="POST">
									<select name="urun" class="form-control" style="width: 45%;float:left;">
										<option value="0">Konuyla İlgili Ürünü Seçiniz</option>';
										$urunlerSql = mysql_query("SELECT * FROM uye_urunleri WHERE uye_Id='".$_SESSION['id']."'");
										while($cekUrunu = mysql_fetch_array($urunlerSql)) {
											$urunSql = mysql_query("SELECT * FROM urun_satis WHERE id='".$cekUrunu['id']."'");
											$cekUrun = mysql_fetch_array($urunSql);
											echo '<option value="'.$cekUrunu['id'].'">'.$cekUrun['urun_adi'].'</option>';
										}
									echo '</select><select name="aciliyet" class="form-control" style="width: 45%;float:right;">
										<option value="0">Destek Aciliyeti</option>
										<option value="0">Düşük</option>
										<option value="1">Orta</option>
										<option value="2">Yüksek</option>
											</select><br><br><br>
									<input type="text" class="form-control" name="konu" placeholder="Destek Başlığını Giriniz" /><br>
									<textarea class="form-control" rows="5" name="yanit" placeholder="Destek mesajınızı yazınız.."></textarea><br>
									<center><input type="submit" class="btn btn-success" name="yanitla" value="Yanıtla"></center>
									</form>
								  </div>
								</div>
								';
						}
				
				break;
				
				case "":
					if(isset($_SESSION['karakter'])){ 

									$ozelmesaj = mysql_query("SELECT * FROM destek_sistemi WHERE uid='".$_SESSION['id']."'"); 
											echo '
											<table width="100%" height="76" border="1" cellpadding="0" align="center" cellspacing="0" class="table table-striped table-hover ">
											  <tr class="info">
												<th height="23" colspan="3" align="center" width="75%"><strong>Destek Mesajları</strong></th>
												<th align="right"><div style="float:right"><a href="destek-yeni-mesaj.html" class="buton">Yeni Destek Mesajı Gönder</a></div></th>
											  </tr> ';
					if(mysql_num_rows($ozelmesaj) > 0)
							{
									while ($mesajRow = mysql_fetch_array($ozelmesaj)) 
											{ 
													$mid = $mesajRow['id']; 
													$konu = $mesajRow['konu'];
													if($mesajRow['urun'] == 0)
													{
														$urun = "Ürün Seçilmedi";
													} else {
														$urunbil = mysql_query("SELECT * FROM urun_satis WHERE id='".$mesajRow['urun']."'"); 
														$urunbilgi = mysql_fetch_array($urunbil);
														$urun = $urunbilgi['urun_adi'];
													}
													$aciliyetBak = $mesajRow["aciliyet"];
													$durum = $mesajRow["durum"];
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
													echo '
												<tr>
													<td width="35%" height="51" >'.$konu.'</td>
													<td>'.$ddurum.'</td>
													<td>'.$urun.'</td>
													<td width="300" align="right"><a href="destek-mesaj-'.$mid.'.html" class="btn btn-primary btn-sm">Oku</a> <a href="destek-kapat-'.$mid.'.html" class="btn btn-primary btn-sm">Kapat</a></td>
												  </tr>';
											 }
							}
							else {
							
							echo '<tr><td align="center" colspan="5">Yeni Mesajınız Bulunmamaktadır.</td></tr>';
							
							}
							
								echo '</table>';
								} else {
									header("Location: index.html");
								}
					break;

					case "mesaj":
						$mesajid = $_GET['id'];
						if(isset($_SESSION['karakter'])){ 
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
										$ekle_sql = mysql_query("INSERT INTO destek_mesaji (destek_id,yanit,yanitlayan) values('".$mesajid."','".nl2br(duzelt($_POST['yanit']))."','".$_SESSION['id']."')");
										if($ekle_sql) {
											mysql_query("UPDATE destek_sistemi SET durum=1 WHERE id='".$mesajid."'");
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
								$destekSql = mysql_query("SELECT * FROM destek_sistemi WHERE id='".$mesajid."' AND uid='".$_SESSION['id']."'"); 
								$cekDestek = mysql_fetch_array($destekSql);
								if($_SESSION['id'] == $cekDestek['uid'])
								{
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
											<td><a href="destek-kapat-'.$cekDestek['id'].'.html" class="btn btn-danger btn-sm">Destek Mesajını Kapat</a></td>
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
											<h3 class="panel-title">'.$yanitiveren.'</h3><b style="float:right;top: -25;position: relative;">'.$tarih.'</b>
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
								}else {
									header("Location: destek.html");
								}	
							}else {
									header("Location: index.html");
							}
				break;
				
				case "kapat":
					if(isset($_SESSION['karakter']))
					{ 
						$silinecek = $_GET['id'];
						$silmekontrol = mysql_query("SELECT * FROM destek_sistemi WHERE uid=".$_SESSION['id']."");
						$silme = mysql_fetch_array($silmekontrol);
						if($_SESSION['id'] != $silme['uid'])
						{
							echo '<script language="JavaScript">
									alert("Hackmi yapmaya çalışıyorsun genç?.") 
								</script>';
							header("refresh: 0; url=destek.html");

						}
						else {
							$mesaj_sil = mysql_query("UPDATE destek_sistemi SET durum='3' WHERE id='".$silinecek."'");
							if($mesaj_sil)
							{
								echo '<script language="JavaScript">
										alert("Destek Mesajı Kapatıldı.") 
									</script>';
								header("refresh: 0; url=destek.html");
							}
							else 
							{
								echo '<script language="JavaScript">
										alert("Hata") 
										</script>';
								header("refresh:1;");
							}
						}
					}
				else {
							header("Location: index.html");
						}
				break;
				
		}
?>