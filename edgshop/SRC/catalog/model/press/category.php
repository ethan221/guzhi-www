<?php
class ModelPressCategory extends Model {
	public function getPressCategory($press_category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "press_category c LEFT JOIN " . DB_PREFIX . "press_category_description cd ON (c.press_category_id = cd.press_category_id) LEFT JOIN " . DB_PREFIX . "press_category_to_store c2s ON (c.press_category_id = c2s.press_category_id) WHERE c.press_category_id = '" . (int)$press_category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");
		return $query->row;
	}
	
	public function getPressCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "press_category c LEFT JOIN " . DB_PREFIX . "press_category_description cd ON (c.press_category_id = cd.press_category_id) LEFT JOIN " . DB_PREFIX . "press_category_to_store c2s ON (c.press_category_id = c2s.press_category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");
		return $query->rows;
	}

	
                  public function getAllPressCategories(){
                                    $cache = md5(__CLASS__.__FUNCTION__);
		$press_data = $this->cache->get($cache);
                                    if(!$press_data) {
                                            $categories = $this->getPressCategories();
                                            if($categories){
                                                        foreach ($categories as $entries){
                                                                $press_data[$entries['press_category_id']] = $entries;
                                                        }
                                                        $query = $this->db->query("SELECT pd.press_id,pd.title,pc.press_category_id FROM " . DB_PREFIX . "press_description pd LEFT JOIN  " . DB_PREFIX . "press_to_press_category pc ON pd.press_id=pc.press_id");
                                                         $press_list = $query->rows;
                                                        if($press_list){
                                                                foreach ($press_list as $entries){
                                                                        $press_data[$entries['press_category_id']]['children'][] = $entries;
                                                                }
                                                        }
                                           }
                                           $this->cache->set($cache, $press_data);
                                    }
                                    return $press_data;
                  }
                  
                  public function getPressCategoriesByKeywords($keywords){
                                    $cache = md5(__CLASS__.__FUNCTION__.$keywords);
		$press_data = $this->cache->get($cache);
                                    if(!$press_data) {
                                            $categories = $this->getPressCategories();
                                            if($categories){
                                                        foreach ($categories as $entries){
                                                                $press_data[$entries['press_category_id']] = $entries;
                                                        }
                                                        $keywords = explode(' ', $keywords);
                                                         $where = '';
                                                        foreach ($keywords as $words){
                                                                $where != '' && $where .= ' OR ';
                                                                $where .= " pd.description LIKE '%".$this->db->escape($words)."%' ";
                                                        }

                                                        $query = $this->db->query("SELECT pd.press_id,pd.title,pc.press_category_id FROM " . DB_PREFIX . "press_description pd LEFT JOIN  " . DB_PREFIX . "press_to_press_category pc ON pd.press_id=pc.press_id WHERE ".$where);
                                                        $press_list = $query->rows;
                                                        if($press_list){
                                                                foreach ($press_list as $entries){
                                                                        $press_data[$entries['press_category_id']]['children'][] = $entries;
                                                                }
                                                        }
                                                        foreach ($press_data as $key => $entries){
                                                                if(!isset($entries['children'])){
                                                                        unset($press_data[$key]);
                                                                }
                                                        }
                                           }
                                           $this->cache->set($cache, $press_data, 120);
                                    }
                                    return $press_data;
                  }
}
