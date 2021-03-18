		<link rel="stylesheet" href="./editor/minified/themes/modern.min.css" type="text/css" media="all" />
		<script src="./editor/minified/jquery.sceditor.bbcode.min.js"></script>
		<script src="./editor/languages/tr.js"></script>
		<script>
		
			// Source: http://www.backalleycoder.com/2011/03/20/link-tag-css-stylesheet-load-event/
			var loadCSS = function(url, callback){
				var link = document.createElement('link');
				link.type = 'text/css';
				link.rel = 'stylesheet';
				link.href = url;
				link.id = 'theme-style';
				
				document.getElementsByTagName('head')[0].appendChild(link);

				var img = document.createElement('img');
				img.onerror = function(){
					if(callback) callback(link);
				}
				img.src = url;
			}

			$(document).ready(function() {
				var initEditor = function() {
					$("textarea").sceditor({
						plugins: 'xhtml',
						locale: 'tr',
						style: "editor/minified/jquery.sceditor.default.min.css"
					});
				};

				$("#theme").change(function() {
					var theme = "editor/minified/themes/" + $(this).val() + ".min.css";

					$("textarea").sceditor("instance").destroy();
					$("link:first").remove();
					$("#theme-style").remove();

					loadCSS(theme, initEditor);
				});

				initEditor();
			});
		</script>
