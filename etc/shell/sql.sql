DROP TABLE IF EXISTS `co_adminMenu`;
CREATE TABLE IF NOT EXISTS `co_adminMenu` (
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
  `needLogin` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n' COMMENT '로그인필요여부',
  `isView` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y' COMMENT '노출여부',
  `regDt` datetime DEFAULT NULL COMMENT '등록일',
  `editDt` datetime DEFAULT NULL COMMENT '수정일',
  `delDt` datetime DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`ano`),
  KEY `parent` (`parent`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DELETE FROM `co_adminMenu`;
INSERT INTO `co_adminMenu` (`ano`, `parent`, `sort`, `icons`, `type`, `code`, `name`, `folder`, `controller`, `class`, `needLogin`, `isView`, `regDt`, `editDt`, `delDt`) VALUES
	(1, 0, 1, 'fad fa-cogs', 'folder', 'config', '기본설정', 'Config', '', '', 'n', 'y', '2022-03-28 09:20:08', '2022-09-06 14:15:17', NULL),
	(2, 1, 2, 'fad fa-info', 'controller', 'base', '기본정보', 'Config', 'base', 'base', 'n', 'y', '2022-03-28 09:21:39', '2022-09-06 14:15:17', NULL),
	(3, 1, 4, 'fad fa-address-card', 'controller', 'about', '회사소개/이용약관', 'Config', 'base', 'about', 'n', 'y', '2022-03-28 09:25:05', '2022-09-06 14:15:18', NULL),
	(4, 1, 5, 'fad fa-code', 'controller', 'meta', '메타테그', 'Config', 'base', 'meta', 'n', 'y', '2022-03-28 10:46:27', '2022-09-06 14:15:18', NULL),
	(5, 1, 6, 'fad fa-window-restore', 'controller', 'popup', '팝업관리', 'config', 'popup', 'list', 'n', 'y', '2022-03-28 10:48:08', '2022-09-06 14:15:19', NULL),
	(6, 1, 7, '', 'controller', 'popup', '팝업등록/수정', 'config', 'popup', 'regist', 'n', 'n', '2022-03-28 10:49:18', '2022-09-06 14:15:19', NULL),
	(7, 1, 8, 'fad fa-flag', 'controller', 'banner', '베너관리', 'Config', 'banner', 'list', 'n', 'y', '2022-03-28 10:54:18', '2022-09-06 14:15:19', NULL),
	(8, 1, 9, '', 'controller', 'banner', '베너등록/수정', 'config', 'banner', 'regist', 'n', 'n', '2022-03-28 10:54:48', '2022-09-06 14:15:19', NULL),
	(9, 0, 10, 'fad fa-user', 'folder', 'member', '회원관리', 'member', '', '', 'n', 'y', '2022-03-28 10:56:08', '2022-09-06 14:15:20', NULL),
	(10, 9, 11, 'fad fa-users', 'controller', 'list', '회원목록', 'member', 'member', 'list', 'n', 'y', '2022-03-28 10:57:39', '2022-09-06 14:15:20', NULL),
	(11, 9, 12, 'fad fa-user-chart', 'controller', 'level', '등급관리', 'member', 'memLevel', 'list', 'n', 'y', '2022-03-28 11:24:18', '2022-09-06 14:15:20', NULL),
	(12, 9, 13, 'fad fa-user-edit', 'controller', 'regist', '회원등록', 'member', 'member', 'regist', 'n', 'y', '2022-03-28 11:25:15', '2022-09-06 14:15:20', NULL),
	(13, 9, 15, 'fad fa-user-tag', 'controller', 'config', '가입정보', 'member', 'member', 'config', 'n', 'y', '2022-03-28 11:26:41', '2022-09-06 14:15:20', NULL),
	(14, 0, 17, 'fad fa-clipboard-list', 'folder', 'board', '게시판관리', 'board', '', '', 'n', 'y', '2022-03-28 11:27:51', '2022-09-06 14:15:20', NULL),
	(15, 14, 18, 'fad fa-clipboard-prescription', 'controller', 'content', '게시글관리', 'board', 'content', 'list', 'n', 'y', '2022-03-28 11:30:09', '2022-09-06 14:15:21', NULL),
	(16, 14, 19, '', 'controller', 'content', '게시글보기', 'board', 'content', 'read', 'n', 'n', '2022-03-28 11:30:49', '2022-09-06 14:15:21', NULL),
	(17, 14, 21, '', 'controller', 'content', '게시글등록/수정', 'board', 'content', 'regist', 'n', 'n', '2022-03-28 11:31:31', '2022-09-06 14:15:21', NULL),
	(18, 14, 20, 'fad fa-list', 'controller', 'list', '게시판목록', 'board', 'board', 'list', 'n', 'y', '2022-03-28 11:32:47', '2022-09-06 14:15:21', NULL),
	(19, 14, 22, '', 'controller', 'list', '게시판등록/수정', 'board', 'board', 'regist', 'n', 'n', '2022-03-28 11:33:15', '2022-09-06 14:15:22', NULL),
	(20, 14, 23, 'fad fa-question', 'controller', 'qna', '1:1 문의', 'board', 'qna', 'list', 'n', 'y', '2022-03-28 11:34:59', '2022-09-06 14:15:22', NULL),
	(21, 14, 24, '', 'controller', 'qna', '1:1 보기', 'board', 'qna', 'read', 'n', 'n', '2022-03-28 11:35:37', '2022-09-06 14:15:22', NULL),
	(22, 14, 25, 'fad fa-bullhorn', 'controller', 'faq', 'FAQ', 'board', 'faq', 'list', 'n', 'y', '2022-03-28 11:37:57', '2022-09-06 14:15:23', NULL),
	(23, 14, 26, '', 'controller', 'faq', 'FAQ 등록/수정', 'board', 'faq', 'regist', 'n', 'n', '2022-03-28 11:38:24', '2022-09-06 14:15:23', NULL),
	(24, 9, 14, '', 'controller', 'lvregist', '등급등록/수정', 'member', 'memLevel', 'regist', 'n', 'n', '2022-03-28 14:09:03', '2022-09-06 14:15:20', NULL),
	(25, 1, 3, 'fad fa-mobile', 'controller', 'app', '앱설정', 'config', 'AppConfig', 'config', 'n', 'n', '2022-08-16 13:02:30', '2022-09-06 14:15:18', NULL),
	(26, 9, 16, 'fas fa-comment', 'controller', 'social', '소셜로그인 설정', 'member', 'social', 'index', 'n', 'y', '2022-09-06 14:15:01', '2022-09-06 14:15:41', NULL);

DROP TABLE IF EXISTS `co_frontMenu`;
CREATE TABLE IF NOT EXISTS `co_frontMenu` (
  `ano` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '부모번호',
  `sort` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '정렬순서',
  `isView` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y' COMMENT '노출여부',
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '타입',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '메뉴이름',
  `link` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '연결페이지',
  `landPage` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '렌딩페이지',
  `folder` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '폴더',
  `controller` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '컨트롤러',
  `class` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '클래스',
  `needLogin` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n' COMMENT '로그인필요여부',
  `imgPath` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '이미지PATH',
  `regDt` datetime DEFAULT NULL COMMENT '등록일',
  `editDt` datetime DEFAULT NULL COMMENT '수정일',
  `delDt` datetime DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`ano`),
  KEY `parent` (`parent`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DELETE FROM `co_frontMenu`;

DROP TABLE IF EXISTS `co_manager`;
CREATE TABLE IF NOT EXISTS `co_manager` (
  `ano` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '아이디',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '비밀번호',
  `level` tinyint(3) NOT NULL DEFAULT 1 COMMENT '등급',
  `photo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '이미지' CHECK (json_valid(`photo`)),
  `info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '정보' CHECK (json_valid(`info`)),
  `auth` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '권한' CHECK (json_valid(`auth`)),
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '앱토큰',
  `regDt` datetime DEFAULT NULL COMMENT '등록일',
  `editDt` datetime DEFAULT NULL COMMENT '수정일',
  `delDt` datetime DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`ano`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DELETE FROM `co_manager`;
INSERT INTO `co_manager` (`ano`, `email`, `password`, `level`, `photo`, `info`, `auth`, `uuid`, `regDt`, `editDt`, `delDt`) VALUES
	(1, 'super@user.com', '$2y$12$PbffEqamvOECOZlsA03O0eNOh7pq74LxyACaFPyWlrBq6TF/Icv8i', 99, NULL, '{"name":"최고관리자"}', NULL, NULL, '2022-10-05 11:35:48', NULL, NULL),
	(2, 'admin@user.com', '$2y$12$YYVjhRWfni0h5OAaS5VsCe0QXIsLmL7JulI1BKYrmSgKv5HvIcQ0a', 10, NULL, '{"name":"관리자"}', NULL, NULL, '2022-10-05 11:35:48', NULL, NULL);

DROP TABLE IF EXISTS `co_memberLevel`;
CREATE TABLE IF NOT EXISTS `co_memberLevel` (
  `ano` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `level` int(11) unsigned NOT NULL COMMENT '등급',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '등급명',
  `info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '기본정보' CHECK (json_valid(`info`)),
  `regDt` datetime DEFAULT NULL COMMENT '등록일',
  `editDt` datetime DEFAULT NULL COMMENT '수정일',
  `delDt` datetime DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`ano`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DELETE FROM `co_memberLevel`;
INSERT INTO `co_memberLevel` (`ano`, `level`, `name`, `info`, `regDt`, `editDt`, `delDt`) VALUES
	(1, 1, '일반회원', NULL, '2022-11-10 17:23:37', '2022-11-10 17:23:37', NULL);

DROP TABLE IF EXISTS `co_config`;
CREATE TABLE IF NOT EXISTS `co_config` (
  `ano` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `regDt` datetime DEFAULT NULL COMMENT '등록일',
  `editDt` datetime DEFAULT NULL COMMENT '수정일',
  `delDt` datetime DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`ano`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DELETE FROM `co_config`;
INSERT INTO `co_config` (`ano`, `group`, `code`, `data`, `regDt`, `editDt`, `delDt`) VALUES
	(1, 'member', 'join', '{"app":"y","appLv":1,"id":"email","personal":{"name":"m","nick":"n","add":"n","tel":"n","phone":"m"},"biz":{"use":"n","compNm":"y","compNo":"y","ceoNm":"y","add":"y","service":"y","item":"y","tel":"y","file":"y"},"etc":{"use":"n","birthday":"y","gender":"y","fax":"y","marriage":"y","job":"y","interest":"y"}}', '2022-11-10 17:24:17', '2022-11-10 17:24:17', NULL),
	(2, 'infos', 'tos', '"제1장 총칙\\r\\n\\r\\n제1조(목적)\\r\\n본 약관은 {company} (이하 \\"당 사이트\\")가 제공하는 모든 서비스(이하 \\"서비스\\")의 이용조건 및 절차, 이용자와 당 사이트의 권리, 의무, 책임사항과 기타 필요한 사항을 규정함을 목적으로 합니다.\\r\\n\\r\\n제2조(용어의 정의)\\r\\n본 약관에서 사용하는 용어의 정의는 다음과 같습니다.\\r\\n\\r\\n① 이용자 : 본 약관에 따라 당 사이트가 제공하는 서비스를 이용할 수 있는 자.\\r\\n② 가 입 : 당 사이트가 제공하는 신청서 양식에 해당 정보를 기입하고, 본 약관에 동의하여 서비스 이용계약을 완료시키는 행위\\r\\n③ 회 원 : 당 사이트에 개인정보 등 관련 정보를 제공하여 회원등록을 한 개인(재외국민, 국내거주 외국인 포함)또는 법인으로서 당 사이트의 정보를 제공 받으며, 당 사이트가 제공하는 서비스를 이용할 수 있는 자.\\r\\n④ 아이디(ID) : 회원의 식별과 서비스 이용을 위하여 회원이 문자와 숫자의 조합으로 설정한 고유의 체계\\r\\n⑤ 비밀번호 : 이용자와 아이디가 일치하는지를 확인하고 통신상의 자신의 비밀보호를 위하여 이용자 자신이 선정한 문자와 숫자의 조합.\\r\\n⑥ 탈 퇴 : 회원이 이용계약을 종료 시키는 행위\\r\\n⑦ 본 약관에서 정의하지 않은 용어는 개별서비스에 대한 별도 약관 및 이용규정에서 정의하거나 일반적인 개념에 의합니다.\\r\\n\\r\\n제3조(약관의 효력과 변경)\\r\\n① 당 사이트는 귀하가 본 약관 내용에 동의하는 것을 조건으로 귀하에게 서비스를 제공할 것이며, 귀하가 본 약관의 내용에 동의하는 경우, 당 사이트의 서비스 제공 행위 및 귀하의 서비스 사용 행위에는 본 약관이 우선적으로 적용됩니다.\\r\\n② 당 사이트는 본 약관을 변경할 수 있으며, 변경된 약관은 당 사이트 내에 공지함으로써 이용자가 직접 확인하도록 할 것입니다. 약관을 변경할 경우에는 적용일자 및 변경사유를 명시하여 당 사이트 내에 그 적용일자 30일 전부터 공지합니다. 약관 변경 공지 후 이용자가 명시적으로 약관 변경에 대한 거부의사를 표시하지 아니하면, 이용자가 약관에 동의한 것으로 간주합니다. 이용자가 변경된 약관에 동의하지 아니하는 경우, 이용자는 본인의 회원등록을 취소(회원탈퇴)할 수 있습니다.\\r\\n\\r\\n제4조(약관외 준칙)\\r\\n① 본 약관은 당 사이트가 제공하는 서비스에 관한 이용규정 및 별도 약관과 함께 적용됩니다.\\r\\n② 본 약관에 명시되지 않은 사항은 정보통신망 이용촉진 및 정보보호 등에 관한 법률, 전기통신기본법, 전기통신사업법, 정보통신윤리위원회심의규정, 정보통신 윤리강령, 프로그램보호법 등 관계법령과 개인정보 처리방침 및 행정안전부가 별도로 정한 지침 등의 규정에 따릅니다.\\r\\n\\r\\n제5조(회원정보의 통합관리)\\r\\n당 사이트의 회원정보는 행정기관 내 타 사이트의 회원정보와 통합하여 관리될 수 있습니다.\\r\\n\\r\\n제2장 서비스 제공 및 이용\\r\\n\\r\\n제6조(이용 계약의 성립)\\r\\n① 이용계약은 신청자가 온라인으로 당 사이트에서 제공하는 소정의 가입신청 양식에서 요구하는 사항을 기록하고, 이 약관에 대한 동의를 완료한 경우에 성립됩니다.\\r\\n② 당 사이트는 다음 각 호에 해당하는 이용계약에 대하여는 가입을 취소할 수 있습니다.\\r\\n1. 다른 사람의 명의를 사용하여 신청하였을 때\\r\\n2. 이용 계약 신청서의 내용을 허위로 기재하였거나 신청하였을 때\\r\\n3. 사회의 안녕 질서 혹은 미풍양속을 저해할 목적으로 신청하였을 때\\r\\n4. 다른 사람의 당 사이트 서비스 이용을 방해하거나 그 정보를 도용하는 등의 행위를 하였을 때\\r\\n5. 당 사이트를 이용하여 법령과 본 약관이 금지하는 행위를 하는 경우\\r\\n6. 기타 당 사이트가 정한 이용신청요건이 미비 되었을 때\\r\\n③ 당 사이트는 다음 각 호에 해당하는 경우 그 사유가 해소될 때까지 이용계약 성립을 유보할 수 있습니다.\\r\\n1. 기술상의 장애사유로 인한 서비스 중단의 경우(시스템관리자의 고의·과실 없는 디스크장애, 시스템 다운 등)\\r\\n2. 전기통신사업법에 의한 기간통신사업자가 전기통신 서비스를 중지하는 경우\\r\\n3. 전시. 사변, 천재지변 또는 이에 준하는 국가 비상사태가 발생하거나 발생할 우려가 있는 경우\\r\\n4. 긴급한 시스템 점검, 증설 및 교체설비의 보수 등을 위하여 부득이한 경우\\r\\n5. 서비스 설비의 장애 또는 서비스 이용의 폭주 등 기타 서비스를 제공할 수 없는 사유가 발생한 경우\\r\\n④ 당 사이트가 제공하는 서비스는 아래와 같으며, 그 변경될 서비스의 내용을 이용자에게 공지하고 아래에서 정한 서비스를 변경하여 제공할 수 있습니다. 다만, 비회원에게는 서비스 중 일부만을 제공할 수 있습니다.\\r\\n1. 당 사이트가 자체 개발하거나 다른 기관과의 협의 등을 통해 제공하는 일체의 서비스\\r\\n\\r\\n\\r\\n제7조(회원정보 사용에 대한 동의)\\r\\n① 당 사이트가 처리하는 모든 개인정보는 개인정보 보호법 등 관련 법령상의 개인정보보호 규정을 준수하여 이용자의 개인정보 보호 및 권익을 보호합니다.\\r\\n② 당 사이트는 다른 법령에 특별한 규정이 있는 경우를 제외하고 귀하가 당 사이트 서비스 가입시 동의하여 제공하는 정보에 한하여 최소한으로 수집합니다.\\r\\n③ 당 사이트와 행정기관 타 사이트간의 회원정보 통합관리와 관련하여 본인이 동의한 경우에는 개인정보 등 관련정보를 행정기관 타 사이트에 제공할 수 있습니다.\\r\\n④ 회원이 당 사이트에 본 약관에 따라 이용신청을 하는 것은 당 사이트가 본 약관에 따라 신청서에 기재된 회원정보를 수집, 이용하는 것에 동의하는 것으로 간주됩니다.\\r\\n⑤ 당 사이트는 회원정보의 진위여부 및 소속기관의 확인 등을 위하여 확인절차를 거칠 수도 있습니다.\\r\\n\\r\\n제8조(사용자의 정보 보안)\\r\\n① 가입 신청자가 당 사이트 서비스 가입 절차를 완료하는 순간부터 귀하는 입력한 정보의 비밀을 유지할 책임이 있으며, 회원의 ID와 비밀번호를 사용하여 발생하는 모든 결과에 대한 책임은 회원본인에게 있습니다.\\r\\n② ID와 비밀번호에 관한 모든 관리의 책임은 회원에게 있으며, 회원의 ID나 비밀번호가 부정하게 사용되었다는 사실을 발견한 경우에는 즉시 당 사이트에 신고하여야 합니다. 신고를 하지 않음으로 인한 모든 책임은 회원 본인에게 있습니다.\\r\\n③ 이용자는 당 사이트 서비스의 사용 종료시 마다 정확히 접속을 종료하도록 해야 하며, 정확히 종료하지 아니함으로써 제3자가 귀하에 관한 정보를 이용하게 되는 등의 결과로 인해 발생하는 손해 및 손실에 대하여 당 사이트는 책임을 부담하지 아니합니다.\\r\\n④ 비밀번호 분실 시 통보는 이메일 또는 단문 메시지 서비스(SMS)로 안내하며, 전 항의 규정에도 불구하고 회원의 이메일 주소 또는 휴대전화번호 기입 잘못 등 본인 과실 및 본인 정보 관리 소홀로 발생하는 문제의 책임은 회원에게 있습니다.\\r\\n⑤ 이용자는 개인정보 보호 및 관리를 위하여 서비스의 개인정보관리에서 수시로 개인정보를 수정\\/삭제할 수 있습니다.\\r\\n\\r\\n제9조(서비스 이용시간)\\r\\n① 서비스 이용시간은 당 사이트의 업무상 또는 기술상 특별한 지장이 없는 한 연중무휴, 1일 24시간을 원칙으로 합니다.\\r\\n② 제1항의 이용시간은 정기점검 등의 필요로 인하여 당 사이트가 정한 날 또는 시간은 예외로 합니다.\\r\\n\\r\\n제10조(서비스의 중지 및 정보의 저장과 사용)\\r\\n① 귀하는 당 사이트 서비스에 보관되거나 전송된 메시지 및 기타 통신 메시지 등의 내용이 국가의 비상사태, 정전, 당 사이트의 관리 범위 외의 서비스 설비 장애 및 기타 불가항력에 의하여 보관되지 못하였거나 삭제된 경우, 전송되지 못한 경우 및 기타 통신 데이터의 손실이 있을 경우에 당 사이트는 관련 책임을 부담하지 아니합니다.\\r\\n② 당 사이트가 정상적인 서비스 제공의 어려움으로 인하여 일시적으로 서비스를 중지하여야 할 경우에는 서비스 중지 1주일 전의 고지 후 서비스를 중지할 수 있으며, 이 기간 동안 귀하가 고지내용을 인지하지 못한 데 대하여 당 사이트는 책임을 부담하지 아니합니다. 부득이한 사정이 있을 경우 위 사전 고지기간은 감축되거나 생략될 수 있습니다. 또한 위 서비스 중지에 의하여 본 서비스에 보관되거나 전송된 메시지 및 기타 통신 메시지 등의 내용이 보관되지 못하였거나 삭제된 경우, 전송되지 못한 경우 및 기타 통신 데이터의 손실이 있을 경우에 대하여도 당 사이트는 책임을 부담하지 아니합니다.\\r\\n③ 당 사이트의 사정으로 서비스를 영구적으로 중단하여야 할 경우 제 2 항에 의거합니다. 다만, 이 경우 사전 고지기간은 1개월로 합니다.\\r\\n④ 당 사이트는 사전 고지 후 서비스를 일시적으로 수정, 변경 및 중단할 수 있으며, 이에 대하여 귀하 또는 제3자에게 어떠한 책임도 부담하지 아니합니다.\\r\\n⑤ 당 사이트는 이용자가 본 약관의 내용에 위배되는 행동을 한 경우, 임의로 서비스 사용을 제한 및 중지할 수 있습니다. 이 경우 당 사이트는 위 이용자의 접속을 금지할 수 있습니다.\\r\\n⑥ 당 사이트에 장기간 접속을 하지 아니한 회원의 경우 이메일 또는 공지사항 등을 통한 안내 후 검토 기간을 거쳐 서비스 이용을 중지할 수 있습니다.\\r\\n\\r\\n제11조(서비스의 변경 및 해지)\\r\\n① 당 사이트는 귀하가 서비스를 이용하여 기대하는 손익이나 서비스를 통하여 얻은 자료로 인한 손해에 관하여 책임을 지지 않으며, 회원이 본 서비스에 게재한 정보, 자료, 사실의 신뢰도, 정확성 등 내용에 관하여는 책임을 지지 않습니다.\\r\\n② 당 사이트는 서비스 이용과 관련하여 가입자에게 발생한 손해 중 가입자의 고의, 과실에 의한 손해에 대하여 책임을 부담하지 아니합니다.\\r\\n③ 당 사이트에 2년을 주기로 개인정보의 수집·이용에 대한 동의를 하지 아니한 회원의 경우 안내 메일 또는 공지사항 발표 후 검토 기간을 거쳐 회원의 정보를 삭제할 수 있습니다.\\r\\n\\r\\n제12조(정보 제공 및 홍보물 게재)\\r\\n① 당 사이트는 회원이 서비스 이용 중 필요하다고 인정되는 다양한 정보 및 광고에 대해서는 이메일, SMS, 메신저 등의 방법으로 회원에게 제공할 수 있으며, 해당 정보를 원하지 않는 회원은 이를 수신거부 할 수 있습니다.\\r\\n② 당 사이트는 서비스에 적절하다고 판단되거나 활용 가능성 있는 홍보물을 게재할 수 있습니다.\\r\\n\\r\\n제13조(당 사이트에 제출된 게시물의 저작권)\\r\\n① 귀하가 게시한 게시물의 내용에 대한 권리는 귀하에게 있습니다.\\r\\n② 당 사이트는 게시된 내용을 사전 통지 없이 편집, 이동 할 수 있는 권리를 보유하며, 다음의 경우 사전 통지 없이 삭제할 수 있습니다.\\r\\n1. 본 서비스 약관에 위배되거나 상용 또는 불법, 음란, 저속하다고 판단되는 게시물을 게시한 경우\\r\\n2. 다른 회원 또는 제 3자를 비방하거나 중상 모략으로 명예를 손상시키는 내용인 경우\\r\\n3. 공공질서 및 미풍양속에 위반되는 내용인 경우\\r\\n4. 범죄적 행위에 결부된다고 인정되는 내용일 경우\\r\\n5. 제3자의 저작권 등 기타 권리를 침해하는 내용인 경우\\r\\n6. 기타 관계 법령에 위배되는 경우\\r\\n③ 귀하의 게시물이 타인의 저작권을 침해함으로써 발생하는 민, 형사상의 책임은 전적으로 귀하가 부담하여야 합니다.\\r\\n\\r\\n제14조(사용자의 행동규범 및 서비스 이용제한)\\r\\n① 귀하가 제공하는 정보의 내용이 허위인 것으로 판명되거나, 그러하다고 의심할 만한 합리적인 사유가 발생할 경우 당 사이트는 귀하의 본 서비스 사용을 일부 또는 전부 중지할 수 있으며, 이로 인해 발생하는 불이익에 대해 책임을 부담하지 아니합니다.\\r\\n② 귀하가 당 사이트 서비스를 통하여 게시, 전송, 입수하였거나 전자메일 기타 다른 수단에 의하여 게시, 전송 또는 입수한 모든 형태의 정보에 대하여는 귀하가 모든 책임을 부담하며 당 사이트는 어떠한 책임도 부담하지 아니합니다.\\r\\n③ 당 사이트는 당 사이트가 제공한 서비스가 아닌 가입자 또는 기타 유관기관이 제공하는 서비스의 내용상의 정확성, 완전성 및 질에 대하여 보장하지 않습니다. 따라서 당 사이트는 귀하가 위 내용을 이용함으로 인하여 입게 된 모든 종류의 손실이나 손해에 대하여 책임을 부담하지 아니합니다.\\r\\n④ 귀하는 본 서비스를 통하여 다음과 같은 행동을 하지 않는데 동의합니다.\\r\\n1. 타인의 아이디(ID)와 비밀번호를 도용하는 행위\\r\\n2. 저속, 음란, 모욕적, 위협적이거나 타인의 프라이버시를 침해할 수 있는 내용을 전송, 게시, 게재, 전자메일 또는 기타의 방법으로 전송하는 행위\\r\\n3. 서비스를 통하여 전송된 내용의 출처를 위장하는 행위\\r\\n4. 법률, 계약에 의하여 이용할 수 없는 내용을 게시, 게재, 전자메일 또는 기타의 방법으로 전송하는 행위\\r\\n5. 타인의 특허, 상표, 영업비밀, 저작권, 기타 지적재산권을 침해하는 내용을 게시, 게재, 전자메일 또는 기타의 방법으로 전송하는 행위\\r\\n6. 당 사이트의 승인을 받지 아니한 광고, 판촉물, 정크메일, 스팸, 행운의 편지, 피라미드 조직 기타 다른 형태의 권유를 게시, 게재, 전자메일 또는 기타의 방법으로 전송하는 행위.\\r\\n7. 다른 사용자의 개인정보를 수집 또는 저장하는 행위\\r\\n8. 컴퓨터 소프트웨어, 하드웨어, 전기통신 장비를 파괴, 방해 또는 기능을 제한하기 위한 소프트웨어 바이러스를 게시, 게재 또는 전자우편으로 보내는 행위\\r\\n9. 서비스의 안정적인 운영에 지장을 주거나 줄 우려가 있는 일체의 행위\\r\\n⑤ 당 사이트는 회원이 본 약관을 위배했다고 판단되면 서비스와 관련된 모든 정보를 이용자의 동의 없이 삭제할 수 있습니다.\\r\\n\\r\\n제3장 의무 및 책임\\r\\n\\r\\n제15조(당 사이트의 의무)\\r\\n① 당 사이트는 법령과 본 약관이 금지하거나 미풍양속에 반하는 행위를 하지 않으며, 지속적, 안정적으로 서비스를 제공하기 위해 노력할 의무가 있습니다.\\r\\n② 당 사이트는 서비스 제공과 관련하여 취득한 회원의 정보를 본인의 승낙 없이 타인에게 누설 또는 배포할 수 없으며, 상업적 목적으로 사용할 수 없습니다. 다만, 전기통신관련법령 등 관계법령에 의하여 관계 국가기관 등의 요구가 있는 경우에는 그러하지 아니합니다.\\r\\n③ 당 사이트는 이용자가 안전하게 당 사이트서비스를 이용할 수 있도록 이용자의 개인정보 (신용정보 포함) 보호를 위한 보안시스템을 갖추어야 합니다.\\r\\n④ 당 사이트는 이용자의 귀책사유로 인한 서비스 이용 장애에 대하여 책임을 지지 않습니다.\\r\\n⑤ 당 사이트는 서비스와 관련한 이용자의 불만사항이 접수되는 경우 이를 즉시 처리하여야 하며, 즉시 처리가 곤란한 경우 이용자에게 그 사유와 처리일정을 당 사이트, 전화, 이메일, 팩스 등으로 통보하여야 합니다.\\r\\n\\r\\n제16조(회원의 의무)\\r\\n① 회원 가입시에 요구되는 정보는 정확하게 기입하여야 합니다. 또한 이미 제공된 귀하에 대한 정보가 정확한 정보가 되도록 유지, 갱신하여야 하며, 회원은 자신의 ID 및 비밀번호를 제3자에게 이용하게 해서는 안됩니다.\\r\\n② 회원은 당 사이트의 사전 승낙 없이 서비스를 이용하여 어떠한 영리행위도 할 수 없습니다.\\r\\n③ 회원은 당 사이트 서비스를 이용하여 얻은 정보를 당 사이트의 사전승낙 없이 복사, 복제, 변경, 번역, 출판·방송 기타의 방법으로 사용하거나 이를 타인에게 제공할 수 없습니다.\\r\\n④ 회원은 당 사이트 서비스 이용과 관련하여 다음 각 호의 행위를 하여서는 안됩니다.\\r\\n1. 다른 회원의 ID를 부정 사용하는 행위\\r\\n2. 범죄행위를 목적으로 하거나 기타 범죄행위와 관련된 행위\\r\\n3. 선량한 풍속, 기타 사회질서를 해하는 행위\\r\\n4. 타인의 명예를 훼손하거나 모욕하는 행위\\r\\n5. 타인의 지적재산권 등의 권리를 침해하는 행위\\r\\n6. 해킹행위 또는 컴퓨터바이러스의 유포행위\\r\\n7. 타인의 의사에 반하여 광고성 정보 등 일정한 내용을 지속적으로 전송하는 행위\\r\\n8. 서비스의 안전적인 운영에 지장을 주거나 줄 우려가 있는 일체의 행위\\r\\n9. 당 사이트에 게시된 정보의 변경\\r\\n\\r\\n제4장 기 타\\r\\n\\r\\n제17조 (당 사이트의 소유권)\\r\\n① 당 사이트가 제공하는 서비스, 그에 필요한 소프트웨어, 이미지, 마크, 로고, 디자인, 서비스명칭, 정보 및 상표 등과 관련된 지적재산권 및 기타 권리는 해당 저작권자 또는 제주영상·문화산업진흥원에 귀속됩니다.\\r\\n② 귀하는 당 사이트가 명시적으로 승인한 경우를 제외하고는 전항의 소정의 각 재산에 대한 전부 또는 일부의 수정, 대여, 대출, 판매, 배포, 제작, 양도, 재라이센스, 담보권 설정 행위, 상업적 이용 행위를 할 수 없으며, 제3자로 하여금 이와 같은 행위를 하도록 허락할 수 없습니다.\\r\\n\\r\\n제18조 (양도금지)\\r\\n회원이 서비스의 이용권한, 기타 이용계약 상 지위를 타인에게 양도, 증여할 수 없으며, 이를 담보로 제공할 수 없습니다.\\r\\n\\r\\n제19조 (손해배상)\\r\\n당 사이트는 무료로 제공되는 서비스와 관련하여 회원에게 어떠한 손해가 발생하더라도 당 사이트가 고의로 행한 범죄행위를 제외하고 이에 대하여 책임을 부담하지 아니합니다.\\r\\n\\r\\n제20조 (면책조항)\\r\\n① 당 사이트는 제10조에 따라 서비스가 중지됨으로써 이용자에게 손해가 발생하더라도 이로 인한 책임을 부담하지 않습니다.\\r\\n② 당 사이트는 서비스에 표출된 어떠한 의견이나 정보에 대해 확신이나 대표할 의무가 없으며 회원이나 제3자에 의해 표출된 의견을 승인하거나 반대하거나 수정하지 않습니다. 당 사이트는 어떠한 경우라도 회원이 서비스에 담긴 정보에 의존해 얻은 이득이나 입은 손해에 대해 책임이 없습니다.\\r\\n③ 당 사이트는 회원간 또는 회원과 제3자간에 서비스를 매개로 하여 물품거래 혹은 금전적 거래 등과 관련하여 어떠한 책임도 부담하지 아니하고, 회원이 서비스의 이용과 관련하여 기대하는 이익에 관하여 책임을 부담하지 않습니다.\\r\\n\\r\\n제21조 (관할법원)\\r\\n본 사이트와 이용자 간에 발생한 서비스 이용에 관한 분쟁에 대하여는 대한민국 법을 적용하며, 본 분쟁으로 인한 소는 행정안전부 주소지의 관할 법원에 제기합니다.\\r\\n\\r\\n부칙\\r\\n본 약관은 행정안전부의 약관을 준용했으며 2019년 10월 30일부터 시행됩니다."', '2022-11-10 17:25:19', '2022-11-11 08:48:09', NULL),
	(3, 'infos', 'privacy', '"\\"{company}\\"(이하 당 사이트)는 정보주체의 동의, 「전자정부법」 및 「개인정보 보호법」 등 관련 법령상의 개인정보 보호 규정을 준수하여 이용자의 개인정보 보호 및 권익을 보호하고 개인정보와 관련한 이용자의 고충을 원활하게 처리할 수 있도록 다음과 같은 처리방침을 두고 있습니다.\\r\\n\\r\\n제1조(개인정보의 처리 목적)\\r\\n당 사이트는 다음 각 호에서 열거한 목적을 위하여 최소한으로 개인정보를 처리하고 있습니다. 처리한 개인정보는 다음의 목적 이외의 용도로는 이용되지 않으며, 이용 목적이 변경되는 경우에는 「개인정보 보호법」 제18조에 따라 별도의 동의를 받는 등 필요한 조치를 이행하고 있습니다.\\r\\n\\r\\n1. 회원가입 및 관리\\r\\n회원가입, 회원제 서비스 이용 및 제한적 본인 확인절차에 따른 본인확인, 개인식별, 부정이용방지, 비인가 사용방지, 가입 의사 확인, 만 14세 미만 아동 개인정보 수집 시 법정대리인 동의여부 확인, 추후 법정대리인 본인확인, 분쟁 조정을 위한 기록보존, 불만처리 등 민원처리, 고지사항 전달 등\\r\\n\\r\\n5. 공공서비스 목록 열람 신청 정보의 처리\\r\\n「전자정부법」 제12조의4에 따른 공공서비스 목록의 안내 및 제공 또는 일부 신청에 대한 본인확인, 개인 식별, 부정 이용 또는 비인가 사용방지, 분쟁 조정을 위한 기록보존, 불만처리 등 민원처리, 고지사항 전달 등\\r\\n6. 타 행정기관 시스템 연계정보의 처리\\r\\n다른 행정기관 등이 보유한 자료를 활용하여 민원인이 청구한 공공서비스 목록 열람ㆍ신청 사무, 행정서비스 및 민원사무 등의 전자적 처리\\r\\n7. {company} 서비스 향상 및 정책평가\\r\\n신규 서비스 및 원스톱ㆍ맞춤형ㆍ선제적 서비스 개발, 인구통계학적 특성에 따른 서비스 분석 및 서비스의 유효성 및 이용 통계 확인 등\\r\\n\\r\\n제2조(개인정보의 처리 및 보유기간)\\r\\n당 사이트에서 처리하는 개인정보는 수집·이용 목적으로 명시한 범위 내에서 처리하며, 개인정보보호법 및 관련 법령에서 정하는 보유기간을 준용하여 이행하고 있습니다.\\r\\n\\r\\n1. {company} 회원정보\\r\\n- 수집근거 : 정보주체의 동의, 전자정부법 시행령 제90조\\r\\n- 보유기간 : 탈퇴 후 5일까지\\r\\n\\r\\n제3조(개인정보의 제3자 제공)\\r\\n당사이트는 원칙적으로 정보주체의 개인정보를 수집·이용 목적으로 명시한 범위 내에서 처리하며, 다음의 경우를 제외하고는 정보주체의 사전 동의 없이는 본래의 목적 범위를 초과하여 처리하거나 제3자에게 제공하지 않습니다. 다만, 제5호부터 제9호까지는 공공기관의 경우로 한정합니다.\\r\\n\\r\\n1. 정보주체로부터 별도의 동의를 받는 경우\\r\\n2. 다른 법률에 특별한 규정이 있는 경우\\r\\n3. 정보주체 또는 그 법정대리인이 의사표시를 할 수 없는 상태에 있거나 주소불명 등으로 사전 동의를 받을 수 없는 경우로서 명백히 정보주체 또는 제3자의 급박한 생명, 신체, 재산의 이익을 위하여 필요하다고 인정되는 경우\\r\\n4. 통계작성 및 학술연구 등의 목적을 위하여 필요한 경우로서 특정 개인을 알아볼 수 없는 형태로 개인정보를 제공하는 경우\\r\\n5. 개인정보를 목적 외의 용도로 이용하거나 이를 제3자에게 제공하지 아니하면 다른 법률에서 정하는 소관 업무를 수행할 수 없는 경우로서 보호위원회의 심의·의결을 거친 경우\\r\\n6. 조약, 그 밖의 국제협정의 이행을 위하여 외국정부 또는 국제기구에 제공하기 위하여 필요한 경우\\r\\n7. 범죄의 수사와 공소의 제기 및 유지를 위하여 필요한 경우\\r\\n8. 법원의 재판업무 수행을 위하여 필요한 경우\\r\\n9. 형 및 감호, 보호처분의 집행을 위하여 필요한 경우\\r\\n\\r\\n\\r\\n제4조(개인정보 처리 위탁)\\r\\n1. 당 사이트는 원활한 개인정보 업무처리 서비스를 위해 다음과 같이 개인정보 처리업무를 위탁 운영하고 있습니다.\\r\\n가. 위탁받는 자(수탁자) : 쉐어잇\\r\\n- 위탁하는 업무의 내용 : 시스템 개발 및 유지보수 수행\\r\\n- 위탁기간 : 1년\\r\\n- 연락처 : 064-900-3658\\r\\n- 근무시간 : 09:00 ~ 18:00\\r\\n2. 위탁계약 체결시 개인정보 보호법 제26조에 따라 위탁업무 수행목적 외 개인정보 처리금지, 기술적ㆍ관리적 보호조치, 재위탁 제한, 수탁자에 대한 관리ㆍ감독, 손해배상 등 책임에 관한 사항을 계약서 등 문서에 명시하고, 수탁자가 개인정보를 안전하게 처리하는지를 감독하고 있습니다.\\r\\n3. 위탁업무의 내용이나 수탁자가 변경될 경우에는 본 개인정보 처리방침을 통하여 공개하고 있습니다.\\r\\n\\r\\n제5조(정보주체와 법정대리인의 권리·의무 및 그 행사방법에 관한 사항)\\r\\n1. 정보주체(만 14세 미만인 경우에는 법정대리인을 말함)는 다음 각 호의 개인정보보호 관련 권리를 행사할 수 있습니다.\\r\\n가. 개인정보 열람요구\\r\\n나. 오류 등이 있을 경우 정정 요구\\r\\n다. 삭제 요구\\r\\n라. 처리정지 요구\\r\\n2. 제1항에 따른 권리 행사는 당사이트에 대해 「개인정보 보호법 시행규칙」 별지 제8호 서식에 따라 작성 후 서면, 전자우편, 모사전송(FAX) 등을 통하여 하실 수 있으며, \\"{company}\\"는 이에 대해 지체 없이 조치하겠습니다.\\r\\n3. 정보주체가 개인정보의 오류 등에 대한 정정 또는 삭제를 요구한 경우에는 정정 또는 삭제를 완료할 때까지 해당 개인정보를 이용하거나 제공하지 않습니다.\\r\\n4. 제1항에 따른 권리 행사는 정보주체의 법정대리인이나 위임을 받은 자 등 대리인을 통하여 하실 수 있습니다. 이 경우 개인정보 보호법 시행규칙 별지 제11호 서식에 따른 위임장을 제출하셔야 합니다.\\r\\n5. 개인정보 열람 및 처리정지 요구는 「개인정보 보호법」 제35조 제4항, 제37조 제2항에 의하여 정보주체의 권리가 제한될 수 있습니다.\\r\\n6. 개인정보의 정정 및 삭제 요구는 다른 법령에서 그 개인정보가 수집 대상으로 명시되어 있는 경우에는 그 삭제를 요구할 수 없습니다.\\r\\n7. 정보주체 권리에 따른 열람의 요구·정정·삭제의 요구·처리정지의 요구 시 열람 등 요구를 한 자가 본인이거나 정당한 대리인인지를 확인합니다.\\r\\n\\r\\n제6조(처리하는 개인정보 항목)\\r\\n당 사이트가 처리하는 개인정보 항목은 다음 각 호와 같습니다.\\r\\n\\r\\n{company} 회원정보\\r\\n① 회원정보\\r\\n- 필수항목 : 아이디, 비밀번호, 성명(법인명), 주민등록번호(외국인등록번호, 법인등록번호·사업자등록번호(법인인 경우)), 주소, 이메일 주소\\r\\n- 선택항목 : 휴대전화번호\\r\\n·민원처리 SMS 수신동의 시 : 휴대전화번호\\r\\n·생체인증 서비스 이용 시 : 휴대전화번호, 휴대폰 운영체제 정보, 통신사, 제조사 정보, 비밀번호\\r\\n·민원 알림수신 선택 시 : 이메일 또는 SMS 수신동의여부\\r\\n·선택입력 등록시 : 연령, 성별, 관심지역\\r\\n② 비회원정보\\r\\n- 필수항목 : 성명(법인명), 주민등록번호(외국인등록번호, 법인등록번호·사업자등록번호(법인인 경우))\\r\\n- 선택항목 : 주소, 상세주소, 연락처, 휴대전화번호\\r\\n\\r\\n\\r\\n제7조(개인정보의 파기 절차 및 방법)\\r\\n당 사이트는 원칙적으로 개인정보 보존기간이 경과하거나, 처리목적이 달성된 경우에는 지체 없이 해당 개인정보를 파기합니다. 다만, 다른 법령에 따라 보존하여야 하는 경우에는 그러하지 않을 수 있습니다. 파기 절차, 기한 및 방법은 다음과 같습니다.\\r\\n\\r\\n1. 파기절차\\r\\n이용자가 입력한 정보는 회원탈퇴 등 목적 달성 후 내부방침 및 기타 관련 법령에 따라 일정기간 저장된 후 파기됩니다. 이 때, DB로 옮겨진 개인정보는 법률에 의한 경우가 아닌 다른 목적으로 이용되지 않습니다.\\r\\n가. 개인정보의 파기\\r\\n보유기간이 경과한 개인정보는 종료일로부터 지체 없이 파기합니다.\\r\\n나. 개인정보파일의 파기\\r\\n개인정보파일의 처리 목적 달성, 해당 서비스의 폐지, 사업의 종료 등 그 개인정보파일이 불필요하게 되었을 때에는 개인정보의 처리가 불필요한 것으로 인정되는 날로부터 지체 없이 그 개인정보파일을 파기합니다.\\r\\n2. 파기방법\\r\\n해당 개인정보는 전자적인 방법으로 복구 또는 재생이 불가능하도록 영구적으로 파기합니다.\\r\\n\\r\\n제8조(개인정보 자동 수집 장치의 설치ㆍ운영 및 거부에 관한 사항)\\r\\n1. 당 사이트는 이용자에게 개인형 서비스를 제공하기 위해 이용정보를 저장하고 수시로 불러오는 \'쿠키(cookie)\'를 사용합니다.\\r\\n2. 쿠키는 웹사이트를 운영하는데 이용되는 서버(http)가 이용자의 컴퓨터 브라우저에게 보내는 소량의 정보이며 이용자들의 PC 컴퓨터내의 하드디스크에 저장되기도 합니다.\\r\\n가. 쿠키의 사용 목적 : 이용자가 방문한 각 서비스와 웹 사이트들에 대한 방문 및 이용형태, 내가 찾은 검색어, 초기화면 설정 등을 파악하여 이용자에게 최적화된 정보 제공을 위해 사용됩니다.\\r\\n나. 쿠키의 설치ㆍ운영 및 거부 : 웹브라우저 상단의 도구 > 인터넷 옵션 > 개인정보 메뉴의 옵션 설정을 통해 쿠키 저장을 거부할 수 있습니다.\\r\\n다. 쿠키 저장을 거부할 경우 개인형 서비스 이용에 어려움이 발생할 수 있습니다.\\r\\n\\r\\n\\r\\n제9조(개인정보의 안전성 확보 조치)\\r\\n개인정보의 안전성 확보를 위해 다음과 같은 조치를 취하고 있습니다.\\r\\n\\r\\n1. 개인정보 취급직원의 최소화 및 교육\\r\\n개인정보를 취급하는 직원은 반드시 필요한 인원에 한하여 지정·관리하고 있으며 취급직원을 대상으로 안전한 관리를 위한 교육을 실시하고 있습니다.\\r\\n2. 개인정보에 대한 접근 제한\\r\\n개인정보를 처리하는 개인정보처리시스템에 대한 접근권한의 부여·변경·말소를 통하여 개인정보에 대한 접근통제를 위한 필요한 조치를 하고 있으며 침입차단시스템을 이용하여 외부로부터의 무단 접근을 통제하고 있습니다.\\r\\n3. 접속기록의 보관\\r\\n개인정보처리시스템에 접속한 기록을 최소 6개월 이상 보관·관리하고 있습니다.\\r\\n4. 개인정보의 암호화\\r\\n개인정보는 암호화 등을 통해 안전하게 저장 및 관리되고 있습니다. 또한, 중요한 데이터는 저장 및 전송 시 암호화하여 사용하는 등의 별도 보안기능을 사용하고 있습니다.\\r\\n5. 보안프로그램 설치 및 주기적 점검·갱신\\r\\n해킹이나 컴퓨터 바이러스 등에 의한 개인정보 유출 및 훼손을 막기 위하여 보안프로그램을 설치하고 주기적으로 갱신·점검하고 있습니다.\\r\\n6. 비인가자에 대한 출입 통제\\r\\n개인정보를 보관하고 있는 개인정보처리시스템의 물리적 보관 장소를 별도로 두고 이에 대해 출입통제 절차를 수립·운영하고 있습니다.\\r\\n\\r\\n제10조(권익침해 구제방법)\\r\\n개인정보 주체는 개인정보침해로 인한 피해를 구제 받기 위하여 다음과 같이 개인정보 분쟁조정위원회, 한국인터넷진흥원 개인정보 침해-신고센터 등에 분쟁해결이나 상담 등을 신청할 수 있습니다.\\r\\n\\r\\n- 개인정보 분쟁조정위원회 : 1833-6972 (www.kopico.go.kr)\\r\\n- 개인정보 침해신고센터 : (국번없이) 118 (privacy.kisa.or.kr)\\r\\n- 대검찰청 사이버수사과 : (국번없이) 1301, cid@spo.go.kr (www.spo.go.kr)\\r\\n- 경찰청 사이버안전국 : (국번없이) 182 (cyberbureau.police.go.kr)\\r\\n\\r\\n또한, 개인정보의 열람, 정정·삭제, 처리정지 등에 대한 정보주체자의 요구에 대하여 공공기관의 장이 행한 처분 또는 부작위로 인하여 권리 또는 이익을 침해 받은 자는 행정심판법이 정하는 바에 따라 행정심판을 청구할 수 있습니다.\\r\\n- 중앙행정심판위원회(www.simpan.go.kr)의 전화번호 안내 참조\\r\\n\\r\\n제11조(개인정보 분야별 책임관 및 담당자 연락처)\\r\\n\\r\\n1. 개인정보 보호책임관 : {company} 000\\r\\n2. 개인정보보호 분야별 책임관 : {company}운영팀장 OOO (064-OOO-OOO)\\r\\n3. 개인정보취급자\\r\\n-담당자 : {private_name} {private_position}\\r\\n-연락처 : {private_tel} 전자메일 : {private_email}\\r\\n\\r\\n제12조(개인정보 열람청구)\\r\\n정보주체는 개인정보 보호법 제35조에 따른 개인정보의 열람청구를 아래의 부서에 할 수 있습니다. {company}운영팀은 정보주체의 열람청구가 신속하게 처리되도록 노력하겠습니다.\\r\\n-부서명 : {company} 운영팀\\r\\n-담당자 : {private_name} {private_position}\\r\\n-연락처 :{private_tel} 전자메일 : {private_email}\\r\\n\\r\\n제13조(개인정보처리방침 변경)\\r\\n이 개인정보 처리방침은 2019. 10. 30. 부터 적용됩니다. 이전의 개인정보 처리방침은 아래에서 확인하실 수 있습니다."', '2022-11-10 17:26:04', '2022-11-11 08:48:29', NULL),
	(4, 'infos', 'email', '"<center>\\r\\n<img alt=\\"이메일 아이콘\\" src=\\"\\/images\\/e-mail_c.png\\">\\r\\n<p class=\\"embtt1\\">전자우편주소 무단수집거부<\\/p>\\r\\n<p class=\\"embtt2\\">ATS 전자우편주소 무단수집 대응방침!<\\/p>\\r\\n<p class=\\"embtt3\\">본 웹사이트에 게시된 이메일 주소가 전자우편 수집 프로그램이나 그밖에 기술적 장치를 이용하여 무단으로 수집되는 것을 거부하며,<br>이를 위반시 정보통신망법에 의해 형사 처벌됨을 유념하시기 바랍니다.<\\/p>\\r\\n<\\/center>"', '2022-11-10 17:26:11', '2022-11-10 17:26:11', NULL),
	(5, 'infos', 'agreement', '{"agreed":"개인정보보호법에 따라 {company}에 회원가입 신청하시는 분께 수집하는 개인정보의 항목, 개인정보의 수집 및 이용목적, 개인정보의 보유 및 이용기간, 동의 거부권 및 동의 거부 시 불이익에 관한 사항을 안내 드리오니 자세히 읽은 후 동의하여 주시기 바랍니다.\\r\\n\\r\\n1. 수집하는 개인정보\\r\\n이용자는 회원가입을 하지 않아도 대부분의 {company} 서비스를 회원과 동일하게 이용할 수 있습니다. 이용자가 회원제 서비스를 이용하기 위해 회원가입을 할 경우, {company}는 서비스 이용을 위해 필요한 최소한의 개인정보를 수집합니다.\\r\\n\\r\\n회원가입 시점에 {company}가 이용자로부터 수집하는 개인정보는 아래와 같습니다.\\r\\n- 회원 가입 시에 ‘아이디, 비밀번호, 이름, 이메일, 닉네임, 휴대전화번호’를 필수항목으로 수집합니다. 만약 이용자가 입력하는 생년월일이 만14세 미만 아동일 경우에는 법정대리인 정보(법정대리인의 이름, 생년월일, 성별, 중복가입확인정보(DI), 휴대전화번호)를 추가로 수집합니다. 그리고 선택항목으로 이메일 주소를 수집합니다.\\r\\n- 단체아이디로 회원가입 시 단체아이디, 비밀번호, 단체이름, 이메일주소, 휴대전화번호를 필수항목으로 수집합니다. 그리고 단체 대표자명을 선택항목으로 수집합니다.\\r\\n서비스 이용 과정에서 이용자로부터 수집하는 개인정보는 아래와 같습니다.\\r\\n- 회원정보 또는 개별 서비스에서 프로필 정보(닉네임)를 설정할 수 있습니다. 회원정보에 닉네임을 입력하지 않은 경우에는 마스킹 처리된 아이디가 별명으로 자동 입력됩니다.\\r\\n\\r\\n서비스 이용 과정에서 IP 주소, 쿠키, 서비스 이용 기록, 기기정보, 위치정보가 생성되어 수집될 수 있습니다. 또한 이미지 및 음성을 이용한 검색 서비스 등에서 이미지나 음성이 수집될 수 있습니다.\\r\\n구체적으로 1) 서비스 이용 과정에서 이용자에 관한 정보를 자동화된 방법으로 생성하여 이를 저장(수집)하거나,\\r\\n2) 이용자 기기의 고유한 정보를 원래의 값을 확인하지 못 하도록 안전하게 변환하여 수집합니다. 서비스 이용 과정에서 위치정보가 수집될 수 있으며,\\r\\n{company}에서 제공하는 위치기반 서비스에 대해서는 \'{company} 위치기반서비스 이용약관\'에서 자세하게 규정하고 있습니다.\\r\\n이와 같이 수집된 정보는 개인정보와의 연계 여부 등에 따라 개인정보에 해당할 수 있고, 개인정보에 해당하지 않을 수도 있습니다.\\r\\n\\r\\n2. 수집한 개인정보의 이용\\r\\n{company} 및 {company} 관련 제반 서비스(모바일 웹\\/앱 포함)의 회원관리, 서비스 개발・제공 및 향상, 안전한 인터넷 이용환경 구축 등 아래의 목적으로만 개인정보를 이용합니다.\\r\\n\\r\\n- 회원 가입 의사의 확인, 연령 확인 및 법정대리인 동의 진행, 이용자 및 법정대리인의 본인 확인, 이용자 식별, 회원탈퇴 의사의 확인 등 회원관리를 위하여 개인정보를 이용합니다.\\r\\n- 콘텐츠 등 기존 서비스 제공(광고 포함)에 더하여, 인구통계학적 분석, 서비스 방문 및 이용기록의 분석, 개인정보 및 관심에 기반한 이용자간 관계의 형성, 지인 및 관심사 등에 기반한 맞춤형 서비스 제공 등 신규 서비스 요소의 발굴 및 기존 서비스 개선 등을 위하여 개인정보를 이용합니다.\\r\\n- 법령 및 {company} 이용약관을 위반하는 회원에 대한 이용 제한 조치, 부정 이용 행위를 포함하여 서비스의 원활한 운영에 지장을 주는 행위에 대한 방지 및 제재, 계정도용 및 부정거래 방지, 약관 개정 등의 고지사항 전달, 분쟁조정을 위한 기록 보존, 민원처리 등 이용자 보호 및 서비스 운영을 위하여 개인정보를 이용합니다.\\r\\n- 유료 서비스 제공에 따르는 본인인증, 구매 및 요금 결제, 상품 및 서비스의 배송을 위하여 개인정보를 이용합니다.\\r\\n- 이벤트 정보 및 참여기회 제공, 광고성 정보 제공 등 마케팅 및 프로모션 목적으로 개인정보를 이용합니다.\\r\\n- 서비스 이용기록과 접속 빈도 분석, 서비스 이용에 대한 통계, 서비스 분석 및 통계에 따른 맞춤 서비스 제공 및 광고 게재 등에 개인정보를 이용합니다.\\r\\n- 보안, 프라이버시, 안전 측면에서 이용자가 안심하고 이용할 수 있는 서비스 이용환경 구축을 위해 개인정보를 이용합니다.\\r\\n3. 개인정보의 보관기간\\r\\n회사는 원칙적으로 이용자의 개인정보를 회원 탈퇴 시 지체없이 파기하고 있습니다.\\r\\n단, 이용자에게 개인정보 보관기간에 대해 별도의 동의를 얻은 경우, 또는 법령에서 일정 기간 정보보관 의무를 부과하는 경우에는 해당 기간 동안 개인정보를 안전하게 보관합니다.\\r\\n\\r\\n이용자에게 개인정보 보관기간에 대해 회원가입 시 또는 서비스 가입 시 동의를 얻은 경우는 아래와 같습니다.\\r\\n- 부정 가입 및 이용 방지\\r\\n부정 이용자의 가입인증 휴대전화번호 또는 DI (만14세 미만의 경우 법정대리인DI) : 탈퇴일로부터 6개월 보관\\r\\n탈퇴한 이용자의 휴대전화번호(복호화가 불가능한 일방향 암호화(해시처리)) : 탈퇴일로부터 6개월 보관\\r\\n- QR코드 복구 요청 대응\\r\\nQR코드 등록 정보:삭제 시점으로부터6개월 보관\\r\\n- 스마트플레이스 분쟁 조정 및 고객문의 대응\\r\\n휴대전화번호:등록\\/수정\\/삭제 요청 시로부터 최대1년\\r\\n- {company} 플러스 멤버십 서비스 혜택 중복 제공 방지\\r\\n암호화처리(해시처리)한DI :혜택 제공 종료일로부터6개월 보관\\r\\n- 지식iN eXpert 재가입 신청 및 부정 이용 방지\\r\\neXpert 서비스 및 eXpert 센터 가입 등록정보 : 신청일로부터 6개월(등록 거절 시, 거절 의사 표시한 날로부터 30일) 보관\\r\\n전자상거래 등에서의 소비자 보호에 관한 법률, 전자문서 및 전자거래 기본법, 통신비밀보호법 등 법령에서 일정기간 정보의 보관을 규정하는 경우는 아래와 같습니다. {company}는 이 기간 동안 법령의 규정에 따라 개인정보를 보관하며, 본 정보를 다른 목적으로는 절대 이용하지 않습니다.\\r\\n- 전자상거래 등에서 소비자 보호에 관한 법률\\r\\n계약 또는 청약철회 등에 관한 기록: 5년 보관\\r\\n대금결제 및 재화 등의 공급에 관한 기록: 5년 보관\\r\\n소비자의 불만 또는 분쟁처리에 관한 기록: 3년 보관\\r\\n- 전자문서 및 전자거래 기본법\\r\\n공인전자주소를 통한 전자문서 유통에 관한 기록 : 10년 보관\\r\\n- 전자서명 인증 업무\\r\\n인증서와 인증 업무에 관한 기록: 인증서 효력 상실일로부터 10년 보관\\r\\n- 통신비밀보호법\\r\\n로그인 기록: 3개월\\r\\n\\r\\n참고로 {company}는 ‘개인정보 유효기간제’에 따라 1년간 서비스를 이용하지 않은 회원의 개인정보를 별도로 분리 보관하여 관리하고 있습니다.\\r\\n\\r\\n4. 개인정보 수집 및 이용 동의를 거부할 권리\\r\\n이용자는 개인정보의 수집 및 이용 동의를 거부할 권리가 있습니다. 회원가입 시 수집하는 최소한의 개인정보, 즉, 필수 항목에 대한 수집 및 이용 동의를 거부하실 경우, 회원가입이 어려울 수 있습니다.","trustUse":"y","trust":" {company}에서 진행하는 프로그램 안내 및 에 사용함을 동의 합니꽈!?","thirdPartyUse":"n","thirdParty":"제 3자 정보 제공에 동의 함!?"}', '2022-11-10 17:26:30', '2022-11-11 09:00:35', NULL),
	(6, 'infos', 'company', '"회사소개 합니돠~!"', '2022-11-11 09:00:11', '2022-11-11 09:00:11', NULL);
