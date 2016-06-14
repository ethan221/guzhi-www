<?php
class ModelLocalisationZone extends Model {
	public function getZone($zone_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone WHERE zone_id = '" . (int)$zone_id . "' AND status = '1'");

		return $query->row;
	}

	public function getZonesByCountryId($country_id) {
		$zone_data = $this->cache->get('zone.' . (int)$country_id);

		if (!$zone_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone WHERE country_id = '" . (int)$country_id . "' AND status = '1' ORDER BY code ASC");

			$zone_data = $query->rows;

			$this->cache->set('zone.' . (int)$country_id, $zone_data);
		}

		return $zone_data;
	}
        
        	public function getRegionsByZoneId($zone_id) {
		$region_data = $this->cache->get('regionzone.' . (int)$zone_id);

		if (!$region_data) {
			$query = $this->db->query("SELECT id,name FROM " . DB_PREFIX . "region WHERE pid=(SELECT id FROM " . DB_PREFIX . "region WHERE zone_id = '" . (int)$zone_id . "')");

			$region_data = $query->rows;

			$this->cache->set('regionzone.' . (int)$zone_id, $region_data);
		}

		return $region_data;
	}
        
                  public function getRegionsByCityId($city_id) {
		$region_data = $this->cache->get('region.' . (int)$city_id);

		if (!$region_data) {
			$query = $this->db->query("SELECT id,name FROM " . DB_PREFIX . "region WHERE pid='" . (int)$city_id . "'");

			$region_data = $query->rows;

			$this->cache->set('region.' . (int)$city_id, $region_data);
		}

		return $region_data;
	}
}