<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
require('logic.php');
?>

<html>
    <head>
        <title>Blogbase - Login</title>
        <meta charset="utf-8"><!-- <meta -->
        <meta name="viewport" content="width=device-width, inital-scale=1"><!-- comment -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            .loginform{
                align-content: center;
                align-items: center;
                align-self: center;
                color:red;
                width: 250px;
                margin: 50px auto;
                padding: 30px 25px;
                background: white;
            }
        </style>                      



    </head><!-- comment -->
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
            require('logic.php');
            if (isset($_POST['username'])) {
                $username = stripslashes($_REQUEST['username']);
                $username = mysqli_real_escape_string($con, $username);
                $password = stripslashes($_REQUEST['password']);
                $password = mysqli_real_escape_string($con, $password);

                $query = "SELECT * FROM `users` WHERE username='$username' AND password='" . md5($password) . "' AND is_approved!=0";
                $result = mysqli_query($con, $query) or die(mysql_error());
                $rows = mysqli_num_rows($result);
                if ($rows == 1) {
                    $_SESSION['username'] = $username;
                    header("Location: index.php");
                } else {
                    header("Location: login_error.php");
                }
            } else {
                ?>
                <center>
                    <form class = "loginform" method="post" name="login">
                        <h1 style ="font-size: 23px; color: #ba986e;">--Login-- </h1><!-- comment -->
                        <br><br>
                        <div class="form-group">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username"/>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password"/>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="submit" value="Login" name="submit" class="form-control"/>
                        </div>                    

                        <center>
                            <br>
                            <p style ="font-size: 14px; color: #a28557;"> Don't Have An Account?</p>                           
                            <a href="register.php" style ="font-size: 16px; color: #a28557; font-weight: bold">Sign Up</a>
                            <p style ="font-size: 13px; color: #a28557;"> or </p>
                            <a href="index.php" style ="font-size: 16px; color: #a28557;font-weight: bold">Return Home</a> 
                        </center>

                    </form>
                </center>
                <br>

                <?php
            }
            ?>
            <script src="script.js"></script>
    </body>
</html>
