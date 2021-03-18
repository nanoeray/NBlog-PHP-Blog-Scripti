<?php 
	function thumbnail_olustur($path,$save,$width,$height){
		$bilgi = getimagesize($path);
		$boyut = array($bilgi[0],$bilgi[1]);

		if($bilgi['mime'] == "image/png"){
			// png
			$src = imagecreatefrompng($path);
		}else if($bilgi['mime'] == "image/jpeg"){
			// jpeg
			$src = imagecreatefromjpeg($path);
		}else if($bilgi['mime'] == "image/gif"){
			// gif
			$src = imagecreatefromgif($path);
		}else {
			return false;
		}

		$resim = imagecreatetruecolor($width, $height);

		$src_gorunum = $boyut[0] / $boyut[1];
		$thumb_gorunum = $width / $height;

		if($src_gorunum < $thumb_gorunum){
			// dar
			$olcek = $width / $boyut[0];
			$yeni_boyut = array($width, $width / $src_gorunum);
			$src_pozisyon = array(0, ($boyut[1] * $olcek - $height) / $olcek / 2);
		}else if($src_gorunum > $thumb_gorunum){
			// geniş
			$olcek = $height / $boyut[1];
			$yeni_boyut = array($height * $src_gorunum, $height);
			$src_pozisyon = array(($boyut[0] * $olcek - $width) / $olcek / 2, 0);
		}else {
			// olduğu gibi
			$yeni_boyut = array($width,$height);
			$src_pozisyon = array(0,0);
		}

		$yeni_boyut[0] = max($yeni_boyut[0],1);
		$yeni_boyut[1] = max($yeni_boyut[1],1);

		imagecopyresampled($resim, $src, 0, 0, $src_pozisyon[0], $src_pozisyon[1], $yeni_boyut[0], $yeni_boyut[1], $boyut[0], $boyut[1]);

		if($save === false){
			return imagepng($resim);
		}else {
			return imagepng($resim,$save);
		}
	}
?>