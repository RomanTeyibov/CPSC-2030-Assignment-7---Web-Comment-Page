<?php 

require_once("config.php");

function showCommenters()
{
    try
    {
        $connectionString = 'mysql:host=' . DBHOST . ';dbname=' . DBNAME;
        $connection = new PDO($connectionString, DBUSER, DBPASS);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT DISTINCT email FROM comments;";
        $result = $connection->query($query);
        
        echo "<div class='commenters'>
                <h2>People Who have Commented:</h2>
                    <ul>";
        
        while($record = $result->fetch())
        {
            $email = $record[0];
            
            echo "<li><a href='index.php?filter=$email'>$email</a></li>";
        }
        
        echo "</ul></div>";
        
    }
    catch(Exception $e)
    {
        die("Database failure: " . $e->getMessage());
    }
}


?>