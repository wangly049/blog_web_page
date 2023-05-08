<?php
include 'logic.php';
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Other/html.html to edit this template
-->


<html lang="eng">
    <head>
        <meta charset="utf-8"><!-- comment -->
        <meta name="viewport" content="width=device-width, intitial-scale=1.0">
        <title>Blog Base e-newspaper</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            .card{
                border: solid 4px #ba986e; 
                background:#f8f8fd
            }
            .h1{
               font-size: 30px;
               color:#ba986e;
               text-align: left; 
            }
            
            .ppost{
                font-size: 15px;
                text-align: left;
            }
            .psummary{
                font-size: 20px;
                text-align: left;
            }
            
            .pdesc{
                font-size: 40px;
                text-align: left;
            }
            
            .preadmore{
                font-size: 15px;
                text-align: left;
            } 
            body{
                background:whitesmoke;
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

        

<!--main part-->
      <?php
       try {
         $stmt = $con->query("SELECT postID, postTitle, postDesc, postDate,post_type FROM blog_posts WHERE is_approved=1 and post_type= 'style' ORDER BY postID DESC");
         ?><table class="main-space"><?php
         $i =0;
         $stmt->fetch_assoc();
         foreach($stmt as $row) {
               echo "<center>";
               echo '<div class="card">';
               echo '<div class="container">';
               echo '<h1 class = "h1"><a href="viewpost.php?id=' . $row['postID'] . '">' . $row['postTitle'] . '</a></h1>';
               echo '<p class = "ppost">Posted on ' . $row['postDate'] . '</p><br>';
               echo '<p class = "psummary">Summary:'.'</p>'; 
               echo '<p class = "pdesc">' . $row['postDesc'] . '</p>';
               echo '<p class = "preadmore"><a href="viewpost.php?id=' . $row['postID'] . '">Read More</a></p>';
               echo '</div>';
               echo "</center>";
               echo "<br>";
               $i = $i+1;
               if($i % 1 == 0 )
               {
                   echo "<tr></tr>";
               }                         
           }
       } catch (PDOException $e) {
           echo $e->getMessage();
       }echo "</table>";
       ?>      
        
   </div>
   </div>
   </center>
   <script src="script.js"></script>


    </body>
</html>
