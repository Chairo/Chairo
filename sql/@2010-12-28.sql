DROP TABLE IF EXISTS `record`;
CREATE TABLE `record` (
`id` INT(4) NOT NULL AUTO_INCREMENT COMMENT '��¼ID' ,
`article_id` VARCHAR(1000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '����ID' ,
`keywords` VARCHAR(1000) COLLATE utf8_unicode_ci NOT NULL COMMENT '�����ؼ���' ,
`ip` VARCHAR(15) COLLATE utf8_unicode_ci NOT NULL COMMENT 'IP' ,
`create_date` BIGINT(20) NOT NULL COMMENT '��¼����ʱ��' ,
PRIMARY KEY (`id`) ,
KEY `IX_article_id` (`article_id`) ,
KEY `IX_keywords` (`keywords`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci comment='��¼';


DELIMITER $$
DROP PROCEDURE IF EXISTS `record_add`$$
CREATE PROCEDURE `record_add`(
IN _id INT(4) ,
IN _article_id VARCHAR(1000),
IN _keywords VARCHAR(1000),
IN _ip VARCHAR(15),
IN _create_date BIGINT(20) ,
OUT intResult INT,
OUT strResult VARCHAR(100)
)
BEGIN
DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;
SET intResult = -2, strResult = '��������ʧ��';
IF NOT EXISTS (SELECT `id` FROM record WHERE `id`=_id LIMIT 1) THEN
START TRANSACTION; #��ʼ����
INSERT INTO record (`article_id`,`keywords`,`ip`,`create_date`) VALUES ( _article_id , _keywords , _ip , _create_date);
SET intResult = 0, strResult = '�������ݳɹ�';
COMMIT; #�ύ����
ELSE
UPDATE record SET `article_id`=_article_id,`keywords`=_keywords,`ip`=_ip,`create_date`=_create_date WHERE `id`=_id;
SET intResult = 0, strResult = '�������ݳɹ�';
END IF;
END$$
DELIMITER ;