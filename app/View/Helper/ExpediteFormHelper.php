<?php 

App::uses('FormHelper', 'View/Helper');
App::uses('PermissionsComponent', 'Controller');

/* 
	@class: ExpediteFormHelper
	@package: Expeditev2
	@author: Tanner Mckenney
	@date: March 7, 2014.
	
	This Class helps create the advanced form functionality used by the Expedite System. 
	It replaces ExtendedFormHelper and FormHelper. 

*/

class ExpediteFormHelper extends FormHelper {

	/* 
		Stores the Values of the Form if set.
	*/

	protected $values = array(); 
	
	/* 
		Determines if the form should be in readonly mode. 
	*/
	
	protected $readOnly = false; 
	
	/* 
		Controls the Show form mode. If set to true, the form will not show at all. This overrides readOnly.
	*/
	
	protected $showForm = true; 
	
	/* 
		U.S. States and Territories to use.
	*/
	
	protected $states = array(
		''  =>' - Please Choose a State - ',
		'AL'=>'Alabama',
		'AK'=>'Alaska',
		'AZ'=>'Arizona',
		'AR'=>'Arkansas',
		'CA'=>'California',
		'CO'=>'Colorado',
		'CT'=>'Connecticut',
		'DE'=>'Delaware',
		'DC'=>'District of Columbia',
		'FL'=>'Florida',
		'GA'=>'Georgia',
		'HI'=>'Hawaii',
		'ID'=>'Idaho',
		'IL'=>'Illinois',
		'IN'=>'Indiana',
		'IA'=>'Iowa',
		'KS'=>'Kansas',
		'KY'=>'Kentucky',
		'LA'=>'Louisiana',
		'ME'=>'Maine',
		'MD'=>'Maryland',
		'MA'=>'Massachusetts',
		'MI'=>'Michigan',
		'MN'=>'Minnesota',
		'MS'=>'Mississippi',
		'MO'=>'Missouri',
		'MT'=>'Montana',
		'NE'=>'Nebraska',
		'NV'=>'Nevada',
		'NH'=>'New Hampshire',
		'NJ'=>'New Jersey',
		'NM'=>'New Mexico',
		'NY'=>'New York',
		'NC'=>'North Carolina',
		'ND'=>'North Dakota',
		'OH'=>'Ohio',
		'OK'=>'Oklahoma',
		'OR'=>'Oregon',
		'PA'=>'Pennsylvania',
		'RI'=>'Rhode Island',
		'SC'=>'South Carolina',
		'SD'=>'South Dakota',
		'TN'=>'Tennessee',
		'TX'=>'Texas',
		'UT'=>'Utah',
		'VI'=>'Virgin Islands',
		'VT'=>'Vermont',
		'VA'=>'Virginia',
		'WA'=>'Washington',
		'WS'=>'West Indies',
		'WV'=>'West Virginia',
		'WI'=>'Wisconsin',
		'WY'=>'Wyoming'
	);

	/*
		Check the parameters to see if the field is ReadOnly or Not. 
		
		@param Array $options
	*/

	protected function isReadOnly(Array $options = array()) {
		if(!empty($options['override_permissions'])) {
			return false; 
		}
		if(isset($options['readonly']) && !$this->readOnly) {
			return (bool) $options['readonly'];
		} else {
			return $this->readOnly; 
		}
	}
	
	/* 
		Checks the Options array for the Values Key, and sets the values accordingly
		
		@param Array $options
	*/
	
	protected function setValuesFromOptions(Array &$options = array()) {
		if(!empty($options['values'])) {
			$this->values = $options['values'];
			unset($options['values']);
		} else {
			return $this->values; 
		}
	}
	
	/*
		Checks the Permission status of the Form, and if we can Submit to the target URL. 
	*/
	
	protected function canWeOperateThisForm($options) {
	
		$controller = $this->request->params['controller'];
		$action = $this->request->params['action']; 
	
		if(!empty($options['url']['controller'])) {
			$controller = $options['url']['controller'];
		}
		
		if(!empty($options['url']['action'])) {
			$action = $options['url']['action'];
		}
		
		$this->readOnly = !(PermissionsComponent::check($controller, $action)); 
	}
	
	/*
		Checks the Parent model for an Enumeration
	*/
	
