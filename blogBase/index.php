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
        <meta name="viewport" content="width=device-width, intitial-scale=0.3">
        <title>Blog Base e-newspaper</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
            .sidebar{
                visibility: visible;
                background: #fff;
                width: 100%;
                height: 100vh;
                position: relative;
                top: 0;
                padding-left: 15%;
                padding-top: 40px;
            }

         
            .mainimage2{
                height: 250px;
                width: 300px;
                border-radius: 50px 10px;
                margin: 0px 10px;
            }
            .mainimage1{
                height: 250px;
                width: 300px;
                border-radius: 50px 10px;
                margin: 10px 10px;
            }
            .maitext1{
                color:#ae926c;
            }            
            .maitext2{
                margin: 100px 0px 0px 0px;
                color:#ae926c;
            }
            
            .floadAd {
                position: absolute;
                z-index: 999900;
                display: none;
            }
            .floadAd .item {
                display: block;
            }
            .floadAd .item img {
                vertical-align: bottom;
            }

        </style>


    </head>

    <body>
        <div id="floadAD" class="floadAd"> 
            <a class="close" href="javascript:void();" style="color: #a28557">×close</a> 
            <a class="item" title='float' href="ad_design.php" target="_blank"> 
                <img src="advertisementpicture.png" style ="height: 160px; width: 270px" alt="this is advertisement" /></a> 
        </div>     

        <div class = "row" style = "margin: 0px; background: #efefef;border-bottom: solid 3px black">
            <div class ="col-md-2"></div> 
            <div class ="col-md-8">
                <img class ="logoImage" src = "Blogbaselogo.png" >
            </div>                
            <div class ="col-md-2"></div>                 
        </div>       
        <nav class="flex-div" style = "background:#ba986e;">
            <div class="nav-left flex-div">
                <img class="menu-icon" style = "margin:0% 0% 0% 30%" src="menu_icon.png">
            </div>
            <div class="nav-mid flex-div" >
                <div class="search-box flex-div" style = "background: whitesmoke;">
                    <form action="search-proc.php" method="POST" id="searchForm">
                        <input type="text/submiit" name="search" placeholder="search"/> <img src="search.png">
                    </form>
                </div>
            </div>
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
                        <a href="user_profile.php" style="padding: 10px;"><img src="follow.png"></a>
                        <button type ="button" style = "color:#ba986e;border-radius: 25px;">
                            <?php echo $_SESSION['username'] ?> </button>
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
        <div class ="row" style ="height: 700px; border-top:solid 3px black; background:whitesmoke">
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

            <!--main-->


            <div class ="col-md-3" style ="width:27.7%;">
                <div class ="row" style ="height: 30%;"> 
                    <a class = "maitext1" href="business.php">business
                    <img class = "mainimage1" src ="business.jpeg" >                                    
                    </a> 
                </div>

                <div class ="row" style ="height: 30%;"> 
                    <a class = "maitext2" href="Technology.php">Technology
                    <img class = "mainimage2" src ="technology.jpeg">                        
                </a>
                </div>
            </div>

            <div class ="col-md-3" style ="width:27.7%;">
                <div class ="row" style ="height: 30%;">
                <a class = "maitext1" href="politics.php">Politics                   
                    <img class = "mainimage1" src ="politics.jpeg">                        
                </a> 
            </div>

                <div class ="row" style ="height: 30%;"> 
                <a class = "maitext2" href="science.php">Science    
                    <img class = "mainimage2" src ="science.jpeg">                        
                </a>
            </div>
            </div>


            <div class ="col-md-3" style ="width:27.7%;">
                <div class ="row" style ="height: 30%;">
                    <a class = "maitext1" href="style.php">Style
                    <img class = "mainimage1" src ="fashion.jpeg">                        
                </a>
            </div>

                <div class ="row" style ="height: 30%;"> 
                    <a  class = "maitext2" href="health.php">Health
                    <img class = "mainimage2" src ="health.jpeg">                        
                </a>
                    </div>
            </div>








            <div class ="row" style ="height: 100px; margin-top: 40px; border-top: solid #ba986e;">
                <center>                    
                    <p style = "color:#ae926c">875 Perimeter Drive | Moscow, ID 83844<span style = "margin: 0 20px">© 2023 University of Idaho All Rights Reserved.</span></p>  
                </center>
            </div>           

        </div>                
    </body>

    <script>
        FloatAd("#floadAD");
        function FloatAd(selector) {
            var obj = $(selector);
            if (obj.find(".item").length == 0)
                return;
            var windowHeight = $(window).height();
            var windowWidth = $(window).width();
            var dirX = -1.5;
            var dirY = -1;

            var delay = 30;
            obj.css({left: windowWidth / 2 - obj.width() / 2 + "px", top: windowHeight / 2 - obj.height() / 2 + "px"});//把元素设置成在页面中间 
            obj.show();
            var handler = setInterval(move, delay);

            obj.hover(function () {
                clearInterval(handler);
            }, function () {
                handler = setInterval(move, delay);
            });

            obj.find(".close").click(function () {
                close();
            });
            $(window).resize(function () {
                windowHeight = $(window).height();
                windowWidth = $(window).width();
            });
            function move() {
                var currentPos = obj.position();
                var nextPosX = currentPos.left + dirX;
                var nextPosY = currentPos.top + dirY;

                if (nextPosX >= windowWidth - obj.width()) {
                    close();
                }

                if (nextPosX <= 0 || nextPosX >= windowWidth - obj.width()) {
                    dirX = dirX * -1;
                    nextPosX = currentPos.left + dirX;
                }
                if (nextPosY <= 0 || nextPosY >= windowHeight - obj.height() - 5) {
                    dirY = dirY * -1;
                    nextPosY = currentPos.top + dirY;
                }
                obj.css({left: nextPosX + "px", top: nextPosY + "px"});
            }

            function close() {
                clearInterval(handler);
                obj.remove();
            }
        }
    </script>
</html>