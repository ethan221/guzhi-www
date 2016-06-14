<?php
class ModelTotalShipping extends Model {
	public function getTotal($total, $order_data) {
		if (isset($order_data['shipping'])) {
                                                      $shipping = $order_data['shipping'];

			$total['totals'][] = array(
				'code'       => 'shipping',
				'title'      =>   $shipping['shipping_method'],
				'value'      => $shipping['cost'],
				'sort_order' => $this->config->get('shipping_sort_order')
			);

			if ($shipping['tax_class_id']) {
				$tax_rates = $this->tax->getRates($shipping['cost'], $shipping['tax_class_id']);

				foreach ($tax_rates as $tax_rate) {
					if (!isset($total['taxes'][$tax_rate['tax_rate_id']])) {
						$total['taxes'][$tax_rate['tax_rate_id']] = $tax_rate['amount'];
					} else {
						$total['taxes'][$tax_rate['tax_rate_id']] += $tax_rate['amount'];
					}
				}
			}

			$total['total'] += $shipping['cost'];
		}
	}
}