	protected function hasEnumeration($field = null) {
		if(empty($field)) {
			return false; 
		}
		$model = $this->_getModel($this->defaultModel); 
		if(!empty($model)) {
			if(array_key_exists($field, $model->enumerations)) {
				return $model->enumerations[$field];
			} else {
				return false; 
			}
		} else {
			return false; 
		}
	}
	
	/* 
		Creates the Form element, if ReadOnly Mode, then setup the form. 
	*/

	public function create($model = null, $options = array()) {
		
		/* 
			Prepare the Permissions
		*/
		
		$this->canWeOperateThisForm($options); 
		
		/* 
			If there are values present, set them. 
		*/
		
		$this->setValuesFromOptions($options);

		/*
			Determine if the form is readonly.
		*/
		
		$this->readOnly = $this->isReadOnly($options);
		
		/* 
			Determine if we can even see the form to begin with. 
		*/
		
		if(!$this->showForm) {
			return null;
		}

		/* 
			Expedite Parameters are set, run the Cake create();
		*/
			
		return parent::create($model, $options);;
	}
	
	/* 
		Ends the form, dumps out any data. 
	*/
	
	public function end($options = null, $secureAttributes = array()) {
		$this->values = array();
		$this->readonly = false; 
		$this->showForm = true; 
		return parent::end($options, $secureAttributes); 
	}
	
	/* 
		Primary interface for generating inputs for the form. 
	*/
	
	public function input($name, $options = array()) {		
		
		/* Determine if the field should be shown or not */
		
		if(array_key_exists('show', $options) && $options['show'] != true) {
			return null;
		}
		
		if(!$this->showForm) {
			return null;
		}
		
		/* Determine ReadOnly status */
		
		if($this->isReadOnly()) {
			$options['readonly'] = 'readonly';
		}
		
		
		/* Check to see if the field is an enumeration */
		
		$enums = $this->hasEnumeration($name); 
		
		if(!empty($enums) || !empty($options['enumeration'])) {
			$options['type'] = 'enumeration';
		}
		
		/* Check and see if field has a standard name we can determine the type from... */
		
		if(empty($options['type'])) {
			switch($name) {
				case 'phone':
				case 'fax':
				case 'mobile':
					$options['type'] = 'phone';
					break;
				
				case 'email':
					$options['type'] = 'email';
					break;
				
				case 'state':
					$options['type'] = 'state';
					break;
			}
		}
		
		/* See if there is a value set for this field. */

		if(!array_key_exists('value', $options) && array_key_exists($name, $this->values)) {
			$options['value'] = $this->values[$name];
		}

		/* Ok, we're satisfied. Return the Cake FormHelper::input() */
		
		return parent::input($name, $options);
	}
	
	/* 
		Enumeration field type, creates a select/multiselect from enumerated fields in the model. 
		This is meant to replace the checkbox/radio field type. And also keep unnecessary table's and
		relations out of the database. 
		
		@param String $name		The Name of the field
		@param Array $options	Options array for the field.
	*/
	
	public function enumeration($name, Array $options = array()) {
	
		if(empty($options['multiple'])) {
			$options['empty'] = ' - Choose - ';
		}
		
		$options = $this->_initInputField($name, $options);
		
		/* 
			if field is in `Model`.`field` Format. 
		*/
		
		if(strpos($name, '.') !== false) {
			$name = explode('.', $name);
			$name = array_pop($name);
		}
		
		/* 
			Pull the Enumeration from the Model. Then Format for Option -> Option
		*/
		
		$enums = array(); 
		
		if(!empty($options['enumeration'])) {
			$enums = $this->hasEnumeration($options['enumeration']);
		} else {
			$enums = $this->hasEnumeration($name);
		}
		
		if(!((bool) count(array_filter(array_keys($enums), 'is_string')))) {
			$enums = array_combine($enums, $enums); 
		} 

		/*
			Explode the value. If Multiple. 
		*/
		
		if(!empty($options['value']) && !empty($options['multiple'])) {
			if(stripos($options['value'], ',')) {
				$options['value'] = explode(',', $options['value']);
			}
		}

		/* 
			Set the Height.
		*/
		
		if(empty($options['style']) && !empty($options['multiple'])) {
			$height = count($enums) * 1.30; 
			$options['style'] = 'height: ' . $height . 'em;';
		}
		
		/* 
			Lets see if we need an Other field. 
		*/
		
		if(in_array("Other", $enums) && !(isset($options['other']) && $options['other'] === false) ) {
			$this->unlockField($name . '_other');
			return $this->select($name, $enums, $options) . '<div style="margin-top: 2em;">' . $this->input($name . '_other',  array('div' => false, 'label' => false)) . '</div>'; 
		} else {
			return $this->select($name, $enums, $options); 
		}
	}
	
