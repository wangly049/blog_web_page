<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
require('logic.php');
?>

<html>
    <head>
        <title>Blogbase - Sign Up</title>
        <meta charset="utf-8"><!-- <meta -->
        <meta name="viewport" content="width=device-width, inital-scale=1"><!-- comment -->

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>        
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
        <style>
            .registerform{
                align-content: center;
                align-items: center;
                align-self: center;
                color:red;
                width: 300px;
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





            <!--main part-->  

            <?php
        require('logic.php');
        if(isset($_REQUEST['username'])){
            $username = stripslashes($_REQUEST['username']);
            $username = mysqli_real_escape_string($con, $username);
            $fname = stripslashes($_REQUEST['fname']);
            $fname = mysqli_real_escape_string($con, $fname);
            $lname = stripslashes($_REQUEST['lname']);
            $lname = mysqli_real_escape_string($con, $lname);
            $email = stripslashes($_REQUEST['email']);
            $email = mysqli_real_escape_string($con, $email);
            $password = stripslashes($_REQUEST['password']);
            $password = mysqli_escape_string($con, $password);
            $Admin =  isset($_POST['Admin']) ? 1:0;
            $graphic_Des = isset($_POST['graphic_Des']) ? 1:0;
            $writer = isset($_POST['writer']) ? 1:0;
            $reader = isset($_POST['reader']) ? 1:0;
            $advr = isset($_POST['advr']) ? 1:0;

// Set default values for non-selected options
    if (!$Admin) {
        $Admin = 0;
    }
    if (!$graphic_Des) {
        $graphic_Des = 0;
    }
    if (!$writer) {
        $writer = 0;
    }
    if (!$reader) {
        $reader = 0;
    }
    if (!$advr) {
        $advr = 0;
    }


            

        $check = "SELECT * FROM `users` WHERE username='$username'";
        $check_select = mysqli_query($con, $check);
        $random_name = mysqli_num_rows($check_select);
        if($random_name > 0){
          header("Location: username_wrong.php");
        }else{

        $query    = "INSERT into `users` (username, fname, lname, email, password, Admin, graphic_des, writer, reader, advr)
                     VALUES ('$username', '$fname', '$lname', '$email', '" . md5($password) . "', '$Admin', '$graphic_Des', '$writer', '$reader', '$advr')";
        $result   = mysqli_query($con, $query);

            if ($result) {
                echo "<div><h3>Registered successfully.</h3></div>";
                header("Location: login.php");
            }
            else{
                echo "<div><h3>Required fields are missing...</h3></div>";
            }
          }
        }
        else{
        ?>
                <center>
                    <form class="registerform" action="" method="post">
                         <h1 style ="font-size: 23px; color: #ba986e;">--Register-- </h1>                       
                        <div class="form-group">
                            <input class="form-control" type="text" id="username" name="username" placeholder="Username" required />
                            <br>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" id="fname" name="fname" placeholder="First Name" required />
                            <br>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" id="lname" name="lname" placeholder="Last Name" required />
                            <br>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="email" id="email" name="email" placeholder="Email" required />
                            <br>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" id="password" name="password" placeholder="Password" required />
                            <br>
                        </div>
                        <div class="form-group">
                            <label for="Admin">Admin:</label>
                            <input type="checkbox" id="Admin" name="Admin" value="1" class="#"/>
                            <br>
                            <label for="graphic_Des">Graphic Designer:</label>
                            <input type="checkbox" id="graphic_Des" name="graphic_Des" value="1" class="#"/>
                            <br>
                            <label for="writer">Writer:</label>
                            <input type="checkbox" id="writer" name="writer" value="1" class="#"/>
                            <br>
                            <label for="reader">Reader:</label>
                            <input type="checkbox" id="reader" name="reader" value="1" class="#" required />
                            <br>
                            <label for="advr">Advertiser:</label>
                            <input type="checkbox" id="advr" name="advr" value="1" class="#"/>
                        </div>
                        <br>
                        <div class="form-group" style = "background:#a28557; color: whitesmoke;">
                            <input type="submit" value="Submit" name="submit" class="form-control"/>
                        </div>
                    </form>
                </center>
                <?php
            }
            ?>
            
            <script src="script.js"></script>

    </body>
</html>
