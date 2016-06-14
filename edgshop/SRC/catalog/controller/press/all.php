<?php
class ControllerPressAll extends Controller {
	public function index() {
                                $data['keyword'] = '';
                                $this->load->model('press/category');
                                $data['categories'] = $this->model_press_category->getAllPressCategories();
                                $data['footer'] = $this->load->controller('common/footer');
                                $data['header'] = $this->load->controller('common/header');
                                $this->response->setOutput($this->load->view('press/press', $data));
                                $this->response->setOutput($this->load->view('press/all', $data));
	}
}