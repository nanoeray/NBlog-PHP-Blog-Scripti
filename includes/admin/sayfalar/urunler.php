<?php
!defined("guvenlik") ? die("Bu sayfaya erişim yasaklanmıştır.") : NULL;

$_SESSION['uyeId'] = 2;
echo '<div id="wrapper">
        <div id="page-wrapper">
		<div class="panel panel-default" >
                        <div class="panel-heading">
                            Ürün Yönetimi
                        </div>
                        <div class="panel-body">';
function ProjeEkle() // projenin ekleneceği tablo. bu kısımda fazla bişey yok, bakınca anlarsın zaten.
{

    echo '<table width="600" border="0" align="center">
    <caption>Ürün Ekleme Sayfası</caption>
<form method="post" action="index.php?admin=urunler&islem=UrunKayit" enctype="multipart/form-data">
  <tr>
    <td width="20%">Ürün Adı</td>
    <td>
      <input name="ad" type="text" size="80px" class="form-control"/>
    </td>
  </tr>
  <tr>
    <td>Açıklama</td>
    <td><input type="text" name="aciklama" size="80px" class="form-control"/></td>
  </tr>
  <tr>
    <td>Fiyat</td>
    <td><input type="text" name="fiyat" size="80px" class="form-control"/></td>
  </tr>
  <tr>
    <td>Stok</td>
    <td><input type="text" name="stok" size="80px" class="form-control"/></td>
  </tr>
   <tr>
    <td>Resim</td>
    <td><input type="text" name="resim" size="80px" class="form-control"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="submit" class="btn btn-outline btn-primary" value="     Ürünü Ekle     " /></td>
  </tr>
  </form>
</table>';
}

