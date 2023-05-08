<?php
require ('logic.php');
include ("auth_session.php");
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
        <script src="script.js"></script>
        <style>
         td{border: 1px solid #c0c0c0;border-collapse: collapse;}   
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







            <!--main part --> 
            <div style = "height: 500px;background:whitesmoke;">
                <?php
                //this is the place that sets up the authentification for the page in tandom with auth_session.php
                $current_user = $_SESSION['username'];
                $test_auth = "SELECT username FROM users where username='$current_user' and Admin=1";
                $help = $con->query($test_auth);
                if ($help->num_rows > 0) {
                    //the rest of the statement is at the bottom and applies if the user doesn't have the proper
                    //access to the page. If they dont they are not able to see any of the information
                    ?>
                <p style="font-size: 25px;color: #a28557; font-weight: bold; margin:10px;">User List</p>
                    <table style="width:1300px;">
                        <?php
                        $sql = "SELECT userid, username, fname, lname, email, is_approved, Admin, graphic_Des, writer, reader, advr FROM users WHERE is_approved=1";
                        $result = $con->query($sql);
                        if ($result->num_rows > 0) {

                            echo "<tr>";
                            echo "<td>ID:</td>";
                            echo "<td>Username:</td>";
                            echo "<td>Name:</td>";
                            echo "<td>Email:</td>";
                            echo "<td>Approved:</td>";
                            echo "<td>Admin:</td>";
                            echo "<td>Graphic Designer:</td>";
                            echo "<td>Writer:</td>";
                            echo "<td>Reader:</td>";
                            echo "<td>Advritiser:</td>";
                            echo "<td>Delete:</td>";
                            echo "</tr>";

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr><td> " . $row["userid"] . "</td><td>" . $row["username"] . " </td><td> " . $row["fname"] . " " . $row["lname"] . " </td><td> " . $row["email"] . "</td><td> " . $row["is_approved"] . "</td><td>" . $row["Admin"] . " </td><td> " . $row["graphic_Des"] . " </td><td> " . $row["writer"] . " </td><td> " . $row["reader"] . " </td><td> " . $row["advr"] . " </td>";
                                ?>
                                <td><a href="delete-process.php?userid=<?php echo $row["userid"]; ?>">Delete</a></td><!-- comment -->
                                <?php
                                echo "";
                            }
                        } else {
                            echo "<tr><td>0 results</td></tr>";
                        }
                        ?>
                    </table>
                    <br>
                  <p style="font-size: 25px;color: #a28557; font-weight: bold; margin:10px;">Waiting List</p>
                    <table style="width:1300px;">
                        <?php
                        $sql1 = "SELECT userid, username, fname, lname, email, is_approved, Admin, graphic_Des, writer, reader, advr FROM users WHERE is_approved!=1";
                        $result1 = $con->query($sql1);
                        if ($result1->num_rows > 0) {
                            echo "<tr>";
                            echo "<td>ID:</td>";
                            echo "<td>Username:</td>";
                            echo "<td>Name:</td>";
                            echo "<td>Email:</td>";
                            echo "<td>Approved:</td>";
                            echo "<td>Admin:</td>";
                            echo "<td>Graphic Designer:</td>";
                            echo "<td>Writer:</td>";
                            echo "<td>Reader:</td>";
                            echo "<td>Advritiser:</td>";
                            echo "<td>Delete:</td>";
                            echo "<td>Approve:</td>";
                            echo "</tr>";

                            while ($row = $result1->fetch_assoc()) {
                                echo "<tr><td> " . $row["userid"] . "</td><td>" . $row["username"] . " </td><td> " . $row["fname"] . " " . $row["lname"] . " </td><td> " . $row["email"] . "</td>";
                                echo "<td> " . $row["is_approved"] . "</td><td>" . $row["Admin"] . " </td><td> " . $row["graphic_Des"] . " </td><td> " . $row["writer"] . " </td><td> " . $row["reader"] . " </td><td> " . $row["advr"] . " </td>";
                                ?>
                                <td><a href="delete-process.php?userid=<?php echo $row["userid"]; ?>">Delete</a></td><!-- comment -->
                                <td><a href="approve_user.php?userid=<?php echo $row["userid"]; ?>">Approve</a></td>
                                <?php
                                echo "";
                            }
                        } else {
                            echo "<tr><td>0 results</td></tr>";
                        }
                        ?>

                    </table>
                    </p>
                    <br><!-- comment -->

                    </center><!-- comment -->
                    <?php
                } else {
                    ?>
                    <center>
                        <p><h3 style = "color:#ba986e">You do not have access to the admin page.</h3></p>
                        <br>
                        <p><h3 style = "color:#ba986e">Return to <a href="index.php">Home?</a></h3></p>
                    </center>
                    <?php
                }
                ?>
                <script src="script.js"></script>
            </div>
    </body>
</html>
