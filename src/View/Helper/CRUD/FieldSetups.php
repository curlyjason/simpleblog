<?php
namespace App\View\Helper\CRUD;

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
 * @author dondrake
 */
class FieldSetups {
	
	/**
	 * The methods index(), view(), edit(), add() are reserved.
	 * If you implement them, they will never be called.
	 */
	
}
