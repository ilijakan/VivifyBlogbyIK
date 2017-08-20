<?php

include("db.php");

class Auth {


	public function signUp($name, $email, $password) {
		$db = Db::getDBInstance();
		$db->executeQuery("INSERT INTO users (email, password) VALUES ('$email', '$password')");
		$user = $db->fetchData("select * from users where email='$email'");
		$db->executeQuery("INSERT INTO profiles (name, user_id) VALUES ('$name', '$user[id]')");
		$user['name'] = $name;
		$_SESSION['current_user'] = $user;
		header("Location: http://localhost:1234/index.php");
		exit();
	}

	public static function getAuthInstance() {
		return new Auth();
	}
	

	public function signIn($email, $password) {

		$db = Db::getDBInstance();
		/*
			ako postoji u bazi user sa email-om i pass-om koji je prosledjen
			- uloguj usera (upisi username u sesiju)
			ako ne postoji
			- redirektuj na istu stranu (forma za sign in) i ispisi geresku
		*/
			$user = $db->fetchData("select * from users where email='$email' AND password ='$password' ");
			if (!empty($user)) {
				
				// var_dump('aaaa');
				// die;
				//uloguj usera (upisi username u sesiju)
				$_SESSION['current_user'] = $user;
			} else {
				//redirektuj na istu stranu (forma za sign in) i ispisi gresku
				echo "Wrong email or password";	
		
			}

	}
}

	
