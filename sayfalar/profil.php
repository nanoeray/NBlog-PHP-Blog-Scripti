<?php
!defined("guvenlik") ? header("location: /index.php") : true;
include('includes/fonksiyonlar.php');
			$uyeid = $_GET['id'];
            $uyeBilgi = mysql_query("SELECT * FROM uyeler WHERE nick='".$uyeid."'"); 
            $uyeRow = mysql_fetch_array($uyeBilgi); 
			$kadi = $uyeRow['nick']; 
			$ad = $uyeRow['ad']; 
			$soyad = $uyeRow['soyad']; 
			$email = $uyeRow['email']; 
			$puan = $uyeRow['puan']; 
			$d_tarihi = $uyeRow['d_tarih']; 
			$avatar = $uyeRow['avatar']; 
			$hakkinda = $uyeRow['hakkinda']; 



		echo '
		<table width="659" height="116" border="0" cellpadding="0" cellspacing="0" align="center">
					  <tr>
						<td width="178" rowspan="5"><img src="'.$avatar.'" width="200" height="180" border="0" alt="'.$kadi.' ,'.$ad.' '.$soyad.', NBlog KSS"></td>
						<td height="28" colspan="3" align="center">Profili Görüntülenen Üye : '.$ad.' '.$soyad.'</td>
					  </tr>
					  <tr>
						<td width="196" height="23">Rumuz</td>
						<td width="10" align="center">:</td>
						<td width="265">'.$kadi.'</td>
					  </tr>
					  <tr>
						<td height="21">Doğum Tarihi</td>
						<td align="center">:</td>
						<td>'.$d_tarihi.'</td>
					  </tr>
					  <tr>
						<td height="21">Puanı</td>
						<td align="center">:</td>
						<td>'.$puan.'</td>
					  </tr>
					  <tr valign="top">
						<td height="21">Hakkında</td>
						<td align="center">:</td>
						<td>'.$hakkinda.'</td>
					  </tr>
					</table>';
?>