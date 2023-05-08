<?php
ob_start();
include 'logic.php';
include('auth_profile.php');
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
            .col-md-4{
                background-color: #ff99f5;
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
                padding:40px 0;
            }
            .modifyinforform{
                align-content: center;
                align-items: center;
                align-self: center;
                color:red;
                width: 400px;
                margin: 50px auto;
                padding: 30px 25px;
                background: white;
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
                            <input type="text/submiit" name="search" placeholder="search"/><img src="search.png">
                        </form>
                    </div>
                </div><!-- comment -->






                <?php
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
            <div class ="row" style ="height: 500px;">
                <div class ="col-md-4">
                    <h1 style ="font-size:30px; color:whitesmoke; margin-left: 35px;"><span style ="font-size:45px;color:whitesmoke"><?php echo $_SESSION['username'] ?> </span> profile<br></h1>
                    <br>

                    <?php
                    $theUser = $_SESSION['username'];
                    $mainSql = "SELECT username, fname, lname, email FROM users WHERE username='$theUser'";
                    $mainResult = $con->query($mainSql);
                    if ($mainResult->num_rows > 0) {
                        while ($row = $mainResult->fetch_assoc()) {
                            ?>
                            <center>
                                <form class=" align-items-center justify-content-center" action="" method="post">
                                    <div class="form-group">                                    
                                        <h6><span style = "font-weight: bold;font-size: 20px;">Current Username:</span> <?php echo "" . $row['username'] . ""; ?></h6><br>
                                    </div>
                                </form>
                                <?php
                                if (isset($_REQUEST['fname'])) {
                                    $fname = stripslashes($_REQUEST['fname']);
                                    $fname = mysqli_real_escape_string($con, $fname);
                                    $firstname = "UPDATE users SET fname='$fname' WHERE username='" . $_SESSION["username"] . "'";
                                    $result = mysqli_query($con, $firstname);
                                    if ($result) {
                                        header("Location: user_profile.php");
                                        exit();
                                    } else {
                                        echo "Error: There was a problem executing the statement...";
                                    }
                                } else {
                                    ?>
                                    <form class=" align-items-center justify-content-center" action="" method="post">
                                        <div class="form-group">
                                            <h6><span style = "font-weight: bold;font-size: 20px;">Current First Name: </span><?php echo "" . $row['fname'] . ""; ?></h6><br>
                                        </div>
                                    </form><!-- comment --> 
                            </div>                
                            <div class ="col-md-8"style ="background:whitesmoke;">
                                <form class="modifyinforform" action="" method="post">        
                                    <div>
                                        <label> New First Name:</label>
                                        <input class="form-control form-input" type="text" id="fname" name="fname" placeholder="First Name" required /><!-- comment -->
                                    </div>
                                    <div class="form-group" style = "background:#a28557; color: whitesmoke;">
                                        <input type="submit" value="Submit" name="submit" class="form-control"/>
                                    </div>
                                    <?php
                                }
                                ?>
                                <br>

                                <?php
                                if (isset($_REQUEST['lname'])) {
                                    $lname = stripslashes($_REQUEST['lname']);
                                    $lname = mysqli_real_escape_string($con, $lname);
                                    $lastname = "UPDATE users SET lname='$lname' WHERE username='" . $_SESSION["username"] . "'";
                                    $result1 = mysqli_query($con, $lastname);
                                    if ($result1) {
                                        header("Location: user_profile.php");
                                        exit();
                                    } else {
                                        echo "Error: There was a problem executing the statement...";
                                    }
                                } else {
                                    ?>

                                    <div class="form-group">
                                        <label for="lname">New Last Name:</label><br>
                                        <input class="form-control form-input" type="text" id="lname" name="lname" placeholder="Last Name" required /><!-- comment -->
                                    </div><!-- comment -->
                                    <div class="form-group" style = "background:#a28557; color: whitesmoke;">
                                        <input type="submit" value="Submit" name="submit" class="form-control"/>
                                    </div>

                                    <?php
                                }
                                ?>
                                <br>
                                <?php
                                if (isset($_REQUEST['email'])) {
                                    $email = stripslashes($_REQUEST['email']);
                                    $email = mysqli_real_escape_string($con, $email);
                                    $newemail = "UPDATE users SET email='$email' WHERE username='" . $_SESSION["username"] . "'";
                                    $result2 = mysqli_query($con, $newemail);
                                    if ($result2) {
                                        header("Location: user_profile.php");
                                        exit();
                                    } else {
                                        echo "Error: There was a problem executing the statement...";
                                    }
                                } else {
                                    ?>

                                    <div class="form-group">
                                        <label for="email">New Email:</label><br>                                   
                                       <input class="form-control form-input" type="email" id="email" name="email" placeholder="Email" required />
                                    </div>
                                    <div class="form-group" style = "background:#a28557; color: whitesmoke;">
                                        <input type="submit" value="Submit" name="submit" class="form-control"/>
                                    </div>

                                    <?php
                                }
                                ?>
                                <br>
                                <?php
                                if (isset($_REQUEST['password'])) {
                                    $password = stripslashes($_REQUEST['password']);
                                    $password = mysqli_real_escape_string($con, $password);
                                    $newpassword = "UPDATE users SET password='" . md5($password) . "' WHERE username='" . $_SESSION["username"] . "'";
                                    $result3 = mysqli_query($con, $newpassword);
                                    if ($result3) {
                                        header("Location: user_profile.php");
                                        exit();
                                    } else {
                                        echo "Error: There was a problem executing the statement...";
                                    }
                                } else {
                                    ?>

                                    <div class="form-group">
                                        <label for="password">New Password:</label><br>
                                        <input class="form-control form-input" type="password" id="password" name="password" placeholder="Password" required />
                                    </div>
                                    <div class="form-group" style = "background:#a28557; color: whitesmoke;">
                                        <input type="submit" value="Submit" name="submit" class="form-control"/>
                                    </div>
                                </form>
                                <?php
                            }
                            ?>
                            </center>
                            <?php
                        }
                    }
                    ob_end_flush();
                    ?>


                    <script src="script.js"></script>

                </div> 

            </div>     
    </body>
</html>