	/* 
		Boolean field type, creates a 'Yes'/'No' drop down box. This is meant to replace 
		the checkbox field type. 
		
		@param String $name		The Name of the field
		@param Array $options	Options array for the field.
	*/
	
	public function boolean($name, Array $options = array()) {
	
		$list = array(0 => __('No'), 1 => __('Yes'));
	
		$options['empty'] = false;
	
		if(!empty($options['class'])) {
			$options['class'] .= ' boolean ';
		} else {
			$options['class'] = ' boolean ';
		}
		
		return $this->select($name, $list, $options); 
	}
	
	/* 
		Date picker.
		Creates the binding needed for jQueryUI to hook into.
		The FormHelper API automatically assigns the class needed for 
		binding before calling this method. It wouldn't be need if ID's 
		were automatically turned off. 
	
		@param String $name		The Name of the field
		@param Array $options	Options array for the field.
	*/
	
	public function datepicker($name, Array $options = array()) {
	
		$options['id'] = false; // Turns off the ID. Causes an Issue with jQuery UI.
		
		return $this->text($name, $options); 
	} 
	
	/* 
		Phone number field.
		Formats a Phone Number Automatically when pulled from database.
		Also saves the Formatting back to the database on save
	
		@param String $name		The Name of the field
		@param Array $options	Options array for the field.
	*/
	
	public function phone($name, Array $options = array()) {
	
		$options = $this->_initInputField($name, $options);
	
		$options['type'] = 'tel';
	
		if(!empty($options['class'])) {
			$options['class'] .= ' phone ';
		} else {
			$options['class'] = ' phone ';
		}
		
		if(!empty($options['value'])) {
			$options['value'] = preg_replace("/^1/", "", preg_replace("/([\.\D])/", "", $options['value']));
			preg_match("/^(\d\d\d)(\d\d\d)(\d\d\d\d)(.*)$/", $options['value'], $matches);
			if(!empty($matches)) {
				$phone = '(' . $matches[1] . ') ' . $matches[2] . '-' . $matches[3];
				if(strlen($matches[4]) > 0) {
					$phone = $phone . " ext: " . $matches[4];
				}
				$options['value'] = $phone;
			}		
		} else {
			$options['value'] = null;
		}
		
		return $this->text($name, $options);
	}
	
	/* 
		State Field
		Allows the choice of one of the 50 US states plus Territories, etc. 
	
		@param String $name		The Name of the field
		@param Array $options	Options array for the field.
	*/
	
	public function state($name, Array $options = array()) {

		$options['empty'] = ' - Please Choose a State - ';
	
		if(!empty($options['class'])) {
			$options['class'] .= ' state ';
		} else {
			$options['class'] = ' state ';
		}
		
		return $this->select($name, $this->states, $options); 
	}
	
	/* 
		Email Field
		Validates Email, and creates a button to allow mailout.  
	
		@param String $name		The Name of the field
		@param Array $options	Options array for the field.
	*/
	
	public function email($name, Array $options = array()) {
	
		$foot = null;
	
		if(!empty($options['value'])) {
			$foot = '<div style="display: block;"><a href="mailto:' . $options['value'] . '" class="button">Send Email</a></div>';
		}
	
		return $this->text($name, $options) . $foot;
	}
	
	/* 
		Currency Field
		Formats and displays the American Dollar. 
	
		@param String $name		The Name of the field
		@param Array $options	Options array for the field.
	*/
	
	public function currency($name, Array $options = array()) {
	
		$options = $this->_initInputField($name, $options);
	
		if(!empty($options['value'])) {
			$options['value'] = number_format($options['value'], 2);
		}
		
		$options['type'] = 'text';
	
		return '<span class="char">$</span>' . $this->text($name, $options); 
	}
	
