<?php
!defined("guvenlik") ? die("Bu sayfaya erişim yasaklanmıştır.") : NULL;

 include("./includes/fonksiyonlar.php") ?>
<?php
include("./ayarlar/veritabani.php");
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
switch(@$_GET['tur'])
{
	case "yazi":
	$kat = @$_GET['kategori'];
	$kategoribulsql = mysql_query("SELECT * FROM kategoriler WHERE ad = '".$kat."'");
	$katbul = mysql_fetch_array($kategoribulsql);
	$kategori = $katbul['id'];
$sayfa = temizledegel(@$_GET['s']);
if($sayfa < 1){
$baslangic = 0;
}else{
$baslangic = (($sayfa-1)*4);
}
$sirala = mysql_query("SELECT * FROM blog WHERE kat_Id = '".$kategori."' ORDER BY id DESC LIMIT $baslangic, 5");
    $sira = mysql_num_rows($sirala);
if($sira > 0)
{	                                         
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
<b><font size="2px">'.$aciklama.'</font></b><a href="blog-'.$id.'-'.$ad2.'.html" class="btn btn-info" style="float:right;">Yazıyı Oku</a>
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
$kategoribulsql = mysql_query("SELECT * FROM kategoriler WHERE ad = '".$_GET['kategori']."'");
	$katbul = mysql_fetch_array($kategoribulsql);
	$kategori = $katbul['id'];
$sayfa = temizledegel(@$_GET['s']);
$sqltoplamkisi =  mysql_query("SELECT * FROM blog WHERE kat_Id = '".$kategori."' "); 
$toplamkisi = mysql_num_rows($sqltoplamkisi );
if($sayfa >= 2){
echo '<li><a href="yazi-kategori-'.$_GET['kategori'].'-'.($sayfa-1).'.html">Önceki Sayfa</a></li> ';
}
else {
echo '<li class="disabled"><a>Önceki Sayfa</a></li> ';

}
for ($j = 1; $j <= ceil($toplamkisi /5); $j++){
if($sayfa == $j){
echo '<li class="active"><a>'.$sayfa.'</a></li>';
}else{
echo '<li><a href="yazi-kategori-'.$_GET['kategori'].'-'.$j.'.html">'.$j.'</a></li>';
}
}

if($sayfa < ceil($toplamkisi /5)){
echo '<li><a href="yazi-kategori-'.$_GET['kategori'].'-'.($sayfa+1).'.html" >Sonraki Sayfa</a></li>';
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
	}
	else {
		echo 'Henüz Bu Kategoride Yazı Paylaşılmamış.';
	}
	break;
}
?>