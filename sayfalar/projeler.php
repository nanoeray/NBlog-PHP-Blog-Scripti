<?php
!defined("guvenlik") ? die("Bu sayfaya erişim yasaklanmıştır.") : NULL;
 include("./includes/fonksiyonlar.php") ?>
<?php
include("./ayarlar/veritabani.php");
$projeler = temizledegel(@$_GET['proje']);
switch ($projeler){
    case "":
	
	
$sayfa = temizledegel(@$_GET['s']);
if($sayfa < 1){
$baslangic = 0;
}else{
$baslangic = (($sayfa-1)*4);
}
$sirala = mysql_query("SELECT * FROM proje ORDER BY projeId DESC LIMIT $baslangic, 4");
                                         
                              echo '<table width="100%">
		<tr cellpacing="0" cellpadding="0"><td>';	   
$sira = $baslangic+1;
    while ($bul = mysql_fetch_array($sirala)){ 
$id = $bul ["0"]; 
$resim = $bul["7"]; 
$resim2 = $bul["8"];
$aciklama = $bul["2"];
$ad = $bul["1"];
$sira = $sira+1;
$aciklama2 = substr($aciklama,0,130);
$ad2 = sef_link($ad);
thumbnail_olustur('includes/admin/ProjeResimler/'.$resim.'','thumbs/250x100'.$resim.'',250, 100);

	echo '
<fieldset>
<legend>'.$ad.'</legend>
<table>
<tr>
<td align="center" class="kucuk-cihaz" rowspan="2">
<center>
<img src="thumbs/250x100'.$resim.'" class="kucuk-cihaz" width="250px" height="100px">
</center>
</td>
</tr>
<tr>
<td width="100%">
<b><font size="2px">'.$aciklama2.'</font></b>
</td>
<td>
<center>
<a href="projeler-'.$id.'-'.$ad2.'.html" class="btn btn-info">Projeyi İncele</a>
</center>
</td>
</tr>
</table>
</fieldset><br>';
	  
}
echo '</td></tr></table>';
echo '
<table align="center"><tr><td align="center" colspan="3">';
	  function sayfala($sayfa){
$sayfa = temizledegel(@$_GET['s']);
$sqltoplamkisi =  mysql_query("SELECT * FROM proje"); 
$toplamkisi = mysql_num_rows($sqltoplamkisi );
if($sayfa >= 2){
echo '<li><a href="projelerim-'.($sayfa-1).'.html">Önceki Sayfa</a></li> ';
}
else {
echo '<li class="disabled"><a>Önceki Sayfa</a></li> ';

}
for ($j = 1; $j <= ceil($toplamkisi /4); $j++){
if($sayfa == $j){
echo '<li class="active"><a>'.$sayfa.'</a></li>';
}else{
echo '<li><a href="projelerim-'.$j.'.html">'.$j.'</a></li>';
}
}

if($sayfa < ceil($toplamkisi /4)){
echo '<li><a href="projelerim-'.($sayfa+1).'.html" >Sonraki Sayfa</a></li>';
}
else {
echo '<li class="disabled"><a>Sonraki Sayfa</a></li> ';

}
}
echo '</td></tr></table>'; 
echo '<div style="float:right;">
<ul class="pagination  pagination-sm">';
sayfala($sayfa);
echo '</ul></div>';
    break;
    
    case $projeler:
    Listele($projeler);
    break;
}

/*׺ellikleri veritaban񮤡n al񰠬isteliyor*/
function Listele ($gelenId)
{
     echo '<div style="width: 100%;min-height: 390px;">
	 <div style="float:left">
    <b>Mevcut Özellikleri :</b><br>
    <ul class="bbc_list">';

    $liste_sql = mysql_query("SELECT * FROM proje_ozellikleri WHERE projeId='".$gelenId."'");
    while($veriYaz = mysql_fetch_array($liste_sql))
    {
        if(@$veriYaz["yeniMi"])
        {
            echo '<li><strong><span style="font-size: 1em;" class="bbc_size"><span style="font-family: Tahoma, Calibri, Verdana, Geneva, sans-serif;" class="bbc_font">'.$veriYaz["ozellik"].'&nbsp;<span style="color: Red;" class="bbc_color">Yeni</span></span></span></strong></li>';
        }
        else
        {
            echo '<li><strong><span style="font-size: 1em;" class="bbc_size"><span style="font-family: Tahoma, Calibri, Verdana, Geneva, sans-serif;" class="bbc_font">'.$veriYaz["ozellik"].'</span></span></strong></li>';
        }
    }
	$ayrinti_sql = mysql_query("SELECT * FROM proje WHERE projeId='".$gelenId."'");
	$ayrinti_sql2 = mysql_query("SELECT * FROM ayarlar WHERE id='1'");
	$veriYaz2 = mysql_fetch_array($ayrinti_sql);
	$veriYaz3 = mysql_fetch_array($ayrinti_sql2);
    echo '</ul>
    </div>
    <div class="panel panel-danger bilgilendirme" style="float:right">
	<div class="panel-heading">
    <h3 class="panel-title">Resimler</h3>
	</div>
	<div class="panel-body">
    <img src="./includes/admin/ProjeResimler/'.$veriYaz2["resim1"].'" width="300" height="150">
    <br>
	<img src="./includes/admin/ProjeResimler/'.$veriYaz2["resim2"].'" width="300" height="150">
	</div>
	</div>
    </div>
	<br>
	<center>
    <b>'.$veriYaz2["aciklama"].'</b><hr>
    <b>Dosya Boyutu : '.$veriYaz2["boyut"].'</b><br>
    <b> Rar Şifresi : <font color="red"><i>'.$veriYaz2["rarpass"].'</i></font> </b><br>
    <input type="button" class="btn btn-info" onclick="window.open(\''.$veriYaz2["demo"].'\')" target="_blank" value="Demoyu Gör">
    <input type="button" class="btn btn-info" onclick="window.open(\''.$veriYaz2["link"].'\')" value="Dosyayı İndir">
    </center>
	<br>
    <center><input type="button" class="btn btn-info" onclick="location.href=\'projelerim-1.html\'" value="< Geri"></center>';
}


?>