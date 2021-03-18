<?php
!defined("guvenlik") ? die("Bu sayfaya erişim yasaklanmıştır.") : NULL;

$_SESSION['uyeId'] = 2;
echo '<div id="wrapper">
        <div id="page-wrapper">
		<div class="panel panel-default" >
                        <div class="panel-heading">
                            Proje Yönetimi
                        </div>
                        <div class="panel-body">';
function ProjeEkle() // projenin ekleneceği tablo. bu kısımda fazla bişey yok, bakınca anlarsın zaten.
{

    echo '<table width="600" border="0" align="center">
    <caption>Proje Ekleme Sayfası</caption>
<form method="post" action="index.php?admin=projeler&islem=ProjeKayit" enctype="multipart/form-data">
  <tr>
    <td width="20%">Proje Adı</td>
    <td>
      <input name="dosyaadi" type="text" size="80px" class="form-control"/>
    </td>
  </tr>
  <tr>
    <td>Açıklama</td>
    <td><input type="text" name="aciklama" size="80px" class="form-control"/></td>
  </tr>
  <tr>
    <td>Demo</td>
    <td><input type="text" name="demo" size="80px" class="form-control"/></td>
  </tr>
  <tr>
    <td>İndirme Linki</td>
    <td><input type="text" name="link" size="80px" class="form-control"/></td>
  </tr>
   <tr>
    <td>Dosya Boyutu</td>
    <td><input type="text" name="dosyaBoyut" size="80px" class="form-control"/></td>
  </tr>
  <tr>
    <td>Rar Şifresi</td>
    <td><input type="text" name="rarsifre" size="80px" class="form-control"/></td>
  </tr>
  <tr>
    <td>Resim 1</td>
    <td><input type="file" name="resim1" size="70px" class="form-control"/></td>
  </tr>
  <tr>
    <td>Resim 2</td>
    <td><input type="file" name="resim2" size="70px" class="form-control"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="submit" class="btn btn-outline btn-primary" value="     Projeyi Ekle     " /></td>
  </tr>
  </form>
</table>';
}

