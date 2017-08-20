<?php
/*
	Napisati skriptu za kreiranje novog posta
*/
include("db.php");

class Post {
		
		public function createPost(){

			$title = $_POST['title'];
			$content = $_POST['content'];
			$category = $_POST['category'];
			$created_at = date('Y-m-d H:i:s');
			$created_by = $_SESSION['current_user']['id'];

			$db = Db::getDBInstance();
			$db->executeQuery("INSERT INTO posts VALUES (null, '$title', '$category', '$content', '$created_at', '$created_by')");

			

		}


		public static function getInstance() {
			return new Post();
		}



		public function fetchAllPosts() {

			$db = Db::getDBInstance();
			
			$posts = $db->fetchAllData(
				"SELECT posts.id, posts.title, posts.created_at, posts.content, profiles.name, posts.created_by FROM posts 
	            INNER JOIN users ON users.id = posts.created_by 
	            INNER JOIN profiles ON profiles.user_id = users.id
	            ORDER BY created_at DESC"
            );

			return $posts;
		}

		public function updatePost($post){
		    $sqlUpdatePosts = "UPDATE posts SET
		                          title = \"{$post->title}\",
		                          text = \"{$post->text}\",
		                          category_id = ".$post->category->getId().",
		                          user_id = ".$post->user->getId()."
		                          WHERE id = ". $post->getId();
		    //$this->log->writeLog($sqlUpdateArticle, null);

          	$db = Db::getDBInstance();				
		    $db->executeQuery($sqlUpdatePosts);
		}

		public function deletePost($id){		    
		    $db = Db::getDBInstance();				
		    $db->executeQuery("DELETE FROM posts WHERE id=$id");
		}

}

/*
		Napisati skriptu za edit posta
*/

  




?>