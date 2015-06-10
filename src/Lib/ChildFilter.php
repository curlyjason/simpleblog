<?php
namespace App\Lib;

use ArrayIterator;
use FilterIterator;

/**
 * Description of ChildFilter
 *
 * @author dondrake
 */
class ChildFilter extends FilterIterator {
	
	public function __construct(ArrayIterator $iterator, $match_value){
//		debug($match_value);
        parent::__construct($iterator);
		$this->match_value = $match_value;
    }

	public function accept() {
        $entry = $this->getInnerIterator()->current();
//		debug($entry->parent_id);
//		debug($this->match_value);
//		debug($entry->parent_id == $this->match_value);
		return $entry->parent_id == $this->match_value;
    }

}