function ProjeKayit() // burada ProjeEkle den gelen veriler kontrol edilip eğer hepsi doğruysa kaydediliyor.
{
    $projeAdi = $_POST['dosyaadi'];
    $aciklama = $_POST['aciklama'];
    $demo = $_POST['demo'];
    $rarpass = $_POST['rarsifre'];    
    $link = $_POST['link'];    
    $dosyaBoyut = $_POST['dosyaBoyut'];    

        $resim1Kaynak = $_FILES["resim1"]["tmp_name"];        
        $resim1Adi = $_FILES["resim1"]["name"];
        $resim1Tipi = $_FILES["resim1"]["type"];
        $resim1Boyut = $_FILES["resim1"]["size"];
        $resim1Uzanti = substr($resim1Adi, -4);
        if($resim1Kaynak == "")
        {
            echo "Resim 1 seçilmedi!";    
        }
        else if(($resim1Tipi != "image/jpeg") && ($resim1Tipi != "image/gif") && ($resim1Tipi != "image/x-png") && ($resim1Tipi != "image/png")) 
        {
            echo "Resim 1 jpeg,png veya gif olabilir!";
        }
        else
        {
            $resim2Kaynak = $_FILES["resim2"]["tmp_name"];
            $resim2Adi = $_FILES["resim2"]["name"]; 
            $resim2Tipi = $_FILES["resim2"]["type"];
            $resim2Boyut    = $_FILES["resim2"]["size"];
            $resim2Uzanti = substr($resim2Adi, -4);
            if($resim2Kaynak == "")
            {
                echo "Resim 2 seçilmedi!";
            }
            else if(($resim2Tipi != "image/jpeg") && ($resim2Tipi != "image/gif") && ($resim2Tipi != "image/x-png") && ($resim1Tipi != "image/png")) 
            {
                 echo "Resim 2 jpeg,png veya gif olabilir!";
            }
            else
            {
                $yeniResim1 = substr(uniqid(md5(rand())),0,35); // resim1 in adı değiştiriliyor.
                $yeniResim1Adi = $yeniResim1.$resim1Uzanti;
                $yeniResim2 = substr(uniqid(md5(rand())),0,35); // resim2 nin adı değiştiriliyor.
                $yeniResim2Adi = $yeniResim2.$resim2Uzanti;
                $hedefResimKlasor = "./ProjeResimler";
                
                    if(move_uploaded_file($resim1Kaynak,$hedefResimKlasor."/".$yeniResim1Adi))
                    {
                        if(move_uploaded_file($resim2Kaynak,$hedefResimKlasor."/".$yeniResim2Adi))
                        {
                               $ekle_sql = mysql_query("INSERT INTO proje (projeAdi,aciklama,link,demo,rarpass,boyut,resim1,resim2,uyeId) 
                               VALUES('$projeAdi','$aciklama','$link','$demo','$rarpass','$dosyaBoyut','$yeniResim1Adi','$yeniResim2Adi','".$_SESSION['uyeId']."')");
                               if($ekle_sql)
                               {
                                   //proje veritabanına kaydedilip proje dosyası ve resimler klasöre taşınınca özellik ekleme sayfasına yönlendiriliyor.
                                   echo "Proje kaydedildi. Şimdi proje özelliklerini eklemek için sayfaya yönlendiriliyorsunuz...";
                                   header("refresh: 2; url=index.php?admin=projeler&islem=OtoOzellikEkle");
                               }
                               else
                               {
                                   echo "Proje bilgileri veritabanına kaydedilemedi. Tekrar eklemek için yönlendiriliyorsunuz...";
                                   header("refresh: 2; url=index.php?admin=projeler&islem=ProjeEkle");
                               }
                        }
                        else
                        {echo "resim 2 yüklenemedi";}
                    }
                    else
                    {echo "resim 1 yüklenemedi";}
            }
        }
    
}

function ProjeListele() // proje.php sayfasına girildiğinde ilk bu kısım çalışıyor ve veritabanındaki projeleri listeliyor.
{
    echo '<script language="javascript"> 
    function SilmeOnayi(){var silinsin=confirm("Bu projeyi silmek istediğinizden emin misiniz?\nBu işlem geri alınamaz!");if (silinsin){return true;}else{return false;}}
    function PencereAc()
    {
        var x=screen.availWidth; var y=screen.availHeight;
        Pencere = window.open("","pencere",\'width=800 height=600 scrollbars=yes,top=\'+(y/2-100)+\',left=\'+(x/2-250));
        Pencere.focus();
    }
    </script>'; // bu javascript kodu silme onayı ve yeni pencere komutlarını içeriyor.
    $sayfa = @$_GET['s'];
	if($sayfa < 1){
		$baslangic = 0;
	}else{
		$baslangic = (($sayfa-1)*5);
	}
    $resimKlasor = "ProjeResimler/";
    $projeListele_sql = mysql_query("SELECT * FROM proje LIMIT $baslangic, 5");
    echo '
	<div class="table-responsive">
		<a href="index.php?admin=projeler&islem=ProjeEkle" class="btn btn-outline btn-success">Yeni Proje Ekle</a>
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr class="gradeA">
						<th>Proje Adı</th>
						<th>Boyut</th>
						<th>Resim 1</th>
						<th>Resim 2</th>
						<th colspan="3">İşlemler</th>
					</tr>
				</thead>';
    if(mysql_num_rows($projeListele_sql) > 0)
    {
        while($listele = mysql_fetch_array($projeListele_sql))
        {
					echo '
	<script language="javascript"> 
    function SilmeOnayi'.$listele['projeId'].'(){
	var silinsin=confirm("Bu Yazıyı silmek istediğinizden emin misiniz?\nBu işlem geri alınamaz!");
	if (silinsin){
	location.href=\'index.php?admin=projeler&islem=ProjeSil&proje='.$listele['projeId'].'\';
	return true;
	}
	else{
	return false;
	}}
	</script>';
            echo '		
			<tr>
				<td>'.$listele['projeAdi'].'</td><td>'.$listele['boyut'].'</td>
				<td align="center"><img src="'.$resimKlasor.$listele['resim1'].'" width="100" height="75" /></td>
				<td align="center"><img src="'.$resimKlasor.$listele['resim2'].'" width="100" height="75" /></td>
				<td align="center">
					<button class="btn btn-default btn-circle btn-lg" onclick="location.href=\'index.php?admin=projeler&islem=ProjeGuncelle&proje='.$listele['projeId'].'\';">
								<i  class="fa fa-check"></i>
					</button>
				</td>
				<td align="center">
					<button class="btn btn-danger btn-circle btn-lg" onclick="return SilmeOnayi'.$listele['projeId'].'();">
								<i  class="fa fa-times"></i>
					</button>
					</td>
				<td align="center">
					<button class="btn btn-success btn-circle btn-lg" onclick="location.href=\'index.php?admin=projeler&islem=OzellikListele&amp;proje='.$listele['projeId'].'\';">
								<i  class="fa fa-list"></i>
					</button>
				</td>
			</tr>';
        }
    }
    else
    {
        echo '<tr><td colspan="6" align="center"><font color="black"><b>Veritabanında kayıtlı proje bulunamadı.</b></font></td></tr>';
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
	$sqltoplamkisi =  mysql_query("SELECT * FROM proje"); 
	$toplamkisi = mysql_num_rows($sqltoplamkisi );
	if($sayfa >= 2){
	echo '<li><a href="index.php?admin=projeler&s='.($sayfa-1).'">Önceki Sayfa</a></li> ';
	}
	else {
		echo '<li class="disabled"><a>Önceki Sayfa</a></li> ';
	}
	for ($j = 1; $j <= ceil($toplamkisi /5); $j++){
	if($sayfa == $j){
		echo '<li class="active"><a>'.$sayfa.'</a></li>';
	}else{
		echo '<li><a href="index.php?admin=projeler&s='.$j.'">'.$j.'</a></li>';
	}
	}
	if($sayfa < ceil($toplamkisi /5)){
		echo '<li><a href="index.php?admin=projeler&s='.($sayfa+1).'" >Sonraki Sayfa</a></li>';
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
    $projeId = $_GET['proje'];
    if(!is_numeric($projeId)) // burada projeId nin geçerli olup olmadığı kontrol ediliyor.
    {
        echo "Parametre Hatası! Proje Sayfasına Yönlediriliyorsunuz...";
        header("refresh: 2; url=proje.php");
    }
    else
    {
        $resimKlasor = "ProjeResimler/";
        $projeGetir_sql = mysql_query("SELECT * FROM proje WHERE projeId='$projeId'");
        if(mysql_num_rows($projeGetir_sql) > 0)
        {
            $veriler = mysql_fetch_array($projeGetir_sql);
            echo '<table width="600" border="0" align="center">
            <caption>Proje Güncelleme Sayfası</caption>
            <form method="post" action="index.php?admin=projeler&islem=ProjeGuncelKayit&proje='.$projeId.'" enctype="multipart/form-data">
            <tr>
            <td width="20%">Proje Adı</td>
            <td>
            <input name="projeadi" type="text" size="80px" value="'.$veriler['projeAdi'].'" class="form-control"/>
            </td>
            </tr>
            <tr>
            <td>Açıklama</td>
            <td><input type="text" name="aciklama" size="80px" value="'.$veriler['aciklama'].'" class="form-control"/></td>
            </tr>
            <tr>
            <td>Link</td>
            <td><input type="text" name="link" size="80px" value="'.$veriler['link'].'" class="form-control"/></td>
            </tr>
            <tr>
            <td>Demo</td>
            <td><input type="text" name="demo" size="80px" value="'.$veriler['demo'].'" class="form-control"/></td>
            </tr>
            <tr>
            <td>Rar Şifresi</td>
            <td><input type="text" name="rarsifre" size="80px" value="'.$veriler['rarpass'].'" class="form-control"/></td>
            </tr>
            <tr>
            <td colspan="2">
            <table align="center" border="0">
            <tr>
            <td>Şuanki Resim 1</td>
            <td>Şuanki Resim 2</td>
            </tr>
            <tr>
            <td><img src="'.$resimKlasor.$veriler['resim1'].'" width="150" height="100" />
            <input name="eskiresim1" type="hidden" value="'.$resimKlasor.$veriler['resim1'].'"  class="form-control"/></td>
            <td><img src="'.$resimKlasor.$veriler['resim2'].'" width="150" height="100" />
            <input name="eskiresim2" type="hidden" value="'.$resimKlasor.$veriler['resim2'].'"  class="form-control"/></td>
            </tr>
            </table>
            </td>
            </tr>
            <tr>
            <td>Yeni Resim 1</td>
            <td><input type="file" name="resim1" size="70px" class="form-control"/></td>
            </tr>
            <tr>
            <td>Yeni Resim 2</td>
            <td><input type="file" name="resim2" size="70px" class="form-control"/></td>
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
        $resimKlasor = "ProjeResimler/";
        $projeKlasor = "Projeler/";
        $projeId = $_GET['proje'];
        $projeAdi = $_POST['projeadi'];
        $aciklama = $_POST['aciklama'];
        $projeLink = $_POST['link'];
        $demo = $_POST['demo'];
        $rarpass = $_POST['rarsifre'];
        $eskiResimler = array($_POST['eskiresim1'],$_POST['eskiresim2']);
        $resim1Kaynak = $_FILES['resim1']['tmp_name'];
        $resim2Kaynak = $_FILES['resim2']['tmp_name'];
        if($resim1Kaynak != null)
        {
            $resim1Adi = $_FILES['resim1']['name'];
            $resim1Tipi = $_FILES['resim1']['type'];
            $resim1Boyut = $_FILES['resim1']['size'];
            $resim1Uzanti = substr($resim1Adi, -4);
            if(($resim1Tipi != "image/jpeg") && ($resim1Tipi != "image/gif") && ($resim1Tipi != "image/x-png") && ($resim1Tipi != "image/png"))
            {
                echo "Resim 1 jpg,png veya gif olabilir";
            }
            else if($resim1Boyut > 1002400)
            {
                echo "Resim 1 en fazla 100 Kb olabilir.";
            }
            else
            {
                $yeniResim1 = substr(uniqid(md5(rand())),0,35);
                $yeniResim1Adi = $yeniResim1.$resim1Uzanti;
                if(move_uploaded_file($resim1Kaynak,$resimKlasor.$yeniResim1Adi))
                {
                    if(file_exists($eskiResimler[0]))
                    {
                        unlink($eskiResimler[0]);
                    }
                }
                else
                {
                    echo "Resim 1 yüklenemedi!";
                }
            }
        }
        else
        {
            $yeniResim1Adi = substr($eskiResimler[0], -39);
        }
        if($resim2Kaynak != null)
        {
            $resim2Adi = $_FILES['resim2']['name'];
            $resim2Tipi = $_FILES['resim2']['type'];
            $resim2Boyut = $_FILES['resim2']['size'];
            $resim2Uzanti = substr($resim2Adi, -4);
            if(($resim2Tipi != "image/jpeg") && ($resim2Tipi != "image/gif") && ($resim2Tipi != "image/x-png") && ($resim2Tipi != "image/png"))
            {
                echo "Resim 2 jpg,png veya gif olabilir";
            }
            else if($resim2Boyut > 1002400)
            {
                echo "Resim 2 en fazla 100 Kb olabilir.";
            }
            else
            {
                $yeniResim2 = substr(uniqid(md5(rand())),0,35);
                $yeniResim2Adi = $yeniResim2.$resim2Uzanti;
                
                if(move_uploaded_file($resim2Kaynak,$resimKlasor.$yeniResim2Adi))
                {
                    if(file_exists($eskiResimler[1]))
                    {
                        unlink($eskiResimler[1]);
                    }
                }
                else
                {
                    echo "Resim 2 yüklenemedi!";
                }
            }
        }
        else
        {
            $yeniResim2Adi = substr($eskiResimler[1], -39);
        }
        $guncelle_sql = mysql_query("UPDATE proje SET projeAdi='$projeAdi',aciklama='$aciklama',link='$projeLink',demo='$demo',rarpass='$rarpass',resim1='$yeniResim1Adi',resim2='$yeniResim2Adi' WHERE projeId='$projeId'");
        if($guncelle_sql)
        {
            echo "Proje güncellendi. Proje sayfasına yönlendiriliyorsunuz...";
            header("refresh: 2; url=index.php?admin=projeler");
        }
        else
        {
            echo "Proje güncellenemedi! Proje sayfasına yönlendiriliyorsunuz...";
            header("refresh: 2; url=index.php?admin=projeler");
        }              
    }
}

function ProjeSil() // burada seçilen proje ve bu projeye ait özellikler,dosya,resim1 ve resim2 hem klasörlerden hemde veritabanından siliniyor.
{
    $projeId = $_GET['proje'];
    $dosyaAl = mysql_fetch_array(mysql_query("SELECT projeId,projeAdi,resim1,resim2 FROM proje WHERE projeId='$projeId'"));
    $ozelliksil_sql = mysql_query("DELETE FROM proje_ozellikleri WHERE projeId='$projeId'");
    $sil_sql = mysql_query("DELETE FROM proje WHERE projeId='$projeId'");
    if($sil_sql)
    { 
        echo "Seçilen proje silindi. Proje sayfasına yönlendiriliyorsunuz.";
        header("refresh: 2; url=index.php?admin=projeler");
    }
    else
    {
        echo "Silme işleminde hata oluştu!";
    }
}

function OtoOzellikEkle() // proje eklendikten sonra direk buraya yönlendirliyor.
{
    $projeGetir = mysql_fetch_array(mysql_query("SELECT projeId,projeAdi,uyeId FROM proje WHERE uyeId='".$_SESSION['uyeId']."' ORDER BY projeId DESC LIMIT 0,1"));
    $projeAdi = $projeGetir['projeAdi'];
    $projeId = $projeGetir['projeId'];
    
    echo '<table align="center" width="600" border="0">
    <caption>Proje Özellikleri Ekleme Sayfası</caption>
    <form id="form1" name="form1" method="post" action="index.php?admin=projeler&islem=OtoOzellikKayit">
    <tr>
    <td>Proje Adı</td>
    <td><input type="text" name="projeadi" class="form-control" disabled="disabled" size="80px" value="'.$projeAdi.'"/></td>
    </tr>
    <tr>
    <td>Özellik</td>
    <td>
    <input type="text" class="form-control" autofocus name="ozellik" size="80px" />
    </td>
    </tr>
    <tr>
    <td>Tarih</td>
    <td>
    <input type="text" class="form-control" name="tarih" disabled="disabled" value="'.date("d.m.Y").'" />
    <input name="projeid" class="form-control" type="hidden" value="'.$projeId.'" />
    </td>
    </tr>
    <tr>
    <td><input type="submit" name="yeniozellik" class="btn btn-outline btn-primary" value="Yeni Özellik Ekle" /></td>
    <td align="right"><input type="submit" name="kaydet" class="btn btn-success btn-outline btn-primary" value="Kaydet ve Kapat" /></td>
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
            header("refresh: 2; url=index.php?admin=projeler&islem=OtoOzellikEkle");
        }
        else
        {
            $tarih = date("d.m.Y");
            $projeId = $_POST['projeid'];
            
            $OtoOzellikEkle_sql = mysql_query("INSERT INTO proje_ozellikleri(ozellik,tarih,projeId) VALUES('$ozellik','$tarih','$projeId')");
            if($OtoOzellikEkle_sql)
            {
                OtoOzellikEkle();  
            }
            else
            {
                echo "Özellik eklenemedi! Tekrar yönlendiriliyorsunuz...";
                header("refresh: 2; url=index.php?admin=projeler&islem=OtoOzellikEkle");
            }
        }        
    }
    if(isset($_POST['kaydet'])) // sağdakine tıklanınca son veriyi kaydedip proje.php sayfasına yönlendiriyor.
    {
        $ozellik = $_POST['ozellik'];
        if($ozellik == "")
        {
            echo "Özellik alanı boş bırakılamaz!";
            header("refresh: 2; url=index.php?admin=projeler&islem=OtoOzellikEkle");
        }
        else
        {
            $tarih = date("d.m.Y");
            $projeId = $_POST['projeid'];
            
            $OtoOzellikEkle_sql = mysql_query("INSERT INTO proje_ozellikleri(ozellik,tarih,projeId) VALUES('$ozellik','$tarih','$projeId')");
            if($OtoOzellikEkle_sql)
            {
                echo "Özellik eklendi. Anasayfaya yönlendiriliyorsunuz...";
                header("refresh: 2; url=index.php?admin=projeler");
            }
            else
            {
                echo "Özellik eklenemedi! Tekrar yönlendiriliyorsunuz...";
                header("refresh: 2; url=index.php?admin=projeler&islem=OtoOzellikEkle");
            }
        }
    }
}

function OzellikListele() // seçilen projeye ait özellikleri yeni bir pencerede listeliyor.
{
    $projeId = $_GET['proje'];
    if(!is_numeric($projeId))
    {
        echo "Parametre Hatası! Proje Sayfasına Yönlediriliyorsunuz...";
        header("refresh: 2; url=index.php?admin=projeler");
    }
    else
    {
	
        $ozellikler_sql = mysql_query("SELECT * FROM proje_ozellikleri WHERE projeId='$projeId'");
        $proje = mysql_fetch_array(mysql_query("SELECT projeAdi FROM proje WHERE projeId=$projeId"));
        echo '
		<table align="center" width="500" border="1" >
        <caption>['.$proje['projeAdi'].'] Projesine Ait Özellikler <br /> 
		<button type="button" class="btn btn-success btn-lg" onclick="location.href=\'index.php?admin=projeler&islem=OzellikEkle&proje='.$projeId.'\'">Yeni Özellik Ekle</i>
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
					location.href=\'index.php?admin=projeler&islem=OzellikSil&ozellik='.$ozellikListe['ozellikId'].'\';
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
	$projeId = $_GET['proje'];
    $projeGetir = mysql_fetch_array(mysql_query("SELECT projeAdi FROM proje WHERE projeId='$projeId'"));
    
	echo '<table align="center" width="600" border="0" >
    <caption>Proje Özellikleri Ekleme Sayfası</caption>
    <form method="post" action="index.php?admin=projeler&islem=OzellikKayit&proje='.$projeId.'">
    <tr>
    <td>Proje Adı</td>
    <td><input type="text" name="projeadi" class="form-control" disabled="disabled" size="80px" value="'.$projeGetir['projeAdi'].'"/></td>
    </tr>
    <tr>
    <td>Özellik</td>
    <td>
    <input type="text" name="ozellik" autofocus class="form-control" size="80px" />
    </td>
    </tr>
    <tr>
    <td>Tarih</td>
    <td>
    <input type="text" name="tarih" class="form-control" disabled="disabled" value="'.date("d.m.Y").'" />
    </td>
    </tr>
    <tr>
    <td><input type="submit" name="yeniozellik" class="btn btn-info" value="Yeni Özellik Ekle" /></td>
    <td align="right"><input type="submit" name="kaydet" class="btn btn-success" value="Kaydet ve Kapat" /></td>
    </tr>
    </form>
    </table>';
}

function OzellikKayit() // daha sonra eklenen özellik kayıt yeri. yine bunda da OtoOzellikEkle mantığı, yani 2 buton var.
{
    if(isset($_POST['yeniozellik']))
    {
        $projeId = $_GET['proje'];
        $ozellik = $_POST['ozellik'];
        if($ozellik == "")
        {
            echo "Özellik alanı boş bırakılamaz!";
            header("refresh: 2; url=index.php?admin=projeler&islem=OzellikEkle&proje=$projeId");
        }
        else
        {
            $tarih = date("d.m.Y");   
            $OtoOzellikEkle_sql = mysql_query("INSERT INTO proje_ozellikleri(ozellik,tarih,projeId) VALUES('$ozellik','$tarih','$projeId')");
            if($OtoOzellikEkle_sql)
            {
                OzellikEkle();  
            }
            else
            {
                echo "Özellik eklenemedi!";
                header("refresh: 2; url=index.php?admin=projeler&islem=OzellikEkle&proje=$projeId");
            }
        }        
    }
    if(isset($_POST['kaydet']))
    {
        $projeId = $_GET['proje'];
        $ozellik = $_POST['ozellik'];
        if($ozellik == "")
        {
            echo "Özellik alanı boş bırakılamaz!";
            header("refresh: 2; url=index.php?admin=projeler&islem=OzellikEkle&proje=$projeId");
        }
        else
        {
            $tarih = date("d.m.Y");            
            $OtoOzellikEkle_sql = mysql_query("INSERT INTO proje_ozellikleri(ozellik,tarih,projeId) VALUES('$ozellik','$tarih','$projeId')");
            if($OtoOzellikEkle_sql)
            {
                echo "Özellik eklendi. Proje özellik sayfasına yönlendiriliyorsunuz...";
                header("refresh: 2; url=index.php?admin=projeler&islem=OzellikListele&proje=$projeId");
            }
            else
            {
                echo "Özellik eklenemedi! Tekrar yönlendiriliyorsunuz...";
                header("refresh: 2; url=index.php?admin=projeler&islem=OzellikListele&proje=$projeId");
            }
        }
    }
}

function OzellikSil()
{
    $ozellikId = $_GET["ozellik"];
    $proje = mysql_fetch_array(mysql_query("SELECT projeId FROM proje_ozellikleri WHERE ozellikId='$ozellikId'"));
    $projeId = $proje['projeId'];
    $ozellikSil_sql = mysql_query("DELETE FROM proje_ozellikleri WHERE ozellikId='$ozellikId'");
    if($ozellikSil_sql)
    {
        echo "Özellik silindi. Özellik listesine yönlendiriliyorsunuz.";
        //echo "<script>self.close();</script>";
        header("refresh: 2; url=index.php?admin=projeler&islem=OzellikListele&proje=$projeId");
    }
    else
    {
        echo "Özellik silinemedi! Özellik listesine yönlendiriliyorsunuz.";
        //echo "<script>self.close();</script>";
        header("refresh: 2; url=index.php?admin=projeler&islem=OzellikListele&proje=$projeId");
    }
}

// burasıda sayfalardaki geçişler için swtich case yapısı.
$islem = @$_GET['islem'];
switch($islem)
{
    default:
        ProjeListele();
    break;
    case "ProjeEkle":
        ProjeEkle();
    break;
    case "ProjeKayit":
        ProjeKayit();
    break;
    case "ProjeGuncelle":
        ProjeGuncelle();
    break;
    case "ProjeGuncelKayit":
        ProjeGuncelKayit();
    break;
    case "ProjeSil":
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