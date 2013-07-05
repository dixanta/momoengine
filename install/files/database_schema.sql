-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 06, 2008 at 05:56 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET FOREIGN_KEY_CHECKS=0;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `backendpro`
--

-- --------------------------------------------------------

--
-- Table structure for table `be_acl_actions`
--

DROP TABLE IF EXISTS `be_acl_actions`;
CREATE TABLE IF NOT EXISTS `be_acl_actions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(254) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `be_acl_actions`
--


-- --------------------------------------------------------

--
-- Table structure for table `be_acl_groups`
--

DROP TABLE IF EXISTS `be_acl_groups`;
CREATE TABLE IF NOT EXISTS `be_acl_groups` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `lft` int(10) unsigned NOT NULL default '0',
  `rgt` int(10) unsigned NOT NULL default '0',
  `name` varchar(254) NOT NULL,
  `link` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `be_acl_groups`
--

INSERT INTO `be_acl_groups` (`id`, `lft`, `rgt`, `name`, `link`) VALUES
(1, 1, 4, 'Member', NULL),
(2, 2, 3, 'Administrator', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `be_acl_permissions`
--

DROP TABLE IF EXISTS `be_acl_permissions`;
CREATE TABLE IF NOT EXISTS `be_acl_permissions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `aro_id` int(10) unsigned NOT NULL default '0',
  `aco_id` int(10) unsigned NOT NULL default '0',
  `allow` char(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `aro_id` (`aro_id`),
  KEY `aco_id` (`aco_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `be_acl_permissions`
--

INSERT INTO `be_acl_permissions` (`id`, `aro_id`, `aco_id`, `allow`) VALUES
(1, 2, 1, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `be_acl_permission_actions`
--

DROP TABLE IF EXISTS `be_acl_permission_actions`;
CREATE TABLE IF NOT EXISTS `be_acl_permission_actions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `access_id` int(10) unsigned NOT NULL default '0',
  `axo_id` int(10) unsigned NOT NULL default '0',
  `allow` char(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `access_id` (`access_id`),
  KEY `axo_id` (`axo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `be_acl_permission_actions`
--


-- --------------------------------------------------------

--
-- Table structure for table `be_acl_resources`
--

DROP TABLE IF EXISTS `be_acl_resources`;
CREATE TABLE IF NOT EXISTS `be_acl_resources` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `lft` int(10) unsigned NOT NULL default '0',
  `rgt` int(10) unsigned NOT NULL default '0',
  `name` varchar(254) NOT NULL,
  `link` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `be_acl_resources`
--

INSERT INTO `be_acl_resources` (`id`, `lft`, `rgt`, `name`, `link`) VALUES
(1, 1, 22, 'Site', NULL),
(2, 2, 21, 'Control Panel', NULL),
(3, 3, 20, 'System', NULL),
(4, 14, 15, 'Members', NULL),
(5, 4, 13, 'Access Control', NULL),
(6, 16, 17, 'Settings', NULL),
(7, 18, 19, 'Utilities', NULL),
(8, 11, 12, 'Permissions', NULL),
(9, 9, 10, 'Groups', NULL),
(10, 7, 8, 'Resources', NULL),
(11, 5, 6, 'Actions', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `be_groups`
--

DROP TABLE IF EXISTS `be_groups`;
CREATE TABLE IF NOT EXISTS `be_groups` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `locked` tinyint(1) unsigned NOT NULL default '0',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `be_groups`
--

INSERT INTO `be_groups` (`id`, `locked`, `disabled`) VALUES
(1, 1, 0),
(2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `be_preferences`
--

DROP TABLE IF EXISTS `be_preferences`;
CREATE TABLE IF NOT EXISTS `be_preferences` (
  `name` varchar(254) character set utf8 NOT NULL,
  `value` text character set utf8 NOT NULL,
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `be_preferences`
--

INSERT INTO `be_preferences` (`name`, `value`) VALUES
('default_user_group', '1'),
('smtp_host', ''),
('keep_error_logs_for', '30'),
('email_protocol', 'sendmail'),
('use_registration_captcha', '0'),
('page_debug', '0'),
('automated_from_name', 'Momo Engine'),
('allow_user_registration', '1'),
('use_login_captcha', '0'),
('site_name', 'Momo Engine Rapid Web Application Development Engine'),
('automated_from_email', 'noreply@momoengine.com'),
('account_activation_time', '7'),
('allow_user_profiles', '0'),
('activation_method', 'email'),
('autologin_period', '30'),
('min_password_length', '8'),
('smtp_user', ''),
('smtp_pass', ''),
('email_mailpath', '/usr/sbin/sendmail'),
('smtp_port', '25'),
('smtp_timeout', '5'),
('email_wordwrap', '1'),
('email_wrapchars', '76'),
('email_mailtype', 'html'),
('email_charset', 'utf-8'),
('bcc_batch_mode', '0'),
('bcc_batch_size', '200'),
('login_field','email'),
('meta_keywords','Momo Engine Fastest Web Application Development Engine'),
('meta_description','Momo Engine Fastest Web Application Development Engine'),
('offline_message',''),
('theme','default'),
('site_status', '1'),
('date_format','Y-m-d'),
('date_time_format','Y-m-d H:i:s'),
('backup_path', 'backups'),
('google_analytics_tracking_code', ''),
('activate_google_analytics', '0');


-- --------------------------------------------------------

--
-- Table structure for table `be_resources`
--

DROP TABLE IF EXISTS `be_resources`;
CREATE TABLE IF NOT EXISTS `be_resources` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `locked` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `be_resources`
--

INSERT INTO `be_resources` (`id`, `locked`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `be_users`
--

DROP TABLE IF EXISTS `be_users`;
CREATE TABLE IF NOT EXISTS `be_users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(254) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL default '0',
  `group` int(10) unsigned default NULL,
  `activation_key` varchar(32) default NULL,
  `last_visit` datetime default NULL,
  `created` datetime NOT NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `password` (`password`),
  KEY `group` (`group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `be_users`
--
 
-- --------------------------------------------------------

--
-- Table structure for table `be_user_profiles`
--

DROP TABLE IF EXISTS `be_user_profiles`;
CREATE TABLE IF NOT EXISTS `be_user_profiles` (
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `be_user_profiles`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) character set utf8 NOT NULL default '0',
  `ip_address` varchar(16) character set utf8 NOT NULL default '0',
  `user_agent` varchar(50) character set utf8 NOT NULL,
  `user_data` text NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sessions`
-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `be_backups`
--

CREATE TABLE IF NOT EXISTS `be_backups` (
  `backup_id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(100) NOT NULL,
  `backup_date` datetime NOT NULL,
  PRIMARY KEY (`backup_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=


-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE IF NOT EXISTS `email_templates` (
  `email_template_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug_name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`email_template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `slug_id` int(11) NOT NULL,
  `slug_name` varchar(250) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pages`
-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `be_shortcuts`
--

CREATE TABLE IF NOT EXISTS `be_shortcuts` (
  `shortcut_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` text NOT NULL,
  `new_window` tinyint(4) NOT NULL,
  `display_order` int(11) NOT NULL,
  `added_date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`shortcut_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `be_shortcuts`
--

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `settings`
--


-- --------------------------------------------------------

--
-- Table structure for table `slug`
--

CREATE TABLE IF NOT EXISTS `slugs` (
  `slug_id` int(11) NOT NULL AUTO_INCREMENT,
  `slug_name` varchar(250) CHARACTER SET utf8 NOT NULL,
  `route` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`slug_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `slug`
--
-- --------------------------------------------------------

--
-- Table structure for table `layouts`
--

CREATE TABLE IF NOT EXISTS `layouts` (
  `layout_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`layout_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `layouts`
--

--
-- Constraints for dumped tables
--

--
-- Constraints for table `be_acl_permissions`
--
ALTER TABLE `be_acl_permissions`
  ADD CONSTRAINT `be_acl_permissions_ibfk_1` FOREIGN KEY (`aro_id`) REFERENCES `be_acl_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `be_acl_permissions_ibfk_2` FOREIGN KEY (`aco_id`) REFERENCES `be_acl_resources` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `be_acl_permission_actions`
--
ALTER TABLE `be_acl_permission_actions`
  ADD CONSTRAINT `be_acl_permission_actions_ibfk_1` FOREIGN KEY (`access_id`) REFERENCES `be_acl_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `be_acl_permission_actions_ibfk_2` FOREIGN KEY (`axo_id`) REFERENCES `be_acl_actions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `be_groups`
--
ALTER TABLE `be_groups`
  ADD CONSTRAINT `be_groups_ibfk_1` FOREIGN KEY (`id`) REFERENCES `be_acl_groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `be_resources`
--
ALTER TABLE `be_resources`
  ADD CONSTRAINT `be_resources_ibfk_1` FOREIGN KEY (`id`) REFERENCES `be_acl_resources` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `be_users`
--
ALTER TABLE `be_users`
  ADD CONSTRAINT `be_users_ibfk_1` FOREIGN KEY (`group`) REFERENCES `be_acl_groups` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `be_user_profiles`
--
ALTER TABLE `be_user_profiles`
  ADD CONSTRAINT `be_user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `be_users` (`id`) ON DELETE CASCADE;

SET FOREIGN_KEY_CHECKS=1;