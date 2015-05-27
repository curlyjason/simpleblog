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
use App\Lib\NameConventions;
use Bake\Utility\Model\AssociationFilter;

/**
 * CakePHP CrudTableTrait
 * @author dondrake
 */
class CrudData {
	
use ConventionsTrait;

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
	 * The foreign keys in this table and info about the associations
	 * 
	 * <pre>[
	 *  fk (string, the field name) => [
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
	protected $_foreign_keys;
	
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
    protected $_associationFilter;
	
	protected $_table;
	
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
		if (!empty($options)) {
			if (isset($options['blacklist'])) {
				$this->_blacklist = $options['blacklist'];
			}
			if (isset($options['whitelist'])) {
				$this->_whitelist = $options['whitelist'];
			}
			if (isset($options['override'])) {
				$this->_override = $options['override'];
			}
		}
		$this->_table = $table;
		$this->update();
	}
	
	public function alias() {
		return new NameConventions($this->_table->alias());
	}
	
	public function update() {
		$this->AssociationCollection = $this->_associationCollection($this->_table);
		$this->_foreignKeys = $this->_foreignKeys();
		$this->_columns = $this->_columns();
		$this->_associationFilter = $this->_filteredAssociations();
	}
	
	public function whitelist($allow = FALSE) {
		if ($allow !== FALSE) {
			$this->_whitelist = $allow;
			$this->update();
		}
		return $this->_whitelist;
	}

	public function blacklist($deny = FALSE) {
		if ($deny !== FALSE) {
			$this->_blacklist = $deny;
			$this->update();
		}
		return $this->_blacklist;
	}

	public function override($types = FALSE) {
		if ($types !== FALSE) {
			$this->_override = $types;
			$this->update();
		}
		return $this->_override;
	}
	
	public function foreignKeys() {
		return $this->_foreignKeys;
	}

	public function columns() {
		return $this->_columns;
	}

	public function columnType($field) {
		if (isset($this->_columns[$field])) {
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
	 * Get an array of the foreign keys in this table and inormation about the associations
	 * 
	 * @return array
	 */
	protected function _foreignKeys() {
		if (!$this->_foreign_keys) {
			$this->_foreign_keys = [];
			$keys = $this->AssociationCollection->keys();
			foreach ($keys as $assoc_name) {
				$association = $this->AssociationCollection->get($assoc_name);
				$this->_foreign_keys[$association->foreignKey()] = [
					'owner' => $association->isOwningSide($this->_table),
					'class' => get_class($association),
					'association_type' => $association->type(), // oneToOne, oneToMany, manyToMany, manyToOne
					'name' => new NameConventions($association->name()), 
					'property' => $association->property()
					// _camelize(), _entityName(), _fixtureName(), _modelKey(), _modelNameFromKey(), _pluginNamespace(), _pluginPath(), _pluralHumanName(), _singularHumanName(), _singularName(), _variableName()
				];
//				echo '<pre>';
//				echo get_class($association) . "\n";
////				debug(get_class_methods($association));
//				echo '_camelize :: ' . $this->_camelize($association->name()) . "\n";
//				echo '_entityName :: ' . $this->_entityName($association->name()) . "\n";
//				echo '_fixtureName :: ' . $this->_fixtureName($association->name()) . "\n";
//				echo '_modelKey :: ' . $this->_modelKey($association->name()) . "\n";
//				echo '_modelNameFromKey :: ' . $this->_modelNameFromKey($this->_modelKey($association->name())) . "\n";
//				echo '_singularName :: ' . $this->_singularName($association->name()) . "\n";
//				echo '_variableName :: ' . $this->_variableName($association->name()) . "\n";
//				echo '_singularHumanName :: ' . $this->_singularHumanName($association->name()) . "\n";
//				echo '_pluralHumanName :: ' . $this->_pluralHumanName($association->name()) . "\n";
//				echo 'alias :: ' . $this->alias() . "\n";
//				echo '</pre>';
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
	protected function _columns() {
		if (!$this->_columns) {
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
					$this->_columns[$name] = $this->_foreign_keys[$name];
				}
				$this->_columns[$name]['type'] = isset($this->type_override[$name]) ? $this->type_override[$name] : $schema->columnType($name);				
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
    protected function _filteredAssociations()
    {
        if (is_null($this->_associationFilter)) {
            $this->_associationFilter = new AssociationFilter();
        }
        return $this->_associationFilter->filterAssociations($this->_table);
    }
}