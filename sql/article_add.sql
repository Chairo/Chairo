DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `article_add`(
        IN title VARCHAR(1000),
        IN content TEXT,
        IN description VARCHAR(400),
        IN keywords VARCHAR(400),
        OUT intResult INT,
        OUT strResult VARCHAR(100)
    )
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;
    SET intResult = -2, strResult = '插入数据失败'; 
    
    IF (title IS NULL OR content IS NULL OR description IS NULL OR keywords IS NULL OR title='' OR content='' OR description='' OR keywords='') THEN
        SET intResult = -1, strResult = '参数不能为空';
    ELSE
        START TRANSACTION;    #开始事务      
            #插入数据        
            INSERT INTO article (title, content, description, keywords, create_date, update_date)
            VALUES (title, content, description, keywords, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
            
            SET intResult = 0, strResult = '插入数据成功';
        COMMIT;    #提交事务 
    END IF;
END$$

DELIMITER ;