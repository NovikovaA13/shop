<?php
ini_set('display_errors', 'Off');

include(__DIR__ .'/biblioPOO.php');

function xmlEscape($string) {
    return str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
}

$sql = new SQL();
$result = $sql->command("SELECT id, title FROM subcategory");
if ($result > 0) {
	header('Content-Type: application/xml');
	$output = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	echo $output;
	echo '<sitemapindex xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">';

	foreach ($result as $row) {
		
			$url = xmlEscape('http://a0288483.xsph.ru?'. $row['title'] .'&cid='. $row['id']);
			echo  "<sitemap><loc>$url</loc>	<lastmod>";
			echo  date('Y-m-dTH:i:sP', time());
			echo '</lastmod>
			</sitemap>';
			
		}
	echo '</sitemapindex>';
}
	