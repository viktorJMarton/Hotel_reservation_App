<?= require_once 'init/db_connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>My Page</title>
</head>
<body>
	<h1>Database Connection Parameters:</h1>
	<ul>
		<li>Database Name: <?= $db->getDbName() ?></li>
		<li>User: <?=$db->getUser()  ?></li>
	</ul>
</body>
</html>
