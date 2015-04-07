<?php
	
class AdminDpdLabelsController extends ModuleAdminController
{

	public function __construct()
	{
		parent::__construct();
		
		if(Tools::getValue('download_label'))
		{
			$this->downloadLabels(Tools::getValue('selected_label'));
			
			die;
		}
		
		if(Tools::getValue('generate_label'))
		{
			$label_count = Tools::getValue('label_count');
			$id_order = Tools::getValue('id_order');
			
			$labels = array();
			for ($i = 0; $i < $label_count; $i++)
				$labels[] = $this->module->generateLabel($id_order);
				
			$this->downloadLabels($labels);
	
			die;
		}

		if(Tools::getValue('labelnumber'))
		{
			$label_number = Tools::getValue('labelnumber');
			
			$this->downloadLabels(array($label_number));
			
			die;
		}
	}
	
	public function setMedia()
	{
		$this->addCSS(_MODULE_DIR_ . $this->module->name . '/views/css/shippinglist.css');
		parent::setMedia();
	}

	public function initContent()
  {
		$this->context->smarty->assign(
			array(
				'sender' => $this->getSenderAddress()
				,'shipments' => $this->getShipments(
					array(
						'date' => (Configuration::get($this->module->generateVariableName('Filter Today')) == 1 ? date("Y-m-d H:i:s") : null)
						,'status' => Configuration::get($this->module->generateVariableName('Filter Status'))
					)
				)
				,'logo_path' => __PS_BASE_URI__ . 'img/dpd_logo.jpg'
			)
		);
		
		parent::initContent();

    $this->setTemplate('shipping-list.tpl');
  }
	
	private function getShipments($filters = null)
	{
		if(isset($filters['date']) && $filters['date'] != null)
			$date = $filters['date'];
			
		if(isset($filters['status']) && $filters['status'] != -1)
			$status = $filters['status'];
		
		$where = '';
		if (isset($date) && isset($status))
			$where .= 'WHERE DATE(oc.`date_add`) = DATE("'.$date.'") AND o.`current_state` = '.$filters['status'];
		elseif (isset($date))
			$where .= 'WHERE DATE(oc.`date_add`) = DATE("'.$date.'")';
		elseif (isset($status))
			$where .= 'WHERE o.`current_state` = '.$filters['status'];
			
		$query_result = Db::getInstance()->executeS('
			SELECT 
				oc.`tracking_number`
				,c.`name`
				,a.`firstname`
				,a.`lastname`
				,a.`address1`
				,a.`postcode`
				,a.`city`
				,co.`iso_code`
				,o.`reference`
				,oc.`weight`
			FROM `'._DB_PREFIX_.'order_carrier` as oc
			JOIN `'._DB_PREFIX_.'orders` as o
				ON oc.`id_order` = o.`id_order`
			JOIN `'._DB_PREFIX_.'carrier` as c
				ON o.`id_carrier` = c.`id_carrier`
			JOIN `'._DB_PREFIX_.'address` as a
				ON o.`id_address_delivery` = a.`id_address`
			JOIN `'._DB_PREFIX_.'country` as co
				ON a.`id_country` = co.`id_country`
			'.$where.' 
			');
			
		$result = array();
			
		foreach($query_result as $curr_result)
		{
			if(preg_match('/^[0-9]{14}$/', $curr_result['tracking_number']))
				$result[] = $curr_result;
		}
		
		return $result;
	}

	private function getSenderAddress()
	{
		return array(
			'company' => Configuration::get('PS_SHOP_NAME')
			,'address1' => Configuration::get('PS_SHOP_ADDR1')
			,'iso_code' => Country::getIsoById(Configuration::get('PS_SHOP_COUNTRY_ID'))
			,'postcode' => Configuration::get('PS_SHOP_CODE')
			,'city' => Configuration::get('PS_SHOP_CITY')
		);
	}
	
	private function downloadLabels($range)
	{
		if(count($range) > 0)
		{
			include_once(_PS_MODULE_DIR_.'dpdlabelgenerator/libraries/PDFMerger/PDFMerger.php');
					
			$pdf = new PDFMerger;
			
			foreach ($range as $label_number)
				$pdf->addPDF($this->module->download_location . DS . $label_number . '.pdf', 'all');

			$pdf->merge('browser', 'labels.pdf');
		}
	}
}