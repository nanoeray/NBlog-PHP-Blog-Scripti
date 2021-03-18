<?php
!defined("guvenlik") ? die("Bu sayfaya erişim yasaklanmıştır.") : NULL;
include("./ayarlar/veritabani.php");
include("./includes/fonksiyonlar.php");
$projebak = mysql_query("SELECT * FROM proje");
$saylanprojeyi = mysql_num_rows($projebak);                  
?>
<div class="row">
<div class="panel panel-success col-md-<?php if($saylanprojeyi > 0) { echo '6';} else { echo '12'; } ?>" style="border:0px;">
  <div class="panel-heading">
    <h3 class="panel-title">Son Blog Yazıları</h3>
  </div>
  <div class="panel-body" style="border: 1px solid #00bc8c;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;">
<div>
<table valign="top" cellpadding="0" cellspacing="0" width="100%">
<tr width="100%">
<td width="100%">
<?php
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
$sirala = mysql_query("SELECT * FROM blog ORDER BY id DESC LIMIT 4");

    while ($bul = mysql_fetch_array($sirala)){ 
$id = $bul["0"]; 
$resim = $bul["5"]; 
$aciklama = $bul["2"];
$okunma = $bul["okunma"];
$tarih = $bul["tarih"];
$blogad = $bul["blog_adi"];
$blogad2 = sef_link($blogad);
thumbnail_olustur('includes/admin/ProjeResimler/'.$resim.'','thumbs/'.$resim.'',120, 60);
	echo '
<table width="100%">
<tr width="100%">
<td align="center">
<center>
<img src="thumbs/'.$resim.'" border="1" bgcolor="black" class="kucuk-cihaz">
</center>
</td>
<td width="100%" colspan="2">
<b> <font style="font-size:11px">';
            $simdi=time();
            $sure = $simdi-strtotime($tarih);
if( $sure < 86400*7) 
{
echo $blogad.'<sup><font color="red">Yeni</font></sup>';
}
else
{
echo $blogad;
}
echo '</font></b></td><td>
<a href="blog-'.$id.'-'.$blogad2.'.html" class="btn btn-info btn-sm" style="float:right">Yazıyı Oku</a>
</td>
</tr>
</table><hr>';
}
?>
</td>
</tr>
</table>
</div>
  </div>
</div>
<div class="panel panel-warning col-md-6" style="border:0px;<?php if($saylanprojeyi > 0) { echo '';} else { echo 'display:none;'; } ?>">
  <div class="panel-heading">
    <h3 class="panel-title">Son Paylaşılan Dosyalar</h3>
  </div>
  <div class="panel-body" style="border: 1px solid orange;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;">

<div>
<table valign="top" cellpadding="0" cellspacing="0" width="100%">
<tr width="100%">
<td width="100%">
<?php
	$siralaProje = mysql_query("SELECT * FROM proje ORDER BY projeId DESC LIMIT 4");
                                         
    while ($bulProje = mysql_fetch_array($siralaProje)){ 
	$id = $bulProje["0"]; 
	$resim = $bulProje["resim1"]; 
	$aciklama = $bulProje["aciklama"];
	$projead = $bulProje["projeAdi"];
	$projeAdi = sef_link($projead);
	thumbnail_olustur('includes/admin/ProjeResimler/'.$resim.'','thumbs/'.$resim.'',120, 60);
		echo '
	<table width="100%">
	<tr width="100%">
	<td align="center" rowspan="2">
	<center>
	<img src="thumbs/'.$resim.'" border="1" bgcolor="black" class="kucuk-cihaz">
	</center>
	</td>
	<td width="100%"  style="font-size:11px">'.substr($aciklama, 0, 100).'</td>
	<td>
	<a href="projeler-'.$id.'-'.$projeAdi.'.html" class="btn btn-info btn-sm" style="float:right">İncele</a>
	</td>
	</tr>
	</table><hr>';
}
?>
</td>
</tr>
</table>
</div>
  </div>
</div>


<div class="panel panel-info col-md-12" style="border:0px;">
  <div class="panel-heading">
    <h3 class="panel-title">Popüler Blog Yazıları</h3>
  </div>
  <div class="panel-body" style="border: 1px solid #3498db;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;">
<div>
<table valign="top" cellpadding="0" cellspacing="0" width="100%">
<tr width="100%">
<td width="100%">
<?php
$sirala = mysql_query("SELECT * FROM blog WHERE okunma >= '50' ORDER BY okunma DESC LIMIT 5");
                                         
    while ($bul = mysql_fetch_array($sirala)){ 
$id = $bul["0"]; 
$resim = $bul["5"]; 
$aciklama = $bul["2"];
$okunma = $bul["okunma"];
$tarih = $bul["tarih"];
$blogad = $bul["blog_adi"];
$blogad2 = sef_link($blogad);
thumbnail_olustur('includes/admin/ProjeResimler/'.$resim.'','thumbs/'.$resim.'',120, 60);
	echo '
<table width="100%">
<tr width="100%">
<td align="center" rowspan="2">
<center>
<img src="thumbs/'.$resim.'" border="1" bgcolor="black" class="kucuk-cihaz">
</center>
</td>
<td width="60%">
<b> <font color="white" style="font-size:15px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $simdi=time();
            $sure = $simdi-strtotime($tarih);
if( $sure < 86400*7) 
{
echo $blogad.'<sup><font color="red">Yeni</font></sup>';
}
else
{
echo $blogad;
}
echo '</font></b></td><td width="250">
<a href="blog-'.$id.'-'.$blogad2.'.html" class="btn btn-info btn-sm" style="float:right">Yazıyı Oku</a>
</td>
</tr>
<tr>
<td>&nbsp;&nbsp;&nbsp;'.$aciklama.'</td>
<td align="right" width="250">Okunma: '.$okunma.' - Tarih: '.post_time($tarih).'</td>
</tr>
</table><hr>';
}
?>
</td>
</tr>
</table>
</div>
  </div>
</div>

</div>