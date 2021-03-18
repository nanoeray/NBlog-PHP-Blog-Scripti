<?php
	if(isset($_POST['kaydol']))
	{
            $kadi = strip_tags($_POST['nick']); 
            $ad = strip_tags($_POST['ad']); 
            $soyad = strip_tags($_POST['soyad']);
            $email = $_POST['email']; 
            $hakkimda = strip_tags($_POST['hakkimda']); 
            $d_tarihi = strip_tags($_POST['d_tarihi']); 
			
			$deger = md5(rand(10,99));
			$sifre = substr($deger,0,6);
			$yenisifre = md5($sifre);
			if(empty($kadi) || empty($ad) || empty($soyad) || empty($email) || empty($hakkimda) || empty($d_tarihi))
			{
			echo 'Tüm Alanları Doldurunuz';
			header("refresh:2; url=uye-1.html"); 
			}
			else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				echo "geçersiz email adresi ($email)";
			}
			else
			{
					$uyeKontrol_sql = mysql_query("SELECT nick,email FROM uyeler WHERE nick='$kadi' OR email='$email'");
					if(mysql_num_rows($uyeKontrol_sql) > 0)
					{
						echo "$kadi kullanıcı adı veya $email email adresi daha önceden alınmıştır.";
					}
					else
					{
						$ekleSql = mysql_query("INSERT INTO uyeler(nick,ad,soyad,email,hakkinda,d_tarih,sifre) values('$kadi','$ad','$soyad','$email','$hakkimda','$d_tarihi','$yenisifre')");
						if($ekleSql)
						{
								//Mail Gönderimi Başlıyor.
								$kime = $email;
								$konu = "".$title." üyelik başvuru bilgileri";
								$mesaj = "Sayın <b>".$ad." ".$soyad."</b> <br>Üyelik kaydınız yapılmıştır.<br>";
								$mesaj .= "<br>Kullanıcı adınız : <b>".$kadi."</b><br>";
								$mesaj .= "Geçici Şifreniz : <font color='red'><b>".$sifre."</b></font><br>";
								$mesaj .= "<br>Siteye ilk üye girişinde şifrenizi değiştirmeniz talep edilecektir.<br>";
								$header = "Content-type: text/html; charset=UTF-8\n";
								$header .= "From : info@nanoeray.com";				
								@mail($kime,$konu,$mesaj,$header);

								echo '<div class="alert alert-dismissable alert-success">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <strong>Üyelik bilgileriniz ve şifreniz <font color="red"><b>$email</b></font> adresine gönderildi.<br><br>Gereksiz/Spam klasörüne de düşebilir.</strong>
							</div>';
						}
						else
						{
							echo '<div class="alert alert-dismissable alert-danger">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <strong>Hata! Üyelik Başarısız!</strong>
							</div>';
						}
					}
			}			

        }
		else { 
                     
                if(isset($_SESSION['karakter'])){ 				
                 header("location: /index.php"); 		
				} else{ 
				
							echo '
							<div class="panel panel-success">
								<div class="panel-heading">
								<h3 class="panel-title">Yeni Üyelik Kaydı</h3>
							</div>
							<div class="panel-body">
								<div class="alert alert-dismissable alert-info">
								  <strong>Üye Olurken Türkçe Karakter Kullanmayın</strong>
								</div>	
								<div class="alert alert-dismissable alert-success">
								  <strong> Şifreniz rastgele oluşturulup maile gönderilecektir. </strong>
								</div>
								<form action="" method="post"> 
							  <div align="center" style="margin-top:5px;">
								  <input name="nick" type="text" placeholder="Kullanıcı Adı" class="form-control">
								</div>
							  <div align="center" style="margin-top:5px;">
								<input name="ad" type="text" placeholder="Adınız" class="form-control">
							  </div>
							  <div align="center" style="margin-top:5px;">
								<input name="soyad" type="text" placeholder="Soyadınız" class="form-control">
							  </div>
							  <div align="center" style="margin-top:5px;">
								<input name="email" type="text" placeholder="E-posta Adresiniz" class="form-control">
							  </div>
							  <div align="center" style="margin-top:5px;">
								Doğum Tarihiniz: <input name="d_tarihi" type="date" placeholder="Doğrum Tarihiniz" class="form-control">
							  </div>
							  <div align="center" style="margin-top:5px;">
								<textarea rows="5" name="hakkimda" placeholder="Bize kendinizden bahsedin...." class="form-control"></textarea>
							  </div>


							  <p align="center">
								<br>
								<input type="submit" class="btn btn-success" name="kaydol" value="Üyeliği Tamamla">
							  </p>
							</form>
						  </div>
						</div>';
					}

			}
?>