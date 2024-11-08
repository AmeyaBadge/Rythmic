CREATE DATABASE  IF NOT EXISTS `musicplayer` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `musicplayer`;
CREATE TABLE `admin` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
);

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` VALUES (1,'ameya','ameyabadge@gmail.com','Ameya@123');

--
-- Table structure for table `album_artist`
--
CREATE TABLE `album_artist` (
  `album_id` int NOT NULL,
  `artist_id` int NOT NULL,
  PRIMARY KEY (`album_id`,`artist_id`),
  KEY `artist_id` (`artist_id`),
  CONSTRAINT `album_artist_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`album_id`),
  CONSTRAINT `album_artist_ibfk_2` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`)
);
--
-- Dumping data for table `album_artist`
--
INSERT INTO `album_artist` VALUES (1,1),(1,2),(2,3),(3,4),(4,5),(4,6),(5,7),(6,8),(2,9);

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `album_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `release_date` date DEFAULT NULL,
  `cover` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`album_id`)
);
--
-- Dumping data for table `albums`
--

INSERT INTO `albums` VALUES (1,'Bhool Bhulaiya 3','2024-11-01','https://i.ytimg.com/vi/4ijYySiMLEw/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLCBSwbl22MmveTAvM0XtiVWqDJe6A'),(2,'Independent','2024-11-08','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT9E7NJeWBh2JZXj-P93xuMYcz22m0akuRi2Q&s'),(3,'Jab Tak Hai Jaan','2013-06-19','https://pagalnew.com/coverimages/Challa-Jab-Tak-Hai-Jaan-500-500.jpg'),(4,'Dear Zindagi','2024-10-21','https://pagalfree.com/images/128Ae%20Zindagi%20Gale%20Laga%20Le%20(Take,%201)%20-%20Dear%20Zindagi%20128%20Kbps.jpg'),(5,'Glory','2024-06-11','https://images.genius.com/1ed8c12912f6484b531bbfb7fd5d6ba0.1000x1000x1.png'),(6,'English','2024-11-08','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTXQdntEytg83gIAOstOaIhNm26OD4tmALBOg&s');

--
-- Table structure for table `artists`
--
CREATE TABLE `artists` (
  `artist_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `age` int DEFAULT NULL,
  `description` text,
  `popularity` int NOT NULL DEFAULT '0',
  `image` varchar(200) NOT NULL DEFAULT 'https://cdn-icons-png.freepik.com/512/8742/8742495.png',
  PRIMARY KEY (`artist_id`)
);
--
-- Dumping data for table `artists`
--
INSERT INTO `artists` VALUES (1,'Pritam',50,'Amazing composer',0,'pritam.jpg'),(2,'Sonu Nigam',48,'Amazing Singer',0,'sonuNigam.jpg'),(3,'Mohit Chauhan',36,'Guitarist, old singer',0,'mohitChauhan.jpg'),(4,'A R Rahman',49,'Composor, GOAT',0,'arRahman.png'),(5,'Arijith Singh',30,'SINGER, GOAT',0,'arijithSingh.jpg'),(6,'Amit Trivedi',32,'singer',0,'amitTrivedi.jpg'),(7,'Yo Yo Honey Singh',50,'singer, Rapper\r\n',0,'yoyo.jpg'),(8,'Alan Walker',29,'English singer',0,'alan.jpg'),(9,'Dhvani Bhanushali',28,'Singer',0,'dhvani.jpg');

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genre_id` int NOT NULL AUTO_INCREMENT,
  `genre_name` varchar(30) NOT NULL,
  PRIMARY KEY (`genre_id`)
);
--
-- Dumping data for table `genres`
--
INSERT INTO `genres` VALUES (1,'Pop'),(2,'Rock'),(3,'Hip-Hop'),(4,'Electronic'),(5,'Country');

--
-- Table structure for table `listening_history`
--

