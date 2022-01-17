-- target engine: MYSQL

CREATE TABLE `user` (
  `userid` VARCHAR(8) NOT NULL,
  `name` VARCHAR(64) NOT NULL,
  `password` VARCHAR(128) NULL,
  `role` VARCHAR(200) NULL,
  `created_by` VARCHAR(8) NULL,
  `updated_by` VARCHAR(8) NULL,
  `deleted_by` VARCHAR(8) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MYISAM;

CREATE TABLE `apps` (
  `appsid` VARCHAR(8) NOT NULL,
  `name` VARCHAR(64) NOT NULL,
  `alias` VARCHAR(8) NULL,
  `description` VARCHAR(200) NULL,
  `url` VARCHAR(200) NOT NULL,
  `priority` SMALLINT NULL DEFAULT 0,
  `popularity` INTEGER NULL DEFAULT 0,
  `created_by` VARCHAR(8) NULL,
  `updated_by` VARCHAR(8) NULL,
  `deleted_by` VARCHAR(8) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`appsid`)
) ENGINE=MYISAM;

CREATE TABLE `apps_hit` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `appsid` VARCHAR(8) NOT NULL,
  `visitor_ip` VARCHAR(60) NOT NULL,
  `visitor_agent` VARCHAR(255) NOT NULL,
  `visited_at` DATETIME NOT NULL,
  `created_by` VARCHAR(8) NULL,
  `updated_by` VARCHAR(8) NULL,
  `deleted_by` VARCHAR(8) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL
) ENGINE=MYISAM;