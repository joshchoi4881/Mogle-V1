<?php
	$cwd = substr(getcwd(), -5);
	if(strcmp($cwd, "mogle") != 0) {
		require "../vendor/autoload.php";
	} else {
		require "vendor/autoload.php";
	}
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, "../.env");
	$dotenv->load();
	class Database {
		private static function connect() {
			$pdo = new PDO($_ENV["DB_SETTINGS"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		}
		public static function query($query, $params = array()) {
			$pdo = self::connect();
			$statement = $pdo->prepare($query);
			$statement->execute($params);
			if (explode(" ", $query)[0] == "SELECT") {
				$data = $statement->fetchAll();
				return $data;
			}
			$lastId = $pdo->lastInsertId();
			return $lastId;
		}
	}
?>