INSERT INTO `co_manager` (`email`,`password`,`level`,`info`,`regDt`)
VALUES
('super@user.com', '[비밀번호]', 99, '{"name":"최고관리자"}', NOW() ),
('admin@user.com', '[비밀번호]', 10, '{"name":"관리자"}', NOW() )