<?php
	require_once('autoload_light.php');
	class User {
		/**
		 * - user authorization
		 * - login and password from auth form
		 *
		 *
		 **/
		public function auth($login, $password) {
			if($login == '' || $password == '') throw new Exception("Empty data");
			$db = Database::getInstance();
			$mysqli = $db->getConnection();
			$password = crypt($password, "silence");
			$sql = sprintf("SELECT * FROM tm_users WHERE user_login = '%s' AND user_password = '%s'", $login, $password);
			$res = $mysqli->query($sql);
			if($res->num_rows == 0) throw new Exception("No such user");
			$row = $res->fetch_assoc();
			$_SESSION['data'] = array();
			foreach($row as $key => $value) {
				$_SESSION['data'][$key] = $value;
			}
		}
		/**
		 * - user creation
		 * - data_parametr from reg form
		 *
		 *
		 **/
		public function registrate($data_parametr = array()) {
			if(empty($data_parametr)) throw new Exception("Empty data");
			$db = Database::getInstance();
			$mysqli = $db->getConnection();
			$sql = sprintf("SELECT login FROM tm_users 
										WHERE user_login = '%s'", $data_parametr['user_login']);
			$res = $mysqli->query($sql);
			if ( $mysqli->affected_rows > 0 )
				throw new Exception("Such login is already exists!");
			
			$part_1 = "INSERT INTO tm_users ( ";
			$part_2 = " VALUES ( ";
			foreach ($data_parametr as $key => $value ) {
				if ( $key == 'registrate' ) continue;
				if ( $key == 'user_password' ) $value = crypt($value, "silence");
				if ( $key == 'g-recaptcha-response' ) continue;
				$part_1 .= " $key, ";
				$part_2 .= "'$value', ";
			}
			$part_1 = rtrim($part_1,", ");
			$part_2 = rtrim($part_2,", ");
			$sql = $part_1 . ' ) ' . $part_2 . ')';
			$res = $mysqli->query($sql);
			if ( $mysqli->affected_rows == 0 )
				throw new Exception("Sorry but we can't create this account");
		}
	}