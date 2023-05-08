<html>
<?php require('logic.php'); ?>
    <head>
        <title>Blogbase - Sign Up</title>
        <meta charset="utf-8"><!-- <meta -->
        <meta name="viewport" content="width=device-width, inital-scale=1"><!-- comment -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>                         

        <style>
            .row1{
                background-color: white;
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
               background: #ba986e
            }               
        </style>
    </head>
    <body>
            <nav class="flex-div" style = "background:#ba986e">
                <div class="nav-left flex-div">
                    <a href="index.php"><img src="logo1.png" class="logo" ></a>
                </div>
                <div class="nav-mid flex-div">
                    <div class="search-box flex-div" style = "background: whitesmoke;">
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
        
    <!--main part -->    
            <div class ="row1" style ="height:600px">
                <!-- This is where the info telling the user they logged out will take place -->
                <center>
                    <h3 style = "font-family: Times New Roman, Times, serif; font-size: 40px;color:#ba986e">REMINDER: 
                        <span style = "font-family: Times New Roman, Times, serif; font-size: 30px;color:whitesmoke">User Name Is Existing</span>
                    </h3>
                    <br>
                    <a class ="maincontent" href="register.php">Register Again</a>
                    <br>
                    <br>
                    <h3><a class ="maincontent" href="index.php">Return Home</a></h3>
                </center>
            </div>
    </body>
</html>
