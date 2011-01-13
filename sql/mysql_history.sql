CREATE TABLE `article` (
  `id` INT(4) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` TEXT COLLATE utf8_unicode_ci,
  `description` VARCHAR(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `keywords` VARCHAR(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_date` BIGINT(20) DEFAULT NULL,
  `update_date` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IX_title` (`title`(255)),
  KEY `IX_dates` (`create_date`,`update_date`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

EXPLAIN SELECT * FROM article WHERE title LIKE '%t%' AND create_date<UNIX_TIMESTAMP();

CALL article_add ('Title', 'Content', 'Description','Keywords', @intResult, @strResult);
SELECT @strResult;
SELECT @intResult;

SELECT UNIX_TIMESTAMP();

SELECT FROM_UNIXTIME(1286107846, '%Y-%m-%d %H:%i:%S');

TRUNCATE TABLE article;

SELECT VERSION();

SELECT * FROM article;

DELETE FROM article;

CALL article_add ('Title', 'Content', 'Description','Keywords', @intResult, @strResult);

SELECT * FROM article ORDER BY RAND() LIMIT 0, 6;


