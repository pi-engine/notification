 CREATE TABLE IF NOT EXISTS `notification_id_value` (
                                         `id` int(10) NOT NULL,
                                         `title` varchar(255) NOT NULL DEFAULT '',
                                         `type` varchar(255) NOT NULL DEFAULT '',
                                         `time_create` int(10) NOT NULL DEFAULT current_timestamp(),
                                         `time_update` int(10) NOT NULL DEFAULT 0,
                                         `time_delete` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification_id_value`
--

INSERT INTO `notification_id_value` (`id`, `title`, `type`, `time_create`, `time_update`, `time_delete`) VALUES
                                                                                                             (1, 'Firebase', 'platform', 1650735005, 0, 0),
                                                                                                             (2, 'PHP mailer', 'platform', 1650735005, 0, 0),
                                                                                                             (3, 'Faraz SMS', 'platform', 1650735005, 0, 0),
                                                                                                             (4, 'Email', 'target', 1650736537, 0, 0),
                                                                                                             (5, 'Browser', 'target', 1650736537, 0, 0),
                                                                                                             (6, 'Device', 'target', 1650736537, 0, 0),
                                                                                                             (7, 'SMS', 'target', 1650736537, 0, 0),
                                                                                                             (8, 'Occasion', 'type', 1650737673, 0, 0),
                                                                                                             (9, 'Warning', 'type', 1650737673, 0, 0),
                                                                                                             (10, 'Notices', 'type', 1650737673, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notification_message`
--

CREATE TABLE IF NOT EXISTS `notification_message` (
                                        `id` int(10) NOT NULL,
                                        `title` text NOT NULL DEFAULT '',
                                        `text` text NOT NULL DEFAULT '',
                                        `image` varchar(255) NOT NULL DEFAULT '',
                                        `link` text NOT NULL DEFAULT '',
                                        `time_create` int(10) NOT NULL DEFAULT current_timestamp(),
                                        `time_update` int(10) NOT NULL DEFAULT 0,
                                        `time_delete` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification_message`
--

INSERT INTO `notification_message` (`id`, `title`, `text`, `image`, `link`, `time_create`, `time_update`, `time_delete`) VALUES
    (1, 'Test', 'This is a test for check api response', '', '', 1650733902, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notification_noti`
--

CREATE TABLE IF NOT EXISTS `notification_noti` (
                                     `id` int(10) NOT NULL,
                                     `sender_id` int(10) NOT NULL DEFAULT 0,
                                     `receiver_id` int(10) NOT NULL DEFAULT 0,
                                     `platform` varchar(255) NOT NULL DEFAULT '',
                                     `provider` varchar(255) NOT NULL DEFAULT '',
                                     `target`varchar(255) NOT NULL DEFAULT '',
                                     `type` int(10) NOT NULL DEFAULT 0,
                                     `status` int(10) NOT NULL DEFAULT 0,
                                     `message_id` int(10) NOT NULL DEFAULT 0,
                                     `parent_id` int(10) NOT NULL DEFAULT 0,
                                     `time_create` int(10) NOT NULL DEFAULT current_timestamp(),
                                     `time_update` int(10) NOT NULL DEFAULT 0,
                                     `time_delete` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification_noti`
--

 INSERT INTO `notification_noti` (`id`, `sender_id`, `receiver_id`, `platform`, `provider`, `target`, `type`, `status`, `message_id`, `parent_id`, `time_create`, `time_update`, `time_delete`) VALUES
     (1, 10, 11, 1,  1, 6, 10, 0, 1, 0, 1650733902, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notification_id_value`
--
ALTER TABLE `notification_id_value`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_message`
--
ALTER TABLE `notification_message`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_noti`
--
ALTER TABLE `notification_noti`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notification_id_value`
--
ALTER TABLE `notification_id_value`
    MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notification_message`
--
ALTER TABLE `notification_message`
    MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notification_noti`
--
ALTER TABLE `notification_noti`
    MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;