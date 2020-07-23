/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 100411
 Source Host           : localhost:3306
 Source Schema         : wminecraft

 Target Server Type    : MySQL
 Target Server Version : 100411
 File Encoding         : 65001

 Date: 23/07/2020 15:05:33
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for authme
-- ----------------------------
DROP TABLE IF EXISTS `authme`;
CREATE TABLE `authme`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `realname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ip` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '127.0.0.1',
  `lastlogin` bigint NULL DEFAULT 0,
  `x` double NOT NULL DEFAULT 0,
  `y` double NOT NULL DEFAULT 0,
  `z` double NOT NULL DEFAULT 0,
  `world` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'world',
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'your@email.com',
  `isLogged` smallint NOT NULL DEFAULT 0,
  `hasSession` smallint NOT NULL DEFAULT 0,
  `regdate` bigint NOT NULL DEFAULT 0,
  `regip` varchar(40) CHARACTER SET ascii COLLATE ascii_bin NULL DEFAULT NULL,
  `yaw` float NULL DEFAULT NULL,
  `pitch` float NULL DEFAULT NULL,
  `points` decimal(64, 2) NOT NULL DEFAULT 0,
  `rp` decimal(64, 2) NOT NULL DEFAULT 0,
  `wm_rank_id` int NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE,
  INDEX `rank_id`(`wm_rank_id`) USING BTREE,
  CONSTRAINT `authme_ibfk_1` FOREIGN KEY (`wm_rank_id`) REFERENCES `wm_rank` (`wm_rank_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for backend_login_logs
-- ----------------------------
DROP TABLE IF EXISTS `backend_login_logs`;
CREATE TABLE `backend_login_logs`  (
  `backend_login_logs_id` int NOT NULL AUTO_INCREMENT,
  `backend_login_logs_browser` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `backend_login_logs_os` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` int NOT NULL,
  `login_logs_status_id` int NOT NULL,
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`backend_login_logs_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `login_logs_status_id`(`login_logs_status_id`) USING BTREE,
  CONSTRAINT `backend_login_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `authme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `backend_login_logs_ibfk_2` FOREIGN KEY (`login_logs_status_id`) REFERENCES `login_logs_status` (`login_logs_status_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for backpack
-- ----------------------------
DROP TABLE IF EXISTS `backpack`;
CREATE TABLE `backpack`  (
  `backpack_id` int NOT NULL AUTO_INCREMENT,
  `backpack_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `backpack_command` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `backpack_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `backpack_status` int NULL DEFAULT 0 COMMENT '0 = ยังไม่รับ, 1 = รับแล้ว',
  `backpack_gift_status` int NULL DEFAULT 0 COMMENT '0 = จากตัวเอง, 1 = คนส่งให้',
  `backpack_gift_player` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `user_id` int NOT NULL,
  `server_id` int NOT NULL,
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`backpack_id`) USING BTREE,
  INDEX `server_id`(`server_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `backpack_ibfk_1` FOREIGN KEY (`server_id`) REFERENCES `server` (`server_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `backpack_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `authme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`category_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for code
-- ----------------------------
DROP TABLE IF EXISTS `code`;
CREATE TABLE `code`  (
  `code_id` int NOT NULL AUTO_INCREMENT,
  `code_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `code_command` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `code_type` int NULL DEFAULT NULL COMMENT '1 = กรอกได้ครั้งเดียว คนเดียว\r\n2 = กรอกได้ 1 คน/ครั้ง ไม่จำกัดว่ากี่คน\r\n3 = กรอกได้ 1 คน/ครั้ง จำกัดว่ากี่คน',
  `code_redeem_amount` int NULL DEFAULT 1,
  `code_status` int NULL DEFAULT 1 COMMENT '1 = เปิดใช้งาน\r\n2 = ปิดใช้งาน\r\n3 = ลบไปแล้ว',
  `server_id` int NOT NULL,
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`code_id`) USING BTREE,
  INDEX `server_id`(`server_id`) USING BTREE,
  CONSTRAINT `code_ibfk_1` FOREIGN KEY (`server_id`) REFERENCES `server` (`server_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for code_logs
-- ----------------------------
DROP TABLE IF EXISTS `code_logs`;
CREATE TABLE `code_logs`  (
  `code_logs_id` int NOT NULL AUTO_INCREMENT,
  `code_id` int NOT NULL,
  `user_id` int NOT NULL,
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`code_logs_id`) USING BTREE,
  INDEX `code_id`(`code_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `code_logs_ibfk_1` FOREIGN KEY (`code_id`) REFERENCES `code` (`code_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `code_logs_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `authme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for diary
-- ----------------------------
DROP TABLE IF EXISTS `diary`;
CREATE TABLE `diary`  (
  `diary_id` int NOT NULL AUTO_INCREMENT,
  `diary_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `diary_command` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `diary_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `diary_date` date NOT NULL DEFAULT current_timestamp,
  `server_id` int NOT NULL,
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`diary_id`) USING BTREE,
  INDEX `server_id`(`server_id`) USING BTREE,
  CONSTRAINT `diary_ibfk_1` FOREIGN KEY (`server_id`) REFERENCES `server` (`server_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for diary_logs
-- ----------------------------
DROP TABLE IF EXISTS `diary_logs`;
CREATE TABLE `diary_logs`  (
  `diary_logs_id` int NOT NULL AUTO_INCREMENT,
  `diary_id` int NOT NULL,
  `user_id` int NOT NULL,
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`diary_logs_id`) USING BTREE,
  INDEX `diary_id`(`diary_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `diary_logs_ibfk_1` FOREIGN KEY (`diary_id`) REFERENCES `diary` (`diary_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `diary_logs_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `authme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for login_logs
-- ----------------------------
DROP TABLE IF EXISTS `login_logs`;
CREATE TABLE `login_logs`  (
  `login_logs_id` int NOT NULL AUTO_INCREMENT,
  `login_logs_browser` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `login_logs_os` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` int NOT NULL,
  `login_logs_status_id` int NOT NULL,
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`login_logs_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `login_logs_status_id`(`login_logs_status_id`) USING BTREE,
  CONSTRAINT `login_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `authme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `login_logs_ibfk_2` FOREIGN KEY (`login_logs_status_id`) REFERENCES `login_logs_status` (`login_logs_status_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for login_logs_status
-- ----------------------------
DROP TABLE IF EXISTS `login_logs_status`;
CREATE TABLE `login_logs_status`  (
  `login_logs_status_id` int NOT NULL AUTO_INCREMENT,
  `login_logs_status_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`login_logs_status_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of login_logs_status
-- ----------------------------
INSERT INTO `login_logs_status` VALUES (1, 'เข้าสู่ระบบสำเร็จ');
INSERT INTO `login_logs_status` VALUES (2, 'รหัสผ่านผิด');
INSERT INTO `login_logs_status` VALUES (3, 'ไม่ได้รับสิทธิ์ในการเข้าใช้งานระบบหลังร้าน');

-- ----------------------------
-- Table structure for randombox
-- ----------------------------
DROP TABLE IF EXISTS `randombox`;
CREATE TABLE `randombox`  (
  `randombox_id` int NOT NULL AUTO_INCREMENT,
  `randombox_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `randombox_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `randombox_price` decimal(64, 2) NOT NULL,
  `randombox_status` int NULL DEFAULT 1 COMMENT '0 = ปิดใช้งาน , 1 = เปิดใช้งาน',
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`randombox_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of randombox
-- ----------------------------

-- ----------------------------
-- Table structure for randombox_item
-- ----------------------------
DROP TABLE IF EXISTS `randombox_item`;
CREATE TABLE `randombox_item`  (
  `randombox_item_id` int NOT NULL AUTO_INCREMENT,
  `randombox_item_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `randombox_item_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `randombox_item_command` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `randombox_item_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `randombox_id` int NOT NULL,
  `server_id` int NOT NULL,
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`randombox_item_id`) USING BTREE,
  INDEX `randombox_id`(`randombox_id`) USING BTREE,
  INDEX `server_id`(`server_id`) USING BTREE,
  CONSTRAINT `randombox_item_ibfk_1` FOREIGN KEY (`randombox_id`) REFERENCES `randombox` (`randombox_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `randombox_item_ibfk_2` FOREIGN KEY (`server_id`) REFERENCES `server` (`server_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of randombox_item
-- ----------------------------

-- ----------------------------
-- Table structure for refill_logs
-- ----------------------------
DROP TABLE IF EXISTS `refill_logs`;
CREATE TABLE `refill_logs`  (
  `refill_logs_id` int NOT NULL AUTO_INCREMENT,
  `refill_logs_transaction` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `refill_logs_amount` decimal(64, 2) NOT NULL,
  `refill_logs_receive` decimal(64, 2) NOT NULL,
  `refill_logs_rp` decimal(64, 2) NOT NULL DEFAULT 0,
  `refill_type_id` int NOT NULL,
  `user_id` int NOT NULL,
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`refill_logs_id`) USING BTREE,
  INDEX `refill_type_id`(`refill_type_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `refill_logs_ibfk_1` FOREIGN KEY (`refill_type_id`) REFERENCES `refill_type` (`refill_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `refill_logs_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `authme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for refill_type
-- ----------------------------
DROP TABLE IF EXISTS `refill_type`;
CREATE TABLE `refill_type`  (
  `refill_type_id` int NOT NULL AUTO_INCREMENT,
  `refill_type_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`refill_type_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of refill_type
-- ----------------------------
INSERT INTO `refill_type` VALUES (1, 'TrueWallet', '2020-06-17 17:13:21');
INSERT INTO `refill_type` VALUES (2, 'TrueMoney', '2020-06-17 17:13:25');

-- ----------------------------
-- Table structure for report
-- ----------------------------
DROP TABLE IF EXISTS `report`;
CREATE TABLE `report`  (
  `report_id` int NOT NULL AUTO_INCREMENT,
  `report_uid_reporter` int NOT NULL,
  `report_uid_person` int NOT NULL,
  `report_descr` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `report_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `report_status` int NULL DEFAULT 0 COMMENT '0=รอตรวจสอบ,1=ตรวจสอบแล้ว',
  `report_accept` int NULL DEFAULT 0 COMMENT '0=ไม่ผิด, 1=ผิด',
  `report_feedback` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`report_id`) USING BTREE,
  INDEX `report_uid_reporter`(`report_uid_reporter`) USING BTREE,
  INDEX `report_uid_person`(`report_uid_person`) USING BTREE,
  CONSTRAINT `report_ibfk_1` FOREIGN KEY (`report_uid_reporter`) REFERENCES `authme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `report_ibfk_2` FOREIGN KEY (`report_uid_person`) REFERENCES `authme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of report
-- ----------------------------

-- ----------------------------
-- Table structure for server
-- ----------------------------
DROP TABLE IF EXISTS `server`;
CREATE TABLE `server`  (
  `server_id` int NOT NULL AUTO_INCREMENT,
  `server_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `server_ip` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `server_port` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `server_password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`server_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of server
-- ----------------------------

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `settings_id` int NOT NULL AUTO_INCREMENT,
  `settings_shop_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `settings_boardcast` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `settings_max_reg` int NOT NULL DEFAULT 1,
  `settings_boardcast_status` int NOT NULL DEFAULT 1 COMMENT '1 = เปิด, 0 = ปิด',
  `settings_max_reg_status` int NOT NULL DEFAULT 1 COMMENT '1 = เปิด, 0 = ปิด',
  `settings_line_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`settings_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES (1, 'WMinecraft', 'WMinecraft ระบบ 100%', 1, 1, 1, '');

-- ----------------------------
-- Table structure for shop
-- ----------------------------
DROP TABLE IF EXISTS `shop`;
CREATE TABLE `shop`  (
  `shop_id` int NOT NULL AUTO_INCREMENT,
  `shop_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `shop_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `shop_command` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `shop_price` decimal(64, 2) NULL DEFAULT NULL,
  `shop_recommended` int NULL DEFAULT 0,
  `category_id` int NOT NULL,
  `server_id` int NOT NULL,
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`shop_id`) USING BTREE,
  INDEX `category_id`(`category_id`) USING BTREE,
  INDEX `server_id`(`server_id`) USING BTREE,
  CONSTRAINT `shop_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `shop_ibfk_2` FOREIGN KEY (`server_id`) REFERENCES `server` (`server_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for shop_logs
-- ----------------------------
DROP TABLE IF EXISTS `shop_logs`;
CREATE TABLE `shop_logs`  (
  `shop_logs_id` int NOT NULL AUTO_INCREMENT,
  `shop_id` int NOT NULL,
  `user_id` int NOT NULL,
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`shop_logs_id`) USING BTREE,
  INDEX `shop_id`(`shop_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `shop_logs_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`shop_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `shop_logs_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `authme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for truemoney
-- ----------------------------
DROP TABLE IF EXISTS `truemoney`;
CREATE TABLE `truemoney`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `amount` int NOT NULL,
  `points` decimal(64, 2) NOT NULL,
  `rp` decimal(64, 2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of truemoney
-- ----------------------------
INSERT INTO `truemoney` VALUES (1, 20, 20.00, 0.00);
INSERT INTO `truemoney` VALUES (2, 50, 50.00, 0.00);
INSERT INTO `truemoney` VALUES (3, 90, 90.00, 0.00);
INSERT INTO `truemoney` VALUES (4, 150, 150.00, 0.00);
INSERT INTO `truemoney` VALUES (5, 300, 300.00, 0.00);
INSERT INTO `truemoney` VALUES (6, 500, 500.00, 0.00);
INSERT INTO `truemoney` VALUES (7, 1000, 1000.00, 0.00);

-- ----------------------------
-- Table structure for wallet_account
-- ----------------------------
DROP TABLE IF EXISTS `wallet_account`;
CREATE TABLE `wallet_account`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phone` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `access_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `mutiple` decimal(64, 1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of wallet_account
-- ----------------------------
INSERT INTO `wallet_account` VALUES (1, 'example@domain.com', 'P@ssw0rd', '', '', '', 1.0);

-- ----------------------------
-- Table structure for wallet_rp
-- ----------------------------
DROP TABLE IF EXISTS `wallet_rp`;
CREATE TABLE `wallet_rp`  (
  `wallet_rp_id` int NOT NULL AUTO_INCREMENT,
  `wallet_rp_topup` decimal(64, 2) NOT NULL,
  `wallet_rp_reward` decimal(64, 2) NOT NULL,
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`wallet_rp_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wallet_rp
-- ----------------------------

-- ----------------------------
-- Table structure for wm_rank
-- ----------------------------
DROP TABLE IF EXISTS `wm_rank`;
CREATE TABLE `wm_rank`  (
  `wm_rank_id` int NOT NULL AUTO_INCREMENT,
  `wm_rank_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `time_reg` timestamp(0) NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`wm_rank_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of wm_rank
-- ----------------------------
INSERT INTO `wm_rank` VALUES (1, 'member', '2020-06-19 11:29:46');
INSERT INTO `wm_rank` VALUES (2, 'admin', '2020-06-19 11:29:50');

SET FOREIGN_KEY_CHECKS = 1;
