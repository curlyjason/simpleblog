<?php

namespace App\View\Helper\CRUD;

use App\View\Helper\CRUD\Decorator;

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
	
	/**
	 * Return the decorated output for the status method
	 * 
	 * This example method 'status' returns the same as the 'index' base action.
	 * It is provided as an example of what you can do with alternate actions.
	 * 
	 * @param type $helper
	 * @return \App\View\Helper\CRUD\Decorator\TableCellDecorator
	 */
	public function status($helper) {
		return new Decorator\TableCellDecorator(
//				new Decorator\LabelDecorator(
				new Decorator\BelongsToDecorator(
				new CrudFields($helper)
		));
	}

	/**
	 * Return the decorated output for the menuIndex method
	 * 
	 * This example method 'status' returns the same as the 'index' base action.
	 * It is provided as an example of what you can do with alternate actions.
	 * 
	 * @param type $helper
	 * @return \App\View\Helper\CRUD\Decorator\TableCellDecorator
	 */
	public function menuIndex($helper) {
		return new Decorator\TableCellDecorator(
//				new Decorator\LabelDecorator(
				new Decorator\BelongsToSelectDecorator(
				new CrudFields($helper)
		));
	}

}
