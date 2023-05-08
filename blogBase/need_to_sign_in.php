<?php
include 'logic.php';
?>
<html lang="eng">
    <head>
        <meta charset="utf-8"><!-- comment -->
        <meta name="viewport" content="width=device-width, intitial-scale=1.0">
        <title>Blog Base e-newspaper</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            .row1{
                background-color: #3b3c36;
                background-image:
                    radial-gradient(at 61% 4%, hsla(303, 91%, 61%, 1) 0px, transparent 50%),
                    radial-gradient(at 75% 66%, hsla(196, 91%, 79%, 1) 0px, transparent 50%),
                    radial-gradient(at 98% 88%, hsla(76, 87%, 78%, 1) 0px, transparent 50%),
                    radial-gradient(at 23% 16%, hsla(238, 96%, 77%, 1) 0px, transparent 50%),
                    radial-gradient(at 95% 65%, hsla(13, 91%, 75%, 1) 0px, transparent 50%),
                    radial-gradient(at 10% 79%, hsla(228, 96%, 69%, 1) 0px, transparent 50%),
                    radial-gradient(at 85% 58%, hsla(328, 81%, 68%, 1) 0px, transparent 50%);
                background-repeat: no-repeat;
                color: white;
                align-items: center;
                justify-content: center;
                padding: 15rem 0;
            }
            .maincontent{
               font-family: Times New Roman,Times, serif;                
               font-size: 25px;
               color:whitesmoke;
               padding:10px; 
               margin: 10px;
               border-radius: 15px;
               background:#ba986e;
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
           <div class ="row1" style ="height:600px">
                <!-- This is where the info telling the user they logged out will take place -->
                <center>
                    <h3 style = "font-family: Times New Roman, Times, serif; font-size: 40px;color:#ba986e">Reminder: 
                        <span style = "font-family: Times New Roman, Times, serif; font-size: 30px;color:whitesmoke">You Don't Have An Account</span>
                    </h3>
                    <br>

                    <a class ="maincontent" href="index.php">Home</a>

                   <a class ="maincontent" href="login.php">LogIn</a>

                    <a class ="maincontent" href="register.php">SignUp</a>

                </center>
            </div> 
            <script src="script.js"></script>
    </body>
</html>
