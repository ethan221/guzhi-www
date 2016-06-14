<?php
class ModelTotalTax extends Model {
	public function getTotal($total) {
                                    if(!empty($total['taxes'])){
                                                foreach ($total['taxes'] as $key => $value) {
                                                        if ($value > 0) {
                                                                $total['totals'][] = array(
                                                                        'code'       => 'tax',
                                                                        'title'      => $this->tax->getRateName($key),
                                                                        'value'      => $value,
                                                                        'sort_order' => $this->config->get('tax_sort_order')
                                                                );

                                                                $total['total'] += $value;
                                                        }
                                                }
                                    }
	}
}