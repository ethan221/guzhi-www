<?php
namespace Aliyunoss;
require_once __DIR__ . '/autoload.php';

if (is_file(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}
require_once __DIR__ . '/main/Config.php';

use OSS\OssClient;
use OSS\Core\OssException;

/**
 * Class Ossapi
 *
 * 示例程序【Samples/*.php】 的Common类，用于获取OssClient实例和其他公用方法
 */
class Ossapi
{
    const endpoint = OssConfig::OSS_ENDPOINT;
    const accessKeyId = OssConfig::OSS_ACCESS_ID;
    const accessKeySecret = OssConfig::OSS_ACCESS_KEY;
    const bucket = OssConfig::OSS_TEST_BUCKET;
    const imgbucket = OssConfig::OSS_IMGPOINT;
    

    protected static $_client;
    protected static $_instance;

    public function __construct() {
            self::$_client = self::getOssClient();
    }

    public static function getInstance(){
            if(self::$_instance == null){
                    self::$_instance = new self();
            }
            return self::$_instance;
    }

    public static function getObjectUrl($object){
            return 'http://'.self::bucket.'.'.self::endpoint.'/'.$object;
    }

    public static function getImgObjectUrl($object){
            return 'http://'.self::bucket.'.'.self::imgbucket.'/'.$object;
    }

    public static function getClient(){
            return self::$_client;
    }

    /**
     * 根据Config配置，得到一个OssClient实例
     *
     * @return OssClient 一个OssClient实例
     */
    public static function getOssClient()
    {
        try {
            $ossClient = new OssClient(self::accessKeyId, self::accessKeySecret, self::endpoint, false);
        } catch (OssException $e) {
            printf(__FUNCTION__ . "creating OssClient instance: FAILED\n");
            printf($e->getMessage() . "\n");
            return null;
        }
        return $ossClient;
    }

    public static function getBucketName()
    {
        return self::bucket;
    }

    /**
     * 工具方法，创建一个存储空间，如果发生异常直接exit
     */
    public static function createBucket()
    {
        $ossClient = self::$_client;
        if (is_null($ossClient)) exit(1);
        $bucket = self::getBucketName();
        $acl = OssClient::OSS_ACL_TYPE_PUBLIC_READ;
        try {
            $ossClient->createBucket($bucket, $acl);
        } catch (OssException $e) {

            $message = $e->getMessage();
            if (\OSS\Core\OssUtil::startsWith($message, 'http status: 403')) {
                echo "Please Check your AccessKeyId and AccessKeySecret" . "\n";
                exit(0);
            } elseif (strpos($message, "BucketAlreadyExists") !== false) {
                echo "Bucket already exists. Please check whether the bucket belongs to you, or it was visited with correct endpoint. " . "\n";
                exit(0);
            }
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            return;
        }
        print(__FUNCTION__ . ": OK" . "\n");
    }
    
    public static function  putObject($object, $content, $options = NULL){
            return self::$_client->putObject(self::bucket, $object, $content, $options);
    }

    public static function  getObject($object, $options = NULL){
            return self::$_client->getObject(self::bucket, str_replace(' ', '', $object), $options);
    }

    public static function  upload($object, $file){
            return self::$_client->uploadFile(self::bucket, $object, $file);
    }

   public static function println($message)
    {
        if (!empty($message)) {
            echo strval($message) . "\n";
        }
    }
}

//Common::createBucket();