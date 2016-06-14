<?php
class Url {
	private $ssl;
	private $rewrite = array();

	public function __construct($ssl = false) {
		$this->ssl = $ssl;
	}
	
	public function addRewrite($rewrite) {
		$this->rewrite[] = $rewrite;
	}

	public function link($route, $args = '', $secure = false) {
                                    if ($route=='/' ){
                                            if($args) {
                                                        $route = '?';
                                            }else{
                                                        $route = '';
                                            }
                                    }
		if ($this->ssl && $secure) {
                                                      if(rtrim(dirname($_SERVER['SCRIPT_NAME']))=='/admin'){
                                                                $url = 'https://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/.\\') . '/index.php?route=' . $route;
                                                      }else{
                                                                $url = 'https://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/.\\') . '/index.php?route=' . $route;
                                                      }
		} else {
                                                      if(rtrim(dirname($_SERVER['SCRIPT_NAME']))=='/admin'){
                                                                $url = 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/.\\') . '/index.php?route=' . $route;
                                                      }else{
                                                                $url = 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/.\\') . '/'.$route;
                                                      }
		}
		if ($args) {
                                                if(rtrim(dirname($_SERVER['SCRIPT_NAME']))=='/admin'){
                                                      if (is_array($args)) {
				$url .= '&amp;' . http_build_query($args);
			} else {
				$url .= str_replace('&', '&amp;', '&' . ltrim($args, '&'));
			}
                                                }else{
			if (is_array($args)) {
				$url .= '?' . http_build_query($args);
			} else {
				$url .= str_replace('&', '&amp;', '?' . ltrim($args, '&'));
			}
                                                }
		}

		foreach ($this->rewrite as $rewrite) {
			$url = $rewrite->rewrite($url);
		}

		return $url;
	}
        
                  public function seolink($id, $args = ''){
                          $url = HTTP_SERVER.$id.'.html';
                          if ($args) {
                                                if(rtrim(dirname($_SERVER['SCRIPT_NAME']))=='/admin'){
                                                      if (is_array($args)) {
				$url .= '&amp;' . http_build_query($args);
			} else {
				$url .= str_replace('&', '&amp;', '&' . ltrim($args, '&'));
			}
                                                }else{
			if (is_array($args)) {
				$url .= '?amp;' . http_build_query($args);
			} else {
				$url .= str_replace('&', '&amp;', '?' . ltrim($args, '&'));
			}
                                                }
		}
                          return $url;
                  }
}