<?php
!defined("guvenlik") ? die("Bu sayfaya erişim yasaklanmıştır.") : NULL;
include("./includes/fonksiyonlar.php") ?>

<?php

    include_once("baglanti.php");
	$islem = @$_GET['islem'];
	switch($islem)
	{
		case "":

	$iletisim = mysql_query("SELECT * FROM iletisim");
	if(mysql_num_rows($iletisim) > 0)
    {
		echo '<table border="1" align="center"><tr><td>Mesaj ID</td><td>Gönderen Ad Soyad</td><td>Gönderen IP</td><td colspan="2">Yönetim</td></tr>';

        while($listele = mysql_fetch_array($iletisim))
        {
            echo '<tr>
			<td>'.$listele['id'].'</td>
 			<td>'.$listele['ad'].' '.$listele['soyad'].'</td>
            <td align="center">'.$listele['ip'].'</td>
            <td align="center"><a href="index.php?admin=iletisim&islem=mesajsil&id='.$listele['id'].'" onclick="return SilmeOnayi();"><img src="butonlar/delete.png" border="0" alt="sil" /></a></td>
            <td align="center"><a href="index.php?admin=iletisim&islem=mesajoku&id='.$listele['id'].'"><img src="butonlar/list.png" border="0" alt="Oku" /></a></td>
           		
			</tr>';
        } echo '</table>';
    }
    else
    {
        echo '<tr><td colspan="6" align="center"><font color="white"><b>Henüz Gönderilmiş İletişim Mesajı Bulunmamaktadır.</b></font></td></tr></table>';
    }
	
	break;
	
	case "mesajsil":
	
	$id = $_GET['id'];
	

	$veriler = mysql_fetch_array(mysql_query("SELECT * FROM iletisim WHERE id='$id'"));
	$mSil_sql = mysql_query("DELETE FROM iletisim WHERE id='$id'");
	
	if($mSil_sql)
	{
		
		echo "Mesaj Silindi.. İletişim listesine yönlendiriliyorsunuz.";
        header("refresh: 2; url=index.php?admin=iletisim");
		}
	
	else
	{
		echo "Mesaj Silinemedi!!!. İletişim listesine yönlendiriliyorsunuz.";
        //echo "<script>self.close();</script>";
        header("refresh: 2; url=index.php?admin=iletisim");
	}
	break;
	
	case "mesajoku":
	$id = $_GET['id'];
	
	$veriler = mysql_fetch_array(mysql_query("SELECT * FROM iletisim WHERE id='$id'"));

	echo '<table align="center" border="1" width="100%">
	<tr>
		<td width="150px">Mesajı Gönderen :</td>
		<td>'.$veriler["ad"].' '.$veriler["soyad"].'</td>
	</tr>
	<tr>
		<td>Mail Adresi :</td>
		<td>'.$veriler["email"].'</td>
	</tr>
	<tr>
		<td>Tarih - IP</td>
		<td>'.$veriler["tarih"].' - '.$veriler["ip"].'
	</tr>
	<tr>
		<td colspan="2">'.$veriler["mesaj"].'</td>
	</tr>
	</table>';
	
	break;
}

?>
<?php include("./includes/temalar/thales/footer.php"); ?>