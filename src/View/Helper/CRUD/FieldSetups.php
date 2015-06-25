<?php

namespace App\View\Helper\CRUD;

use Cake\Utility\Text;

/**
 * FieldSetups are your customer output configurations
 * 
 * The method name is the the name you'll invoke them by.
 * They should return some CrudFields sub-class possibly 
 * decorated with sub-classes of FieldDecorator.
 * 
 * return new CRUD\Decorator\BelongsToDecorator(new CRUD\CrudFields($helper));
 * 
 * They should all take one argument, $helper, which is an instance of CrudHelper
 * 
 * The methods index(), view(), edit(), add() are reserved.
 * If you implement them, they will never be called.
 *
 * @author dondrake
 */
class FieldSetups {
	
	protected $helper;


	public function __construct($helper) {
		$this->helper = $helper;
	}
		
	/**
	 * Show some of long text and hide all for flyout
	 * 
	 * When there is a lot of text for a small area, this shows just the 
	 * truncated lead. The full text is in an element that is hidden. 
	 * Javascript can implement a flyout to show the full thing.
	 * 
	 * @param type $helper
	 */
	public function leadPlus($field, $options) {
		$hidden = $this->helper->Html->div(
				'full_text',
				$this->helper->Html->para(
						null, 
						$this->helper->entity->$field
					), 
					['style' => 'position: absolute; display: none;']
				);
		return $this->helper->Html->tag(
				'span', 
				Text::truncate($this->helper->entity->$field, 100) .
				$hidden
			);
	}

}
