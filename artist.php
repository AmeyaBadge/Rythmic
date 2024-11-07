<?php


if(!isset($_GET['artist_id']))
{
    die("Go to dashboard");
}else{
    require_once('comp/connection.php');

    $query = "SELECT 
                ar.artist_id, 
                ar.name AS artist_name,
                ar.age,
                ar.description AS artist_bio,
                ar.popularity,
                ar.image AS artist_image,
                s.song_id, 
                s.song_name, 
                s.duration,
                s.cover_image AS song_cover,
                s.song_file,
                g.genre_name AS genre_name,
                a.title AS album_name
            FROM 
                artists ar
            JOIN 
                song_artist sa ON ar.artist_id = sa.artist_id
            JOIN 
                songs s ON sa.song_id = s.song_id
            JOIN 
                genres g ON s.genre_id = g.genre_id
            JOIN 
                albums a ON s.album_id = a.album_id
            WHERE 
                ar.artist_id = ".$_GET['artist_id']."  -- Replace with specific artist_id or bind in application code
            ORDER BY 
                ar.popularity;
            ";
    $res = $conn->query($query);
    $first_row = $res->fetch_assoc();
    $artist_info = [
        'artist_id' => $first_row['artist_id'],
        'artist_name' => $first_row['artist_name'],
        'age' => $first_row['age'],
        'bio' => $first_row['artist_bio'],
        'popularity' => $first_row['popularity'],
        'image' => $first_row['artist_image']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
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

        </div>
    </div>


    <div class="song_side">
        <nav>
            <ul>
                <li>Discover <span></span></li>
                <li>MY LIBRARY</li>
                <li>RADIO</li>
            </ul>
            <div class="search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Search Music...">
            </div>
            <div class="user">
                <img src="img/logo.png" alt="User" title="Rhythmic">
            </div>
        </nav>
        <div class="content">
            <h1><?php echo $artist_info['artist_name'];?></h1>
            <p>
               <?php echo $artist_info['bio']; ?>
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
            
            
            do{
                echo '
                <li class="songItem">
                    <div class="img_play">
                        <img src="'.$first_row['song_cover'].'" alt="alan">
                        <i class="bi playListPlay bi-play-circle-fill" id="'.$first_row['song_id'].'" onclick="handlePlay(event, '.$first_row['song_id'].', \''.$first_row['song_name'].'\', \''.$first_row['song_cover'].'\' ,\'uploads/song/'.$first_row['song_file'].'\')" ></i>
                    </div>
                    <h5>'.$first_row['song_name'].'
                        <br>
                        <div class="subtitle">'.$artist_info['artist_name'].'</div>
                    </h5>
                </li>
                ';
            }while($first_row = $res->fetch_assoc());

            ?>
                
            </div>
        </div>
        <div class="popular_artists">
            <div class="h4">
                <h4>Other Artists</h4>
                <div class="btn_s">
                    <i id="left_scrolls" class="bi bi-arrow-left-short"></i>
                    <i id="right_scrolls" class="bi bi-arrow-right-short"></i>
                </div>
            </div>
            <div class="item">

                <?php
                
                $query = "SELECT * FROM artists ORDER BY popularity,name DESC;";
                $res = $conn->query($query);

                foreach($res as $row){
                    echo '<li>
                            <img src="./uploads/artist/'.$row['image'].'" alt="'.$row['name'].'" title="'.$row['name'].'">
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
    <script src="app.js"></script>
</body>

</html>