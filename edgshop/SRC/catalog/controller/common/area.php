<?php
class ControllerCommonArea extends Controller {
	public function index() {
                                    $json = array();
		$type = $this->request->post['type'];
                                    $this->load->model('localisation/zone');
                                    if($type=='province'){
                                            $result = $this->model_localisation_zone->getZonesByCountryId(44);
                                            $json = array_column($result, 'name', 'zone_id');
                                    }else if($type=='city'){
                                            $province_id = $this->request->post['provinceid'];
                                            if($province_id>0){
                                                $result = $this->model_localisation_zone->getRegionsByZoneId($province_id);
                                                $json = array_column($result, 'name', 'id');
                                            }
                                    }else if($type == 'region'){
                                            $city_id = $this->request->post['cityid'];
                                            if($city_id>0){
                                                $result = $this->model_localisation_zone->getRegionsByCityId($city_id);
                                                $json = array_column($result, 'name', 'id');
                                            }
                                    }
                                    $this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
