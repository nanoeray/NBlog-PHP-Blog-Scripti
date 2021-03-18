<?php
echo '<div id="wrapper">
        <div id="page-wrapper">';
$gelen = @$_GET["yer"];

switch($gelen)
{
	default :
		echo '<div class="panel panel-primary">
                        <div class="panel-heading">
                            Kategoriler
                        </div>
                        <div class="panel-body">';
			$kategoriBulSql = mysql_query("SELECT * FROM kategoriler Order by ad ASC");			
			$sayi = mysql_num_rows($kategoriBulSql);
			if($sayi > 0)
			{
				echo '<table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kategori Adı</th>
                                            <th>Açıklama</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>';
				while($bul = mysql_fetch_array($kategoriBulSql))
				{
				
					echo '     <tbody>
                                        <tr>
                                            <td>'.$bul['id'].'</td>
                                            <td>'.$bul['ad'].'</td>
                                            <td>'.$bul['aciklama'].'</td>
                                            <td><a href="index.php?admin=kategoriler&yer=duzenle&kategori='.$bul['id'].'">Düzenle</a> <a href="index.php?admin=kategoriler&yer=sil&kategori='.$bul['id'].'">Sil</a></td>
                                        </tr> ';
				}
				echo '</tbody>
                      </table>';
			}
			else {
				echo '<center><strong>Henüz Eklenmiş Kategori Yok</strong></center>';
			}
			echo '<a href="index.php?admin=kategoriler&yer=ekle" class="btn btn-outline btn-success">Yeni Kategori Ekle</a>';
        echo '</div>
                     <div class="panel-footer">
							NBlog V2.0 Yönetim Paneli			
					</div>   
                    </div>';
	break;
	
	case "ekle":

	echo '<div class="panel panel-green">
                        <div class="panel-heading">
                            Yeni Kategori Ekle
                        </div>
                        <div class="panel-body">';
						if(isset($_POST['ekle']))
						{
							$katadi = $_POST["adi"];
							$kataaci = $_POST["aciklama"];
							if(empty($kataaci) OR empty($katadi))
							{
								echo '
								<div class="alert alert-danger alert-dismissable">
													<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
													Kategori Adı veya Açıklama Boş Geçilemez
								</div>
								';
							}
							else {
							function temizle($text)
							{
								$g_karakter    = array("'");
								$c_karakter    = array("&#39;");

								$degisen = str_replace($g_karakter, $c_karakter, $text);
								return $degisen;
							}
								$ekle = mysql_query("INSERT INTO kategoriler(ad,aciklama) values('".temizle($katadi)."','".temizle($kataaci)."')");
								if($ekle)
								{
									header("Location: index.php?admin=kategoriler");
								}
								else {
									echo 'Kategori Eklenemedi';
								}
							}
						}
						echo'<form action="" method="POST">
								<input type="text" class="form-control" name="adi" placeholder="Kategori Adı"/><br>
								<textarea class="form-control" name="aciklama" placeholder="Kategori Açıklaması"/></textarea><br>
								<input type="submit" name="ekle" value="Kategori Ekle" class="btn btn-outline btn-success">
							</form>
                        </div>
                        <div class="panel-footer">
                            NBlog Kss v2.0 Yönetim Paneli
                        </div>
                    </div>';
	break;
	
	case "duzenle":
	echo '<div class="panel panel-green">
                        <div class="panel-heading">
                            Kategori Düzenle
                        </div>
                        <div class="panel-body">';
						if(isset($_POST['duzenle']))
						{
							$katadi = $_POST["adi"];
							$kataaci = $_POST["aciklama"];
							if(empty($kataaci) OR empty($katadi))
							{
								echo '
								<div class="alert alert-danger alert-dismissable">
													<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
													Kategori Adı veya Açıklama Boş Geçilemez
								</div>
								';
							}
							else {
							function temizle($text)
							{
								$g_karakter    = array("'");
								$c_karakter    = array("&#39;");

								$degisen = str_replace($g_karakter, $c_karakter, $text);
								return $degisen;
							}
								$ekle = mysql_query("UPDATE kategoriler SET ad='".temizle($katadi)."',aciklama='".temizle($kataaci)."' WHERE id='".$_POST['id']."'");
								if($ekle)
								{
									header("Location: index.php?admin=kategoriler");
								}
								else {
									echo 'Kategori Düzenlemedi';
								}
							}
						}
						$katSql = mysql_query("SELECT * FROM kategoriler WHERE id='".$_GET['kategori']."'");
						$katBul = mysql_fetch_array($katSql);
						echo'<form action="" method="POST">
								<input type="hidden" value="'.$katBul['id'].'" name="id">
								<input type="text" class="form-control" name="adi" value="'.$katBul['ad'].'" placeholder="Kategori Adı"/><br>
								<textarea class="form-control" name="aciklama" placeholder="Kategori Açıklaması"/>'.$katBul['aciklama'].'</textarea><br>
								<input type="submit" name="duzenle" value="Kategoriyi Düzenle" class="btn btn-outline btn-success">
							</form>
                        </div>
                        <div class="panel-footer">
                            NBlog Kss v2.0 Yönetim Paneli
                        </div>
                    </div>';	
	break;
	
	case "sil":
		$sil = mysql_query("DELETE FROM kategoriler WHERE id='".$_POST['id']."'");
		if($sil)
		{
			header("Location: index.php?admin=kategoriler");
		}
		else {
			echo 'Kategori Düzenlemedi';
		}
	break;
}
echo '
	</div>
</div>';
?>