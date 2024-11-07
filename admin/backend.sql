
-- Users table
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT, 
    user_name VARCHAR(60), 
    email_id VARCHAR(25), 
    dob VARCHAR(11), 
    age INT(3), 
    phone_no VARCHAR(15)
);

-- User accounts table
CREATE TABLE user_accounts (
    account_id VARCHAR(10) PRIMARY KEY , 
    email_id VARCHAR(25), 
    password VARCHAR(50), 
    account_name VARCHAR(20)
);

-- Artists table
CREATE TABLE artists (
    artist_id INT PRIMARY KEY AUTO_INCREMENT, 
    name VARCHAR(50),
    age INT,
    description VARCHAR(300)
);

-- Songs table
CREATE TABLE songs (
    song_id INT PRIMARY KEY AUTO_INCREMENT, 
    song_name VARCHAR(50),
    duration TIME,
    genre_id INT,
    album_id INT,
    FOREIGN KEY (genre_id) REFERENCES genres(genre_id),
    FOREIGN KEY (album_id) REFERENCES albums(album_ID)
);

-- Albums table
CREATE TABLE albums (
    album_ID INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(30),
    release_date DATE
);

-- Genres table
CREATE TABLE genres (
    genre_id INT PRIMARY KEY AUTO_INCREMENT,
    genres_name VARCHAR(30)
);

-- Subscriptions table
CREATE TABLE subscriptions (
    subscription_id INT PRIMARY KEY AUTO_INCREMENT,
    sub_type ENUM('free', 'pro'),
    price INT,
    account_id INT,
    FOREIGN KEY (account_id) REFERENCES user_accounts(account_id)
);

-- Listening history table
CREATE TABLE listening_history (
    history_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    song_id INT,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (song_id) REFERENCES songs(song_id)
);

-- Playlists table
CREATE TABLE playlists (
    playlist_ID INT PRIMARY KEY AUTO_INCREMENT,
    playlist_name VARCHAR(50),
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Playlist song association table (for many-to-many relationship between playlists and songs)
CREATE TABLE playlist_song (
    playlist_ID INT,
    song_id INT,
    PRIMARY KEY (playlist_ID, song_id),
    FOREIGN KEY (playlist_ID) REFERENCES playlists(playlist_ID),
    FOREIGN KEY (song_id) REFERENCES songs(song_id)
);

-- Admin table
CREATE TABLE admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL UNIQUE,
    email VARCHAR(30) NOT NULL UNIQUE,
    pass VARCHAR(30) NOT NULL
);

-- Album artist association table (for many-to-many relationship between albums and artists)
CREATE TABLE album_artist (
    album_id INT,
    artist_id INT,
    PRIMARY KEY (album_id, artist_id),
    FOREIGN KEY (album_id) REFERENCES albums(album_ID),
    FOREIGN KEY (artist_id) REFERENCES artists(artist_id)
);

-- Song artist association table (for many-to-many relationship between songs and artists)
CREATE TABLE song_artist (
    song_id INT,
    artist_id INT,
    PRIMARY KEY (song_id, artist_id),
    FOREIGN KEY (song_id) REFERENCES songs(song_id),
    FOREIGN KEY (artist_id) REFERENCES artists(artist_id)
);

DELIMITER //
CREATE TRIGGER update_artist_popularity 
AFTER INSERT ON listening_history
FOR EACH ROW
BEGIN
    UPDATE artists ar
    JOIN song_artist sa ON ar.artist_id = sa.artist_id
    SET ar.popularity = ar.popularity + 1
    WHERE sa.song_id = NEW.song_id;
END;
//
DELIMITER ;