function ProjeKayit() // burada ProjeEkle den gelen veriler kontrol edilip eğer hepsi doğruysa kaydediliyor.
{
    $urunadi = $_POST['ad'];
    $aciklama = $_POST['aciklama'];
    $fiyat = $_POST['fiyat'];
    $stok = $_POST['stok'];    
    $resim = $_POST['resim'];    


   $ekle_sql = mysql_query("INSERT INTO urun_satis (urun_adi,urun_aciklamasi,urun_fiyati,stok_durumu,resim) 
   VALUES('$urunadi','$aciklama','$fiyat','$stok','$resim')");
   if($ekle_sql)
   {
	   //proje veritabanına kaydedilip proje dosyası ve resimler klasöre taşınınca özellik ekleme sayfasına yönlendiriliyor.
	   echo "Ürün kaydedildi. Şimdi Ürün özelliklerini eklemek için sayfaya yönlendiriliyorsunuz...";
	   header("refresh: 2; url=index.php?admin=urunler&islem=OtoOzellikEkle");
   }
   else
   {
	   echo "Proje bilgileri veritabanına kaydedilemedi. Tekrar eklemek için yönlendiriliyorsunuz...";
	   header("refresh: 2; url=index.php?admin=urunler&islem=UrunEkle");
   }

}

function ProjeListele() // proje.php sayfasına girildiğinde ilk bu kısım çalışıyor ve veritabanındaki projeleri listeliyor.
{
    $sayfa = @$_GET['s'];
	if($sayfa < 1){
		$baslangic = 0;
	}else{
		$baslangic = (($sayfa-1)*5);
	}
    $projeListele_sql = mysql_query("SELECT * FROM urun_satis LIMIT $baslangic, 5");
    echo '
	<div class="table-responsive">
		<a href="index.php?admin=urunler&islem=UrunEkle" class="btn btn-outline btn-success">Yeni Ürün Ekle</a>
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr class="gradeA">
						<th>Ürün Adı</th>
						<th>Açıklama</th>
						<th>Fiyat</th>
						<th>Stok</th>
						<th colspan="3">İşlemler</th>
					</tr>
				</thead>';
    if(mysql_num_rows($projeListele_sql) > 0)
    {
        while($listele = mysql_fetch_array($projeListele_sql))
        {
					echo '
	<script language="javascript"> 
    function SilmeOnayi'.$listele['id'].'(){
	var silinsin=confirm("Bu Ürünü silmek istediğinizden emin misiniz?\nBu işlem geri alınamaz!");
	if (silinsin){
	location.href=\'index.php?admin=urunler&islem=UrunSil&urun='.$listele['id'].'\';
	return true;
	}
	else{
	return false;
	}}
	</script>';
            echo '		
			<tr>
				<td>'.$listele['urun_adi'].'</td>
				<td>'.$listele['urun_aciklamasi'].' Kb</td>
				<td align="center">'.$listele['urun_fiyati'].'</td>
				<td align="center">'.$listele['stok_durumu'].'</td>
				<td align="center">
					<button class="btn btn-default btn-circle btn-lg" onclick="location.href=\'index.php?admin=urunler&islem=UrunGuncelle&amp;urun='.$listele['id'].'\';">
								<i  class="fa fa-check"></i>
					</button>
				</td>
				<td align="center">
					<button class="btn btn-danger btn-circle btn-lg" onclick="return SilmeOnayi'.$listele['id'].'();">
								<i  class="fa fa-times"></i>
					</button>
					</td>
				<td align="center">
					<button class="btn btn-success btn-circle btn-lg" onclick="location.href=\'index.php?admin=urunler&islem=OzellikListele&amp;urun='.$listele['id'].'\';">
								<i  class="fa fa-list"></i>
					</button>
				</td>
			</tr>';
        }
    }
    else
    {
        echo '<tr><td colspan="6" align="center"><font color="black"><b>Veritabanında kayıtlı ürün bulunamadı.</b></font></td></tr>';
    }
    echo "</table></div>";
	function sayfala($sayfa){
	if(isset($_GET['s']))
	{
		$sayfa = @$_GET['s'];
	}
	else {
	$sayfa = "1";
	}
	$sqltoplamkisi =  mysql_query("SELECT * FROM urun_satis"); 
	$toplamkisi = mysql_num_rows($sqltoplamkisi );
	if($sayfa >= 2){
	echo '<li><a href="index.php?admin=urunler&s='.($sayfa-1).'">Önceki Sayfa</a></li> ';
	}
	else {
		echo '<li class="disabled"><a>Önceki Sayfa</a></li> ';
	}
	for ($j = 1; $j <= ceil($toplamkisi /5); $j++){
	if($sayfa == $j){
		echo '<li class="active"><a>'.$sayfa.'</a></li>';
	}else{
		echo '<li><a href="index.php?admin=urunler&s='.$j.'">'.$j.'</a></li>';
	}
	}
	if($sayfa < ceil($toplamkisi /5)){
		echo '<li><a href="index.php?admin=urunler&s='.($sayfa+1).'" >Sonraki Sayfa</a></li>';
	}
	else {
		echo '<li class="disabled"><a>Sonraki Sayfa</a></li> ';
	}
}
	echo '<div style="float:right;">
		<ul class="pagination pagination-sm">';
			sayfala($sayfa);
echo '</ul></div>';
   
}                                               
                                             
function ProjeGuncelle() // proje günceleme işleminde kullanılan tablo.
{
    $projeId = $_GET['urun'];
    if(!is_numeric($projeId)) // burada projeId nin geçerli olup olmadığı kontrol ediliyor.
    {
        echo "Parametre Hatası! Proje Sayfasına Yönlediriliyorsunuz...";
        header("refresh: 2; url=proje.php");
    }
    else
    {
        $projeGetir_sql = mysql_query("SELECT * FROM urun_satis WHERE id='$projeId'");
        if(mysql_num_rows($projeGetir_sql) > 0)
        {
            $veriler = mysql_fetch_array($projeGetir_sql);
            echo '<table width="600" border="0" align="center">
            <caption>Ürün Güncelleme Sayfası</caption>
            <form method="post" action="index.php?admin=urunler&islem=UrunGuncelKayit&urun='.$projeId.'" enctype="multipart/form-data">
            <tr>
            <td width="20%">Ürün Adı</td>
            <td>
            <input name="urun_adi" type="text" size="80px" value="'.$veriler['urun_adi'].'" class="form-control"/>
            </td>
            </tr>
            <tr>
            <td>Açıklama</td>
            <td><input type="text" name="urun_aciklamasi" size="80px" value="'.$veriler['urun_aciklamasi'].'" class="form-control"/></td>
            </tr>
            <tr>
            <td>Stok</td>
            <td><input type="text" name="stok" size="80px" value="'.$veriler['stok_durumu'].'" class="form-control"/></td>
            </tr>
            <tr>
            <td>Fiyat</td>
            <td><input type="text" name="fiyat" size="80px" value="'.$veriler['urun_fiyati'].'" class="form-control"/></td>
            </tr>
            <tr>
            <td>Resim Linki</td>
            <td><input type="text" name="resim" size="80px" value="'.$veriler['resim'].'" class="form-control"/></td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td align="right"><input type="submit" name="guncelle" class="btn btn-outline btn-primary" value="     Güncelle     " /></td>
            </tr>
            </form>
            </table>';
        }
        else
        {
            echo "Parametre Hatası!";
        }
    }    
}

function ProjeGuncelKayit() // proje güncellendikten sonra burada kayıt ediliyor.
{
    if(isset($_POST['guncelle']))
    {
        $projeId = $_GET['urun'];
        $projeAdi = $_POST['urun_adi'];
        $aciklama = $_POST['urun_aciklamasi'];
        $fiyat = $_POST['fiyat'];
        $stok = $_POST['stok'];
        $resim = $_POST['resim'];
                    
        $guncelle_sql = mysql_query("UPDATE urun_satis SET urun_adi='$projeAdi',urun_aciklamasi='$aciklama',urun_fiyati='$fiyat',stok_durumu='$stok',resim='$resim' WHERE id='$projeId'");
        if($guncelle_sql)
        {
            echo "Ürün güncellendi. Ürün sayfasına yönlendiriliyorsunuz...";
            header("refresh: 2; url=index.php?admin=urunler");
        }
        else
        {
            echo "Ürün güncellenemedi! Ürün sayfasına yönlendiriliyorsunuz...";
            header("refresh: 2; url=index.php?admin=urunler");
        }
		}
}

function ProjeSil() // burada seçilen proje ve bu projeye ait özellikler,dosya,resim1 ve resim2 hem klasörlerden hemde veritabanından siliniyor.
{
    $projeId = $_GET['urun'];
    $dosyaAl = mysql_fetch_array(mysql_query("SELECT * FROM urun_satis WHERE id='$projeId'"));
    $ozelliksil_sql = mysql_query("DELETE FROM urun_ozellikleri WHERE urunId='$projeId'");
    $sil_sql = mysql_query("DELETE FROM urun_satis WHERE id='$projeId'");
    if($sil_sql)
    { 
        echo "Seçilen Ürün silindi. Ürün sayfasına yönlendiriliyorsunuz.";
        header("refresh: 2; url=index.php?admin=urunler");
    }
    else
    {
        echo "Silme işleminde hata oluştu!";
    }
}

function OtoOzellikEkle() // proje eklendikten sonra direk buraya yönlendirliyor.
{
    $projeGetir = mysql_fetch_array(mysql_query("SELECT * FROM urun_satis ORDER BY id DESC LIMIT 0,1"));
    $projeAdi = $projeGetir['urun_adi'];
    $projeId = $projeGetir['id'];
    
    echo '<table align="center" width="600" border="0">
    <caption>Ürün Özellikleri Ekleme Sayfası</caption>
    <form id="form1" name="form1" method="post" action="index.php?admin=urunler&islem=OtoOzellikKayit">
    <tr>
    <td>Ürün Adı</td>
    <td><input type="text" name="projeadi" class="form-control" disabled="disabled" size="80px" value="'.$projeAdi.'"/></td>
    </tr>
    <tr>
    <td>Özellik</td>
    <td>
    <input type="text" class="form-control" name="ozellik" size="80px" />
    </td>
    </tr>
    <tr>
    <td>Tarih</td>
    <td>
    <input type="text" class="form-control" name="tarih" disabled="disabled" value="'.date("d.m.Y").'" />
    <input name="urunid" class="form-control" type="hidden" value="'.$projeId.'" />
    </td>
    </tr>
    <tr>
    <td><input type="submit" name="yeniozellik" class="btn btn-outline btn-primary" value="Yeni Özellik Ekle" /></td>
    <td align="right"><input type="submit" name="kaydet" class="btn btn-outline btn-primary" value="Kaydet ve Kapat" /></td>
    </tr>
    </form>
    </table>';
}

function OtoOzellikKayit() // otomatik eklenen özellikte 2 buton var.
{
    if(isset($_POST['yeniozellik'])) // soldaki butona tıklanınca kaydı ekleyip yeniden özellik ekleme yerine geliyor.
    {
        $ozellik = $_POST['ozellik'];
        if($ozellik == "")
        {
            echo "Özellik alanı boş bırakılamaz!";
            header("refresh: 2; url=index.php?admin=urunler&islem=OtoOzellikEkle");
        }
        else
        {
            $tarih = date("d.m.Y");
            $projeId = $_POST['projeid'];
            
            $OtoOzellikEkle_sql = mysql_query("INSERT INTO urun_ozellikleri(ozellik,tarih,urunId) VALUES('$ozellik','$tarih','$projeId')");
            if($OtoOzellikEkle_sql)
            {
                OtoOzellikEkle();  
            }
            else
            {
                echo "Özellik eklenemedi! Tekrar yönlendiriliyorsunuz...";
                header("refresh: 2; url=index.php?admin=urunler&islem=OtoOzellikEkle");
            }
        }        
    }
    if(isset($_POST['kaydet'])) // sağdakine tıklanınca son veriyi kaydedip proje.php sayfasına yönlendiriyor.
    {
        $ozellik = $_POST['ozellik'];
        if($ozellik == "")
        {
            echo "Özellik alanı boş bırakılamaz!";
            header("refresh: 2; url=index.php?admin=urunler&islem=OtoOzellikEkle");
        }
        else
        {
            $tarih = date("d.m.Y");
            $projeId = $_POST['urunid'];
            
            $OtoOzellikEkle_sql = mysql_query("INSERT INTO urun_ozellikleri(ozellik,tarih,urunId) VALUES('$ozellik','$tarih','$projeId')");
            if($OtoOzellikEkle_sql)
            {
                echo "Özellik eklendi. Anasayfaya yönlendiriliyorsunuz...";
                header("refresh: 2; url=index.php?admin=urunler");
            }
            else
            {
                echo "Özellik eklenemedi! Tekrar yönlendiriliyorsunuz...";
                header("refresh: 2; url=index.php?admin=urunler&islem=OtoOzellikEkle");
            }
        }
    }
}

function OzellikListele() // seçilen projeye ait özellikleri yeni bir pencerede listeliyor.
{
    $projeId = $_GET['urun'];
    if(!is_numeric($projeId))
    {
        echo "Parametre Hatası! Proje Sayfasına Yönlediriliyorsunuz...";
        header("refresh: 2; url=index.php?admin=projeler");
    }
    else
    {
	
        $ozellikler_sql = mysql_query("SELECT * FROM urun_ozellikleri WHERE urunId='$projeId'");
        $proje = mysql_fetch_array(mysql_query("SELECT * FROM urun_satis WHERE id=$projeId"));
        echo '
		<table align="center" width="500" border="1" >
        <caption>['.$proje['urun_adi'].'] Ürününe Ait Özellikler <br /> 
		<button type="button" class="btn btn-success " onclick="location.href=\'index.php?admin=urunler&islem=OzellikEkle&urun='.$projeId.'\'">Yeni Özellik Ekle</i>
        </button>
        <tr><td align="center"><strong>Özellik</strong></td><td align="center"><strong>Eklenme Tarihi</strong></td>
        <td align="center"><strong>İşlemler</strong></td></tr>';
        if(mysql_num_rows($ozellikler_sql) > 0)
        {
            while($ozellikListe = mysql_fetch_array($ozellikler_sql))
            {
					echo '
					<script language="javascript"> 
					function SilmeOnayi'.$ozellikListe['ozellikId'].'(){
					var silinsin=confirm("Bu Yazıyı silmek istediğinizden emin misiniz?\nBu işlem geri alınamaz!");
					if (silinsin){
					location.href=\'index.php?admin=urunler&islem=OzellikSil&ozellik='.$ozellikListe['ozellikId'].'\';
					return true;
					}
					else{
					return false;
					}}
					</script>';
                 echo '<tr><td>'.$ozellikListe['ozellik'].'</td><td>'.$ozellikListe['tarih'].'</td>
                 <td align="center">
				 <button type="button" class="btn btn-danger btn-circle btn-lg" onclick="return SilmeOnayi'.$ozellikListe['ozellikId'].'();"><i class="fa fa-times"></i>
				</button>
				 </td></tr>';
            }
            echo "</table>";   
        }
        else
        {
            echo '<td align="center" colspan="3">Özellik bulunamadı.</td></tr>';
        }
    }    
}

function OzellikEkle() // projeye daha sonradan özellik eklemek için kullanılan bölüm.
{
	$projeId = $_GET['urun'];
    $projeGetir = mysql_fetch_array(mysql_query("SELECT * FROM urun_satis WHERE id='$projeId'"));
    
	echo '<table align="center" width="600" border="0" >
    <caption>Ürün Özellikleri Ekleme Sayfası</caption>
    <form method="post" action="index.php?admin=urunler&islem=OzellikKayit&urun='.$projeId.'">
    <tr>
    <td>Ürün Adı</td>
    <td><input type="text" name="projeadi" disabled="disabled" size="80px" value="'.$projeGetir['urun_adi'].'"/></td>
    </tr>
    <tr>
    <td>Özellik</td>
    <td>
    <input type="text" name="ozellik" size="80px" />
    </td>
    </tr>
    <tr>
    <td>Tarih</td>
    <td>
    <input type="text" name="tarih" disabled="disabled" value="'.date("d.m.Y").'" />
    </td>
    </tr>
    <tr>
    <td><input type="submit" name="yeniozellik" class="btn btn-outline btn-success" value="Yeni Özellik Ekle" /></td>
    <td align="right"><input type="submit" name="kaydet" class="btn btn-outline btn-success" value="Kaydet ve Kapat" /></td>
    </tr>
    </form>
    </table>';
}

function OzellikKayit() // daha sonra eklenen özellik kayıt yeri. yine bunda da OtoOzellikEkle mantığı, yani 2 buton var.
{
    if(isset($_POST['yeniozellik']))
    {
        $projeId = $_GET['urun'];
        $ozellik = $_POST['ozellik'];
        if($ozellik == "")
        {
            echo "Özellik alanı boş bırakılamaz!";
            header("refresh: 2; url=index.php?admin=urunler&islem=OzellikEkle&urun=$projeId");
        }
        else
        {
            $tarih = date("d.m.Y");   
            $OtoOzellikEkle_sql = mysql_query("INSERT INTO urun_ozellikleri(ozellik,tarih,urunId) VALUES('$ozellik','$tarih','$projeId')");
            if($OtoOzellikEkle_sql)
            {
                OzellikEkle();  
            }
            else
            {
                echo "Özellik eklenemedi!";
                header("refresh: 2; url=index.php?admin=urunler&islem=OzellikEkle&urun=$projeId");
            }
        }        
    }
    if(isset($_POST['kaydet']))
    {
        $projeId = $_GET['urun'];
        $ozellik = $_POST['ozellik'];
        if($ozellik == "")
        {
            echo "Özellik alanı boş bırakılamaz!";
            header("refresh: 2; url=index.php?admin=urunler&islem=OzellikEkle&urun=$projeId");
        }
        else
        {
            $tarih = date("d.m.Y");            
            $OtoOzellikEkle_sql = mysql_query("INSERT INTO urun_ozellikleri(ozellik,tarih,urunId) VALUES('$ozellik','$tarih','$projeId')");
            if($OtoOzellikEkle_sql)
            {
                echo "Özellik eklendi. ürün özellikleri sayfasına yönlendiriliyorsunuz...";
                header("refresh: 2; url=index.php?admin=urunler&islem=OzellikListele&urun=$projeId");
            }
            else
            {
                echo "Özellik eklenemedi! Tekrar yönlendiriliyorsunuz...";
                header("refresh: 2; url=index.php?admin=urunler&islem=OzellikListele&urun=$projeId");
            }
        }
    }
}

function OzellikSil()
{
    $ozellikId = $_GET["ozellik"];
    $proje = mysql_fetch_array(mysql_query("SELECT * FROM urun_ozellikleri WHERE ozellikId='$ozellikId'"));
    $projeId = $proje['urunId'];
    $ozellikSil_sql = mysql_query("DELETE FROM urun_ozellikleri WHERE ozellikId='$ozellikId'");
    if($ozellikSil_sql)
    {
        echo "Özellik silindi. Özellik listesine yönlendiriliyorsunuz.";
        //echo "<script>self.close();</script>";
        header("refresh: 2; url=index.php?admin=urunler&islem=OzellikListele&urun=$projeId");
    }
    else
    {
        echo "Özellik silinemedi! Özellik listesine yönlendiriliyorsunuz.";
        //echo "<script>self.close();</script>";
        header("refresh: 2; url=index.php?admin=urunler&islem=OzellikListele&proje=$projeId");
    }
}

// burasıda sayfalardaki geçişler için swtich case yapısı.
$islem = @$_GET['islem'];
switch($islem)
{
    default:
        ProjeListele();
    break;
    case "UrunEkle":
        ProjeEkle();
    break;
    case "UrunKayit":
        ProjeKayit();
    break;
    case "UrunGuncelle":
        ProjeGuncelle();
    break;
    case "UrunGuncelKayit":
        ProjeGuncelKayit();
    break;
    case "UrunSil":
        ProjeSil();
    break;
    case "OzellikListele":
        OzellikListele();
    break;
    case "OtoOzellikEkle":
        OtoOzellikEkle();
    break;
	case "OzellikEkle":
        OzellikEkle();
    break;
    case "OtoOzellikKayit":
        OtoOzellikKayit();
    break;
    case "OzellikKayit":
        OzellikKayit();
    break;
    case "OzellikSil":
        OzellikSil();
    break;    
}
	echo '</div></div></div>
                    </div>';
?>