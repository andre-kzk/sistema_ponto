SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for registro_ponto
-- ----------------------------
DROP TABLE IF EXISTS `registro_ponto`;
CREATE TABLE `registro_ponto`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `fk_usuario` int NOT NULL,
  `status_ponto` tinyint(1) NOT NULL,
  `hora` datetime NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`, `fk_usuario`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of registro_ponto
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
