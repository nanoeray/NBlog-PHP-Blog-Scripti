<?php
!defined("guvenlik") ? die("Bu sayfaya erişim yasaklanmıştır.") : NULL;

error_reporting(0);
echo '<META http-equiv=content-type content=text/html;charset=utf8>';
echo '<style type="text/css">
body { background: url(http://files.customize.org/thumbnails/larger/61440.jpg); }
input[type=submit]:hover {
background: rgb(226,226,226);
background: -moz-linear-gradient(top, rgba(226,226,226,1) 0%, rgba(244,244,244,1) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(226,226,226,1)), color-stop(100%,rgba(244,244,244,1)));
background: -webkit-linear-gradient(top, rgba(226,226,226,1) 0%,rgba(244,244,244,1) 100%);
background: -o-linear-gradient(top, rgba(226,226,226,1) 0%,rgba(244,244,244,1) 100%);
background: -ms-linear-gradient(top, rgba(226,226,226,1) 0%,rgba(244,244,244,1) 100%);
background: linear-gradient(top, rgba(226,226,226,1) 0%,rgba(244,244,244,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#e2e2e2\', endColorstr=\'#f4f4f4\',GradientType=0 );
border: 1px solid #ccc;
border-radius: 4px;
-moz-border-radius: 4px;
-webkit-border-radius: 4px;
text-decoration: none;
}
input[type=submit] {
display: block;
font-size: 0.8em;
color: #979797;
text-shadow: 0 1px 0 #FFFFFF;
background: rgb(244,244,244);
background: -moz-linear-gradient(top, rgba(244,244,244,1) 0%, rgba(226,226,226,1) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(244,244,244,1)), color-stop(100%,rgba(226,226,226,1)));
background: -webkit-linear-gradient(top, rgba(244,244,244,1) 0%,rgba(226,226,226,1) 100%);
background: -o-linear-gradient(top, rgba(244,244,244,1) 0%,rgba(226,226,226,1) 100%);
background: -ms-linear-gradient(top, rgba(244,244,244,1) 0%,rgba(226,226,226,1) 100%);
background: linear-gradient(top, rgba(244,244,244,1) 0%,rgba(226,226,226,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#f4f4f4\', endColorstr=\'#e2e2e2\',GradientType=0 );
border: 1px solid #ccc;
border-radius: 4px;
-moz-border-radius: 4px;
-webkit-border-radius: 4px;
padding: 0px 8px 0 8px;
margin-left: 12px;
text-transform: uppercase;
cursor: pointer;
min-width:100px;
height:30px;
}
a:hover {
background: rgb(226,226,226);
background: -moz-linear-gradient(top, rgba(226,226,226,1) 0%, rgba(244,244,244,1) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(226,226,226,1)), color-stop(100%,rgba(244,244,244,1)));
background: -webkit-linear-gradient(top, rgba(226,226,226,1) 0%,rgba(244,244,244,1) 100%);
background: -o-linear-gradient(top, rgba(226,226,226,1) 0%,rgba(244,244,244,1) 100%);
background: -ms-linear-gradient(top, rgba(226,226,226,1) 0%,rgba(244,244,244,1) 100%);
background: linear-gradient(top, rgba(226,226,226,1) 0%,rgba(244,244,244,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#e2e2e2\', endColorstr=\'#f4f4f4\',GradientType=0 );
border: 1px solid #ccc;
border-radius: 4px;
-moz-border-radius: 4px;
-webkit-border-radius: 4px;
text-decoration: none;
}
a {
display: inline-block;
font-size: 0.8em;
color: #979797;
text-shadow: 0 1px 0 #FFFFFF;
background: rgb(244,244,244);
background: -moz-linear-gradient(top, rgba(244,244,244,1) 0%, rgba(226,226,226,1) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(244,244,244,1)), color-stop(100%,rgba(226,226,226,1)));
background: -webkit-linear-gradient(top, rgba(244,244,244,1) 0%,rgba(226,226,226,1) 100%);
background: -o-linear-gradient(top, rgba(244,244,244,1) 0%,rgba(226,226,226,1) 100%);
background: -ms-linear-gradient(top, rgba(244,244,244,1) 0%,rgba(226,226,226,1) 100%);
background: linear-gradient(top, rgba(244,244,244,1) 0%,rgba(226,226,226,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#f4f4f4\', endColorstr=\'#e2e2e2\',GradientType=0 );
border: 1px solid #ccc;
border-radius: 4px;
-moz-border-radius: 4px;
-webkit-border-radius: 4px;
padding: 4px 8px 0 8px;
margin-left: 0px;
cursor: pointer;
min-width:60px;
height:20px;
text-decoration: initial;
}
.dis
{
margin: 0 auto;
background: lightblue; 
width: 60%; 
border: 3px solid black;
border-top: 0px solid black;
height:20px;
}
.ic
{
float:left;
margin-right: 10px;
margin-left: 4px;
}
</style>
<title>NBlog Kss v2.0 Kurulum</title>';
$go = @$_GET['kurulum'];
echo '<div style="margin: 0 auto; background: lightblue; width: 60%; border: 3px solid black;min-height:250px;"><center>';
switch($go)
{
	case "":
	echo '
	<div class="dis">
	<center>
	<div class="ic">Veritabanı Bilgileri <font color="red"><b>X</b></font></div>
	<div class="ic">Tabloları Oluştur <font color="red"><b>X</b></font></div>
	<div class="ic">Verileri Aktar <font color="red"><b>X</b></font></div>
	<div class="ic">Bitiş <font color="red"><b>X</b></font></div>
	</center>
	</div>';

		
	
		echo '
		<form action="" method="post">
		<table>
		<tr>
		<td>
        Host</td><td>:</td><td> <input type="text" value="localhost" name="host"/></td>
        </tr>
		<tr>
		<td>
        Kullanıcı Adı</td><td>:</td><td><input type="text" value="root" name="kullanici"/></td>
        </tr>
		<tr>
		<td>
        Şifre</td><td>:</td><td><input type="text" value="şifre" name="sifre"/></td>
        </tr>
		<tr>
		<td>
        Veritabanı Adı</td><td>:</td><td><input type="text" value="veritabanı" name="veritabani"/></td>
        </tr>

		<tr>
		<td colspan="3" align="right">
        <input type="submit" name="basla" value="Kuruluma Başla"/></td>
		</tr>
		</table>
		</form>';
		if(isset($_POST['basla']))
		{
	$host = $_POST['host'];
	$kullanici = $_POST['kullanici'];
	$sifre = $_POST['sifre'];
	$veritabani = $_POST['veritabani'];
	$prefix = $_POST['prefix'];

	$file_handle = fopen("ayarlar/veritabani.php", "w");
	$file_contents = '<?php
  $baglan = mysql_connect("'.$host.'","'.$kullanici.'","'.$sifre.'") or die("MYSQL Bağlantısı Yapılamıyor!");
  mysql_select_db("'.$veritabani.'",$baglan) or die("Veri tabanı bağlantısı yapılamıyor!");
  mysql_query("SET NAMES UTF8");
  $prefix = "'.$prefix.'";
?>';

	fwrite($file_handle, $file_contents);
	fclose($file_handle);
	print "Bilgiler Kaydedildi.<br><a href='?kurulum=tablolar'>Devam Et</a>";
	}
	
	break;

	case "tablolar":
		echo '<div class="dis"><center>
	
	<div class="ic">Veritabanı Bilgileri <font color="green"><b>?</b></font></div>
	<div class="ic">Tabloları Oluştur <font color="red"><b>X</b></font></div>
	<div class="ic">Verileri Aktar <font color="red"><b>X</b></font></div>
	<div class="ic">Bitiş <font color="red"><b>X</b></font></div>
	</center></div>';
	include("ayarlar/veritabani.php");
	$aktar = mysql_query("CREATE TABLE IF NOT EXISTS `ayarlar` (
							`id` int(11) NOT NULL,
							  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
							  `tema` varchar(255) NOT NULL,
							  `facebook` varchar(255) NOT NULL,
							  `twitter` varchar(255) NOT NULL,
							  `google` varchar(255) NOT NULL,
							  `youtube` varchar(255) NOT NULL,
							  `acpsifre` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
							  `metatag` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
							  `metatanim` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
							  `metaauthor` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
							  `site_link` varchar(255) NOT NULL,
							  `analytics` text NOT NULL,
							  `uyelik` int(11) NOT NULL
							) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
");
	if($aktar)
	{
		$aktar2 = mysql_query("CREATE TABLE IF NOT EXISTS `blog` (
								`id` int(11) NOT NULL,
								  `yazi` longtext CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
								  `k_aciklama` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
								  `tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
								  `durum` int(11) NOT NULL DEFAULT '0',
								  `o_gorsel` varchar(255) NOT NULL,
								  `okunma` int(11) NOT NULL DEFAULT '0',
								  `blog_adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
								  `kat_Id` int(11) NOT NULL DEFAULT '0'
								) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;
																							");
		if($aktar2)
		{
			$aktar3 = mysql_query("CREATE TABLE IF NOT EXISTS `blog_yorumlar` (
								`id` int(11) NOT NULL,
								  `onay` int(11) DEFAULT '0',
								  `adsoyad` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
								  `email` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
								  `yorum` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
								  `yazi_id` int(11) NOT NULL,
								  `tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
								  `uye_id` int(11) NOT NULL DEFAULT '0'
								) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;
																							");
			if($aktar3)
			{
				$aktar4 = mysql_query("CREATE TABLE IF NOT EXISTS `destek_mesaji` (
										`id` int(11) NOT NULL,
										  `destek_id` int(11) NOT NULL,
										  `yanit` longtext CHARACTER SET utf8 NOT NULL,
										  `yanitlayan` int(11) NOT NULL DEFAULT '0',
										  `tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
										) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;
										");
				if($aktar4)
				{
					$aktar5 = mysql_query("
					CREATE TABLE IF NOT EXISTS `destek_sistemi` (
					`id` int(11) NOT NULL,
					  `uid` int(11) NOT NULL,
					  `durum` int(11) NOT NULL,
					  `urun` int(11) NOT NULL DEFAULT '0',
					  `konu` varchar(255) CHARACTER SET utf8 NOT NULL,
					  `aciliyet` int(11) NOT NULL,
					  `tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

					");
					if($aktar5)
					{
						$aktar6 = mysql_query("CREATE TABLE IF NOT EXISTS `kategoriler` (
												`id` int(11) NOT NULL,
												  `ad` varchar(255) CHARACTER SET utf8 NOT NULL,
												  `aciklama` varchar(255) CHARACTER SET utf8 NOT NULL
												) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
																											");
						if($aktar6)
						{
						
							$aktar7 = mysql_query("CREATE TABLE IF NOT EXISTS `ozel_mesaj` (
												`id` int(11) NOT NULL,
												  `uyeid` int(11) NOT NULL,
												  `gonderenid` int(11) NOT NULL,
												  `mesaj` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
												  `konu` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
												  `tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
												  `durum` int(11) NOT NULL DEFAULT '0'
												) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;
												");
							if($aktar7)
							{
								$aktar8 = mysql_query("CREATE TABLE IF NOT EXISTS `proje` (
											`projeId` int(11) NOT NULL,
											  `projeAdi` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
											  `aciklama` longtext COLLATE utf8_turkish_ci NOT NULL,
											  `link` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
											  `demo` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
											  `rarpass` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
											  `boyut` varchar(10) COLLATE utf8_turkish_ci NOT NULL,
											  `resim1` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
											  `resim2` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
											  `uyeId` int(11) NOT NULL
											) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=13 ;
											");
								if($aktar8)
								{
									$aktar9 = mysql_query("CREATE TABLE IF NOT EXISTS `proje_ozellikleri` (
															`ozellikId` int(11) NOT NULL,
															  `ozellik` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
															  `tarih` varchar(15) COLLATE utf8_turkish_ci NOT NULL,
															  `projeId` int(11) NOT NULL
															) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=95 ;
															");
									if($aktar9)
									{
										$aktar10 = mysql_query("CREATE TABLE IF NOT EXISTS `urun_ozellikleri` (
																`ozellikId` int(11) NOT NULL,
																  `ozellik` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
																  `tarih` varchar(15) COLLATE utf8_turkish_ci NOT NULL,
																  `urunId` int(11) NOT NULL
																) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=66 ;
																");
										if($aktar10)
										{
											$aktar11 = mysql_query("CREATE TABLE IF NOT EXISTS `urun_satis` (
											`id` int(11) NOT NULL,
											  `urun_adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
											  `urun_aciklamasi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
											  `urun_fiyati` varchar(255) CHARACTER SET utf8 NOT NULL,
											  `stok_durumu` varchar(255) CHARACTER SET utf8 NOT NULL,
											  `resim` varchar(255) NOT NULL
											) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;
											");
											if($aktar11)
											{
												$aktar12 = mysql_query("CREATE TABLE IF NOT EXISTS `uyeler` (
												`id` int(11) NOT NULL,
												  `nick` varchar(255) NOT NULL,
												  `sifre` varchar(255) NOT NULL,
												  `ad` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
												  `soyad` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
												  `email` varchar(255) NOT NULL,
												  `d_tarih` varchar(255) NOT NULL,
												  `k_tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
												  `hakkinda` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
												  `puan` int(11) NOT NULL,
												  `durum` int(11) NOT NULL DEFAULT '0',
												  `avatar` varchar(255) NOT NULL DEFAULT 'resimler/avataryok.png',
												  `ip` int(11) NOT NULL
												) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;
												");
												if($aktar12)
												{
													$aktar13 = mysql_query("CREATE TABLE IF NOT EXISTS `uye_urunleri` (
																			`id` int(11) NOT NULL,
																			  `urun_Id` int(11) NOT NULL,
																			  `alimTarihi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
																			  `durum` int(11) NOT NULL DEFAULT '0',
																			  `uye_Id` int(11) NOT NULL
																			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;
																			");
													if($aktar13)
													{
														echo 'Tüm Tablolar Başarıyla Oluşturuldu.<br><a href="?kurulum=aktar">Devam Et</a>';
													}
													else { echo "Adım 13'te hata oluştu."; }
												} else { echo "Adım 12'de hata oluştu."; }
											} else { echo "Adım 11'de hata oluştu."; }
										} else { echo "Adım 10'da hata oluştu."; }
									} else { echo "Adım 9'da hata oluştu."; }
								} else { echo "Adım 8'de hata oluştu."; }									
							} else { echo "Adım 7'de hata oluştu."; }	
						} else { echo "Adım 6'da hata oluştu."; }
					} else { echo "Adım 5'te hata oluştu."; }
				} else { echo "Adım 4'te hata oluştu."; }	
			} else { echo "Adım 3'te hata oluştu."; }
		} else { echo "Adım 2'de hata oluştu."; }
	} else { echo "Adım 1'de hata oluştu."; }	
	break;
	
	case "aktar":
			echo '<div class="dis"><center>
	
	<div class="ic">Veritabanı Bilgileri <font color="green"><b>?</b></font></div>
	<div class="ic">Tabloları Oluştur <font color="green"><b>?</b></font></div>
	<div class="ic">Verileri Aktar <font color="red"><b>X</b></font></div>
	<div class="ic">Bitiş <font color="red"><b>X</b></font></div>
	</center></div>';
	include("ayarlar/veritabani.php");
		echo '
		<form action="" method="post">
		<table>
		<tr>
		<td>
        Site Başlığı (title)</td><td>:</td><td> <input type="text" value="NBlog Kss Powered by NBlog V2" name="title"/></td>
        </tr>
		<tr>
		<td>
        Meta Tags</td><td>:</td><td><input type="text" value="Nblog, nblog kss, nanoeray, eray tuğrul gül, blog, kişisel site" name="metatags"/></td>
        </tr>
		<tr>
		<td>
        Meta Desc (Site Tanımı)</td><td>:</td><td><input type="text" value="Nblog Kss v2.0 Kişisel Blog Scripti" name="metadesc"/></td>
        </tr>
		<tr>
		<td>
        iletişim mail</td><td>:</td><td><input type="text" value="info@sizinsiteniz.com" name="mail"/></td>
        </tr>
		<tr>
		<td>
        Panel Şifresi</td><td>:</td><td><input type="text" value="BirŞifreOluşturun" name="sifre"/></td>
        </tr>
		<tr>
		<td>
        Site Yazarı</td><td>:</td><td><input type="text" value="Eray Tuğrul Gül" name="author"/></td>
        </tr>
		<tr>
		<td colspan="3" align="right">
        <input type="submit" name="basla" value="Verileri Aktar"/></td>
		</tr>
		</table>
		</form>';
		if(isset($_POST['basla']))
		{	
	
			$sayfa_aktar = mysql_query("INSERT INTO `ayarlar` (`id`, `title`, `tema`, `facebook`, `twitter`, `google`, `youtube`, `acpsifre`, `metatag`, `metatanim`, `metaauthor`, `site_link`, `analytics`, `uyelik`) VALUES
									  (1, '".$_POST['title']."', 'darkly', 'http://www.facebook.com/eraytugrul', 'http://www.twitter.com/eraytugrul', 'https://plus.google.com/u/0/109905623891510967731/posts', 'http://youtube.com/nanoerayy', '".$_POST['sifre']."', '".$_POST['metatags']."', '".$_POST['metadesc']."', '".$_POST['author']."', 'localhost', '	<script>\r\n  (function(i,s,o,g,r,a,m){i[&#39;GoogleAnalyticsObject&#39;]=r;i[r]=i[r]||function(){\r\n  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),\r\n  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\r\n  })(window,document,&#39;script&#39;,&#39;//www.google-analytics.com/analytics.js&#39;,&#39;ga&#39;);\r\n\r\n  ga(&#39;create&#39;, &#39;UA-45217477-1&#39;, &#39;nanoeray.com&#39;);\r\n  ga(&#39;send&#39;, &#39;pageview&#39;);\r\n\r\n	</script>        ', 1);");
			if($sayfa_aktar)
			{
				
				$ayar_aktar = mysql_query("INSERT INTO `blog` (`id`, `yazi`, `k_aciklama`, `tarih`, `durum`, `o_gorsel`, `okunma`, `blog_adi`, `kat_Id`) VALUES
										(69, '<p>Yepyeni haliyle NBlog v2.0 1 yıl aradan sonra tamamlandı! Yaklaşık olarak 1 hafta önce tekrardan geliştirmeye başladığım NBlog Kss sisteminin 2. sürümünü nihayet tamamlamış bulunmaktayım. Peki Yeni Sürüm ile gelenler neler? Hemen inceleyelim;<br></p><p><span id=\"sceditor-end-marker\" class=\"sceditor-selection sceditor-ignore\" style=\"line-height: 0; display: none;\"> </span><span id=\"sceditor-start-marker\" class=\"sceditor-selection sceditor-ignore\" style=\"line-height: 0; display: none;\"> </span><br></p><p><b>Ürün Sistemi;</b></p><hr>Bu Sistem aslında ilk sürümde olacaktı ancak bazı aksaklıklardan dolayı eklememiştim ancak 2. sürümde çok fonksyonelli olarak sisteme eklemiş bulunmaktayım.<div><br></div><div><b>Kategori Sistemi</b></div><hr>İlk Sürümde olmayan büyük eksiklerden birisi. Blog yazılarının kategorilendirilmesi artık 2. sürüm ile mevcut.<div><br></div><div><b>Yeni Bootstrap Temalar</b></div><hr>İlk sürümü kend çabalarım ile tasarlamaya çalışsamda hem ziyaretçilerim hemde script kullanıcıları bu temalarımı beğenmemişti. Bende 2. sürümde bootstrap temalara geçmeye karar verdim.<div><br></div><div><b>Destek Sistemi</b></div><hr>Evet. Büyük yeniliklerden biriside destek sistemi. Artık iletişim bölümü yerine üyeler ister ürünleriyle ilgili isterlerse başka konularda destek almak için bu kısmı kullanarak bizimle iletişime geçebilirler.<div><br></div><div><b>Yeni Admin Paneli</b></div><hr>İlk sürümdeki basit admin panelinin bootstrap ile güçlendirilip yeniden tasarlanarak bazı ek özellikler ile modifiye ettiğim yeni hali.<div><br></div><div>Şimdilik yenilikler bu kadar. İleride 2.1 sürümünü çıkartmayı düşünürsem Forum sistemi eklemeyi düşünüyorum. Sağlıcakla Kalın. (ee indirme linki nerede? diye soracaksanız şu anda scripti paylaşmayı düşünmüyorum. Belki ileride ilk sürümü yaptığım gibi paylaşabilirim. )</div>', 'Yepyeni haliyle NBlog v2.0 1 yıl aradan sonra tamamlandı!', '2014-11-17 20:59:13', 0, 'ad1aee42344e7f7432abd116da321569546.png', 51, 'NBlog v2.0 Tamamlandı.', 0);");	
				if($ayar_aktar)
				{
					$aktar_kategori = mysql_query("INSERT INTO `kategoriler` (`id`, `ad`, `aciklama`) VALUES
												 (0, 'Genel', 'Genel Kategori');");
					if($aktar_kategori)
					{
					echo 'Tüm Veriler Başarıyla Aktarıldı.<br><a href="?kurulum=bitti">Devam Et</a>';
					}
				}
				else
				{
					echo 'Ayarlar aktarılırken bir hata oluştu.';
				}
			}
			else
			{
				echo 'Sayfalar aktarılırken bir hata oluştu.';
			}
		}
	break;
	
	case "bitti":
				echo '<div class="dis"><center>
	
	<div class="ic">Veritabanı Bilgileri <font color="green"><b>?</b></font></div>
	<div class="ic">Tabloları Oluştur <font color="green"><b>?</b></font></div>
	<div class="ic">Verileri Aktar <font color="green"><b>?</b></font></div>
	<div class="ic">Bitiş <font color="green"><b>?</b></font></div>
	</center></div>';
		echo 'Web siteniz başarıyla kurulmuştur. <br><br>Admin Paneli Kullanıcı Adı : admin<br>
		<br><a href="../index.php">Web Sitenizi Görüntüleyin</a> - <a href="../includes/admin/index.php">Admin Panelini Görüntüleyin</a>';
	unlink(".krlm");
	break;
}
echo '</div>';
?>