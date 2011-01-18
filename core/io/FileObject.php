<?php
/**
 *FileObject文件操作类
 *Create@2010-12-30Vpc:
 */

require('IFileObject.php');

class FileObject implements IFileObject {

    public function copyFile($strSource, $strTarget) {
        $strSource = $this->replaceDiagonal($strSource);
        $strTarget = $this->replaceDiagonal($strTarget);
        if(fileSize($strSource) == 0) {
            @copy($strSource, $strTarget);
            return file_exists($strTarget);
        } else {
            return copy($strSource, $strTarget);
        }
    }

    public  function copyDirectory($strSource, $strTarget) {
        $strSource = $this->replaceDiagonal($strSource);
        $strTarget = $this->replaceDiagonal($strTarget);
        if(!file_exists($strTarget)) {    //目标目录不存在则创建目录
            $this->createDirectory($strTarget);
        }
        if(!file_exists($strSource) || !file_exists($strTarget)) return false;    //开始目录或者目标目录不存在提示错误
        $handle = openDir($strSource);    //打开要复制的目录
        while($file = readDir($handle)) {
            if($file != "." && $file!="..") {
                $fullpath = $strSource.DIRECTORY_SEPARATOR.$file;
                $fullpathTarget = $strTarget.DIRECTORY_SEPARATOR.$file;
                if(is_dir($fullpath)) {
                    $this->copyDirectory($fullpath, $fullpathTarget);   //如果开始目录中有下级目录,递归
                } else {
                    if(!$this->copyFile($fullpath, $fullpathTarget)) {
                        return false;
                    }
                }
            }
        }
        closeDir($handle);
        return true;
    }

    public function listFloders($strPath) {
        $strPath = $this->replaceDiagonal($strPath);
        if(!file_exists($strPath)) return array('Error!');
        $handle = openDir($strPath);
        while($file = readDir($handle)) {
            if($file != "." && $file!="..") {
                $fullpath = $strPath.DIRECTORY_SEPARATOR.$file;
                if(is_dir($fullpath)) {
                    $arrResult[] = array($file);
                }
            }
        }
        closeDir($handle);
        return $arrResult;
    }

    public function listFiles($strPath) {
        $strPath = $this->replaceDiagonal($strPath);
        if(!file_exists($strPath)) return array('Error!');
        $handle = openDir($strPath);
        while($file = readDir($handle)) {
            if($file != "." && $file!="..") {
                $fullpath = $strPath.DIRECTORY_SEPARATOR.$file;
                if(is_file($fullpath)) {
                    $arrResult[] = array($file);
                }
            }
        }
        closeDir($handle);
        return $arrResult;
    }

    public function listFlodersAndFiles($strPath) {
        $arrResult[] = $this->ListFloders($strPath);
        $arrResult[] = $this->ListFiles($strPath);
        return $arrResult;
    }

    public function deleteFile($strFilePath) {
        $strFilePath = $this->replaceDiagonal($strFilePath);
        if(!file_exists($strFilePath)) return false;
        return unLink($strFilePath);
    }

    public function deleteDirectory($strPath) {
        $strPath = $this->replaceDiagonal($strPath);
        If(!is_dir($strPath)) return false;    //如果目录不存在返回False
        $dh = openDir($strPath);    //打开目录
        while($file = readDir($dh)) {
            if($file != "." && $file!="..") {
                $fullpath = $strPath.DIRECTORY_SEPARATOR.$file;
                !is_dir($fullpath) ? $this->deleteFile($fullpath) : $this->deleteDirectory($fullpath);
            }
        }
        closeDir($dh);
        return rmDir($strPath);
    }

    public function createDirectory($strPath) {
    	$spath = "";
    	$tmpPath = '';
    	$spaths = explode("/", $this->replaceDiagonal($strPath));
    	foreach($spaths as $spath) {
    		if ($spath=="") continue;
    		$spath = trim($spath);
    		if($tmpPath == '') {
    		    $tmpPath = trim($spath).DIRECTORY_SEPARATOR;
    		} else {
    		    $tmpPath .= trim($spath).DIRECTORY_SEPARATOR;
    		}
    		if(!is_dir($tmpPath)) {
    			if(!mkDir($tmpPath, 0777)) return false;
    		}
    	}
    	return true;
    }

    public function createFile($strFilePath, $strContent = '') {
        $strFilePath = $this->replaceDiagonal($strFilePath);
        if(file_exists($strFilePath)) return false;    //文件存在则返回False
        $strFloder = $this->getFileFloder($strFilePath);
        if(!is_dir($strFloder)) $this->createDirectory($strFloder);    //如果文件所在的目录不存在,则创建目录
        if($handle = fOpen($strFilePath, 'wb')) {
            if(!fWrite($handle, $strContent) === false) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    public function renameDirectory($strPath, $strNewName) {
        return rename($strPath, $strNewName);
    }

    public function readContent($strFilePath) {
        //$strFilePath = UrlEncode($this->replaceDiagonal($strFilePath));    //使用File_Get_Contents需要UrlEncode文件路径,实际测试不需要
        $strFilePath = $this->replaceDiagonal($strFilePath);
        if(!file_exists($strFilePath)) return '';
        return file_get_contents($strFilePath);
    }

    public function updateContent($strFilePath, $strContent) {
        $strFilePath = $this->replaceDiagonal($strFilePath);
        if(!file_exists($strFilePath)) return false;    //文件不存在则返回False
        if($handle = fOpen($strFilePath, 'wb')) {
            if(!fWrite($handle, $strContent) === false) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    public function getFileFloder($strFilePath) {
        $tmp = '';
        $spaths = explode('/', $this->replaceDiagonal($strFilePath));
        for($i=0; $i<count($spaths)-1; $i++) {
            $tmp .= $spaths[$i].DIRECTORY_SEPARATOR;
        }
       return $tmp;
    }

    public function getFileName($strFilePath) {
        $strFilePath = $this->replaceDiagonal($strFilePath);
        $paths = explode('/', $strFilePath);
        return $paths[count($paths)-1];
    }

    /**
     *Action: 替换反斜线
     *Input: string $strSource 文件夹地址
     *Output: string
     *Create@2010-12-30Vpc:
     */
    public function replaceDiagonal(&$strSource) {
        $strSource = str_replace('\\', '/', $strSource);
        return $strSource;
    }
}