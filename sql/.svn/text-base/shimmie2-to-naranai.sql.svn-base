#
# MySQLDiff 1.5.0
#
# http://www.mysqldiff.org
# (c) 2001-2004, Lippe-Net Online-Service
#
# Create time: 19.01.2010 16:04
#
# --------------------------------------------------------
# Source info
# Host: mysql.oniichannoecchi.com
# Database: ikitest
# --------------------------------------------------------
# Target info
# Host: mysql.oniichannoecchi.com
# Database: iki_image
# --------------------------------------------------------
#

SET FOREIGN_KEY_CHECKS = 0;

#
# DDL START
#
CREATE TABLE `colors` (
    `id` int(11) NOT NULL DEFAULT 0 COMMENT '' auto_increment,
    `hexadecimal` char(6) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    `name` varchar(25) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    `hue` varchar(15) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    PRIMARY KEY (`id`),
    UNIQUE `hexidecimal` (`hexadecimal`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `favourites` (
    `id` int(11) NOT NULL DEFAULT 0 COMMENT '' auto_increment,
    `image_id` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '',
    PRIMARY KEY (`id`),
    UNIQUE `image_id` (`image_id`, `user_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `forum_posts` (
    `id` int(11) NOT NULL DEFAULT 0 COMMENT '' auto_increment,
    `topic` int(11) NOT NULL DEFAULT '-1' COMMENT '',
    `sticky` binary(1) NOT NULL DEFAULT '' COMMENT '',
    `locked` binary(1) NOT NULL DEFAULT '' COMMENT '',
    `title` varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    `post` text NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    `posted_at` datetime NOT NULL DEFAULT 0000-00-00 00:00:00 COMMENT '',
    `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `ip` varchar(16) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    PRIMARY KEY (`id`),
    UNIQUE `title` (`title`, `user_id`, `posted_at`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `groups` (
    `id` int(11) NOT NULL DEFAULT 0 COMMENT '' auto_increment,
    `group_name` varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    `description` text NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '',
    PRIMARY KEY (`id`),
    UNIQUE `group_name` (`group_name`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `image_groups` (
    `image_id` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `group_id` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `image_order` int(11) NOT NULL DEFAULT '0' COMMENT '',
    UNIQUE `image_group_key` (`image_id`, `group_id`),
    UNIQUE `image_id` (`image_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `implications` (
    `id` int(11) NOT NULL DEFAULT 0 COMMENT '' auto_increment,
    `tag` varchar(128) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    `implies` varchar(128) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    `reason` text NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    PRIMARY KEY (`id`),
    UNIQUE `implications__unique` (`tag`, `implies`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `note_histories` (
    `id` int(11) NOT NULL DEFAULT 0 COMMENT '' auto_increment,
    `note_id` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `image_id` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `note` text NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    `x` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `y` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `height` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `width` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '',
    PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `notes` (
    `id` int(11) NOT NULL DEFAULT 0 COMMENT '' auto_increment,
    `image_id` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `note` text NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    `x` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `y` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `height` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `width` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '',
    PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `numeric_score_votes` (
    `image_id` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `score` int(11) NOT NULL DEFAULT 0 COMMENT '',
    UNIQUE `image_id` (`image_id`, `user_id`),
    INDEX `image_id_2` (`image_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `reported` (
    `id` int(11) NOT NULL DEFAULT 0 COMMENT '' auto_increment,
    `image_id` int(11) NULL DEFAULT NULL COMMENT '',
    `reporter_name` varchar(32) NULL DEFAULT NULL COMMENT '' COLLATE utf8_general_ci,
    `reason_type` varchar(255) NULL DEFAULT NULL COMMENT '' COLLATE utf8_general_ci,
    `reason` varchar(255) NULL DEFAULT NULL COMMENT '' COLLATE utf8_general_ci,
    PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `tag_histories` (
    `id` int(11) NOT NULL DEFAULT 0 COMMENT '' auto_increment,
    `image_id` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `tags` text NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '',
    `date_set` datetime NOT NULL DEFAULT 0000-00-00 00:00:00 COMMENT '',
    `user_ip` char(15) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

ALTER TABLE `aliases`
    ADD `id` int(11) NOT NULL DEFAULT 0 COMMENT '' auto_increment FIRST,
    ADD `reason` text NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER newtag,
    DROP PRIMARY KEY,
    ADD PRIMARY KEY (`id`),
    DROP INDEX `newtag`,
    ADD UNIQUE `aliases__unique` (`oldtag`, `newtag`),
    COMMENT='';


ALTER TABLE `comments`
    MODIFY `owner_ip` char(16) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    DROP INDEX `owner_id`,
    COMMENT='InnoDB free: 0 kB';
#
#  Fieldformat of
#    comments.owner_ip changed from char(15) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci to char(16) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci.
#  Possibly data modifications needed!
#

ALTER TABLE `config`
    COMMENT='';


ALTER TABLE `image_tags`
    DROP INDEX `image_id_2`,
    DROP INDEX `image_id`,
    DROP INDEX `tag_id`,
    ADD UNIQUE `image_tags__key` (`image_id`, `tag_id`),
    ADD INDEX `image_tags__image_id` (`image_id`),
    ADD INDEX `image_tags__tag_id` (`tag_id`),
    COMMENT='';


ALTER TABLE `images`
    ADD `numeric_score` int(11) NOT NULL DEFAULT '0' COMMENT '' AFTER posted,
    ADD `rating` tinyint(1) NOT NULL DEFAULT '0' COMMENT '' AFTER numeric_score,
    ADD `note` varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER rating,
    ADD `primary_color` varchar(20) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER note,
    ADD `secondary_color` varchar(20) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER primary_color,
    ADD `tertiary_color` varchar(20) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER secondary_color,
    MODIFY `owner_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    MODIFY `hash` varchar(32) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    MODIFY `ext` varchar(4) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    MODIFY `source` varchar(249) NULL DEFAULT NULL COMMENT '' COLLATE utf8_general_ci,
    ALTER `posted` DROP DEFAULT,
    DROP `locked`,
    DROP INDEX `hash`,
    DROP INDEX `owner_id`,
    DROP INDEX `width`,
    DROP INDEX `height`,
    ADD UNIQUE `images__hash` (`hash`),
    ADD INDEX `images__owner_id` (`owner_id`),
    ADD INDEX `images__width` (`width`),
    ADD INDEX `images__height` (`height`),
    ADD INDEX `images__numeric_score` (`numeric_score`),
    COMMENT='';
#
#  Fieldformats of
#    images.owner_ip changed from char(15) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci to varchar(15) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci.
#    images.hash changed from char(32) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci to varchar(32) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci.
#    images.ext changed from char(4) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci to varchar(4) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci.
#    images.source changed from varchar(255) NULL DEFAULT NULL COMMENT '' COLLATE utf8_general_ci to varchar(249) NULL DEFAULT NULL COMMENT '' COLLATE utf8_general_ci.
#  Possibly data modifications needed!
#

ALTER TABLE `tags`
    ADD `type` enum('normal','character','artist','series','company') NOT NULL DEFAULT 'normal' COMMENT '' COLLATE utf8_general_ci AFTER count,
    DROP INDEX `tag`,
    ADD UNIQUE `tags__tag` (`tag`),
    COMMENT='';


ALTER TABLE `users`
    ADD `user_level` int(11) NOT NULL DEFAULT '1' COMMENT '' AFTER joindate,
    ADD `last_login` datetime NOT NULL DEFAULT 0000-00-00 00:00:00 COMMENT '' AFTER email,
    ADD `forums` datetime NULL DEFAULT NULL COMMENT '' AFTER last_login,
    ADD `approval_code` char(32) NULL DEFAULT NULL COMMENT '' COLLATE utf8_general_ci AFTER forums,
    ADD `approved` binary(1) NOT NULL DEFAULT '0' COMMENT '' AFTER approval_code,
    MODIFY `pass` varchar(32) NULL DEFAULT NULL COMMENT '' COLLATE utf8_general_ci,
    ALTER `joindate` DROP DEFAULT,
    DROP `admin`,
    MODIFY `email` varchar(249) NULL DEFAULT NULL COMMENT '' COLLATE utf8_general_ci,
    DROP INDEX `name`,
    ADD UNIQUE `users__name` (`name`),
    COMMENT='';
#
#  Fieldformats of
#    users.pass changed from char(32) NULL DEFAULT NULL COMMENT '' COLLATE utf8_general_ci to varchar(32) NULL DEFAULT NULL COMMENT '' COLLATE utf8_general_ci.
#    users.email changed from varchar(128) NULL DEFAULT NULL COMMENT '' COLLATE utf8_general_ci to varchar(249) NULL DEFAULT NULL COMMENT '' COLLATE utf8_general_ci.
#  Possibly data modifications needed!
#

#
# DDL END
#

SET FOREIGN_KEY_CHECKS = 1;
