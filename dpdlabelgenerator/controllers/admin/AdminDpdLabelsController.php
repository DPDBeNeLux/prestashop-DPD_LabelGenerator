<?php
	
class AdminDpdLabelsController extends ModuleAdminController
{

	public function __construct()
	{
		parent::__construct();

		if(Tools::getValue('labelnumber'))
		{
			$label_number = Tools::getValue('labelnumber');
			
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='" . $label_number . ".pdf'");
			readfile($this->module->download_location . DS . $label_number . '.pdf');
			
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
				,'shipments' => $this->getShipments()
				,'logo_path' => __PS_BASE_URI__ . 'img/dpd_logo.jpg'
			)
		);
		
		parent::initContent();

    $this->setTemplate('shipping-list.tpl');
  }
	
	private function getShipments($date = null)
	{
		if(!$date)
			$date = date("Y-m-d H:i:s");
			
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
			WHERE DATE(oc.`date_add`) = DATE("'.$date.'")
			');
			
		$result;
			
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
}