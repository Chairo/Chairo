<?php
/**
 *Action: 记录点击操作和搜索操作
 *Input: int $articleID 文章ID
 *       string $keywords 搜索关键词/文章标题
 *       string $ip 操作IP
 *       IncConfig $dbConfig 数据库配置
 *Output:
 *Create@2010-12-30Vpc:
 */
function record($articleID, $keywords, $ip, $dbConfig) {
    $_db= Database::getDatebase('Mysqli');
    $_conn = $_db->open($dbConfig);
    $_db->setQuery("CALL record_add (-1, $articleID, '$keywords', '$ip', ".Time().", @intResult, @strResult)");
    $_db->executeQuery($_conn);
    $_db->close($_conn);
    unset($_conn);
    unset($_db);
}