<?php
!defined("guvenlik") ? die("Bu sayfaya erişim yasaklanmıştır.") : NULL;

	function temizle($text)
	{
		$g_karakter    = array("'");
		$c_karakter    = array("&#39;");

		$degisen = str_replace($g_karakter, $c_karakter, $text);
		return $degisen;
	}

	echo '<div id="wrapper">
        <div id="page-wrapper">
		<div class="panel panel-default" >
                        <div class="panel-heading">
                            Blog Yönetimi
                        </div>
                        <div class="panel-body">';	

	$islem = @$_GET['islem'];
	switch($islem)
	{
		case "":
		
	
	$sayfa = @$_GET['s'];
	if($sayfa < 1){
		$baslangic = 0;
	}else{
		$baslangic = (($sayfa-1)*5);
	}
	$projeListele_sql = mysql_query("SELECT * FROM blog ORDER by id DESC LIMIT $baslangic, 5");
	$yorumListele_sql = mysql_query("SELECT * FROM blog_yorumlar");
    echo '<div class="table-responsive">
	<a href="index.php?admin=blogs&islem=ekle" class="btn btn-outline btn-success">Yeni Yazı Ekle</a>
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr class="gradeA">
						<th>Blog Adı</th>
						<th>Kısa Açıklaması</th>
						<th>Resim</th>
						<th colspan="4">İşlemler</th>
					</tr>
				</thead>';
    if(mysql_num_rows($projeListele_sql) > 0)
    {
		    $resimKlasor = "ProjeResimler/";
        while($listele = mysql_fetch_array($projeListele_sql))
        {
			echo '
	<script language="javascript"> 
    function SilmeOnayi'.$listele['id'].'(){
	var silinsin=confirm("Bu Yazıyı silmek istediğinizden emin misiniz?\nBu işlem geri alınamaz!");
	if (silinsin){
	location.href=\'index.php?admin=blogs&islem=yazisil&yazi='.$listele['id'].'\';
	return true;
	}
	else{
	return false;
	}}
	</script>';	
            echo '
			<tbody>
					<tr>
						<td>'.$listele['blog_adi'].'</td>
						<td>'.$listele['k_aciklama'].'</td>
						<td><img src="'.$resimKlasor.$listele['o_gorsel'].'" width="100" height="75" /></td>
						<td>
							<button class="btn btn-default btn-circle btn-lg" onclick="location.href=\'index.php?admin=blogs&islem=yaziduzenle&yazi='.$listele['id'].'\'" title="Yazıyı Düzenle">
								<i  class="fa fa-check"></i>
							</button>
						</td>
						<td>
							<button class="btn btn-danger btn-circle btn-lg" onclick="return SilmeOnayi'.$listele['id'].'();">
								<i  class="fa fa-times"></i>
							</button>
						</td>
						<td>
							<button class="btn btn-info btn-circle btn-lg" onclick="location.href=\'index.php?admin=blogs&islem=yorumlar&yazi='.$listele['id'].'\'" title="Yorumları Listele">
								<i  class="fa fa-list"></i>
							</button>
						</td>
					 ';			
			$yeniyorum = mysql_query("SELECT * FROM blog_yorumlar where yazi_id='".$listele['id']."' and onay='0'");
			$k_yeniyorum = mysql_fetch_array($yeniyorum);
			$kontrolet = $k_yeniyorum['onay'];
			if($kontrolet == "0")
			{
			echo '<td align="center">
			<button class="btn btn-warning btn-circle btn-lg" title="Yeni Yorum Var!">
								<i  class="fa fa-check"></i>
			</button>
			</td>';
           	}
			else
			{
			echo '<td align="center"><button class="btn btn-success btn-circle btn-lg" title="Yeni Yorum Yok">
								<i  class="fa fa-check"></i>
							</button></td>';
			}
			echo '</tr>
			</tbody>';
        }
    }
    else
    {
        echo '<tr><td colspan="6" align="center"><font color="white"><b>Veritabanında kayıtlı blog yazısı bulunamadı.</b></font></td></tr></table>';
    }
	echo '</table></div>';
	function sayfala($sayfa){
	if(isset($_GET['s']))
	{
		$sayfa = @$_GET['s'];
	}
	else {
	$sayfa = "1";
	}
	$sqltoplamkisi =  mysql_query("SELECT * FROM blog"); 
	$toplamkisi = mysql_num_rows($sqltoplamkisi );
	if($sayfa >= 2){
	echo '<li><a href="index.php?admin=blogs&s='.($sayfa-1).'">Önceki Sayfa</a></li> ';
	}
	else {
		echo '<li class="disabled"><a>Önceki Sayfa</a></li> ';
	}
	for ($j = 1; $j <= ceil($toplamkisi /5); $j++){
	if($sayfa == $j){
		echo '<li class="active"><a>'.$sayfa.'</a></li>';
	}else{
		echo '<li><a href="index.php?admin=blogs&s='.$j.'">'.$j.'</a></li>';
	}
	}
	if($sayfa < ceil($toplamkisi /5)){
		echo '<li><a href="index.php?admin=blogs&s='.($sayfa+1).'" >Sonraki Sayfa</a></li>';
	}
	else {
		echo '<li class="disabled"><a>Sonraki Sayfa</a></li> ';
	}
}
	echo '<div style="float:right;">
		<ul class="pagination pagination-sm">';
			sayfala($sayfa);
echo '</ul></div>';
		break;
	
		case "ekle":
		
		?>
	<div align="center">
		<form action="" method="post" action="" enctype="multipart/form-data">
		<table border="0">
		<tr>
		<td>
			<div>
				<input type="text" name="baslik" class="form-control" placeholder="Yazı Başlığını Buraya Giriniz."></input><br>
				<input type="text" name="aciklama" class="form-control" maxlength="220" placeholder="Kısa Açıklamayı giriniz. (Max 50 Karakter)"/><br>
				<textarea onClick="focus(this.code)" name="bbcode_field" class="form-control" style="height:300px;"></textarea>
				<div align="right">
				<label class="form-control">Öne Çıkarılmış Görsel Seçiniz: <input type="file" name="resim" size="100%" style="display:inline;width:50%;"/></label><br>
				<select name="kategori" class="btn btn-default">
					<option value="sec">Kategori Seçiniz</option>
				<?php
				$kategori_sql = mysql_query("SELECT * FROM kategoriler ORDER by ad ASC");
				while($kategori = mysql_fetch_array($kategori_sql))
				{
					echo '<option value="'.$kategori['id'].'">'.$kategori['ad'].'</option>';
				}
				?>
				</select>
				<input type="submit" name="gonder" class="btn btn-default" value="Yazıyı Yayımla"></div>
				</div>
		</td>
		</tr>
		</table>	
		</form>
	</div>	
		
<?php
		if(isset($_POST['gonder']))
	{	
		$baslik = $_POST['baslik'];
		$yazi = $_POST['bbcode_field'];
		$kategori = $_POST['kategori'];
		$aciklama = $_POST['aciklama'];
		// resim ekleme ve yükleme
		$resimKaynak = $_FILES['resim']['tmp_name'];
		$resimAdi = $_FILES['resim']['name'];
		$resimTipi = $_FILES['resim']['type'];
		$resimBoyut = $_FILES['resim']['size'];
		$resimUzanti = substr($resimAdi, -4);
		if($baslik =="")
		{
			echo "Başlık boş geçilemez...";
		}
		else if($aciklama == "")
		{
			echo "Açıklama alanı boş olamaz... Mk";
		}
		else if($resimKaynak == "")
		{
			echo "Resim seçilmedi!";
		}
		else if(($resimTipi != "image/jpeg") && ($resimTipi != "image/gif") && ($resimTipi != "image/x-png") && ($resimTipi != "image/png")) 
		{
			 echo "Resim jpeg,png veya gif olabilir!";
		}
		else if($resimBoyut > 2097152) // 1024*1024*2 = 2 Mb
		{
			echo "Resim en fazla 2 mb olabilir";  
		}
		else
		{
			$yeniResim = substr(uniqid(md5(rand())),0,35); // resim in adı değiştiriliyor.
			$yeniResimAdi = $yeniResim.$resimUzanti;
			$hedefResimKlasor = "ProjeResimler";
			
			if(move_uploaded_file($resimKaynak,$hedefResimKlasor."/".$yeniResimAdi))
			{
			   $ekle_sql = mysql_query("INSERT INTO blog(kat_Id,blog_adi,yazi,o_gorsel,k_aciklama) values('".$kategori."','".temizle($baslik)."','".temizle($yazi)."','".temizle($yeniResimAdi)."','".temizle($aciklama)."')");
			   if($ekle_sql)
			   {
				   //proje veritabanına kaydedilip proje dosyası ve resimler klasöre taşınınca özellik ekleme sayfasına yönlendiriliyor.
				   echo "Blog yazısı eklendi, yönlendiriliyorsunuz...";
				   header("Refresh: 2; url=index.php?admin=blogs");
			   }
			   else
			   {
				   echo "Blog yazısı veritabanına kaydedilemedi. Tekrar eklemek için yönlendiriliyorsunuz...";
				   header("Refresh: 2; url=index.php?admin=blogs");
			   }
			}
			else
			{echo "Resim yüklenemedi";}
		}
	}

	
		break;
	
		case "yazisil":
	$id = $_GET["yazi"];
	
	$blogVeriler = mysql_fetch_array(mysql_query("SELECT id,o_gorsel FROM blog WHERE id='$id'"));
	
	$blogSil_sql = mysql_query("DELETE FROM blog WHERE id='$id'");
	
	if($blogSil_sql)
	{
		if(file_exists('./ProjeResimler/'.$blogVeriler['o_gorsel']))
		{
			unlink('./ProjeResimler/'.$blogVeriler['o_gorsel']);
			echo "Blog yazısı silindi. Blog listesine yönlendiriliyorsunuz.";
			//echo "<script>self.close();</script>";
			header("refresh: 2; url=index.php?admin=blogs");
		}
	}
	else
	{
		echo "Blog yazısı silinemedi! Blog listesine yönlendiriliyorsunuz.";
        //echo "<script>self.close();</script>";
        header("refresh: 2; url=index.php?admin=blogs");
	}
	

	break;
	
	case "yaziduzenle";
	
	$id = $_GET['yazi'];
	    if(!is_numeric($id))
    {
        echo "Parametre Hatası! Blog Sayfasına Yönlediriliyorsunuz...";
        header("refresh: 2; url=index.php?admin=blogs");
    }
	else {
			$resimKlasor = "ProjeResimler/";
			$projeGetir_sql = mysql_query("SELECT * FROM blog WHERE id='$id'");
			if(mysql_num_rows($projeGetir_sql) > 0)
			{

				$veriler = mysql_fetch_array($projeGetir_sql);
				echo '
				<div align="center">
		<form action="" method="post" action="" enctype="multipart/form-data">
		<table border="0">
		<tr>
		<td>
			<div>
				<input type="text" name="baslik" class="form-control" value="'.$veriler['blog_adi'].'" placeholder="Yazı Başlığını Buraya Giriniz."></input><br>
				<input type="text" name="aciklama" class="form-control" value="'.$veriler['k_aciklama'].'" maxlength="220" placeholder="Kısa Açıklamayı giriniz. (Max 50 Karakter)"/><br>
				<textarea onClick="focus(this.code)" name="bbcode_field" class="form-control" style="height:300px;">'.$veriler['yazi'].'</textarea>
				<fieldset align="center">
				<legend>Şu anki Görsel (Değiştirilemez)</legend>
				<img src="ProjeResimler/'.$veriler['o_gorsel'].'" width="250px" border="0">
				</fieldset>
				<br>
				<div align="right">
				<b>Kategori:</b> <select name="kategori" class="btn btn-default">
					<option value="sec">Kategori Seçiniz</option>';
				
				$kategori_sql = mysql_query("SELECT * FROM kategoriler ORDER by ad ASC");
				while($kategori = mysql_fetch_array($kategori_sql))
				{
					echo '<option value="'.$kategori['id'].'" ';
					if($veriler['kat_Id'] == $kategori['id'])
					{
						echo 'selected';
					}
					echo '>'.$kategori['ad'].'</option>';
				}
				
				echo '</select>
				<input type="submit" name="guncelleyazi" class="btn btn-default" value="Yazıyı Güncelle"></div>
				</div>
		</td>
		</tr>
		</table>	
		</form>
	</div>
				';
			} else 
				{
					echo'Parametre Hatası Oluştu';
				}
		}
	    
		$blogYaziVerilerKaydet = mysql_fetch_array(mysql_query("SELECT * FROM blog WHERE id='$id'"));

		if(isset($_POST['guncelleyazi']))
		{
			
			$baslik = $_POST['baslik'];
			$yazi = $_POST['bbcode_field'];
			$aciklama = $_POST['aciklama'];
			$kategori = $_POST["kategori"];
			
			if($baslik =="")
			{
				echo "Başlık boş geçilemez...";
			}
			else if($aciklama == "")
			{
				echo "Açıklama alanı boş olamaz...";
			}
			else
			{
				   $ekle_sql =  mysql_query("UPDATE blog SET blog_adi='".temizle($baslik)."',k_aciklama='$aciklama',yazi='".temizle($yazi)."',kat_Id='".$kategori."' WHERE id='$id'");

				   if($ekle_sql)
				   {
					   //proje veritabanına kaydedilip proje dosyası ve resimler klasöre taşınınca özellik ekleme sayfasına yönlendiriliyor.
					   echo "Blog yazısı eklendi, yönlendiriliyorsunuz...";
					   header("refresh: 2; url=index.php?admin=blogs");
				   }
				   else
				   {
					   echo "Blog yazısı veritabanına kaydedilemedi. Tekrar eklemek için yönlendiriliyorsunuz...";
					   header("refresh: 2; url=index.php?admin=blogs");
				   }
				}	
			}
	break;
	
	case "yorumlar":

    $projeId = $_GET['yazi'];
    if(!is_numeric($projeId))
    {
        echo "Parametre Hatası! Proje Sayfasına Yönlediriliyorsunuz...";
        header("refresh: 2; url=index.php?admin=blogs");
    }
    else
    {
	
	echo '
	<script language="javascript"> 
    function SilmeOnayi(){var silinsin=confirm("Bu yorumu silmek istediğinizden emin misiniz?\nBu işlem geri alınamaz!");if (silinsin){return true;}else{return false;}}
	</script>
	
	';
        $ozellikler_sql = mysql_query("SELECT * FROM blog_yorumlar WHERE yazi_id='$projeId' ORDER BY tarih and onay");
        echo '<table border="1" align="center" width="720px"><tr align="center" width="700px">';
        if(mysql_num_rows($ozellikler_sql) > 0)
        {
			echo '<tr><td>Gönderen A-S</td><td>Gönderen Email</td><td width="150px">Yorumu</td><td>Gön. Tarih</td><td>Gön. Yazı</td><td colspan="2">İşlemler</td><td>Onay</td></tr>';
            while($ozellikListe = mysql_fetch_array($ozellikler_sql))
            {
                 echo '
				 <tr width="700px">
				 <td>'.$ozellikListe['adsoyad'].'</td>
				 <td>'.$ozellikListe['email'].'</td>
				 <td>'.chunk_split(substr($ozellikListe['yorum'],0,200),20,'<br>').'</td>
				 <td>'.$ozellikListe['tarih'].'</td>
				 <td><input value="Yazıyı Oku" type="submit" onclick="location.href=\'/index.php?sayfa=blog&yazi='.$ozellikListe['yazi_id'].'\'" target="_blank"></td>
                 <td align="center"><a href="index.php?admin=blogs&islem=sil&yorum='.$ozellikListe['id'].'" onclick="return SilmeOnayi();"><img src="butonlar/delete.png" border="0" alt="sil" /></a></td>
                 <td align="center"><a href="index.php?admin=blogs&islem=onayla&yorum='.$ozellikListe['id'].'"><img src="butonlar/tick.png" border="0" alt="onayla" /></a></td>
				  <td align="center">';
					$onay = $ozellikListe['onay'];
					if($onay == 1)
					{
						echo '<img src="butonlar/tick.png" border="0" alt="onaylı"/>';
					}
					else 
					{
						echo '<img src="butonlar/not.png" border="0" alt="onaysız"/>';

					}
					
					echo '</td>	
				 
				 </tr>';
            }
            echo "</table>";   
        }
        else
        {
            echo '<td align="center" colspan="3" width="550">Bu Yazıya ait yorum bulunmamaktadır..</td></tr></table>';
        }
    }    

	break;
	
	case "sil":
	$id = $_GET['yorum'];
	

	$veriler = mysql_fetch_array(mysql_query("SELECT * FROM blog_yorumlar WHERE id='$id'"));
	$yaziid = $veriler['yazi_id'];
	$yorumSil_sql = mysql_query("DELETE FROM blog_yorumlar WHERE id='$id'");
	
	if($yorumSil_sql)
	{
		
		echo "Yorum Silindi.. Blog listesine yönlendiriliyorsunuz.";
        header("refresh: 2; url=index.php?admin=blogs&islem=yorumlar&yazi=$yaziid");
		}
	
	else
	{
		echo "Yorum silinemedi! Blog listesine yönlendiriliyorsunuz.";
        //echo "<script>self.close();</script>";
        header("refresh: 2; url=index.php?admin=blogs&islem=yorumlar&yazi=$yaziid");
	}
	
	
	break;
	
	case "onayla":
	$id = $_GET['yorum'];
	
	$veriler = mysql_fetch_array(mysql_query("SELECT * FROM blog_yorumlar WHERE id='$id'"));
	$yaziid = $veriler['yazi_id'];
	
	$ekle_sql =  mysql_query("UPDATE blog_yorumlar SET onay='1' WHERE id='$id'");
			 if($ekle_sql)
	   {
		   //proje veritabanına kaydedilip proje dosyası ve resimler klasöre taşınınca özellik ekleme sayfasına yönlendiriliyor.
		   echo "Yorum Onaylandı. yönlendiriliyorsunuz...";
        header("refresh: 2; url=index.php?admin=blogs&islem=yorumlar&yazi=$yaziid");
	   }
	   else
	   {
		   echo "Yorum Onaylanamadı. Tekrar Denemeniz için Yönlendiriliyorsunuz...";
        header("refresh: 2; url=index.php?admin=blogs&islem=yorumlar&yazi=$yaziid");
	   }
	break;
	
	}
	
	
	
	
	echo '</div></div></div>
                    </div>';
?>