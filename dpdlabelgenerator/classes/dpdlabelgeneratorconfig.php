<?php

class DpdLabelGeneratorConfig
{
	private $config = array(
		array(
			'name'	=> 'Delis Credentials'
			,'elements'	=> array(
				array(
					'name'	=>	'DelisID'
					,'required'	=> true
				)
				,array(
					'type' => 'password'
					,'name'	=> 	'Password'
					,'required'	=> true
				)
				,array(
					'type' => 'radio'
					,'name' => 'Live Server'
					,'required' => true
					,'class' => 't'
					,'is_bool' => true
					,'default_value' => 2
					,'values' => array(
						array(
							'id' => 'active_on'
							,'value' => 1
							,'label' => 'Yes'
						)
						,array(
							'id' => 'active_off'
							,'value' => 2
							,'label' => 'No'
						)
					)
				)
			)
		)
		,array(
			'name'	=> 'Options'
			,'elements'	=> array(
				array(
					'type' => 'select'
					,'name' => 'On status'
					,'required' => true
					,'options' => array(
						'query' => array()
						,'id' => 'id_option'
						,'name' => 'name'
					)
				)
				,array(
					'type' => 'radio'
					,'name' => 'DPD Carrier Only'
					,'required' => true
					,'class' => 't'
					,'default_value' => 2
					,'values' => array(
						array(
							'id' => 'DpdOnly'
							,'value' => 1
							,'label' => 'Yes'
						)
						,array(
							'id' => 'All'
							,'value' => 2
							,'label' => 'No (All Orders)'
						)
					)
				)
				,array(
					'type' => 'radio'
					,'name' => 'Default Predict'
					,'required' => true
					,'class' => 't'
					,'is_bool' => true
					,'default_value' => 1
					,'values' => array(
						array(
							'id' => 'perdict_on'
							,'value' => 1
							,'label' => 'Yes'
						)
						,array(
							'id' => 'predict_off'
							,'value' => 2
							,'label' => 'No'
						)
					)
				)
				,array(
					'type' => 'radio'
					,'name' => 'Auto download'
					,'required' => true
					,'class' => 't'
					,'default_value' => 2
					,'values' => array(
						array(
							'id' => 'auto'
							,'value' => 1
							,'label' => 'Yes'
						)
						,array(
							'id' => 'manual'
							,'value' => 2
							,'label' => 'No'
						)
					)
				)
			)
		)
	);
	
	public function __construct(){
		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
		foreach(OrderState::getOrderStates($default_lang) as $key => $orderState)
		{
			$this->config[1]['elements'][0]['options']['query'][$key]['id_option'] = $orderState['id_order_state'];
			$this->config[1]['elements'][0]['options']['query'][$key]['name'] = $orderState['name'];
		}
		
		if(Module::isInstalled('dpdcarrier')
			&& Module::isEnabled('dpdcarrier'))
			array_shift($this->config);
		else
			unset($this->config[1]['elements'][1]);
	}

	public function getAllElementsFlat()
	{
		$result = array();
		
		foreach ($this->config as $config_group)
		{
			$result = array_merge($result, $config_group['elements']);
		}
		
		return $result;
	}
	
	public function getAllElements()
	{
		return $this->config;		
	}

}
