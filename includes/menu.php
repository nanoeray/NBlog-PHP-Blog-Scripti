<?php
 if(isset($_SESSION['karakter'])){
$sor = mysql_query("SELECT * FROM ozel_mesaj WHERE durum='0' and uyeid='".$_SESSION["id"]."' ORDER BY tarih DESC LIMIT 5");
$say = mysql_num_rows($sor);
 echo '<a href="index.php" class="ilk2">Anasayfa</a>'; } else { echo '<a href="index.php" class="ilk">Anasayfa</a>'; }?><?php if(isset($_SESSION['karakter'])){ echo '<a href="kullanici-paneli.html" class="orta2">Kullanıcı Paneli <sub><font color="yellow">Yeni</font></sub></a>'; } else{ echo '<a id="goster" onclick="this.style.display=\'none\';gizle.style.display=\'\';noti.style.display=\'block\'" style="cursor:pointer;" class="orta3">Üye Girişi<sub><font color="yellow">Yeni</font></sub></a><a name="Gizle" onclick="noti.style.display=\'none\';this.style.display=\'none\';goster.style.display=\'\'" class="orta3" style="display:none;cursor:pointer;" id="gizle">Üye Girişi<sub><font color="yellow">Yeni</font></sub></a>'; } ?><a class="ara"></a><a href="market.html" class="orta">Market<sub><font color="yellow">Yeni</font></sub></a><a href="dosyalar.html" class="orta">Dosyalar</a><a href="blog.html" class="orta">Blog</a><a href="iletisim-1.html" class="son">İletişim</a><br>
<div class="menubar2" style="    width: 100%;"><a href="http://imperial.nanoeray.com" class="menubar">Imperial Online</a><a href="http://forum.scificenter.org" class="menubar">Sci Fi Center Forum</a>
<?php
if(isset($_SESSION['karakter'])){ ?>
<a class="menubar2" href="ozel-mesajlar.html" style="
    width: 32px;
    position: absolute;
   cursor:pointer;
"><img src="./includes/temalar/RiBaRoN/resimler/ikonlar/mesaj.png" style="
    position: absolute;
    right: -180;
    top: 5px;
"></a>
<a class="menubar2" onclick="bildirim.style.display='none';this.style.display='none';goster.style.display=''" id="gizle" style="
    width: 32px;
    position: absolute;
   cursor:pointer;
"><img src="./includes/temalar/RiBaRoN/resimler/ikonlar/bildirim.png" style="
    position: absolute;
    right: -205;
    top: 5px;
">
<?php
if(!$say == 0) {
?>
<div style="
    height: 15;
    width: 15;
    background: red;
    position: relative;
    top: -3px;
    z-index: 1;
    right: -229;
    border-radius: 3;
    border: 1px solid black;
"></div>
<div style="
    position: absolute;
    right: -212;
    top: -10;
    /* background: red; */
    height: 20;
    width: 13;
            
    z-index: 2;
"><?php echo $say; ?></div>
<?php
}
?></a>
<a class="menubar2" id="goster" onclick="bildirim.style.display='block';this.style.display='none';gizle.style.display=''" style="
    width: 32px;
    position: absolute;
    cursor:pointer;
"><img src="./includes/temalar/RiBaRoN/resimler/ikonlar/bildirim.png" style="
    position: absolute;
    right: -205;
    top: 5px;
">
<?php
if(!$say == 0) {
?>
<div style="
    height: 15;
    width: 15;
    background: red;
    position: relative;
    top: -3px;
    z-index: 1;
    right: -229;
    border-radius: 3;
    border: 1px solid black;
"></div>
<div style="
    position: absolute;
    right: -212;
    top: -10;
    /* background: red; */
    height: 20;
    width: 13;
            
    z-index: 2;
"><?php echo $say; ?></div>
<?php
}
?></a>
</div>
<div id="bildirim" style="display:none;position: absolute;
top: 99;
z-index: 500;
width: 260px;
min-height: 75px;
border-radius: 0px 0px 10px 10px;
margin-left: 544px;
border: 1px solid rgb(61, 61, 61);
background: rgb(226, 226, 226);
color: black;
text-shadow: 1px 1px 1px white;">
<?php
if($say > 0) {
while($bildirim = mysql_fetch_array($sor))
{

								$gonderen2 = $bildirim['gonderenid']; 
								$tarih2 = $bildirim['tarih']; 
								$gonderenbilg2 = mysql_query("SELECT * FROM uyeler WHERE id='".$gonderen2."'"); 
								$gonderenbilgi2 = mysql_fetch_array($gonderenbilg2);
								$gonderennick2 = $gonderenbilgi2["nick"];

echo '<b style="font-size:12px;"><a href="profil-'.$gonderennick2.'.html"><font color="blue" >'.$gonderennick2.'</font></a> size bir <a href="ozel-mesajlar.html"><font color="blue">özel mesaj</font></a> gönderdi</b><br>';
}
}else {
echo 'Bildiriminiz Bulunmamaktadır.';
}
?>
</div>
<?php if(isset($_SESSION['karakter'])){
//include("includes/bildirimler.php");
}
else {
echo '';
}
}
if(isset($_POST['girisbutton'])){ 

            $kadi = $_POST['kadi']; 
            $sifre = md5($_POST['sifre']); 
            $sql = mysql_query("Select * from uyeler where nick='$kadi' and sifre='$sifre'"); 
            $say = mysql_num_rows($sql); 
            $row = mysql_fetch_array($sql); 
            $durum = $row['durum']; 

			if($kadi == "" || $sifre == "")
			{
			echo 'Tüm Alanları Doldurunuz';
			    header("refresh:2"); 
			}
			elseif($durum == 1){ 
                     echo'Hesabınız Kapatılmıştır. Eğer Haksız yere hesabınızın kapatıldığını<br> düşünüyor iseniz <b>İletişim</b>Sayfasından bize ulaşabilirsiniz.<br>'; 
                    header("refresh:2"); 
                     }              
            elseif($say > 0){ 
                    $_SESSION['karakter'] = true; 
                    $_SESSION['kadi'] = $kadi; 
                    $_SESSION['id'] = $row['id']; 
				header("Location:kullanici-paneli.html");
                 
                } else{ 
                        echo 'Kullanıcı Adı veya Şifre Yanlış. Lütfen Tekrar Deneyin.<br>'; 
                } 
             
        }
?>
<div class="orta" style="padding-top: 5px;padding-left: 5px;padding-right: 5px;display: none;width: 230px;height: 100px;position: absolute;top: 50px;z-index: 500;margin-left: 70px;border: 1px solid rgb(61, 61, 61);background: rgb(226, 226, 226);color: black;text-shadow: 1px 1px 1px white;border-radius: 0px 0px 10px 10px;" id="noti" name="noti">
	<table>
		<tbody>
			<form action="" method="post"> 
				<tr>
					<td>
						<input name="kadi" type="text" placeholder="Kullanıcı Adı" size="40" style="width: 150px;">
					</td>
					<td rowspan="2">
						<input type="submit" class="yorumyap" name="girisbutton" value="Giriş Yap"><br>
						<button class="yorumyap" style="width: 71;left: 2px;top: 1px;position: relative;">Şifre İste</button>
					</td>
				</tr>
				<tr>
					<td>
						<input name="sifre" type="password" placeholder="Şifreniz" size="40" style="width: 150px;">
					</td>
				</tr>
			</form>
		</tbody>
	</table>
	<button class="yorumyap" style="left: 2px;top: 1px;position: relative;" onclick="location.href='uye-ol.html'">Yeni Kullanıcı Kaydı</button>	
</div>

<!---->




