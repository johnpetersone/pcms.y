<STYLE> 
	.tmb {object-fit: cover; width: 183px; height: 183px; transition: ease transform .5s} 
	.tmb:hover {transform: scale(1.6);}
</STYLE>
<?
if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] != 'off'))  $imageURLBase = 'https://'; 
else $imageURLBase = 'http://';
$imageURLBase.= $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']).'/../uploads/';

$dir = '../uploads';
if (is_dir($dir)) {
	if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			if (substr($file,0,1) !='.') {
				?><IMG class="tmb" src="<?=$imageURLBase.$file?>"><?
			}
		}
	closedir($dh);
	}
}
?>
