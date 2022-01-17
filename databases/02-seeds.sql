-- target engine: mysql

INSERT INTO `user` (`userid`, `name`, `role`, `created_by`, `updated_by`, `created_at`, `updated_at`)
VALUES ('admin', 'Administrator', 'admin', 'seed', 'seed', NOW(), NOW());
