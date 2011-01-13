<?php
/**
 *小偷接口
 *Create@2010-12-30Vpc:
 */

interface IGetcontent {

    /**
     *Action: 根据配置获取远程页面内容
     *Input: IncConfig $config 配置
     *Output: string
     *Create@2010-12-30Vpc:
     */
    public function open(IncConfig $config);

    /**
     *Action: 根据正则表达式截取内容
     *Input: string $strRegular 正则表达式
     *       string $strData 内容
     *Output: string
     *Create@2010-12-30Vpc:
     */
    public function getContentByRegular($strRegular, $strData = "");

    /**
     *Action: 根据开始结束标识截取内容
     *Input: string $strBegin 开始标识
     *       string $strEnd 结束标识
     *       string $strData 内容
     *Output: string
     *Create@2010-12-30Vpc:
     */
    public function getContentByTag($strBegin, $strEnd, $strData = "");
}