CREATE TABLE roles(
	Id int not null,
	Name varchar(255) not null,
	PRIMARY KEY(Id)
) ENGINE=InnoDB;

INSERT INTO roles(Id, Name)
VALUES(1,'Admin'),(2,'user');


CREATE TABLE `app_config` (
    `key` varchar(15) NOT NULL,
    `value` tinyint(1) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
	PRIMARY KEY (`key`)
) ENGINE=InnoDB;

INSERT INTO `app_config` (`key`, `value`, `created_at`) VALUES
    ('initialized', 1, '2019-04-30 07:13:37');



CREATE TABLE `threads` (
                          `thread_id` int(11) NOT NULL AUTO_INCREMENT,
                          `title` varchar(255) NOT NULL,
                          `content` longtext NOT NULL,
                          `user_id` int(11) NOT NULL,
                          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                          `deleted_at` timestamp NULL DEFAULT NULL,
		PRIMARY KEY (`thread_id`)
) ENGINE=InnoDB;

INSERT INTO `threads` (`thread_id`, `title`, `content`, `user_id`, `created_at`, `deleted_at`) VALUES
                    (1, 'EZ EZ EDIT', 'asdasdjksahdjkas', 6, '2023-11-20 16:49:46', NULL);


CREATE TABLE `users` (
                         `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                         `fullname` varchar(255) NULL,
                         `username` varchar(255) NOT NULL,
                         `email` varchar(255) NOT NULL,
                         `role` INT NOT NULL DEFAULT 2,
                         `password` varchar(100) NOT NULL,
                         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                         `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                         `attempt` int(11) NOT NULL DEFAULT 0,
                         `last_login_time` timestamp NULL DEFAULT NULL,
			PRIMARY KEY(Id),
			CONSTRAINT fk_users_role
				FOREIGN KEY(role) REFERENCES roles(id)
) ENGINE=InnoDB;


INSERT INTO `users` ( `fullname`, `username`, `email`, `role`, `password`, `created_at`, `updated_at`, `attempt`, `last_login_time`) VALUES
        ('fulladmin', 'useradmin', 'admin@dummy.com', 1, 'passadmin', '2019-04-30 07:13:37', '2019-08-02 04:49:24', 0, NULL),
        ('fulluser', 'useruser', 'user@dummy.com', 2, 'passuser', '2019-04-30 07:13:37', '2019-08-02 04:49:24', 0, NULL);



CREATE TABLE `communications` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `sender_id` int(10) UNSIGNED NOT NULL,
    `recipient_id` int(10) UNSIGNED NOT NULL,
    `title` varchar(64) NOT NULL,
    `message` text NOT NULL,
    `send_at` timestamp NOT NULL DEFAULT current_timestamp(),
PRIMARY KEY (`id`),
CONSTRAINT `fk_communications_users` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;


INSERT INTO `communications` (`sender_id`, `recipient_id`, `title`, `message`, `send_at`) VALUES
(1, 1, 'Important Request', 'Dear admin,\r\nwe need backup now!\r\nA virus is attacking and we are low on supply! SOS!', '2019-05-03 06:02:33');