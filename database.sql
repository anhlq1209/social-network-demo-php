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
    
    UNIQUE KEY `id`(`id`),
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