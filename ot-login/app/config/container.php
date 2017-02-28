<?php

use Doctrine\DBAL\DriverManager;

$container = [
	'querybuilder' => function() use ($db) {
						$config = new \Doctrine\DBAL\Configuration();
						$connectionParams = array_merge($db, array('driver' => 'pdo_mysql'));
						$conn = DriverManager::getConnection($connectionParams, $config);
						$queryBuilder = $conn->createQueryBuilder() ;
						return $queryBuilder;
					}
];

$container['fb_params'] = function() use ($fb_params) {
    return $fb_params;
};

?>