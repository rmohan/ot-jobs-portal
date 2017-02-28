<?php

use Doctrine\DBAL\DriverManager;

$container = [
	'querybuilder' => function() use ($db) {
						$config = new \Doctrine\DBAL\Configuration();
						$connectionParams = array_merge($db, array('driver' => 'pdo_mysql'));
						$conn = DriverManager::getConnection($connectionParams, $config);
						$queryBuilder = $conn->createQueryBuilder() ;
						return $queryBuilder;
					},
	'login_service' => new LoginService($service['login_service']),
	'user_state' => UserState::getInstance()					
];


?>