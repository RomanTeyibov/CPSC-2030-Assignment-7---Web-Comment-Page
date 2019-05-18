<?php 
require_once("config.php");

function displayPosts()
{
    try
    {
        $connectionString = 'mysql:host=' . DBHOST . ';dbname=' . DBNAME;
        $connection = new PDO($connectionString, DBUSER, DBPASS);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM comments ORDER BY DATE DESC, ID DESC";
        if(isset($_GET['filter']) && $_GET['filter'] != '')
        {
            $query = "SELECT * FROM comments WHERE email = '" . $_GET['filter'] . "' ORDER BY DATE DESC, ID DESC";
        }
        $result = $connection->query($query);
        
        echo "<div class='comments'><h2>Comments</h2>";
        
        while($record = $result->fetch())
        {
            $id = $record[0];
            $date = $record[1];
            $mood = $record[2];
            $email = $record[3];
            $comment = $record[4];
            
            echo "<div class='comment'>

                    <div class='ID'>
                      Post ID:  $id   </div>

                    <div class='date'>
                        Posted on: $date    </div>

                    <h3>New comment by: $email</h3>

                    <div class='mood'>
                      Current mood: $mood    </div>

                    <div class='comment-text'>
                      $comment    </div>

                  </div>";
        }
        
        echo "</div>";
        
    }
    catch(Exception $e)
    {
        die("Database failure: " . $e->getMessage());
    }
}




?>