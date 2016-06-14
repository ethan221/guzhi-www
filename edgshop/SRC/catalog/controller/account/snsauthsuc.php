<?php
class ControllerAccountSnsauthsuc extends EdgController {
                  public function index(){
                          $data['header'] = $this->load->controller('common/account_header');
                          $data['footer'] = $this->load->controller('common/footer');
                          $this->document->setTitle('登录成功');
                          $this->response->setOutput($this->load->view('account/snsauth', $data));
                  }
}