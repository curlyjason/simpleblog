<?php

/*
 * CrudTableTrait provides data to support tailoring CRUD elements for thier Models
 * 
 * This trait provides simple arrays that aid with automating the use of Models.
 * It can also provide an object that provides basic information and logic about Model 
 * fields and relationships.
 * 
 * The foreignKeys data always contains information on all the associations for the Model. 
 * The columns data can contain information about all the columns in the Model, or the data  
 * can filtered by a whitelist or blacklist. If a whitelist is present, that will be used, 
 * if not, and a blacklist is present the column list will be filtered. If neither is 
 * present, all columns will be returned.
 * 
 */

namespace App\Model\Table;

use Cake\Core\ConventionsTrait;
use Cake\Core\InstanceConfigTrait;
use App\Lib\NameConventions;
use Bake\Utility\Model\AssociationFilter;

/**
 * CakePHP CrudTableTrait
 * @author dondrake
 */
class CrudData {

	use ConventionsTrait;

use InstanceConfigTrait;

	/**
	 * This is just for reference. 
	 * 
	 * These are the standard cake types. all datasource specific types
	 * get translated into one of these types
	 *
	 * @var type 
	 */
	private $column_types = ['date', 'time', 'datetime', 'timestamp',
		'boolean',
		'biginteger',
		'integer',
		'uuid',
		'string',
		'binary',
		'float',
		'decimal'
	];

	/**
	 * The AssociationCollection for this model
	 *
	 * @var object AssociationCollection
	 */
	protected $AssociationCollection;

	/**
	 * The foreign keys in this table and its associations
	 * 
	 * @var array
	 */
	protected $_foreign_keys;

	/**
	 * The associations in this table and info about them
	 * 
	 * <pre>[
	 *  fk (string, the name) => [
	 *    'owner' => boolean, is this table the owner of the association,
	 *    'association_type' => string, the type of association,
	 *    'name' => string, the alias for the association,
	 *    'property' => string, name of the entity property that will contain the associated data
	 *   ],
	 *  fk => [
	 *    ...
	 *   ]
	 *  ]</pre>
	 *
	 * @var array
	 */
	protected $_associations;

	/**
	 * An array of all the BelongsTo objects for this model 
	 *
	 * @var array
	 */
//	protected $_belongs_to;

	/**
	 * fields to return in the columns list
	 * 
	 * If set, this will be the list of columns returned 
	 * regardless of any blacklist setting
	 *
	 * @var array
	 */
	protected $_whitelist;

	/**
	 * fields to exclude from the columns list
	 * 
	 * If there is a whitelist, these exclusions will be ignored 
	 *
	 * @var array
	 */
	protected $_blacklist;
	protected $_override;
	protected $_attributes;
	protected $_defaultConfig;

	/**
	 * An alternate output setup name for a standard crud view
	 * 
	 * index, view, add, edit are hard-mapped to output strategies. If you want 
	 * to use one of these views with a different output strategy, you'll need 
	 * to set this override. ['index' => 'tree_index'] would get the 'tree_index' 
	 * output strategy when 'index' action was in use.
	 *
	 * @var array
	 */
	protected $_overrideAction;

	/**
	 * 
	 *
	 * @var array
	 */
	protected $_columns;

	/**
	 * AssociationFilter utility
	 *
	 * @var AssociationFilter
	 */
//    protected $_associationFilter;

	protected $_table;

	/**
	 * The output strategy to use if this is a secondary module
	 * 
	 * If this is output as the primary model, it will use the strategy that 
	 * matches the current action. If This is a CrudData object added to include 
	 * another page module, this is the strategy that will be used.
	 *
	 * @var string
	 */
	protected $_strategy;

