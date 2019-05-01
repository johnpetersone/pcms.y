<STYLE>
	DIV {
		background: #FAA;
		margin: 100px;
		padding: 50px;
		border-radius: 10px;
		font-family: monospace;
		font-size: 12pt;
		color: red;
	}
</STYLE>
<?
	?><DIV><?
	$config = require 'config/web.php';
	$db = $config['components']['db'];

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 'On');

	# CHECK DB name, user, password
	try {
		$dbh = new PDO($db['dsn'], $db['username'], $db['password']);
	} catch (Exception $e) { 
		die($e->getMessage().' check config/db.php'); 
	}
	
	# CHECK pages TABLE OR CREATE
	if( ! $dbh->query('SELECT 1 FROM pages') ) { 
		$result = $dbh->query('CREATE TABLE `pages` (`key` int(11) NOT NULL, `page` text NOT NULL, `title` text NOT NULL,`html` text NOT NULL,`description` text, `keywords` text) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=COMPACT;'); 
		if ( ! $result) die($dbh->errorInfo()[2].' can\'t create table, please drop PAGES table manually'); 
		
		$result = $dbh->query('INSERT INTO `pages` (`key`, `page`, `title`, `html`, `description`, `keywords`) VALUES (1, "index", "index", "<h2>happy cmsing</h2>", "pcms", "pcms");'); 
		if ( ! $result) die($dbh->errorInfo()[2].' can\'t insert fields, please drop PAGES table manually'); 

		$result = $dbh->query('ALTER TABLE `pages` ADD PRIMARY KEY (`key`);'); 
		if ( ! $result) die($dbh->errorInfo()[2].' can\'t set primary key, please drop PAGES table manually'); 

		$result = $dbh->query('ALTER TABLE `pages` MODIFY `key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;'); 
		if ( ! $result) die($dbh->errorInfo()[2].' can\'t set key autoincrement, please drop PAGES table manually'); 
	}	
	
	# CHECK FIELDS
	if( ! $dbh->query('SELECT page, title, html, description, keywords FROM pages LIMIT 1') ) {
		die($dbh->errorInfo()[2].' Malformed table, please drop PAGES table manually');
	}
	#uploads folder missing
	if ( ! file_exists('uploads') ) {
		if ( ! mkdir('uploads') ) die(getcwd().'/uploads folder missing. please create manually.');
	}
	chmod('uploads',0777);
	if( ! (decoct(fileperms('uploads')%512) == '777')) die (getcwd().'/uploads folder permissions need to be 777. could you please maybe aaaaa, you know.');
	
	
	?></DIV><?
	header('Location:web/page/index'); 
?>