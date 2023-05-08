<?php
include 'logic.php';
include("auth_ad.php");
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

    </head>

    <body style = "background:black">
            <nav class="flex-div" style = "background:#ba986e;">
                <div class="nav-left flex-div">
                    <img class="menu-icon" src="menu_icon.png">
                </div>
                <div class="nav-mid flex-div" >
                    <div class="search-box flex-div" style = "background: whitesmoke;">
                        <form action="search-proc.php" method="POST" id="searchForm">
                            <input type="text/submiit" name="search" placeholder="search"/> <img src="search.png">
                        </form>
                    </div>
                </div>
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
                        <a href="user_profile.php" style="padding: 10px;"><img src="follow.png"></a>
                        <button type ="button" style = "color:#ba986e;border-radius: 25px;"><?php echo $_SESSION['username'] ?> </button>
                        <button type = "button" href = "logout.php" style = "color:#ba986e;border-radius: 25px; padding: 0px 10px"> 
                            <a href="logout.php">Logout</a>
                        </button>

                    </div>
                    <?php
                } else {
                    ?>
                    <div class="nav-right flex-div">
                        <a href="admin.php"><img src="admin_img.png"></a>
                        <a href="graphDes.php"><img src="gd.png"></a>
                        <a href="create.php"><img src="editor_img.png"></a>
                        <a href="ad_design.php"><img src="ad.png"></a>
                        <a href="user_profile.php"><img src="follow.png"></a>
                        <button type ="button" style = "color:#ba986e;border-radius: 25px;padding: 10px">
                            <a href="login.php" >Login</a>
                        </button>
                        <button type ="button" style = "color:#ba986e;border-radius: 25px;padding: 10px">
                            <a href="register.php">SignUp</a>                            
                        </button>                                                
                    </div>
                    <?php
                }
                ?>
            </nav>

            <!--------------------- side bar --------------------->
            <div class ="row" style ="height: 700px; border-top:solid 3px black;">
                <div class ="col-md-2">
                    <div class="sidebar">
                        <div class="shortcut-links">
                            <a  style="color: orange" href="index.php"><img src="home.png"> Home </a></p>
                            <a href="hot.php"><p><img src="hot.png"> Hot! </a></p>
                            <a href="viewSaved.php"><p><img src="saved.png"> Saved </a></p>
                            <a href="archived.php"><p><img src="history.png"> Archived </a></p>
                        </div>
                        <div class="Authors">
                            <center>
                                <p><a href="social.php" style="color:#a28557">Social</a></p>
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
                                                <a href="" style ="color:#a28557"><p><img src="follow.png"><?php echo $row1["username"]; ?></p></a>
                                                <?php
                                            }
                                        }
                                    }
                                }
                            } else {
                                ?>
                                <center>
                                    <p>Please Login</p><br>
                                </center>
                                <?php
                            }
                            ?>
                        </div>
                    </div>                                             
                </div>            




                <!--main part-->
                <div class ="row">
                    <?php
//this is the place that sets up the authentification for the page in tandom with auth_session.php
                    $current_user = $_SESSION['username'];
                    $test_auth = "SELECT username FROM users where username='$current_user' and advr=1";
                    $help = $con->query($test_auth);
                    if ($help->num_rows > 0) {
                        //the rest of the statement is at the bottom and applies if the user doesn't have the proper
                        //access to the page. If they dont they are not able to see any of the information
                        ?> 
                        <br>
                        <p style = "color:#ba986e; font-size: 25px; margin-left: 25px">Advertisement List</p>
                        <?php
// Include the database configuration file
// Get images from the database
                        $query = $con->query("SELECT * FROM ad_displays");
                        $i = 0;
                        if ($query->num_rows > 0) {
                            while ($row = $query->fetch_assoc()) {
                                $imageURL = 'uploads/' . $row["file_name"];
                                ?>                            
                                    <img class="ad_images" style = "height: 250px; width: 330px; border: solid #ba986e 2px;margin:0px 0px 15px 55px;"src="<?php echo $imageURL; ?>" alt="" />                                                                                                        
                                <?php
                            }
                        } else {
                            ?>
                            <p>No image(s) found...</p>
                            <?php
                        }
                        ?>                            
                        <form method="post" action="adlogic.php" enctype="multipart/form-data">
                            <center>
                            <br><br>
                            <label style = "color: #ba986e">Edit Your Ads</label>
                            <input type="file" name="file" style ="color:#ba986e"/><!-- comment -->
                            <input type="submit" name="submit" value='Upload'/>
                            <p style ="color:#ba986e"> Return <a href="index.php">Home?</a></p>
                            </center>
                        </form>
                        <?php
                    }
                    ?>
                    <script src="script.js"></script>
                </div>
            </div>
    </body>
</html>
