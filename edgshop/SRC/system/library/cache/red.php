<?php
namespace Cache;
class Red {
	private $expire;
	private $cache;
                  private $option = array(
                      'cache_prefix' => 'edg_',
                      'expire' => 3600
                  );
//                  redis.pwd=RexAuowxqJ2K8dsfls+.2_xsy
//                  redis.master.host1=121.40.49.227
//                  redis.master.port1=6379

	public function __construct($expire, $option = array()) {
		$this->expire = $expire;
                                    if(!empty($option)){
                                            $this->option = array_merge($option, (array)  $this->option);
                                    }
		$this->cache = new \Redis();
                                    //$this->cache->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_PHP); 
		$this->cache->connect('120.24.78.166', 6379);
                                    $this->cache->auth('Redis.Guzhi.Edg.Test');
                                    //$this->cache->connect('121.40.49.227', 6379);
                                    //$this->cache->auth('RexAuowxqJ2K8dsfls+.2_xsy');
	}

	public function get($key) {
                                    $value = $this->cache->get($this->option['cache_prefix'] . $key);
                                    $jsonData = json_decode($value, true);
                                    return ($jsonData === NULL) ? $value : $jsonData;
	}

	public function set($key, $value, $expire=0) {
                           $value = (is_object($value) || is_array($value)) ? json_encode($value) : $value;
                           $expire == 0 && $expire = $this->expire;
                           if(is_int($this->expire)) {
		return $this->cache->setex($this->option['cache_prefix'] . $key, $expire, $value);
                           }else{
                                    return $this->cache->set($this->option['cache_prefix'] . $key,  $value);
                           }
	}

	public function delete($key) {
		$this->cache->delete($this->option['cache_prefix'] . $key);
	}
        
                 public function flush(){
                           return $this->cache->flushDB();
                 }
                 
                 public function __destruct() {
                           $this->cache->close();
                 }
}