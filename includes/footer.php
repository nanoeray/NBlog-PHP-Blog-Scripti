</div>
</div>
<div class="panel panel-default" style="text-align:centeR;">
  <div class="panel-body">
    Copyright &copy; 2009 - 2014 Tüm Haklarım Bende Gizlidir. - Eray Tuğrul Gül - İsmail Gül <a href="http://www.nanoeray.com" title="NBlog Kss v2.0" alt="NBlog Kss v2.0" target="_blank">NBlog Kss v2.0</a> | ♣El Emeği Göz Nuru PHP Kodlamasıdır.♣|
 <br> <a href="http://validator.w3.org/feed/check.cgi?url=http%3A//nanoeray.com/rss.xml" target="_blank"><img src="http://validator.w3.org/feed/images/valid-rss-rogers.png" alt="[Valid RSS]" title="Validate my RSS feed" /></a> - <a href="rss.xml">RSS Feed</a>
  </div>
</div>
</div>
<div class="sag-blok mobil-uyumluluk col-md-3 " style="">

<div class="panel panel-primary" >
  <div class="panel-heading">
    <h3 class="panel-title">Menü</h3>
  </div>
  <div class="panel-body">
  <ul class="nav nav-tabs">
	  <li class="active"><a href="#kategoriler" data-toggle="tab" aria-expanded="true">Kategoriler</a></li>
	  <li class=""><a href="#yorumlar" data-toggle="tab" aria-expanded="false">Son Yorumlar</a></li>
  </ul>
	<div id="myTabContent" class="tab-content"><br>
	  <div class="tab-pane fade active in" id="kategoriler">
		<ul class="list-group">
		  <?php
		   $kategoriSql = mysql_query("SELECT * FROM kategoriler ORDER BY id DESC");                                     
		   while ($kategoriBul = mysql_fetch_array($kategoriSql)){
		   $yaziSaySql = mysql_query("SELECT * FROM blog WHERE kat_Id = '".$kategoriBul['id']."'");
		   $sayi = mysql_num_rows($yaziSaySql);
		  ?>
		  <li class="list-group-item">
			<span class="badge"><?php echo $sayi ?></span>
			<?php echo "<a href='yazi-kategori-".$kategoriBul['ad']."-1.html'>".$kategoriBul['ad']."</a>"; ?>
		  </li>
			<?php
			}
			?>
		</ul>
	  </div>
	  <div class="tab-pane fade" id="yorumlar">
		<div class="list-group">
		<?php
		   $sonyyorumSql = mysql_query("SELECT * FROM blog_yorumlar ORDER BY tarih DESC limit 5");                                     
		   while ($yorumubul = mysql_fetch_array($sonyyorumSql)){
		   $yaziSql = mysql_query("SELECT * FROM blog WHERE id = '".$yorumubul['yazi_id']."'");
		   $yazi = mysql_fetch_array($yaziSql);
		   
		   $uyeSql = mysql_query("SELECT * FROM uyeler WHERE id = '".$yorumubul['uye_id']."'");
		   $uye = mysql_fetch_array($uyeSql);
		   
		   
		   $yazisef= sef_link($yazi['blog_adi']);
		   thumbnail_olustur($uye['avatar'],'thumbs/avatarlar/'.'uyeavatar'.$uye['id'].'.jpg',38, 38);

		  ?>
		  <a href="blog-<?php echo $yazi['id'] ?>-<?php echo $yazisef; ?>.html" class="list-group-item" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Tooltip on bottom">
			<table>
				<tr>
					<td rowspan="2" style="border-right: 1px dotted #444;padding-right: 3px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Tooltip on bottom"><img src="thumbs/avatarlar/uyeavatar<?php echo $uye['id'].'.jpg'; ?>" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Tooltip on bottom"></td>
					<td style="padding-left:3px;" ><h5 class="list-group-item-heading"><?php echo $yazi['blog_adi']; ?></h4></td>
				</tr>
				<tr>
					<td><p class="list-group-item-text" style="padding-left:5px;color:white;text-shadow: 1px 0 0 #000, -1px 0 0 #000, 0 1px 0 #000, 0 -1px 0 #000, 1px 1px #000, -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000;"><?php echo $yorumubul['yorum']; ?></p></td>
				</tr>
			</table>
		  </a>
		  <?php } ?>
		</div>
	  </div>
	</div> 
  </div>
</div>

<div class="panel panel-primary" >
  <div class="panel-heading">
    <h3 class="panel-title">Hakkımda</h3>
  </div>
  <div class="panel-body">
	<ul class="nav nav-tabs">
	  <li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">Hakkımda</a></li>
	  <li class=""><a href="#profile" data-toggle="tab" aria-expanded="false">Yeteneklerim</a></li>
	</ul>
	<div id="myTabContent" class="tab-content"><br>
	  <div class="tab-pane fade active in" id="home">
		<center><img width="200px" src="https://fbcdn-sphotos-d-a.akamaihd.net/hphotos-ak-xap1/v/t1.0-9/1383060_777828795575924_570492419_n.jpg?oh=400666b091114d8e4b5d865bb089a91e&oe=54ED9505&__gda__=1423268742_2d33692dff527241b27169ca33e36d79"><br>
		</center><br><br>
		Kendini programlamaya atamış, bir çok websitesi ve online oyunda emeği geçmiş kişilik/webmaster.<br>
		Evet o ben oluyorum :)<br>
		<br>
		<p class="text-success">Kodlama : +9 7 Efsun 3 Taşlı;</p>
		<p class="text-warning">Tasarım : +5 5 Efsun Taşsız;</p>

	  </div>
	  <div class="tab-pane fade" id="profile">
		<table width="100%">
			<tr>
				<td>  
					<div>PHP</div>	
				</td>
				<td width="65%">
					<div class="progress progress-striped">
					<div class="progress-bar progress-bar-success" style="width: 100%"></div>
				</div>
				</td>
			</tr>
			<tr>
				<td>
					<div>HTML / CSS</div>	
				</td>
				<td>
					<div class="progress progress-striped">
					<div class="progress-bar progress-bar-success" style="width: 100%;"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div>PS</div>	
				</td>
				<td>
					<div class="progress progress-striped">
					<div class="progress-bar progress-bar-info" style="width: 90%;"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div>ASP / .NET</div>	
				</td>
				<td>
					<div class="progress progress-striped" style="width:100%;">
					<div class="progress-bar progress-bar-danger" style="width: 30%;"></div>
					</div>
				</td>
			</tr>
		</table>
	  </div>
	</div>  
  </div>
</div>

<div class="panel panel-primary" >
  <div class="panel-heading">
    <h3 class="panel-title">Reklamlar</h3>
  </div>
  <div class="panel-body">
    <script type="text/javascript">
    google_ad_client = "ca-pub-0624887056257934";
    google_ad_slot = "8396976457";
    google_ad_width = 300;
    google_ad_height = 250;
</script>
<!-- Nanoeray Sağ Reklam -->
<script type="text/javascript"
src="//pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
  </div>
</div>

</div>

</div>
</body>
</html>
<?php
ob_end_flush();
?>