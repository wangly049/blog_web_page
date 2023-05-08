<?php
require('logic.php');

$stmt = $con->query("SELECT postID, postTitle, postCont, postDate,post_type FROM blog_posts WHERE postID ='" . $_GET["id"] . "'");
//$stmt->$query(array('postID' => $_GET['id']));
$row = $stmt->fetch_assoc();
$realPostID = $_GET["id"];

//this is where we will add a view for the "hot" page where it is sorted by most viewed articles
$incHot = $con->query("UPDATE blog_posts SET clickNumber=clickNumber + 1 WHERE postID='" . $_GET["id"] . "'");

//if post does not exists redirect user.
if ($row['postID'] == '') {
    header('Location: ./'); //add page so that if a article is trying to be found that does not exit it willl rout to a paage saying this deos not exit, would like to got to the home page
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Blog - <?php echo $row['postTitle']; ?></title>
    <link rel="stylesheet" href="BBlog.css">
    		<link href="comments.css" rel="stylesheet" type="text/css">
    <!--<link rel="stylesheet" href="style/main.css">-->
    <style>
    .card1 {
      color: black;
      width: fit-content;
      padding: 15px;
      box-shadow: 0 4px 8px 0 rgba(178, 178, 178,0.6);
      transition: 0.3s;
      border-radius: 5px; /* 5px rounded corners */
    }
    .container1 {
      padding: 4px 18px;
    }
    .textBox {
      height: 100px;
      padding: 12px 20px;
      box-sizing: border-box;
      border: 2px solid #ccc;
      border-radius: 5px;
      background-color: #f8f8f8;
      font-size: 16px;
      resize: none;
    }
    .textBox1 {
      height: 75px;
      padding: 12px 20px;
      box-sizing: border-box;
      border: 2px solid #ccc;
      border-radius: 5px;
      background-color: #f8f8f8;
      font-size: 16px;
      resize: none;
    }
    .pcategory{
      font-size: 22px;
      color: #ba986e;
      }    
    </style>
</head>

<body>

        <nav class="flex-div" style = "background:#ba986e;" >
            <div class="nav-left flex-div">
                <img class="menu-icon" src="menu_icon.png">
                <a href="index.php"><img src="logo1.png" class="logo" ></a>
            </div>
            <div class="nav-mid flex-div">
                <div class="search-box flex-div"style = "background: whitesmoke;">
                    <form action="search-proc.php" method="POST" id="searchForm">
                        <input type="text/submiit" name="search" placeholder="search"/> <img src="search.png">
                    </form>
                </div>
            </div><!-- comment -->






            <?php
            session_start();
            if (isset($_SESSION["username"])) {
                $loggedInUser = $_SESSION["username"];
                ?>
                <div class="nav-right flex-div">
                    <a href="admin.php"><img src="admin_img.png"></a>
                    <a href="graphDes.php"><img src="gd.png"></a>
                    <a href="create.php"><img src="editor_img.png"></a>
                    <a href="ad_design.php"><img src="ad.png"></a>
                    <a href="user_profile.php" style="padding: 10px"><img src="follow.png"></a>
                    <u><?php echo $_SESSION['username'] ?></u>
                    <a href="logout.php" style="padding: 10px">Logout</a>
                    <?php
                } else {
                    ?>
                    <div class="nav-right flex-div">
                        <a href="admin.php"><img src="admin_img.png"></a>
                        <a href="graphDes.php"><img src="gd.png"></a>
                        <a href="create.php"><img src="editor_img.png"></a>
                        <a href="ad_design.php"><img src="ad.png"></a>
                        <a href="user_profile.php"><img src="follow.png"></a>                            
                        <button type ="button" style = "color:#ba986e;border-radius: 10px;padding: 5px">
                            <a href="login.php" >Login</a>
                        </button>
                        <button type ="button" style = "color:#ba986e;border-radius: 10px;padding: 5px">
                            <a href="register.php">SignUp</a>                            
                        </button>                       


                    </div>
                    <?php
                }
                ?>
        </nav>







        <!--------------------- side bar --------------------->
        <div class="sidebar">
            <div class="shortcut-links">
                <a href="index.php"><img src="home.png"> Home </a></p>
                <a href="hot.php"><p><img src="hot.png"> Hot! </a></p>
                <a href="viewSaved.php"><p><img src="saved.png"> Saved </a></p>
                <a href="archived.php"><p><img src="history.png"> Archived </a></p>
                <hr>
            </div>
            <div class="Authors">
                <center>
                    <p><a href="social.php">Social</a></p>
                </center>
                <?php
                if (isset($_SESSION["username"])) {
                    $loggedInUser = $_SESSION["username"];
                    $getUserID = "SELECT userid FROM users WHERE username='$loggedInUser'";
                    $loggedOn = $con->query($getUserID);
                    if ($loggedOn->num_rows > 0) {
                        while ($row = $loggedOn->fetch_assoc()) {
                            $realUserID = $row["userid"];
                            $followList = "SELECT username FROM users, social_follow WHERE username!='$loggedInUser' and follower_id='$realUserID' and follow_id=1 and followed_user_id=userid";
                            $getFollowList = $con->query($followList);
                            if ($getFollowList->num_rows > 0) {
                                while ($row1 = $getFollowList->fetch_assoc()) {
                                    ?>
                                    <a href=""><p><img src="follow.png"><?php echo $row1["username"]; ?></a></p>
                                    <?php
                                }
                            }
                        }
                    }
                } else {
                    ?>
                    <center>
                        <p style ="color:#a28557">Not follow/Login?</p><br>
                    </center>
                    <?php
                }
                ?>

            </div>
        </div>       
    
    
    
    
    
<!-- the above is all for the sidebar and the other things that follow the sidebar -->
<center>
    <div id="wrapper">

        <?php

        echo '<div class="cont">';
        //below will show the save icon on the page
        if(isset($_SESSION["username"])){
          $loggedInUser = $_SESSION["username"];
          $getUserID = "SELECT userid FROM users WHERE username='$loggedInUser'";
          $loggedOn = $con->query($getUserID);
          if($loggedOn->num_rows > 0){
            while($row2 = $loggedOn->fetch_assoc()){
              $realUserID = $row2["userid"];

          //this will update and maintain the posts from the various trader_cdlupsidegap2crows
          $savedPart = "SELECT t1.postID as post1, t2.userID as user2
                          FROM blog_posts as t1
                          cross join users as t2";
          $getSavedPart = $con->query($savedPart);
          if($getSavedPart->num_rows > 0){
            while($row7 = $getSavedPart->fetch_assoc()){
              $PostID = $row7["post1"];
              $UserID = $row7["user2"];

              $sql7 = "INSERT INTO `save`
                      SET postID = '$PostID',
                          userID = '$UserID'
                          ON DUPLICATE KEY UPDATE
                              postID = VALUES(postID),
                              userID = VALUES(userID)";
              $resultToEnd = mysqli_query($con, $sql7);
              //above loads all the entries into the db
            }
          }
          $checkIfSaved = "SELECT is_saved, saveID FROM save WHERE userID='$realUserID' and postID='$realPostID'";
          $getCheckIfSaved = $con->query($checkIfSaved);
          $stmt1 = $con->query("SELECT postID, postTitle, postCont, postDate,post_type FROM blog_posts WHERE postID ='" . $_GET["id"] . "'");
          //$stmt->$query(array('postID' => $_GET['id']));
          $row10 = $stmt1->fetch_assoc();
          if($getCheckIfSaved->num_rows > 0){
            while($saveCheck = $getCheckIfSaved->fetch_assoc()){
              if($saveCheck['is_saved']==0){
                ?>
                <p><h1><?php echo $row10['postTitle']; ?>
                  <a href="savePost.php?saveID=<?php echo $saveCheck['saveID']; ?>"><img style="width: 20px; height: 20px;" src="saveIcon_New.png"></a></h1></p>
                <?php
                echo '<p class = "ppost">Posted on ' . $row10['postDate'] . '</p>';
                echo '<p class = "pcategory">Category: ' . $row10['post_type'] . '</p>';
                echo '<p class = "pcont">' . $row10['postCont'] . '</p>';
                echo '</div>';
              }else{
         ?>
            <p><h1><?php echo $row10['postTitle']; ?><a href="unsavePost.php?saveID=<?php echo $saveCheck['saveID']; ?>"><img style="width: 20px; height: 20px;" src="checkmark.png"></a></h1></p>
          <?php
          echo '<p class = "ppost">Posted on ' . $row10['postDate'] . '</p>';
            echo '<p class = "pcategory">Category: ' . $row10['post_type'] . '</p><br>';
          echo '<p class = "pcont">' . $row10['postCont'] . '</p>';
          echo '</div>';
      }
    }
  }
}
}

      }else{
        ?>
        <p><h1><?php echo $row['postTitle']; ?></h1></p>
        <?php

        echo '<p class = "ppost">Posted on ' . $row['postDate'] . '</p>';
        echo '<p class = "pcategory">Category: ' . $row['post_type'] . '</p><br>';
        echo '<p class = "pcont">' . $row['postCont'] . '</p>';
        echo '</div>';
}
        ?>
    
    
    </div>

</center>
    
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<div class="w3-container">
  <button onclick="document.getElementById('id01').style.display='block'" class="w3-button w3-black">Comment Section</button>

  <div id="id01" class="w3-modal">
    <div class="w3-modal-content">
      <header class="w3-container w3-teal"> 
        <span onclick="document.getElementById('id01').style.display='none'" 
        class="w3-button w3-display-topright">&times;</span>
        <h2>Comment Section</h2>
      </header>
        <div class="w3-container">
            <details>
            <summary>Add Comments</summary>
        <?php

      ?>
      <div class="comments"></div>
      <?php
       ?>
            </details>
      </div>
      <footer class="w3-container w3-teal">
      </footer>
    </div>
  </div>
</div>
<br>

      <?php
       ?>
    <script>
    const comments_page_id = '<?php echo $realPostID; ?>'; // This number should be unique on every page
    fetch("comments.php?page_id=" + comments_page_id).then(response => response.text()).then(data => {
    	document.querySelector(".comments").innerHTML = data;
    	document.querySelectorAll(".comments .write_comment_btn, .comments .reply_comment_btn").forEach(element => {
    		element.onclick = event => {
    			event.preventDefault();
    			document.querySelectorAll(".comments .write_comment").forEach(element => element.style.display = 'none');
    			document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "']").style.display = 'block';
    			document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "'] input[name='name']").focus();
    		};
    	});
    	document.querySelectorAll(".comments .write_comment form").forEach(element => {
    		element.onsubmit = event => {
    			event.preventDefault();
    			fetch("comments.php?page_id=" + comments_page_id, {
    				method: 'POST',
    				body: new FormData(element)
    			}).then(response => response.text()).then(data => {
    				element.parentElement.innerHTML = data;
    			});
          location.reload();
    		};
    	});
    });
    </script>



    <script src="script.js"></script>

</body>

</html>
