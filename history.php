<?php

require_once('comp/connection.php');
require_once('admin/comps/functions.php');

session_start();
if(!isset($_SESSION['userID'])){
    redirect('login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/history.css">
    <link rel="icon" href="img/logo.png"/>
    <title>Rhythmic</title>
</head>

<body>
<header>
    <div class="menu_side">
        <h1>Rhythmic</h1>
        <div class="playlist">
            <h4 class="active"><span></span><i class="bi bi-music-note-beamed"></i> Playlist</h4>
            <h4 ><span></span><i class="bi bi-music-note-beamed"></i> Last Listening</h4>
            <h4 ><span></span><i class="bi bi-music-note-beamed"></i> Recommended</h4>
        </div>
        <div class="menu_song">
            <li class="songItem">
                <span>01</span>
                <img src="img/1.jpg" alt="Alan">
                <h5>
                    On My Way
                    <div class="subtitle">Alan Walker</div>
                </h5>
                    <i class="bi playListPlay bi-play-circle-fill" id="1"></i>
            </li>
        </div>
    </div>


    <div class="song_side" id="songSide" style="display: block;">
        <nav>
            
            <div class="search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Search Music...">
            </div>
            <ul>
                <li onclick="goToHome()">Discover<span></span></li>
                <?php
                if(!isset($_SESSION['userID'])){

                    echo '<li onclick="goToLogin()">Sign In</li>';
                }else{
                    echo '<li onclick="goToLogOut()">Logout</li>';
                }
                ?>
            </ul>
            <div class="user">
                <img src="img/logo.png" alt="User" title="Rythmic">
            </div>
        </nav>
        <div class="content">
            <h1>Alan Walker - Faded</h1>
            <p>
                So when your tears roll down your pillow like a river 
                <br>
                I'll be there for you
            </p>
            <div class="buttons">
                <button>PLAY</button>
                <button>FOLLOW</button>
            </div>
        </div>
        <div class="popular_song">
            <div class="h4">
                <h4>Popular Song</h4>
                <div class="btn_s">
                    <i id="left_scroll" class="bi bi-arrow-left-short"></i>
                    <i id="right_scroll" class="bi bi-arrow-right-short"></i>
                </div>
            </div>
            <div class="pop_song">

            <?php
            
            $sql = "SELECT 
                        s.song_id, 
                        s.song_name, 
                        s.cover_image, 
                        s.song_file,
                        g.genre_name AS genre_name, 
                        a.title AS album_name, 
                        GROUP_CONCAT(ar.name SEPARATOR ', ') AS artist_names
                    FROM songs s
                    JOIN genres g ON s.genre_id = g.genre_id
                    JOIN albums a ON s.album_id = a.album_id
                    LEFT JOIN song_artist sa ON s.song_id = sa.song_id
                    LEFT JOIN artists ar ON sa.artist_id = ar.artist_id
                    GROUP BY s.song_id
                    ORDER BY s.song_id;";

            $res = $conn->query($sql);

            foreach($res as $row){
                echo '
                <li class="songItem">
                    <div class="img_play">
                        <img src="'.$row['cover_image'].'" alt="alan">
                        <i class="bi playListPlay bi-play-circle-fill" id="'.$row['song_id'].'" data-user="'.$_SESSION['userID'].'" onclick="handlePlay(event, '.$row['song_id'].', \''.$row['song_name'].'\', \''.$row['cover_image'].'\' ,\'uploads/song/'.$row['song_file'].'\')" ></i>
                    </div>
                    <h5>'.$row['song_name'].'
                        <br>
                        <div class="subtitle">'.$row['artist_names'].'</div>
                    </h5>
                </li>
                ';
            }

            ?>
                
            </div>
        </div>
        <div class="popular_artists">
            <div class="h4">
                <h4>Popular Artists</h4>
                <div class="btn_s">
                    <i id="left_scrolls" class="bi bi-arrow-left-short"></i>
                    <i id="right_scrolls" class="bi bi-arrow-right-short"></i>
                </div>
            </div>
            <div class="item">

                <?php
                
                $query = "SELECT * FROM artists ORDER BY popularity DESC;";
                $res = $conn->query($query);

                foreach($res as $row){
                    echo '<li>
                        <form action="artist.php" method="get">
                            <input hidden type="text" name="artist_id" value="'.$row['artist_id'].'">
                            <input type="image" src="./uploads/artist/'.$row['image'].'" alt="Submit">
                        </form>
                        </li>';    
                }
                ?>
            </div>
        </div>
    </div>


    <div class="master_play">
        <div class="wave">
            <div class="wave1"></div>
            <div class="wave1"></div>
            <div class="wave1"></div>
        </div>
        <img src="img/26th.jpg" alt="Alan" id="poster_master_play">
        <h5 id="title">Vande Mataram<br>
            <div class="subtitle">Bankim Chandra</div>
        </h5>
        <div class="icon">
            <i class="bi bi-skip-start-fill" id="back"></i>
            <i class="bi bi-play-fill" id="masterPlay"></i>
            <i class="bi bi-skip-end-fill" id="next"></i>
        </div>
        <span id="currentStart">0:00</span>
        <div class="bar">
            <input type="range" id="seek" min="0" value="0" max="100">
            <div class="bar2" id="bar2"></div>
            <div class="dot"></div>
        </div>
        <span id="currentEnd">0:00</span>

        <div class="vol">
            <i class="bi bi-volume-down-fill" id="vol_icon"></i>
            <input type="range" id="vol" min="0" value="30" max="100">
            <div class="vol_bar"></div>
            <div class="dot" id="vol_dot"></div>
        </div>
    </div>
</header>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>          
    <script src="app.js"></script>
</body>

</html>