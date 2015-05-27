<?php
namespace App\Lib;

use Cake\Core\ConventionsTrait;

/**
 * Description of NameConventions
 *
 * @author dondrake
 */
class NameConventions {
	
	use ConventionsTrait;
	
	protected $_name;

	public function __construct($name) {
		$this->_name = $name;
	}
	
	public function __get($version) {
		$method = "_$version";
		if (method_exists($this, $method)) {
			return $this->$method($this->_name);
		} else {
			return NULL;
		}
	}
	
	protected function _name($name) {
		return $name;
	}
	
	public function __toString() {
		return $this->_name;
	}
	
	/**
	 * This one doesn't make sense in this class
	 * 
	 * @param string $key
	 * @return NULL
	 */
	protected function _modelNameFromKey($key) {
		return NULL;
	}
}
