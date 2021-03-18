<?php
!defined("guvenlik") ? die("Bu sayfaya erişim yasaklanmıştır.") : NULL;
	function temizle($text)
	{
		$g_karakter    = array("'");
		$c_karakter    = array("&#39;");

		$degisen = str_replace($g_karakter, $c_karakter, $text);
		return $degisen;
	}
	$ayarlar = mysql_query("SELECT * FROM ayarlar");
	$listele = mysql_fetch_array($ayarlar);
		echo '
		<table align="center" border="0">
		<form action="" method="post">
			<tr align="center">
				<td colspan="2">
				<b>Site Genel Ayarları</b>
				</td>
			</tr>
			<tr align="center">
				<td>
				<b>Site Başlığı : </td><td><input type="text" class="form-control" name="title" value="'.$listele["title"].'" size="50">
				</b>
				</td>
			</tr>
			<tr align="center">
				<td>
				<b>Sistem Domain : </td><td><input type="text" class="form-control" name="link" value="'.$listele["site_link"].'" size="50">
				</b>
				</td>
			</tr>
			<tr align="center">
				<td>
				<b>Admin Şifresi : </td><td><input type="password" class="form-control" name="acpsifre" value="" size="50"></b>
				</td>
			</tr>
			<tr align="center">
				<td>
				<b>Sosyal Ağ (Facebook)</td><td><input type="text" class="form-control" name="facebook" value="'.$listele["facebook"].'" size="50"></b>
				</td>
			</tr>
			<tr align="center">
				<td>
				<b>Sosyal Ağ (Twitter)</td><td><input type="text" class="form-control" name="twitter" value="'.$listele["twitter"].'" size="50"></b>
				</td>
			</tr>
			<tr align="center">
				<td>
				<b>Sosyal Ağ (Google)</td><td><input type="text" class="form-control" name="google" value="'.$listele["google"].'" size="50"></b>
				</td>
			</tr>
			<tr align="center">
				<td>
				<b>Sosyal Ağ (Youtube)</td><td><input type="text" class="form-control" name="youtube" value="'.$listele["youtube"].'" size="50"></b>
				</td>
			</tr>
			<tr align="center">
				<td>
				<b>Google Analytics Kodu</td><td><textarea name="analytics" class="form-control" rows="7">'.$listele["analytics"].' </textarea></b>
				</td>
			</tr>

			<tr align="center">
				<td>
				<b>Tema Seçimi : </td><td>
				
				<select name="tema" class="form-control">
				';
					$dizin = opendir('./../temalar');
					while($dosya = readdir($dizin)) {
						if($dosya != "." && $dosya != ".." && $dosya != "index.php") {
							echo "<option value='".$dosya."' ";
							if($listele["tema"] == $dosya) { echo 'selected'; }
							echo ">".$dosya."</option>"; 
						}
					}
				echo '</select></b>
				</td>
			</tr>
			<tr align="center">
				<td colspan="2">
				<b><input type="submit" name="gonder" class="btn btn-outline btn-success" value="Site Ayarlarını Kaydet"></b>
				</td>
			</tr>
			</form>
		</table>';
		
		if(isset($_POST['gonder']))
			{
				$title = $_POST['title'];
			
				$facebook = $_POST['facebook'];
				$twitter = $_POST['twitter'];
				$google = $_POST['google'];
				$youtube = $_POST['youtube'];
				$tema = $_POST['tema'];
				$acpsifrey = $_POST['acpsifre'];			
				$acpsifre = md5($_POST['acpsifre']);			
				$link = $_POST['link'];			
				$analytics = $_POST['analytics'];			
				
				$ekle_sql =  mysql_query("UPDATE ayarlar SET analytics='".temizle($analytics)."',site_link='$link',title='$title',facebook='$facebook',twitter='$twitter',google='$google',youtube='$youtube',tema='$tema',acpsifre='$acpsifre' WHERE id='1'");
					
					if(empty($acpsifrey))
					{
					echo 'Admin Paneli Şifresi Girmediniz';
					}
					elseif($ekle_sql)
			   {
				   //proje veritabanına kaydedilip proje dosyası ve resimler klasöre taşınınca özellik ekleme sayfasına yönlendiriliyor.
				   echo "Site Ayarları Başarıyla Güncellendi.";
				  // 	@session_destroy();
				   header("refresh: 2; url=index.php");
			   }
			   else
			   {
				   echo "Site Ayarları Kaydedilemedi... Tekrar Denemeniz için Yönlendiriliyorsunuz...";
				   header("refresh: 2; url=index.php?admin=ayarlar");
			   }
			}
			
				echo '
		<table align="center" border="0">
		<form action="" method="post">
			<tr align="center">
				<td colspan="2">
				<b>Site Meta Ayarları</b>
				</td>
			</tr>
			<tr align="center">
				<td>
				<b>Meta Tags </td><td><input class="form-control" type="text" name="tag" value="'.$listele["metatag"].'" size="50"></b>
				</td>
			</tr>
			<tr align="center">
				<td>
				<b>Meta Tanım </td><td><input class="form-control" type="text" name="tanim" value="'.$listele["metatanim"].'" size="50"></b>
				</td>
			</tr>
			<tr align="center">
				<td>
				<b>Meta Author</td><td><input class="form-control" type="text" name="author" value="'.$listele["metaauthor"].'" size="50"></b>
				</td>
			</tr>
			<tr align="center">
				<td colspan="2">
				<b><input type="submit" name="gonder2" class="btn btn-outline btn-success" value="Meta Ayarlarını Kaydet"></b>
				</td>
			</tr>
			</form>
		</table>';
		
				if(isset($_POST['gonder2']))
			{
				$tanim = $_POST['tanim'];
				$tag = $_POST['tag'];
				$author = $_POST['author'];				
				
				$ekle_sql2 =  mysql_query("UPDATE ayarlar SET metatanim='$tanim', metatag='$tag', metaauthor='$author' WHERE id='1'");
					
					if($ekle_sql2)
			   {
				   echo "Site Ayarları Başarıyla Güncellendi.";
				  // 	@session_destroy();
				   header("refresh: 2; url=index.php");
			   }
			   else
			   {
				   echo "Site Ayarları Kaydedilemedi... Tekrar Denemeniz için Yönlendiriliyorsunuz...";
				   header("refresh: 2; url=index.php?admin=ayarlar");
			   }
			}
		
?>