	/**
	 * Create a fully populated information object for guiding abstracted output of table data
	 * 
	 * allowed options keys
	 * 'whitelist' -- array of desired fields
	 * 'blacklist' -- array of fields to exclude
	 * 'override' -- hash of fieldnames and types. To force columns to a special type.
	 * whitelist will win if both are present
	 * 
	 * @param \Cake\ORM\Table $table
	 * @param array $options
	 */
	public function __construct(\Cake\ORM\Table $table, $options = []) {

		$this->_blacklist = (isset($options['blacklist'])) ? $options['blacklist'] : [];
		$this->_whitelist = (isset($options['whitelist'])) ? $options['whitelist'] : [];
		$this->_override = (isset($options['override'])) ? $options['override'] : [];
		$this->_overrideAction = (isset($options['overrideAction'])) ? $options['overrideAction'] : [];
		$this->_attributes = (isset($options['attributes'])) ? $options['attributes'] : [];
		$this->_strategy = (isset($options['strategy'])) ? $options['strategy'] : 'index';

		$this->_table = $table;
		$this->update();
//		debug($this->_associationFilter);
//		debug($this->AssociationCollection);
//		debug($this->_foreignKeys());die;
	}

	public function primaryKey($as_array = FALSE) {
		if ($as_array) {
			return (array) $this->_table->primaryKey();
		} else {
			return $this->_table->primaryKey();
		}
	}

	public function displayField() {
		return $this->_table->displayField();
	}

	public function alias($type = 'object') {
		if ($type === 'string') {
			return $this->_table->alias();
		} else {
			return new NameConventions($this->_table->alias());
		}
	}

	public function strategy($name = NULL) {
		if (!is_null($name)) {
			$this->_strategy = $name;
		}
		return $this->_strategy;
	}

	public function update() {
		$this->AssociationCollection = $this->_associationCollection($this->_table);
		$this->_foreignKeys = $this->_foreignKeys(TRUE);
		$this->_columns = $this->_columns(TRUE);
//		$this->_associationFilter = $this->_filteredAssociations();
	}

	public function whitelist(array $allow = [], $replace = FALSE) {
		if ($replace) {
			$this->_whitelist = [];
		}
		if (!empty($allow) || $replace) {
			$this->_whitelist = array_merge($this->_whitelist, (array) $allow);
			$this->update();
		}
		return $this->_whitelist;
	}

	public function blacklist($deny = [], $replace = FALSE) {
		if ($replace) {
			$this->_blacklist = [];
		}
		if (!empty($deny) || $replace) {
			$this->_blacklist = array_merge($this->_blacklist, (array) $deny);
			$this->update();
		}
		return $this->_blacklist;
	}

	public function override($types = [], $replace = FALSE) {
		if ($replace) {
			$this->_override = [];
		}
		if (!empty($types) || $replace) {
			$this->_override += $types;
			$this->update();
		}
		return $this->_override;
	}

	public function attributes($attributes = [], $replace = FALSE) {
		if ($replace) {
			$this->_attributes = [];
		}
		if (!empty($attributes) || $replace) {
			$this->_attributes += $attributes;
			$this->update();
		}
		return $this->_attributes;
	}

	/**
	 * Set and/or return override action
	 * 
	 * The action name will select a Field strategy in CrudHelper. And the 
	 * four standard crud actions are hard-wired. This allows you to substitute 
	 * a different strategy for one of the standards. Or, indeed, to substitute 
	 * a strategy for one of your own views (though I'm not sure why you would).
	 * 
	 * @param string $action
	 * @param string $alternate
	 * @return string or BOOLEAN FALSE
	 */
	public function overrideAction($actionAlternates = [], $replace = FALSE) {
		//pass only a string action to get the alternate back, if already set
		if (is_string($actionAlternates) && isset($this->_overrideAction[$actionAlternates])) {
			return $this->_overrideAction[$actionAlternates];
		} elseif (is_string($actionAlternates) && !isset($this->_overrideAction[$actionAlternates])) {
			return FALSE;
		}
		
		if ($replace) {
			$this->_overrideAction = [];
		}
		if (!empty($actionAlternates) || $replace) {
			while (list($key, $val) = each($actionAlternates)) {
				$this->_overrideAction[$key] = $val;
			}
		}
	}

	public function foreignKeys() {
		return $this->_foreignKeys;
	}

	public function associations() {
		return $this->_associations;
	}