CREATE TABLE `listening_history` (
  `history_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `song_id` int NOT NULL,
  `listened_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`history_id`),
  KEY `user_id` (`user_id`),
  KEY `song_id` (`song_id`),
  CONSTRAINT `listening_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `listening_history_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`)
);
--
-- Dumping data for table `listening_history`
--
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
--
-- Table structure for table `playlist_song`
--

CREATE TABLE `playlist_song` (
  `playlist_id` int NOT NULL,
  `song_id` int NOT NULL,
  PRIMARY KEY (`playlist_id`,`song_id`),
  KEY `song_id` (`song_id`),
  CONSTRAINT `playlist_song_ibfk_1` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`playlist_id`),
  CONSTRAINT `playlist_song_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`)
);
--
-- Dumping data for table `playlist_song`
--

--
-- Table structure for table `playlists`
--
CREATE TABLE `playlists` (
  `playlist_id` int NOT NULL AUTO_INCREMENT,
  `playlist_name` varchar(50) NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`playlist_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `playlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
);
--
-- Dumping data for table `playlists`
--
INSERT INTO `playlists` VALUES (1,'Chill Vibes',1),(2,'Workout Mix',2),(3,'Electronic Favorites',3),(4,'Country Classics',4),(5,'Rock Anthems',1);
--
-- Table structure for table `song_artist`
--
CREATE TABLE `song_artist` (
  `song_id` int NOT NULL,
  `artist_id` int NOT NULL,
  PRIMARY KEY (`song_id`,`artist_id`),
  KEY `artist_id` (`artist_id`),
  CONSTRAINT `song_artist_ibfk_1` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`),
  CONSTRAINT `song_artist_ibfk_2` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`)
);
--
-- Dumping data for table `song_artist`
--
INSERT INTO `song_artist` VALUES (1,1),(1,2),(2,3),(3,4),(4,5),(4,6),(5,7),(6,8),(7,9);
--
-- Table structure for table `songs`
--
CREATE TABLE `songs` (
  `song_id` int NOT NULL AUTO_INCREMENT,
  `song_name` varchar(50) NOT NULL,
  `duration` time NOT NULL,
  `genre_id` int DEFAULT NULL,
  `album_id` int DEFAULT NULL,
  `cover_image` varchar(200) DEFAULT NULL,
  `song_file` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`song_id`),
  KEY `genre_id` (`genre_id`),
  KEY `album_id` (`album_id`),
  CONSTRAINT `songs_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`genre_id`),
  CONSTRAINT `songs_ibfk_2` FOREIGN KEY (`album_id`) REFERENCES `albums` (`album_id`)
);
--
-- Dumping data for table `songs`
--
INSERT INTO `songs` VALUES (1,'Mere Dholna','00:10:00',3,1,'https://i.scdn.co/image/ab67616d0000b273a7ee517f57e805d99cd27014','mereDholna.mp3'),(2,'Masakali','00:10:00',1,2,'https://a10.gaanacdn.com/gn_img/albums/koMWQ7BKqL/koMWQDX3qL/size_m.webp','masakali.mp3'),(3,'Challa','00:10:00',5,3,'https://pagalnew.com/coverimages/Challa-Jab-Tak-Hai-Jaan-500-500.jpg','Challa Jab Tak Hai Jaan.mp3'),(4,'Ae Zindagi (Take 1)','00:10:00',2,4,'https://pagalfree.com/images/128Ae%20Zindagi%20Gale%20Laga%20Le%20(Take,%201)%20-%20Dear%20Zindagi%20128%20Kbps.jpg','Ae Zindagi Gale Laga Le (Take, 1).mp3'),(5,'Millionare','00:10:00',1,5,'https://i.scdn.co/image/ab67616100005174bc7e4fffd515b47ff1ebbc1f','Millionaire.mp3'),(6,'Faded','00:10:00',1,6,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTXQdntEytg83gIAOstOaIhNm26OD4tmALBOg&s','Faded.mp3'),(7,'Vaaste','00:10:00',5,2,'https://www.pagalworld.us/_big/vaaste-dhvani-bhanushali-250.jpg','Vaaste.mp3');

--
-- Table structure for table `subscriptions`
--
CREATE TABLE `subscriptions` (
  `subscription_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `subscription_type` enum('free','pro') NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`subscription_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
);
--
-- Dumping data for table `subscriptions`
--
INSERT INTO `subscriptions` VALUES (1,1,'pro',9.99,'2024-01-01','2025-01-01'),(2,2,'free',0.00,'2024-03-01',NULL),(3,3,'pro',9.99,'2024-05-15','2025-05-15'),(4,4,'free',0.00,'2024-06-01',NULL);

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `account_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `account_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `email_id` (`email_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
);
--
-- Dumping data for table `user_accounts`
--
INSERT INTO `user_accounts` VALUES (1,1,'alice@example.com','password123','alice_account'),(2,2,'bob@example.com','securepassword','bob_account'),(3,3,'charlie@example.com','charliepass','charlie_account'),(4,4,'dana@example.com','danapass','dana_account');

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `dob` date DEFAULT NULL,
  `age` int DEFAULT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email_id` (`email_id`)
);
--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES (1,'Alice Johnson','alice@example.com','1998-05-12',26,'1234567890'),(2,'Bob Smith','bob@example.com','1995-08-22',29,'0987654321'),(3,'Charlie Rose','charlie@example.com','2000-01-15',24,'1122334455'),(4,'Dana White','dana@example.com','1993-10-05',31,'2233445566');
