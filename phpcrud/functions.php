<?php

/**
 * @return PDO
 */
function pdo_connect_mysql(): PDO {
    $DATABASE_HOST = 'localhost:3307';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'students_table';
    try {
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
        exit('Failed to connect to database!');
    }
}


function template_header($title) {
    echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="../styles/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<h1>Welcome!</h1>
            <a href="index.php"><i class="fas fa-home"></i>Home</a>
    		<a href="readStudents.php"><i class="fas fa-address-book"></i>Students</a>
    		<a href="readSubjects.php"><i class="fas fa-book-reader"></i>Subjects</a>
    	</div>
    </nav>
EOT;
}

function template_footer() {
    echo <<<EOT
    </body>
</html>
EOT;
}
?>