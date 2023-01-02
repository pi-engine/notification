CREATE TABLE IF NOT EXISTS `notification_storage`
(
    `id`          INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`     INT(10) UNSIGNED NOT NULL DEFAULT 0,
    `status`      tinyint(1)       NOT NULL DEFAULT 1,
    `viewed`      tinyint(1)       NOT NULL DEFAULT 0,
    `sent`        tinyint(1)       NOT NULL DEFAULT 1,
    `time_create` int(10)          NOT NULL DEFAULT 0,
    `time_update` int(10)          NOT NULL DEFAULT 0,
    `information` JSON,
    PRIMARY KEY (`id`)
);