	public function columns() {
		return $this->_columns;
//		if (isset($this->_columns)) {
//			return $this->_columns;
//		} else {
//			return $this->_columns();
//		}
	}

	/**
	 * get data about a column in the schema
	 * 
	 * @param string $name
	 * @return array
	 */
	public function column($name) {
		return $this->_table->schema()->column($name);
	}

	public function columnType($field) {
		if (isset($this->_columns[$field])) {
			if (isset($this->_override[$field])) {
				return $this->_override[$field];
			}
			return $this->_columns[$field]['type'];
		} else {
			return NULL;
		}
	}

	public function filteredAssociations() {
		return $this->_associationFilter;
	}

//	public function entityName($name = NULL) {
//		if 
//		return $this->_entityName($this->alias());
//	}

	/**
	 * Get the AssociationCollection for this Model
	 * 
	 * @return object
	 */
	protected function _associationCollection() {
		if (!$this->AssociationCollection) {
			$this->AssociationCollection = $this->_table->associations();
		}
		return $this->AssociationCollection;
	}

	/**
	 * Get an array of the foreign keys in this table and information about the associations
	 * 
	 * @return array
	 */
	protected function _foreignKeys($refresh = FALSE) {
		if (!$this->_foreign_keys || $refresh) {
			$this->_foreign_keys = [];
			$this->_associations = [];
			$keys = $this->AssociationCollection->keys();
			foreach ($keys as $assoc_name) {
				$association = $this->AssociationCollection->get($assoc_name);
				$this->_associations[$association->name()] = [
					'foreign_key' => $association->foreignKey(),
					'owner' => $association->isOwningSide($this->_table),
					'class' => get_class($association),
					'association_type' => $association->type(), // oneToOne, oneToMany, manyToMany, manyToOne
					'name' => new NameConventions($association->name()),
					'property' => $association->property()
				];
				$this->_foreign_keys[$association->foreignKey()] = $association->foreignKey();
			}
		}
		return $this->_foreign_keys;
	}

	/**
	 * Get an array of the columns and information about them for this Models table
	 * 
	 * If there is a whitelist, include only these fields. 
	 * If there is no whitelist, but there is a blacklist, exclude these fields
	 * type_override allows forcing a column to a specific type. This will something 
	 * like having an image_name field (normally a text field) return as a file field type 
	 * so the proper inputs/outputs can be generated.
	 * 
	 * @return array 
	 */
	protected function _columns($refresh = FALSE) {
		if (!$this->_columns || $refresh) {
			$this->_columns = [];
			$foreign_keys = array_keys($this->foreignKeys());
			$schema = $this->_table->schema();
			$columns = $schema->columns();
			foreach ($columns as $name) {
				if ($this->_whitelist) {
					if (!in_array($name, $this->_whitelist)) {
						continue;
					}
				} elseif ($this->_blacklist) {
					if (in_array($name, $this->_blacklist)) {
						continue;
					}
				}
				if (in_array($name, $foreign_keys)) {
					$this->_columns[$name] = ['foreign_key' => TRUE];
				}
				$this->_columns[$name]['type'] = isset($this->type_override[$name]) ? $this->type_override[$name] : $schema->columnType($name);
				$this->_columns[$name]['attributes'] = isset($this->_attributes[$name]) ? $this->_attributes[$name] : [];
			}
		}
//		debug($this->_columns);
		return $this->_columns;
	}

	/**
	 * Get filtered associations
	 * To be mocked...
	 *
	 * @param \Cake\ORM\Table $table Table
	 * @return array associations
	 */
	protected function _filteredAssociations() {
		if (is_null($this->_associationFilter)) {
			$this->_associationFilter = new AssociationFilter();
		}
		return $this->_associationFilter->filterAssociations($this->_table);
	}

	public function addAttributes($key = null, $value = null, $merge = true) {
		$this->_defaultConfig = $this->_columns[$key]['attributes'];
		$this->_columns[$key]['attributes'] = $this->config($key, $value, $merge)->config()[$key];
//		$this->_columns[$key]['attributes'] += $value;
	}

}
