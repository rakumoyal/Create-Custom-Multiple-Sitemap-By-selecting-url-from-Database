<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zsolt";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

/* Wordpress Query for wp_posts tables link*/
//$sql = "SELECT CONCAT('http://localhost/zsolt/',(SELECT wp_terms.slug FROM `wp_term_relationships`,wp_terms where wp_term_relationships.object_id = wp_posts.ID and wp_terms.term_id=wp_term_relationships.term_taxonomy_id limit 1),'/',post_name) as guiddetail FROM `wp_posts` group by guiddetail ORDER BY `wp_posts`.`ID` DESC";

/* Any table work as your wish*/
 $sql = "SELECT CONCAT('http://localhost/project_name/',post_name) as guiddetail FROM `posts` group by guiddetail ORDER BY `posts`.`ID` DESC";

$result = $conn->query($sql);


$t = "\t";
$n = "\n";


$firstsitemap = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';


$counter=1;
$main= "";
$checkcounter = 1;

while($row = mysqli_fetch_array($result))
{
	$main.= '<url>'."$n";
	$row['guiddetail'] =preg_replace('/&([^#])(?![a-z1-4]{1,8};)/i', '&#038;$1',$row['guiddetail'] );
	$main.= "$t".'<loc>'.$row['guiddetail'].'</loc>'."$n";
	$main.= '</url>'."$n";

	if($counter%300==0){
		$xml = '<?xml version="1.0" encoding="UTF-8"?>'."$n";
		$xml.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."$n";
		$xml.=$main;
		$xml.= '</urlset>';	
		// if($checkcounter==0){

		// 	$handle = fopen('allsitemap/sitemap.xml','w+');
		// 	fwrite($handle,$xml);
		// 	fclose($handle);
		// }
		// else{
		$name = "allsitemap/sitemap".$checkcounter.".xml";
			$handle = fopen($name,'w+');
			fwrite($handle,$xml);
			fclose($handle);
		// }	


		$checkcounter++;
		$main="";

		$firstsitemap .= '<sitemap>
		<loc>http://localhost/first/'.$name.'</loc>
		</sitemap>';
	}	
	$counter++;
}

if($main!=""){
	$name = "allsitemap/sitemap".$checkcounter.".xml";
	$xml = '<?xml version="1.0" encoding="UTF-8"?>'."$n";
	$xml.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."$n";
	$xml.=$main;
	$xml.= '</urlset>';
	$handle = fopen($name,'w+');
	fwrite($handle,$xml);
	fclose($handle);
	$main="";
	$firstsitemap .= '<sitemap>
		<loc>http://localhost/first/'.$name.'</loc>
		</sitemap>';
}

$firstsitemap .= '</sitemapindex>';
$handle = fopen('sitemap.xml','w+');
fwrite($handle,$firstsitemap);
fclose($handle);



echo "Done";
