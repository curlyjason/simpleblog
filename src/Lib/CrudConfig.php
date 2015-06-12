<?php
namespace App\Lib;

use Cake\View\ViewVarsTrait;
use App\Model\Table\CrudData;
use Cake\ORM\TableRegistry;

/**
 * CrudConfigs holds the CrudData configurations for output modules
 * 
 * This is a place to move all the configuration code so it can be called 
 * by name rather than cluttering up all the controllers
 *
 * @author dondrake
 */
class CrudConfig {
	
	use ViewVarsTrait;
	
	public $context;
	
	public function __construct($context) {
		$this->context = $context;
	}
		
	public function vanilla($table, $action) {
		return new CrudData($table, [
			'whitelist' => [],
			'blacklist' => ['created', 'modified', 'id'],
			'override' => [],
			'attributes' => [],
			'strategy' => $action
		]);
	}
	
	public function navigatorIndex() {
		$this->set('filter_property', 'parent_id');
		$this->set('filter_match', 'id');
		$navigators = TableRegistry::get('Navigators');
		return new CrudData($navigators, [
			'whitelist' => ['name'],
			'overrideAction' => ['index' => 'liLink'],
			'strategy' => 'index'
		]);
	}
	
    /**
     * Saves a variable or an associative array of variables for use inside a template.
     *
     * @param string|array $name A string or an array of data.
     * @param string|array|null $value Value in case $name is a string (which then works as the key).
     *   Unused if $name is an associative array, otherwise serves as the values to $name's keys.
     * @return $this
     */
    public function set($name, $value = null)
    {
        if (is_array($name)) {
            if (is_array($value)) {
                $data = array_combine($name, $value);
            } else {
                $data = $name;
            }
        } else {
            $data = [$name => $value];
        }
        $this->context->viewVars = $data + $this->context->viewVars;
        return $this;
    }

}