	/* 
		Percent Field
		Displays Percentages. 
	
		@param String $name		The Name of the field
		@param Array $options	Options array for the field.
	*/
	
	public function percent($name, Array $options = array()) {
	
		if(!empty($options['style'])) {
			$options['style'] .= ' width: 4em;';
		} else {
			$options['style'] = 'width: 4em;';
		}
		
		$options['type'] = 'text';
	
		return $this->text($name, $options) . '<span class="char">%</span>';
	}
	
	/* 
		Read-Only Field
		Only Shows the Value. 
	
		@param String $name		The Name of the field
		@param Array $options	Options array for the field.
	*/
	
	public function readonly($name, Array $options = array()) {
	
		return $this->text($name, array('readonly' => 'readonly', 'name' => 'readonly[' . $name . ']') + $options);
	}
	
	/* 
		Textarea Field
		Uses the FormHelper method, but adds a random ID.
	
		@param String $name		The Name of the field
		@param Array $options	Options array for the field.
	*/
	
	public function textarea($fieldName, $options = array()) {
	
		if(!isset($options['id'])) {
			$options['id'] = 'textarea-' . time() . rand();
		}

		if($this->readOnly) {
			
			$options = $this->_initInputField($fieldName, $options);
			
			if(!empty($options['value'])) {
			
				$doc = new tidy(); 
				$doc->parseString($options['value']); 
				$doc->cleanRepair();
				$doc = $doc->body(); 
				$options['value'] = str_replace(array('<body>', '</body>'), "", $doc->value); 
			}
			
			return '<div class="textarea-html">' . $options['value'] . '</div>';
			
		} else {
			return parent::textarea($fieldName, $options);
		}
	}
	
	/* 
		Select Field
		Uses the FormHelper method, but allows the readonly function to work. 
	
		@param String $name		The Name of the field
		@param Array $options	Options array for the field.
	*/
	
	public function select($fieldName, $options = array(), $attributes = array()) {
		if($this->readOnly) {
			$attributes = $this->_initInputField($fieldName, array_merge(
				(array)$attributes, array('secure' => self::SECURE_SKIP)
			));
			
			if(is_bool($attributes['value'])) {
				$attributes['value'] = (int) $attributes['value']; 
			}
			
			$value = null; 
				
			if(!is_array($attributes['value'])) {
				$options = array_intersect_key($options, array($attributes['value'] => $attributes['value']));				
				if(array_key_exists($attributes['value'], $options)) $value = $options[$attributes['value']]; 
			} else {
				$options = array_intersect_key($options, array_flip($attributes['value'])); 
				$value = implode(', ', $options); 
			}
			
			/* Fix broken widths. */
			
			if(empty($attributes['style'])) {
				$attributes['style'] = "";
			}
			
			if(stripos($attributes['style'], 'width:') === false) {
				if(is_array($attributes['value']) && !empty($options)) {
					$widths = array_map('strlen', $options); 
					$attributes['style'] .= 'width: ' . (max($widths) * 0.65) . 'em; ';
				} elseif(count($attributes['value']) > 0) {
					$attributes['style'] .= 'width: ' . (strlen($value) * 0.9) . 'em; ';
				} else {
					$attributes['style'] .= 'width: 2em; ';
				}
			} 
			
			return parent::select($fieldName, $options, array('style' => 'display: none;') + $attributes) . $this->readonly($fieldName, array('value' => $value) + $attributes);

		} else {
			return parent::select($fieldName, $options, $attributes);
		}
	}
	
	/* 
		Delete Button
		Checks for Delete Permission, displays the button if so. 
	
		@param Array $url	URL array for the field.
	*/
	
	public function deleteButton($url = array(), $options = array()) {
		if(empty($url['controller'])) {
			$url['controller'] = $this->request->params['controller'];
		}
		if(empty($url['action'])) {
			$url['action'] = $this->request->params['action']; 
		}
		if(PermissionsComponent::check($url['controller'], $url['action'])) {
			$span = $this->Html->tag('span', "", array('class' => "ui-icon ui-icon-trash"));
			$link = $this->Html->link($span, $url, array('class' => 'delete button', 'escape' => false));
			return $this->Html->tag('div', $link, array('class' => 'span-22 last', 'style' => 'text-align: right;')); 
		} else {
			return null;
		}
	}
}