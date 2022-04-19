SET NAMES utf8;

DROP TABLE IF EXISTS `co_admin_menu`;
CREATE TABLE IF NOT EXISTS `co_admin_menu` (
  `ano` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '부모번호',
  `sort` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '정렬순서',
  `icons` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '아이콘',
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '타입',
  `code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '코드',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '메뉴이름',
  `folder` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '폴더',
  `controller` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '컨트롤러',
  `class` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '클래스',
  `isView` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y' COMMENT '노출여부',
  `regDt` datetime DEFAULT NULL COMMENT '등록일',
  `editDt` datetime DEFAULT NULL COMMENT '수정일',
  `delDt` datetime DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`ano`),
  KEY `parent` (`parent`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `co_admin_menu` (`ano`, `parent`, `sort`, `icons`, `type`, `code`, `name`, `folder`, `controller`, `class`, `isView`, `regDt`, `editDt`, `delDt`) VALUES
	(1, 0, 1, 'fad fa-cogs', 'folder', 'config', '기본설정', 'Config', '', '', 'y', '2022-03-28 09:20:08', '2022-03-28 14:09:11', NULL),
	(2, 1, 2, 'fad fa-info', 'controller', 'base', '기본정보', 'Config', 'base', 'base', 'y', '2022-03-28 09:21:39', '2022-03-28 14:09:11', NULL),
	(3, 1, 3, 'fad fa-address-card', 'controller', 'about', '회사소개/이용약관', 'Config', 'base', 'about', 'y', '2022-03-28 09:25:05', '2022-03-28 14:09:11', NULL),
	(4, 1, 4, 'fad fa-code', 'controller', 'meta', '메타테그', 'Config', 'base', 'meta', 'y', '2022-03-28 10:46:27', '2022-03-28 14:09:12', NULL),
	(5, 1, 5, 'fad fa-window-restore', 'controller', 'popup', '팝업관리', 'config', 'popup', 'list', 'y', '2022-03-28 10:48:08', '2022-03-28 14:09:12', NULL),
	(6, 1, 6, '', 'controller', 'popup', '팝업등록/수정', 'config', 'popup', 'regist', 'n', '2022-03-28 10:49:18', '2022-03-28 14:09:12', NULL),
	(7, 1, 7, 'fad fa-flag', 'controller', 'banner', '베너관리', 'Config', 'banner', 'list', 'y', '2022-03-28 10:54:18', '2022-03-28 14:09:12', NULL),
	(8, 1, 8, '', 'controller', 'banner', '베너등록/수정', 'config', 'banner', 'regist', 'n', '2022-03-28 10:54:48', '2022-03-28 14:09:12', NULL),
	(9, 0, 9, 'fad fa-user', 'folder', 'member', '회원관리', 'member', '', '', 'y', '2022-03-28 10:56:08', '2022-03-28 14:09:12', NULL),
	(10, 9, 10, 'fad fa-users', 'controller', 'list', '회원목록', 'member', 'member', 'list', 'y', '2022-03-28 10:57:39', '2022-03-28 14:09:12', NULL),
	(11, 9, 11, 'fad fa-user-chart', 'controller', 'level', '등급관리', 'member', 'memLevel', 'list', 'y', '2022-03-28 11:24:18', '2022-03-28 14:09:12', NULL),
	(12, 9, 12, 'fad fa-user-edit', 'controller', 'regist', '회원등록', 'member', 'member', 'regist', 'y', '2022-03-28 11:25:15', '2022-03-28 14:09:12', NULL),
	(13, 9, 14, 'fad fa-user-tag', 'controller', 'config', '가입정보', 'member', 'member', 'config', 'y', '2022-03-28 11:26:41', '2022-03-28 14:09:12', NULL),
	(14, 0, 15, 'fad fa-clipboard-list', 'folder', 'board', '게시판관리', 'board', '', '', 'y', '2022-03-28 11:27:51', '2022-03-28 14:09:12', NULL),
	(15, 14, 16, 'fad fa-clipboard-prescription', 'controller', 'content', '게시글관리', 'board', 'content', 'list', 'y', '2022-03-28 11:30:09', '2022-03-28 14:09:12', NULL),
	(16, 14, 17, '', 'controller', 'content', '게시글보기', 'board', 'content', 'read', 'n', '2022-03-28 11:30:49', '2022-03-28 14:09:12', NULL),
	(17, 14, 19, '', 'controller', 'content', '게시글등록/수정', 'board', 'content', 'regist', 'n', '2022-03-28 11:31:31', '2022-03-28 14:09:13', NULL),
	(18, 14, 18, 'fad fa-list', 'controller', 'list', '게시판목록', 'board', 'board', 'list', 'y', '2022-03-28 11:32:47', '2022-03-28 14:09:12', NULL),
	(19, 14, 20, '', 'controller', 'list', '게시판등록/수정', 'board', 'board', 'regist', 'n', '2022-03-28 11:33:15', '2022-03-28 14:09:13', NULL),
	(20, 14, 21, 'fad fa-question', 'controller', 'qna', '1:1 문의', 'board', 'qna', 'list', 'y', '2022-03-28 11:34:59', '2022-03-28 14:09:13', NULL),
	(21, 14, 22, '', 'controller', 'qna', '1:1 보기', 'board', 'qna', 'read', 'n', '2022-03-28 11:35:37', '2022-03-28 14:09:13', NULL),
	(22, 14, 23, 'fad fa-bullhorn', 'controller', 'faq', 'FAQ', 'board', 'faq', 'list', 'y', '2022-03-28 11:37:57', '2022-03-28 14:09:13', NULL),
	(23, 14, 24, '', 'controller', 'faq', 'FAQ 등록/수정', 'board', 'faq', 'regist', 'n', '2022-03-28 11:38:24', '2022-03-28 14:09:13', NULL),
	(24, 9, 13, '', 'controller', 'lvregist', '등급등록/수정', 'member', 'memLevel', 'regist', 'n', '2022-03-28 14:09:03', '2022-03-28 14:09:12', NULL);
