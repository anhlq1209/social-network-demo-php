CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `displayname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'avatar-default.png',
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `images_post`(
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `post_id` bigint unsigned NOT NULL,
    `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,
  	`updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    UNIQUE KEY `id`(`id`),
    CONSTRAINT `FK_Images_Posts` FOREIGN KEY (`post_id`) REFERENCES `posts`(`id`)

) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create PROCEDURE sp_InsertFriend
(in userId bigint, in friendId bigint)
BEGIN
	IF (userId != friendId) THEN
		IF (NOT EXISTS (SELECT * FROM friends WHERE friends.user_id=userId and friends.friend_id=friendId)) THEN
			INSERT INTO friends (user_id, friend_id) VALUES (userId, friendId);
		END IF;
		IF (NOT EXISTS (SELECT * FROM friends WHERE friends.user_id=friendId and friends.friend_id=userId)) THEN
			INSERT INTO friends (user_id, friend_id) VALUES (friendId, userId);
		END IF;
	END if;
end;

create PROCEDURE sp_DeleteFriend
(in userId bigint, in friendId bigint)
BEGIN
	IF (userId != friendId) THEN
		IF (EXISTS (SELECT * FROM friends WHERE friends.user_id=userId and friends.friend_id=friendId)) THEN
			DELETE FROM friends 
				    where friends.user_id=userId
				      and friends.friend_id=friendId;
		END IF;
		IF (EXISTS (SELECT * FROM friends WHERE friends.user_id=friendId and friends.friend_id=userId)) THEN
			DELETE FROM friends 
				    where friends.user_id=friendId
				      and friends.friend_id=userId;
		END IF;
	END IF;
end;

create TRIGGER tg_InsertLike
after insert on likes
for each row
BEGIN
	SET @post_id = new.post_id;
	
	IF EXISTS(select * FROM posts WHERE posts.id=@post_id) THEN
		update posts
	    set posts.count_likes = (select count(*) from likes where likes.post_id=@post_id)
	    where posts.id=@post_id;
	END IF;
END;

create TRIGGER tg_DeleteLike
after delete on likes
for each row
BEGIN
	SET @post_id = old.post_id;
	
	IF EXISTS(select * FROM posts WHERE posts.id=@post_id) THEN
		update posts
	    set posts.count_likes = (select count(*) from likes where likes.post_id=@post_id)
	    where posts.id=@post_id;
	END IF;
END;

create TRIGGER tg_UpdateLike
after update on likes
for each row
BEGIN
	SET @post_id_new = new.post_id;
	SET @post_id_old = old.post_id;
	
	IF EXISTS(select * FROM posts WHERE posts.id=@post_id_new) THEN
		update posts
	    set posts.count_likes = (select count(*) from likes where likes.post_id=@post_id_new)
	    where posts.id=@post_id_new;
	END IF;
	
	IF EXISTS(select * FROM posts WHERE posts.id=@post_id_old) THEN
		update posts
	    set posts.count_likes = (select count(*) from likes where likes.post_id=@post_id_old)
	    where posts.id=@post_id_old;
	END IF;
END;

create TRIGGER tg_InsertComment
after insert on comments
for each row
BEGIN
	SET @post_id = new.post_id;
	
	IF EXISTS(select * FROM posts WHERE posts.id=@post_id) THEN
		update posts
	    set posts.count_comments = (select count(*) from comments where comments.post_id=@post_id)
	    where posts.id=@post_id;
	END IF;
END;

create TRIGGER tg_DeleteComment
after delete on comments
for each row
BEGIN
	SET @post_id = old.post_id;
	
	IF EXISTS(select * FROM posts WHERE posts.id=@post_id) THEN
		update posts
	    set posts.count_comments = (select count(*) from comments where comments.post_id=@post_id)
	    where posts.id=@post_id;
	END IF;
END;

create TRIGGER tg_UpdateComment
after update on comments
for each row
BEGIN
	SET @post_id_new = new.post_id;
	SET @post_id_old = old.post_id;
	
	IF EXISTS(select * FROM posts WHERE posts.id=@post_id_new) THEN
		update posts
	    set posts.count_comments = (select count(*) from comments where comments.post_id=@post_id_new)
	    where posts.id=@post_id_new;
	END IF;
	
	IF EXISTS(select * FROM posts WHERE posts.id=@post_id_old) THEN
		update posts
	    set posts.count_comments = (select count(*) from comments where comments.post_id=@post_id_old)
	    where posts.id=@post_id_old;
	END IF;
END;

create TRIGGER tg_DeletePost
after DELETE on posts
for each row
BEGIN
	set @id = OLD.id;
	
	IF EXISTS (select * from likes where likes.post_id=@id) THEN
		DELETE FROM likes 
		where likes.post_id=@id;
	END IF;
	
	IF EXISTS (select * from comments where comments.post_id=@id) THEN
	    delete from comments
	    where comments.post_id=@id;
	END IF;
	
	IF EXISTS (select * from images_post where images_post.post_id=@id) THEN
	    delete from images_post
	    where images_post.post_id=@id;
	END IF;
END;

INSERT INTO `users` (`id`, `displayname`, `email`, `password`, `gender`, `phone`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'Lê Quốc Anh', 'anhlq1209@gmail.com', '$2y$10$DUHlh.td5b7MII50rg3wM.ifIACYtEyn32bj7kVs8gZ.WObzHLl.q', NULL, '0778651136', 'avatar-default.png', '2021-11-11 17:14:00', '2021-11-11 17:14:00');
INSERT INTO `users` (`id`, `displayname`, `email`, `password`, `gender`, `phone`, `avatar`, `created_at`, `updated_at`) VALUES
(2, 'admin1', 'admin1@admin.com', '$2y$10$HT5vZGbYwlUf.mKK1eqDCuAXQvdqMxfSj5/74wt4g2rswm12ElHee', NULL, '0123456788', 'avatar-default.png', '2021-11-11 18:50:22', '2021-11-11 18:50:22');
INSERT INTO `users` (`id`, `displayname`, `email`, `password`, `gender`, `phone`, `avatar`, `created_at`, `updated_at`) VALUES
(3, 'admin2', 'admin2@admin.com', '$2y$10$lPdbOR7QyJEnR1sqRNUPQ.ddhWKyhmblQddlPdZ6EizBY2Pzw4tZK', NULL, '0123456787', 'avatar-default.png', '2021-11-11 18:50:39', '2021-11-11 18:50:39');