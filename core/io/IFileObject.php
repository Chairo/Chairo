<?php
/**
 *文件操作接口
 *Create@2010-12-30Vpc:
 */

interface IFileObject {

    /**
     *Action: 复制文件
     *Input: string $strSource 源文件路径
     *       string $strTarget 目标路径
     *Output: bool
     *Create@2010-12-30Vpc:
     */
    public function copyFile($strSource, $strTarget);

    /**
     *Action: 复制文件夹
     *Input: string $strSource 源文件夹路径
     *       string $strTarget 目标路径
     *Output: bool
     *Create@2010-12-30Vpc:
     */
    public function copyDirectory($strSource, $strTarget);

    /**
     *Action: 文件夹列表
     *Input: string $strPath 文件夹路径
     *Output: array
     *Create@2010-12-30Vpc:
     */
    public function listFloders($strPath);

    /**
     *Action: 文件列表
     *Input: string $strPath 文件夹路径
     *Output: array
     *Create@2010-12-30Vpc:
     */
    public function listFiles($strPath);

    /**
     *Action: 文件夹&文件列表
     *Input: string $strPath 文件夹路径
     *Output: array
     *Create@2010-12-30Vpc:
     */
    public function listFlodersAndFiles($strPath);

    /**
     *Action: 删除文件
     *Input: string $strFilePath 文件路径
     *Output: bool
     *Create@2010-12-30Vpc:
     */
    public function deleteFile($strFilePath);

    /**
     *Action: 删除文件夹
     *Input: string $strPath 文件夹路径
     *Output: bool
     *Create@2010-12-30Vpc:
     */
    public function deleteDirectory($strPath);

    /**
     *Action: 创建文件夹
     *Input: string $strPath 文件夹路径
     *Output: bool
     *Create@2010-12-30Vpc:
     */
    public function createDirectory($strPath);

    /**
     *Action: 创建文件
     *Input: string $strFilePath 文件路径
     *       string $strContent 文件内容
     *Output: bool
     *Create@2010-12-30Vpc:
     */
    public function createFile($strFilePath, $strContent = '');

    /**
     *Action: 重命名文件夹
     *Input: string $strPath 文件夹路径
     *       string $strNewName 文件夹新名称
     *Output: bool
     *Create@2010-12-30Vpc:
     */
    public function renameDirectory($strPath, $strNewName);

    /**
     *Action: 读取文件内容
     *Input: string $strFilePath 文件路径
     *Output: string
     *Create@2010-12-30Vpc:
     */
    public function readContent($strFilePath);

    /**
     *Action: 更新文件内容
     *Input: string $strFilePath 文件路径
     *       string $strContent 文件内容
     *Output: bool
     *Create@2010-12-30Vpc:
     */
    public function updateContent($strFilePath, $strContent);

    /**
     *Action: 获取文件所在目录
     *Input: string $strFilePath 文件路径
     *Output: string
     *Create@2010-12-30Vpc:
     */
    public function getFileFloder($strFilePath);

    /**
     *Action: 获取文件名称
     *Input: string $strFilePath 文件完整路径
     *Output: string
     *Create@2010-12-30Vpc:
     */
    public function getFileName($strFilePath);
}