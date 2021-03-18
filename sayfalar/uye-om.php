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
				case "":
							if(isset($_SESSION['karakter'])){ 

									$ozelmesaj = mysql_query("SELECT * FROM ozel_mesaj WHERE uyeid='".$_SESSION['id']."'"); 
											echo '
											<table width="761" height="76" border="1" cellpadding="0" align="center" cellspacing="0" class="table table-striped table-hover ">
											  <tr class="info">
												<th height="23" colspan="2" align="center" width="75%"><strong>Özel Mesajlar</strong></th>
												<th align="right"><div style="float:right"><a href="yeni-mesaj.html" class="buton">Yeni Mesaj</a></div></th>
											  </tr> ';
					if(mysql_num_rows($ozelmesaj) > 0)
							{
									while ($mesajRow = mysql_fetch_array($ozelmesaj)) 
											{ 
													$mid = $mesajRow['id']; 
													$gonderen = $mesajRow['gonderenid']; 
													$tarihi = $mesajRow['tarih']; 
													$durum = $mesajRow['durum']; 
													$mesaj = $mesajRow['mesaj']; 
													$konu = $mesajRow['konu'];
													$gonderenbilg = mysql_query("SELECT * FROM uyeler WHERE id='".$gonderen."'"); 
													$gonderenbilgi = mysql_fetch_array($gonderenbilg);
													$gonderennick = $gonderenbilgi["nick"];
													echo '
												<tr>
													<td width="121" height="51" >'.$gonderennick.'</td>
													<td>'.$konu.'</td>
													<td width="300" align="right"><a href="uye-om-mesaj-'.$mid.'.html" class="btn btn-primary btn-sm">Oku</a> <a href="mesaj-sil-'.$mid.'.html" class="btn btn-primary btn-sm">Sil</a></td>
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
						if(isset($_SESSION['karakter'])){ 
						$mesajid = $_GET['id'];
						$ozelmesaj = mysql_query("SELECT * FROM ozel_mesaj WHERE uyeid='".$_SESSION['id']."' and id='".$mesajid."'"); 
						$mesajRow = mysql_fetch_array($ozelmesaj);
									mysql_query("UPDATE ozel_mesaj SET durum=1 WHERE uyeid='".$_SESSION['id']."' and id='".$mesajid."'");

								$mid = $mesajRow['id']; 
								$gonderen = $mesajRow['gonderenid']; 
								$tarih = $mesajRow['tarih']; 
								$durum = $mesajRow['durum']; 
								$mesaj = $mesajRow['mesaj']; 
								$konu = $mesajRow['konu'];
								$gonderenbilg = mysql_query("SELECT * FROM uyeler WHERE id='".$gonderen."'"); 
								$gonderenbilgi = mysql_fetch_array($gonderenbilg);
								$gonderennick = $gonderenbilgi["nick"];
								echo '
								<div class="panel panel-info">
								<div class="panel-heading">
									<h3 class="panel-title">Konu: '.$konu.' - Gönderen: '.$gonderennick.'</h3><b style="float:right;top: -25;position: relative;"><a href="mesaj-sil-'.$mid.'.html" class="btn btn-danger btn-sm">Sil</a> <a href="" class="btn btn-success btn-sm">Yanıtla</a></b>
								</div>
							  <div class="panel-body">
									'.$mesaj.'
								</div>
							</div>';
							}else {
									header("Location: index.html");
							}
				break;
				
				case "mesajsil":
					if(isset($_SESSION['karakter']))
					{ 
						$silinecek = @$_GET['sil'];
						$silmekontrol = mysql_query("SELECT * FROM ozel_mesaj WHERE uyeid=".$_SESSION['id']."");
						$silme = mysql_fetch_array($silmekontrol);
						$silme2 = mysql_fetch_array($silmekontrol2);
						if($_SESSION['id'] != $silme['uyeid'])
						{
							echo '<script language="JavaScript">
									alert("Hackmi yapmaya çalışıyorsun genç?.") 
								</script>';
							header("refresh: 0; url=uye-om-1.html");

						}
						else {
							$mesaj_sil = mysql_query("DELETE FROM ozel_mesaj WHERE id='".$silinecek."'");
							if($mesaj_sil)
							{
								echo '<script language="JavaScript">
										alert("Mesaj Silinmiştir.") 
									</script>';
								header("refresh: 0; url=uye-om-1.html");
							}
							else 
							{
								echo '<script language="JavaScript">
										alert("Hata") 
										</script>';
								header("refresh:1");
							}
						}
					}
				else {
							header("Location: index.html");
						}
				break;
				
				case "mesajgonder":
				if(isset($_SESSION['id'])){ 
				$uyeler = mysql_query("SELECT * FROM uyeler"); 
				if(isset($_POST['mgonder']))
				{
					$sql = mysql_query("SELECT * FROM uyeler WHERE nick='".$_POST['gidecek']."'");
					$kontrol = mysql_num_rows($sql);
					$sqlkim = mysql_fetch_array($sql);
					$kim = $sqlkim['id'];
					$gonderen = $_SESSION['id'];
					$konu = $_POST['konu'];
					$mesaj = $_POST['mesaj'];
					if(empty($_POST['gidecek']) || empty($gonderen) || empty($konu) || empty($mesaj))
					{
						 echo '<div class="alert alert-dismissable alert-danger " id="sonuc2">
						  <button type="button" class="close" data-dismiss="alert">×</button>
						  Tüm  Alanları Doldurmalısınız..</div>';
					}
					elseif($kim == $gonderen)
					{
						echo '<div class="alert alert-dismissable alert-danger " id="sonuc2">
						  <button type="button" class="close" data-dismiss="alert">×</button>
						  Kendinize Mesaj Gönderemezsiniz</div>';
					}
					elseif($kontrol == 0) {
						echo '<div class="alert alert-dismissable alert-danger " id="sonuc2">
						  <button type="button" class="close" data-dismiss="alert">×</button>
						  Geçerli Bir Kullanıcı Adı Giriniz</div>';
					}
					else {
								$ekle_sql = mysql_query("INSERT INTO ozel_mesaj(uyeid,gonderenid,konu,mesaj) values('".$kim."','".$gonderen."','".$konu."','".$mesaj."')");
								if($ekle_sql)
								{
									echo '
									<div class="alert alert-dismissable alert-success" id="sonuc">
									<button type="button" class="close" data-dismiss="alert">×</button>
									Mesajınız Başarıyla Gönderildi!
									</div>';
								}
								else {
									echo '<div class="alert alert-dismissable alert-danger" id="sonuc2">
									<button type="button" class="close" data-dismiss="alert">×</button>
									Mesajınızı Gönderirken Hata Oluştu.</div>';
								}
							}
				}
				echo '
				<form action="" method="post">
				<table align="center" width="60%" style="border-spacing: 2;border-collapse: separate;">
				<tr>
				<td>
				Gönderilecek Üye : <input type="text" class="form-control" name="gidecek" placeholder="Gönderilecek Üye">
				</td><td>Konu : <input type="text" class="form-control" name="konu" placeholder="Konu Başlığını Giriniz"></td>
				</tr>
				<tr>
				<td colspan="2"><textarea class="form-control" style="height:90px;resize:none;" name="mesaj" placeholder="Mesajınızı Buraya Giriniz."></textarea>
				</tr>
				<tr>
				<td colspan="2" align="center">
				<input type="submit" class="btn btn-primary" name="mgonder">
				</td>
				</tr>
				</table>
				</form>';
			
				}
				else {
						header("Location: index.html");
					}
			break;
		}
?>