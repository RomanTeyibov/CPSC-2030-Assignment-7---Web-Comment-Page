<?php 
require_once("config.php");
require_once("display-posts.php");
require_once("format-comment-text.php");
require_once("show-commenters.php");

if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST")
{
    $comment = formatCommentText($_POST['comment']);
    try
    {
        $connectionString = 'mysql:host=' . DBHOST . ';dbname=' . DBNAME;
        $connection = new PDO($connectionString, DBUSER, DBPASS);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "INSERT INTO comments (date, mood, email, commentText) VALUES (now(), ?, ?, ?)";
        $statement = $connection->prepare($query);
        $statement->bindValue(1, $_POST['mood']);
        $statement->bindValue(2, $_POST['email']);
        $statement->bindValue(3, $comment);
        $statement->execute();
    }
    catch(Exception $e)
    {
        die("Database failure: " . $e->getMessage());
    }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Assignment 7</title>

    <link rel="stylesheet" href="style.css">
  </head>
  <body>

    <h1>Assignment 7: SQL</h1>

    <div class="write-comment">
      <h2>Post a Comment</h2>

      <form action="index.php" method="post">

        <label>
          Email Address:
          <input type="email" name="email">
        </label>

        <label>
          Mood:
          <select name="mood">
            <option value="happy">Happy</option>
            <option value="sad">Sad</option>
            <option value="excited">Excited</option>
            <option value="bored">Bored</option>
            <option value="angry">Angry</option>
          </select>
        </label>

        <label>
          Enter a Comment:
          <textarea name="comment"></textarea>
        </label>

        <button type="submit" name="button">Post Comment</button>

      </form>
    </div>
    <?php 
    displayPosts();
    showCOmmenters();
      
    if(isset($_GET['filter']) && $_GET['filter'] != '')
    {
        echo "<a href='index.php'>Show All Posts</a>";
    }
    ?>
    
  </body>
</html>
