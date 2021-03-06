<?php

/*
 * This file is part of the dayax package.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dayax\core;

/**
 * Translator Class.
 *
 * @author Anthonius Munthi <me@itstoni.com>
 */
class Translator extends Component
{
    private $cacheDir = null;

    private $cached = array();

    private $lang =  'en';

    private $catalog = array();

    private $checksum = array();

    static private $instance = null;

    public function __construct()
    {
        $this->addCatalog('dayax', __DIR__.'/resources/messages');
    }

    public function setLanguage($lang)
    {
        $this->lang = substr($lang, 0,2);
        return $this;
    }

    public function getLanguage()
    {
        return $this->lang;
    }

    public function setCacheDir($dir)
    {
        if(!is_dir($dir)){
            throw new InvalidArgumentException('core.message_cache_dir_invalid', $dir);
        }
        $this->cacheDir = $dir;
    }

    public function getCacheDir()
    {
        return $this->cacheDir;
    }

    public function translate($message,$params=array(),$catalog=null,$lang=null)
    {
        $lang = is_null($lang) ? $this->lang:$lang;
        $cached = $this->cached;
        $trans = array();
        if(isset($cached[$catalog])){
            if(isset($cached[$catalog][$lang])){
                $trans = $cached[$catalog][$lang];
            }
        }

        $defaultLang = 'en';
        $defTrans = array();

        if(isset($cached[$catalog])){
            $defTrans = $cached[$catalog][$defaultLang];
        }

        $key = $message;
        $message = $key;

        if(isset($trans[$key])){
            $message = $trans[$key];
        }elseif(isset($defTrans[$key])){
            $message = $defTrans[$key];
        }

        $tokens = array();
        for ($i=0;$i<count($params);$i++) {
            $tokens["{".$i."}"] = $params[$i];
        }

        return strtr($message,$tokens);
    }

    public function addCatalog($namespace,$dir)
    {
        if(!is_dir($dir)){
            throw new InvalidArgumentException('core.message_catalog_dir_invalid',$namespace,$dir);
        }
        $dir = realpath($dir);
        if(isset($this->catalog[$namespace]) && $this->catalog[$namespace]===$dir){
            return;//@codeCoverageIgnore
        }
        
        if(!isset($this->catalog[$namespace])){
            $this->catalog[$namespace] = array();
        }
        $this->catalog[$namespace][] = $dir;
        $this->initCatalog($namespace,$dir);
    }

    public function hasCatalog($name)
    {
        return isset($this->catalog[$name]) ? true:false;
    }

    private function initCatalog($namespace,$dir)
    {        
        $files = array();
        foreach(scandir($dir) as $file){
            if($file==='.' || $file==='..') continue;
            $files[] = $dir.DIRECTORY_SEPARATOR.$file;
        }

        if(!isset($this->cached[$namespace])){
            $this->cached[$namespace] = array();
        }        
        foreach($files as $file){
            $contents = @file($file);
            $lang = strtr(basename($file),array(
                '.txt'=>'',
                'messages'=>'',
                '.'=>'',
            ));
            if($lang===''){
                $lang = 'en';
            }
            $cached[$lang] = array();
            array_walk($contents, create_function('&$item', '$item=trim($item);'));
            foreach($contents as $content){
                if($content=='') continue;
                
                $exp = explode("=",$content);               
                array_walk($exp, create_function('&$item', '$item=trim($item);'));
                list($key,$msg) = $exp;
                $this->cached[$namespace][$lang][$key] = $msg;
            }//end foreach contents
        }//end foreach files
        
    }

    /**
     * @return \dayax\core\Translator
     */
    static public function getInstance()
    {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }
}
