<?php
!defined("guvenlik") ? die("Bu sayfaya erişim yasaklanmıştır.") : NULL;
include("./ayarlar/veritabani.php");
include("./includes/fonksiyonlar.php") ?>
<?php

$yazilar = temizledegel(@$_GET['yazi']);
function sqlinj($variable)
{
$search = array("'","select","delete","union");
$replace = array("`","\select","\delete","\union");
return str_replace($search, $replace, $variable);
}

function duzelt($text)
{
					 
	$g_karakter    = array("&#39;","<code style>","</code>");
    $c_karakter    = array("'","<div class='code'><code class='code'>","</code></div>");
    
	
	
    $degisen = str_replace($g_karakter, $c_karakter, $text);
    return $degisen;
}
function duzelt2($text)
{
					 
	$g_karakter    = array("'","<",">","-","&#60;","&#62;");
    $c_karakter    = array("&#39;","","&#45;","","");
    
	
	
    $degisen = str_replace($g_karakter, $c_karakter, $text);
    return $degisen;
}
	 function post_time($tarih, $simdi=null)
        {
            //aradan geçen süreyi bul
            if(!$simdi) $simdi=time();
            $sure=$simdi-strtotime($tarih);
 
            //eğer geçen süre negatif ise boş metin döndür.
            if($sure<0) return date("Y-m-d",strtotime($tarih));
 
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
function karaktersil($text)
{
					 
	$g_karakter    = array("'",":D",":)",":(",":&#39;(",":P","&#45;","[url]","[/url]","[img]","[/img]");
    $c_karakter    = array("&#39;","<img src='./includes/adm/emoticons/grin.png'>","<img src='./includes/adm/emoticons/smile.png'>","<img src='./includes/adm/emoticons/sad.png'>","<img src='./includes/adm/emoticons/cwy.png'>","<img src='./includes/adm/emoticons/tongue.png'>","-","<a href=\"","\" target=\"_blank\"><u>[LİNK]</u></a>","<img src=\"","\" width=\"150px\">");
    
	
	
    $degisen = str_replace($g_karakter, $c_karakter, $text);
    return $degisen;
}
function karaktersil2($text)
{
					 
	$g_karakter    = array("'",":D",":)",":(",":&#39;(",":P","&#45;","[url]","[/url]","[img]","[/img]");
    $c_karakter    = array("&#39;","","","","","","-","","","","");
    
	
	
    $degisen = str_replace($g_karakter, $c_karakter, $text);
    return $degisen;
}
switch ($yazilar){
    case "":
$sayfa = temizledegel(@$_GET['s']);
if($sayfa < 1){
$baslangic = 0;
}else{
$baslangic = (($sayfa-1)*4);
}
$sirala = mysql_query("SELECT * FROM blog ORDER BY id DESC LIMIT $baslangic, 4");
                                         
                              echo '<table width="100%">
		<tr cellpacing="0" cellpadding="0"><td>';	   
$sira = $baslangic+1;
$bol = 0;
while ($bul = mysql_fetch_array($sirala)){
$id = $bul["0"]; 
$yorumsql = mysql_query("SELECT * FROM blog_yorumlar WHERE yazi_id=$id AND onay=1");
$yorumsayisi = mysql_fetch_array($yorumsql);
$resim = $bul["5"]; 
$aciklama = $bul["2"];
$ad = $bul["7"];
$okunma = $bul["okunma"];
$tarih = $bul["tarih"];
$sira = $sira+1;
$yorum = mysql_num_rows($yorumsql);
thumbnail_olustur('includes/admin/ProjeResimler/'.$resim.'','thumbs/250x100'.$resim.'',250, 100);

$ad2 = sef_link($ad);
echo '
<fieldset>
<legend>';
            $simdi=time();
            $sure = $simdi-strtotime($tarih);
if( $sure < 86400*7)
{
echo ''.$ad.'<sup><font color="red">Yeni</font></sup>';
}
else
{
echo ''.$ad.'<sub><font color="gray">Eski</font></sub>';
}
echo '</legend>
<table width="100%">
<tr>
<td rowspan="2" class="kucuk-cihaz" align="left" width="120px">
<img src="thumbs/250x100'.$resim.'" width="250px" height="100px" border="1px" bgcolor="black">
</td>
<td colspan="2">
<b><font size="2px"> &nbsp;&nbsp;&nbsp;&nbsp;'.$aciklama.'</font></b><a href="blog-'.$id.'-'.$ad2.'.html" class="btn btn-info" style="float:right;">Yazıyı Oku</a>
</td>
</tr>
<tr>
<td valign="bottom">

</td>
<td align="right" valign="bottom">
Okunma : '.$okunma.' | Tarih : '.post_time($tarih).' | Yorum : '.$yorum.'

</td>
</tr>
</table>
</fieldset><br>';
$bol++;	  
}
echo '</td></tr></table>';
echo '
<table align="center"><tr><td align="center" colspan="3">';

function sayfala($sayfa){
$sayfa = temizledegel(@$_GET['s']);
$sqltoplamkisi =  mysql_query("SELECT * FROM blog"); 
$toplamkisi = mysql_num_rows($sqltoplamkisi );
if($sayfa >= 2){
echo '<li><a href="blog-'.($sayfa-1).'.html">Önceki Sayfa</a></li> ';
}
else {
echo '<li class="disabled"><a>Önceki Sayfa</a></li> ';

}
for ($j = 1; $j <= ceil($toplamkisi /5); $j++){
if($sayfa == $j){
echo '<li class="active"><a>'.$sayfa.'</a></li>';
}else{
echo '<li><a href="blog-'.$j.'.html">'.$j.'</a></li>';
}
}

if($sayfa < ceil($toplamkisi /5)){
echo '<li><a href="blog-'.($sayfa+1).'.html" >Sonraki Sayfa</a></li>';
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

    case $yazilar:
    Listele($yazilar);
	break;


}

function Listele ($gelenId)
{

		$vericek123123123 = mysql_query("SELECT * FROM blog where id='$gelenId'");
		$bulid = mysql_fetch_array($vericek123123123);
		$blogid = $bulid["id"];
 
	if($gelenId == $blogid )
		{
			$vericek = mysql_query("SELECT * FROM blog where id=$gelenId");
			$bul = mysql_fetch_array($vericek);
			$yorumcek = mysql_query("SELECT * FROM blog_yorumlar where yazi_id=$gelenId and onay='1' ORDER by tarih DESC");
			$id = $bul["0"]; 
			$yazi = $bul["1"]; 
			$k_aciklama = $bul["2"];
			$tarih = $bul["3"];
			$durum = $bul["4"];
			$o_gorsel = $bul["5"];
			$okunma = $bul["6"];
			$yaziadi = $bul['blog_adi'];
			$kategoribulsql = mysql_query("SELECT * FROM kategoriler WHERE id = '".$bul['kat_Id']."'");
			$katbul = mysql_fetch_array($kategoribulsql);
			$kategori = $katbul['ad'];
			mysql_query("UPDATE blog SET okunma=okunma+1 WHERE id='".$id."'");
			echo '<table border="0" height="100%" class="blok" width="100%" align="center">
			<tr valign="top">
			<td colspan="3">
			<div class="panel panel-success bilgilendirme" style="float:right;">
			  <div class="panel-heading">
				<h3 class="panel-title">Yazı Hakkında</h3>
			  </div>
			  <div class="panel-body">
			  <img src="includes/admin/ProjeResimler/'.$o_gorsel.'" border="0" width="200"><br>
			  <table width="100%" align="center">
				<tr>
					<td align="center" width="75px">Tarih</td><td>:</td><td align="center">'.post_time($tarih).'</td>
				</tr>
				<tr>
					<td align="center" width="75px">Okunma</td><td>:</td><td align="center">'.$okunma.'</td>
				</tr>
				<tr>
					<td align="center" width="75px">Kategori</td><td>:</td><td align="center">'.$kategori.'</td>
				</tr>
			  </table>
			  </div>
			</div>
			'.duzelt($yazi).'
			</td>
			</tr>
			<tr>
			<td colspan="3"><br>';
			//Yeni Yorum Yaz
			if(isset($_SESSION['kadi']))
			{
				echo '
				<div class="panel panel-info">
				  <div class="panel-heading">
					<h3 class="panel-title" style="cursor: pointer;" onclick="yorum.style.display=\'\';yorumac.style.display=\'none\';yorumkapat.style.display=\'\';" name="yorumac" id="yorumac">Yeni Yorum Yaz (Açmak için Tıklatın)</h3>
					<h3 class="panel-title" style="cursor: pointer;display:none;" onclick="yorum.style.display=\'none\';yorumac.style.display=\'\';yorumkapat.style.display=\'none\';" name="yorumkapat" id="yorumkapat">Yeni Yorum Yaz (Kapatmak için Tıklatın)</h3>
				  </div>
				  <div class="panel-body" style="display:none;" name="yorum" id="yorum">
					<table align="center">
						<tr align="center">
						<td align="center" colspan="2"><font size=2><center><b>Yorumlarınızda Gülücükler Kullanabilirsiniz : " :) - :D - :P - :( - :&#39;( "<br>
						BBCode olarak ise "[url]linkiniz[/url] ve [img]resim linkiniz[/img]"<br>
						Ancak Tag Kullanımı Yasaktır. ( < - > )</b></center></font></td>
						</tr>
						<tr align="center">
						<form action="" method="post">
						<td align="center" colspan="2"><center>
							<b><font color="red">'.$_SESSION['kadi'].'</font> olarak giriş yaptınız. Yorumda Bu isminiz görüntülenecektir.<br>
						</td>
						</tr>
						<tr align="center">
						<td  align="center">
						<center><textarea name="yorum" class="form-control" style="width:494px;height:150px;resize:none;" placeholder="Yorumunuz - Yorumlarınızda Gülücükler ve URL - IMG BBCode larını kullanabilirsiniz."></textarea></center>
						</td>
						<td>
						-Yorumlarda Argo İçerikli Kelimeler Kullanmak Yasaktır.<br>
							-Yorumlarda Kişiye Hakaret içerikli sözcükler kullanmak yasaktır<br>
							-Yorumlarda Harici Sitelere Yardım dışı Reklam amaçlı link vermek yasaktır.<br>
							-Yorumlarda Gereksiz Yazılar yasaktır.<br>
							-Yorumlarda Onaylanma Süresi 1 ile 24 saattir..<br>
						</td>
						</tr>
						  <tr >
						  <td></td>
							<td >
							<label><input type="checkbox" name="L1" id="L1" onclick="Goster(\'btn1\')"/> Kuralları okudum ve Anladım. Kabul Ediyorum</label>		
							</td>
						  </tr>
							<tr>
							<td></td>
						<td align="center">
						<input type="submit" value="Yorum Yap" id="btn1" class="btn btn-primary" style="display:none" name="gonder" />
						</td>
						</form>
						</tr>
					</table>
			  </div>
			</div>';
			}
			//Yorumları Listeleme
			echo '<br><div class="panel panel-success">
			<div class="panel-heading">
			<h3 class="panel-title">Yorumlar</h3>
		  </div>
		  <div class="panel-body">
			<table align="center" width="100%">
				';
				if(mysql_num_rows($yorumcek) > 0)
					{
					
					while($veri = mysql_fetch_array($yorumcek))
					{
						
						$uyeBilgi = mysql_query("SELECT id,nick,puan FROM uyeler where id=".$veri['uye_id']."");
						$veriUye = mysql_fetch_array($uyeBilgi);
						$uyekontrol = $veri['uye_id'];
						if($uyekontrol == 0)
						{
								echo '
								<tr><td colspan="4"><hr></td></tr>
								<tr>						
								<td class="golgeli" width="150px;">
								Yorumu Gönderen :</td><td><b> '.karaktersil2($veri["adsoyad"]).'</b></td><td class="golgeli" align="right">Gönderme Tarihi :</td><td align="right" width="180px;"> '.karaktersil2($veri["tarih"]).'</td>
								</tr>
								<tr>
								<td class="golgeli"><div id="yorum-'.$veri["id"].'">
								<b><a href="#yorum-'.$veri["id"].'"><font color="white">Yorum</font></a> : </td><td colspan="3">'.karaktersil($veri["yorum"]).'</b></div>
								</td>
								</tr>';
							}
						
						else {

								echo '
										<tr><td colspan="4"><hr></td></tr>
										<tr>						
										<td class="golgeli">
										Yorumu Gönderen :</td><td><font color="red"><b>'.$veriUye["nick"].' - <font color="gray" size="2">Puan : '.$veriUye["puan"].'</font></b></font></td><td class="golgeli">Gönderme Tarihi :</td><td> '.karaktersil2($veri["tarih"]).'</td>
										</tr>
										<tr>
										<td class="golgeli">
										<div id="yorum-'.$veri["id"].'">
										<b><a href="#yorum-'.$veri["id"].'"><font color="white">Yorum</font></a> :</td><td colspan="2" width="350px" align="center">'.karaktersil($veri["yorum"]).'</b></div>
										</td>
										<td>';
										$uyekontrolid = $veri['uye_id'];
										$uyekontrolid2 = $_SESSION['id'];
										if($uyekontrolid == $uyekontrolid2)
										{
												echo '<form action="" method="post">
														<input type="image" value="submit" src="resimler/sil.png" name="yorumsilid">
														</form>';
												if(isset($_POST['yorumsilid']))
												{
													$yorum_sil = mysql_query("DELETE FROM blog_yorumlar WHERE id='".$veri['id']."'");
														if($yorum_sil)
														{
																mysql_query("UPDATE uyeler SET puan=puan-1 WHERE id='".$uyekontrolid2."'");
																$yenipuan2 	= mysql_query("SELECT * FROM uyeler where id=$uyekontrolid2");
																$puanlama2		= mysql_fetch_array($yenipuan2);
																$toplampuan2 = $puanlama2['puan'];
																echo '<script language="JavaScript">
																		alert("Yorumunuz Silindi. Puanınız -1 Düşürülmüştür. \n Toplam Puanınız '.$toplampuan2.' olmuştur.") 
																	</script>';
																	header("refresh:2");
														}
														else 
														{
																echo '<script language="JavaScript">
																		alert("Hata") 
																		</script>';
																header("refresh:2");
														}
												}
										}
										else
										{
											echo '<form action="" method="post">
														<input type="image" value="submit" src="resimler/sikayet.png" name="yorumsikayet">
														</form>';
												if(isset($_POST['yorumsikayet']))
												{
																echo '<script language="JavaScript">
																		alert("Bu Sistem Yapım Aşamasındadır..") 
																		</script>';
																	header("refresh:2");
												}
										}
										
										
										echo '</td>
										</tr>';
							}
					}
				}
				else {
				echo '<tr><td aling="center" colspan="4">Bu yazıya henüz Yorum Yapılmamıştır.<hr></td></tr>';
				
				}
			
			if(isset($_SESSION['karakter']))
			{ 
				echo '
				</table>	
		  </div>
		</div>';


			echo '</td>
				</td>
				</table>';
				if(isset($_POST['gonder']))
						{	
							$uyeid		=	$_SESSION['id'];
							$bilgicek2 	= mysql_query("SELECT * FROM blog where id=$gelenId");
							$row 		= mysql_fetch_array($bilgicek2);
							$bilgicek22 	= mysql_query("SELECT * FROM uyeler where id=$uyeid");
							$row2		= mysql_fetch_array($bilgicek22);
							$kadi 		= $_SESSION['kadi'];
							$yorum 	= sqlinj($_POST['yorum']);
							$kural		= sqlinj($_POST['L1']);
							$blogid	= 	$row['id'];
							
						if($yorum == "")
								{
								echo 'Tüm Alanları Doldurunuz.';
								}
						elseif(!isset($kural))
								{
								echo 'Kuralları Kabul Etmediniz..';
								}
						elseif(!$gelenId == $blogid)
								{
								echo 'Yorum Eklenirken hata oluştu....';
								}
							else {
							   $ekle_sql = mysql_query("INSERT INTO blog_yorumlar(adsoyad,yorum,yazi_id,uye_id,onay) values('".$kadi."','".duzelt2($yorum)."','".$gelenId."','".$uyeid."','1')");
									 if($ekle_sql)
							   {
								mysql_query("UPDATE uyeler SET puan=puan+1 WHERE id='".$uyeid."'");
							$yenipuan 	= mysql_query("SELECT * FROM uyeler where id=$uyeid");
							$puanlama		= mysql_fetch_array($yenipuan);
									$toplampuan = $puanlama['puan'];
									echo '
									<script language="JavaScript">
										alert("Tebrikler! Yorumunuz için 1 Puan Kazandınız! \n Toplam Puanınız '.$toplampuan.' olmuştur.")
									</script>';
								   echo "Yorumunuz Kaydedildi..";
								   header("refresh:2");
							   }
							   else
							   {
								   echo "Yorum Eklenemedi. Tekrar Deneyin";
								   header("refresh:2");
							   }
						   }
						}
			}
			else
			{
				echo '
				</table>
				</fieldset>
				</td>
				</td>
				</tr>
				<tr align="center">
				<td align="center" colspan="3" >
				<center>
					Yorum yazmak için <u><b>Üye Olmalısınız.</b></u>
				</center>
				</td>
				</tr>
				</table>';
				
				if(isset($_POST['gonder']))
					{	
									$bilgicek = mysql_query("SELECT * FROM blog where id=$gelenId");
									$row = mysql_fetch_array($bilgicek);
									$adsoyad = sqlinj($_POST['adsoyad']);
									$email = sqlinj($_POST['email']);
									$yorum = sqlinj($_POST['yorum']);
									$kural = sqlinj($_POST['L1']);
									$blogid = 	$row['id'];
						if($adsoyad == "")
								{
								echo 'Tüm Alanları Doldurunuz.';
								}
						elseif($email == "")
								{
								echo 'Tüm Alanları Doldurunuz.';
								}
						elseif($yorum == "")
								{
								echo 'Tüm Alanları Doldurunuz.';
								}
						elseif(!isset($kural))
								{
								echo 'Kuralları Kabul Etmediniz..';
								}
						elseif(!$gelenId == $blogid)
								{
								echo 'parametre hatası';
								}
							else {
							   $ekle_sql = mysql_query("INSERT INTO blog_yorumlar(adsoyad,email,yorum,yazi_id) values('".duzelt2($adsoyad)."','".duzelt2($email)."','".duzelt2($yorum)."','$gelenId')");
									 if($ekle_sql)
							   {
								   echo "Yorumunuz Kaydedildi..";
								   header("refresh: 2; url=index.php");
							   }
							   else
							   {
								   echo "Yorum Eklenemedi. Tekrar Deneyin";
								   header("refresh: 2; url=index.php");
							   }
							   }
					}
			}
		}
	else
		{
			echo "Parametre Hatası! Blog Sayfasına Yönlediriliyorsunuz...";
			header("refresh: 2; url=blog-1.html");
		}
	}	


?>