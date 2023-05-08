<?php
include("logic.php");
include("auth_editor.php");
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8"><!-- comment -->
    <meta name="viewport" content="width=device-width, intitial-scale=1.0">
    <title>Blog Base e-newspaper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>        
    <script src="script.js"></script>
</head>
<body>
<html lang="eng">
    <head>
        <meta charset="utf-8"><!-- comment -->
        <meta name="viewport" content="width=device-width, intitial-scale=1.0">
        <title>Blog Base e-newspaper</title>
        <style>
            .card{
                border: solid 4px #a28557; 
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
                font-size: 20px;
                text-align: left;
            }
            
            .preadmore{
                font-size: 15px;
                text-align: left;
            }
            .pcategory{
                font-size: 20px;
                text-align: left;
                font-weight: bold;
                color: #ba986e;
            }

            
            
        </style>

    </head>

    <body style = "background: black">

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
                //error_reporting(0);
                //session_start();
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
            //this is the place that sets up the authentification for the page in tandom with auth_session.php
            $current_user = $_SESSION['username'];
            $test_auth = "SELECT username FROM users where username='$current_user' and (graphic_Des=1)";
            $help = $con->query($test_auth);
            if ($help->num_rows > 0) {
                //the rest of the statement is at the bottom and applies if the user doesn't have the proper
                //access to the page. If they dont they are not able to see any of the information
                ?>
                <center><h1 style="font-size:30px; color:#a28557;">Approval & Denial List:</h1></center>
               <p style ="font-size:20px; color:#a28557;text-align: left;">Waiting List:</p>
                
                <br>
                <?php
                require('logic.php');
                try {
                    $stmt = $con->query('SELECT postID, postTitle, postDesc, postDate,post_type FROM blog_posts WHERE is_approved=0 ORDER BY postID DESC');
                    ?><table class="main-space"><?php
                    $i = 0;
                    if ($stmt->num_rows > 0) {
                        $stmt->fetch_assoc();
                        foreach ($stmt as $row) {

                            echo "<center>";
                            echo '<div class="card">';
                            echo '<div class="container">';
                            echo '<h1 class = "h3"><a href="viewpost2.php?id=' . $row['postID'] . '">' . $row['postTitle'] . '</a></h3>';
                            echo '<p class = "ppost">Posted on: ' . $row['postDate'] . '</p>';
                            echo '<p class = "pcategory"> Category:' . $row['post_type'] . '</p>';
                            echo '<p class = "psummary">Summary:'.'</p>';                            
                            echo '<p class = "pdesc">' . $row['postDesc'] . '</p>';
                            echo '<p class = "preadmore"><a href="viewpost2.php?id=' . $row['postID'] . '">Read More</a></p>';
                            echo '</div>';
                            echo "</center>";
                            echo "<br>";
                            $i = $i + 1;
                            if ($i % 1 == 0) {
                                echo "<tr></tr>";
                                echo "<tr></tr>";
                            }
                        }
                    } else {
                        ?>
                            <center><p style ="font-size:18px; color:#a28557;">--No Posts Waiting to Be Approved--</p></center>
                            <?php
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    echo "</table>";
                    ?>


                    <p style ="font-size:20px; color:#a28557;text-align: left;">Approved Post List:</p>

                    <?php
                    try {
                        $stmt = $con->query('SELECT postID, postTitle, postDesc, postDate,post_type FROM blog_posts WHERE is_approved=1 ORDER BY postID DESC');
                        ?><table class="main-space"><?php
                            $i = 0;
                            if ($stmt->num_rows > 0) {
                                $stmt->fetch_assoc();
                                foreach ($stmt as $row) {

                                    echo "<center>";
                                    echo '<div class="card">';
                                    echo '<div class="container">';
                                    echo '<h1 class = "h3"><a href="viewpost2.php?id=' . $row['postID'] . '">' . $row['postTitle'] . '</a></h3>';
                                    echo '<p class = "ppost">Posted on: ' . $row['postDate'] . '</p>';
                                    echo '<p class = "pcategory">Category: ' . $row['post_type'] . '</p>';
                                    echo '<p class = "psummary">Summary:'.'</p>';                                       
                                    echo '<p class = "pdesc">' . $row['postDesc'] . '</p>';
                                    echo '<p class = "preadmore"><a href="viewpost2.php?id=' . $row['postID'] . '">Read More</a></p>';
                                    echo '</div>';
                                    echo "</center>";
                                    echo '<br>';
                                    $i = $i + 1;
                                    if ($i % 1 == 0) {
                                        echo "<tr></tr>";
                                        echo "<tr></tr>";
                                    }
                                }
                            } else {
                                ?>
                                <br><center><h5>There are no posts that are currently approved</h5></center><br>
                                <?php
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }

                        echo "</table>";
                        ?>

                        </div>
                        </div>
                        </center>
                        <?php
                    } else {
                        ?>
                        <center>
                            <p><h3 style = "color:#ba986e">You do not have access to the editor page.</h3></p>
                            <br>
                            <p><h3 style = "color:#ba986e">Return <a href="index.php">Home?</a></h3></p>
                        </center>
                        <?php
                    }
                    ?>
                    <script src="script.js"></script>

     </body>
</html>
