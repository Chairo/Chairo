<?php
/**
 *Action: 获取热门搜索数据
 *Input: IncConfig $dbConfig 数据库配置
 *       int $count 热门搜索数据数量
 *Output: array
 *Create@2010-12-30Vpc:
 */
function hotSearch($dbConfig, $count=12) {
    $_result = array();
    $_db = Database::getDatebase('Mysqli');
    $_conn = $_db->open($dbConfig);
    $_db->setQuery("SELECT COUNT(*) AS numb, keywords FROM record WHERE keywords != ' ' AND keywords IS NOT NULL AND keywords != '全部酒方' GROUP BY keywords ORDER BY numb DESC LIMIT $count");
    $_rs = $_db->executeQuery($_conn);
    while($row = $_db->getArray($_rs)) {
        $_result[] = $row['keywords'];
    }
    $_db->close($_conn);
    unset($_conn);
    unset($_db);
    return $_result;
}