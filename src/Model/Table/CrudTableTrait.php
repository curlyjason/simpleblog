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

/**
 * CakePHP CrudTableTrait
 * @author dondrake
 */
trait CrudTableTrait {
	
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
	public $whitelist;
	
	/**
	 * fields to exclude from the columns list
	 * 
	 * If there is a whitelist, these exclusions will be ignored 
	 *
	 * @var array
	 */
	public $blacklist;
	
	public $type_override;

	/**
	 * 
	 *
	 * @var array
	 */
	protected $_columns;

	/**
	 * Get an array of the foreign keys in this table and inormation about the associations
	 * 
	 * @return array
	 */
	public function foreignKeys() {
		if (!$this->_foreign_keys) {
			$this->_foreign_keys = [];
			$keys = $this->associationCollection()->keys();
			foreach ($keys as $assoc_name) {
				$association = $this->AssociationCollection->get($assoc_name);
				$this->_foreign_keys[$association->foreignKey()] = [
					'owner' => $association->isOwningSide($this),
					'association_type' => $association->type(),
					'name' => $association->name(), 
					'property' => $association->property()
				];
			}
		}
//		debug($this->foreign_keys);
		return $this->_foreign_keys;
	}
	
	/**
	 * Get an array of the BelongsTo associations for this model
	 * 
	 * @return array
	 */
//	public function belongsTo() {
//		$belongsTo = $this->associationCollection()->type('BelongsTo');
////		debug(($belongsTo));
////		debug(count($belongsTo));
//		return $belongsTo;
//	}
	
	/**
	 * Get the AssociationCollection for this Model
	 * 
	 * @return object
	 */
	protected function associationCollection() {
		if (!$this->AssociationCollection) {
			$this->AssociationCollection = $this->associations();
		}
		return $this->AssociationCollection;
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
	public function columns() {
		if (!$this->_columns) {
			$this->_columns = [];
			$foreign_keys = array_keys($this->foreignKeys());
			$schema = $this->schema();
			$columns = $schema->columns();
			foreach ($columns as $name) {
				if ($this->whitelist) {
					if (!in_array($name, $this->whitelist)) {
						continue;
					}
				} elseif ($this->blacklist) {
					if (in_array($name, $this->blacklist)) {
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
}


class CrudData {
	
	public function __construct($columns, $associations) {
		
	}
}
