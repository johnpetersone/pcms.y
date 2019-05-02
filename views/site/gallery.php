<?
	use yii\helpers\Url;
?>
<STYLE> 
	.tmb {object-fit: cover; width: 183px; height: 183px; transition: ease transform .5s} 
	.tmb:hover {transform: scale(1.6);}
</STYLE>
<?

$dir = '../uploads';
if (is_dir($dir)) {
	if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			if (substr($file,0,1) !='.') {
				?><IMG class="tmb" src="<?=Url::base(true).'/../uploads/'.$file?>"><?
			}
		}
	closedir($dh);
	}
}
?>
