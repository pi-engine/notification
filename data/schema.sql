CREATE TABLE IF NOT EXISTS `notification_noti` (
  `id` int(10) NOT NULL,
  `sender_id` int(10) NOT NULL DEFAULT 0,
  `receiver_id` int(10) NOT NULL DEFAULT 0,
  `platform_id` int(10) NOT NULL DEFAULT 0,
  `target_id` int(10) NOT NULL DEFAULT 0,
  `type` int(10) NOT NULL DEFAULT 0,
  `status` int(10) NOT NULL DEFAULT 0,
  `message_id` int(10) NOT NULL DEFAULT 0,
  `parent_id` int(10) NOT NULL DEFAULT 0,
  `time_create` int(10) NOT NULL DEFAULT current_timestamp(),
  `time_update` int(10) NOT NULL DEFAULT 0,
  `time_delete` int(10) NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS `notification_message` (
  `id` int(10) NOT NULL,
  `title` text NOT NULL DEFAULT '',
  `text` text NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `link` text NOT NULL DEFAULT '',
  `time_create` int(10) NOT NULL DEFAULT current_timestamp(),
  `time_update` int(10) NOT NULL DEFAULT 0,
  `time_delete` int(10) NOT NULL DEFAULT 0
);

