CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `displayname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'avatar-default.png',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `friends`(
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `friend_id` bigint unsigned NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE KEY `id`(`id`),
  CONSTRAINT `FK_Friends_Users_U` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  CONSTRAINT `FK_Friends_Users_F` FOREIGN KEY (`friend_id`) REFERENCES `users`(`id`)

) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `friend_requests`(
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `friend_id` bigint unsigned NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE KEY `id`(`id`),
  CONSTRAINT `FK_FriendRequests_Users_U` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  CONSTRAINT `FK_FriendRequests_Users_F` FOREIGN KEY (`friend_id`) REFERENCES `users`(`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `posts`(
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `user_id` bigint unsigned NOT NULL,
    `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
    `count_likes` bigint unsigned default 0,
    `count_comments` bigint unsigned default 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,
  	`updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    UNIQUE KEY `id`(`id`),
    CONSTRAINT `FK_Posts_Users` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `likes`(
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `post_id` bigint unsigned NOT NULL,
    `user_id` bigint unsigned NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,
  	`updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    UNIQUE KEY `id`(id),
    CONSTRAINT `FK_Likes_Posts` FOREIGN KEY (`post_id`) REFERENCES `posts`(`id`),
    CONSTRAINT `FK_Likes_Users` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)

) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `comments`(
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `post_id` bigint unsigned NOT NULL,
    `user_id` bigint unsigned NOT NULL,
    `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,
  	`updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    UNIQUE KEY `id`(`id`),
    CONSTRAINT `FK_Comments_Posts` FOREIGN KEY (`post_id`) REFERENCES `posts`(`id`),
    CONSTRAINT `FK_Comments_Users` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)

) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create TRIGGER tg_InsertLike
after insert on likes
for each row
	update posts
    set posts.count_likes = (select count(*) from likes where new.post_id=likes.post_id)
    where posts.id=new.post_id;

create TRIGGER tg_DeleteLike
after delete on likes
for each row
	update posts
    set posts.count_likes = (select count(*) from likes where old.post_id=likes.post_id)
    where posts.id=old.post_id;
    
create TRIGGER tg_InsertComment
after insert on comments
for each row
	update posts
    set posts.count_comments = (select count(*) from comments where new.post_id=comments.post_id)
    where posts.id=new.post_id;
    
create TRIGGER tg_DeleteComment
after delete on comments
for each row
	update posts
    set posts.count_comments = (select count(*) from comments where old.post_id=comments.post_id)
    where posts.id=old.post_id;

create TRIGGER tg_InsertFriend
after insert on friends
for each row
	insert into friends (user_id, friend_id)
		VALUES (NEW.friend_id, NEW.user_id);
		
create TRIGGER tg_DeleteFriend
after DELETE on friends
for each row
	DELETE FROM friends 
    where friends.user_id=OLD.friend_id
      and friends.friend_id=OLD.user_id

create TRIGGER tg_DeletePost
after DELETE on posts
for each row
BEGIN
	DELETE FROM likes 
    where likes.post_id=OLD.id;
    delete from comments
    where comments.post_id=OLD.id;
END;

INSERT INTO `users` (`id`, `displayname`, `email`, `password`, `gender`, `phone`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'Lê Quốc Anh', 'anhlq1209@gmail.com', '$2y$10$DUHlh.td5b7MII50rg3wM.ifIACYtEyn32bj7kVs8gZ.WObzHLl.q', NULL, '0778651136', 'avatar-default.png', '2021-11-11 17:14:00', '2021-11-11 17:14:00');
INSERT INTO `users` (`id`, `displayname`, `email`, `password`, `gender`, `phone`, `avatar`, `created_at`, `updated_at`) VALUES
(2, 'admin1', 'admin1@admin.com', '$2y$10$HT5vZGbYwlUf.mKK1eqDCuAXQvdqMxfSj5/74wt4g2rswm12ElHee', NULL, '0123456788', 'avatar-default.png', '2021-11-11 18:50:22', '2021-11-11 18:50:22');
INSERT INTO `users` (`id`, `displayname`, `email`, `password`, `gender`, `phone`, `avatar`, `created_at`, `updated_at`) VALUES
(3, 'admin2', 'admin2@admin.com', '$2y$10$lPdbOR7QyJEnR1sqRNUPQ.ddhWKyhmblQddlPdZ6EizBY2Pzw4tZK', NULL, '0123456787', 'avatar-default.png', '2021-11-11 18:50:39', '2021-11-11 18:50:39');