<?php
include "ayarlar/veritabani.php";
	function sef_link($baslik)
	{
		$baslik = str_replace(array("&quot;","&#39;"), NULL, $baslik);
		$bul2 = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '-');
		$yap = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', ' ');
		$perma = strtolower(str_replace($bul2, $yap, $baslik));
		$perma = preg_replace("@[^A-Za-z0-9\-_]@i", ' ', $perma);
		$perma = trim(preg_replace('/\s+/',' ', $perma));
		$perma = str_replace(' ', '_', $perma);
		return $perma;
	}
header("Content-type: text/xmlns");
header("Content-type: text/html; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom"
xmlns:content="http://purl.org/rss/1.0/modules/content/"
xmlns:wfw="http://wellformedweb.org/CommentAPI/"
xmlns:dc="http://purl.org/dc/elements/1.1/"
xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
xmlns:slash="http://purl.org/rss/1.0/modules/slash/">
<channel>
<atom:link href="http://www.nanoeray.com/rss.xml" rel="self"/>
<title><![CDATA[NBlog KSS Kişisel Site Sistemi RSS]]></title>
<link>http://www.nanoeray.com</link>
<description><![CDATA[NBlog KSS RSS Beslemesi]]></description>
<language>tr-tr</language>
<managingEditor>info@nanoeray.com (Eray Tuğrul Gül)</managingEditor>';
 
$rssSql = mysql_query("SELECT * FROM blog order by tarih desc limit 5");
while($rss = mysql_fetch_assoc($rssSql)) {
 $ayarlar2 = mysql_query("SELECT * FROM ayarlar");
 $ayarlar = mysql_fetch_assoc($ayarlar2);
$yazi_ad = sef_link($rss['blog_adi']);
$link = "blog-".$rss['id']."-".$yazi_ad.".html"; 
$tarih = strtotime($rss['tarih']);
$d = date( 'Y-m-d H:i:s T', $tarih );
$mysqldate = gmdate(DATE_RSS, strtotime($d));

$url=  "http://www.nanoeray.com/".$link;
echo "
<item>
<title>".$rss['blog_adi']."</title>
<guid>".$url."</guid>
<pubDate>".$mysqldate."</pubDate>
<description><![CDATA[".$rss['k_aciklama']."]]></description>
</item>";
}
 
echo "
</channel>
</rss>";
header("Content-type: text/xmlns");
?>