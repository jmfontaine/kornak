<?php
class Kajoa_Model_Conditions
{
    const TYPE_NONE = 1; 
    const TYPE_AND  = 2; 
    const TYPE_OR   = 3; 
    
    protected $_conditions = array();

    protected function _add($property, $value, $operator, $type)
    {
        $validOperators = array('=', '>', '>=', '<', '<=', '!=', 'in');
        if (!in_array($operator, $validOperators)) {
            throw new Kajoa_Exception('Invalid operator');
        }
        
        $this->_conditions[] = array(
            'property' => $property,
            'value'    => $value,
            'operator' => $operator,
            'type'     => $type,
        );
    }
        
    public function __construct($property, $value, $operator = '=')
    {
        $this->_add($property, $value, $operator, self::TYPE_NONE);
    }
    
    public function __toString()
    {
        return $this->toSql();
    }
    
    public function andCondition($property, $value, $operator = '=')
    {
        $this->_add($property, $value, $operator, self::TYPE_AND);
    }
    
    public function getConditions()
    {
        return $this->_conditions;
    }
    
    public function orCondition($property, $value, $operator = '=')
    {
        $this->_add($property, $value, $operator, self::TYPE_OR);
    }
    
    public function toSql($dbAdapter = null)
    {
        if(null === $dbAdapter) {
            $dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
        }
        $sql = '';
        foreach($this->_conditions as $condition) {
            switch($condition['type']) {
                case self::TYPE_NONE:
                    $type = '';
                    break;
                
                case self::TYPE_AND:
                    $type = 'AND';
                    break;

                case self::TYPE_OR:
                    $type = 'OR';
                    break;
            
                default:
                    throw new Kajoa_Exception('Invalid type');
            }
            
            if ($condition['operator'] == '=' && $condition['value'] === null) {
                $sql .= "$type {$condition['property']} IS NULL";
            } else {
                switch($condition['operator']) {
                    case '=':
                    case '>':
                    case '>=':
                    case '<':
                    case '<=':
                    case '<>':
                        $clause = "$type {$condition['property']} {$condition['operator']} ? ";
                        $sql .= $dbAdapter->quoteInto($clause,  $condition['value']);
                        break;
                    
                    case 'in':
                        $quotedValues = array();
                        foreach($condition['value'] as $value) {
                            $quotedValues[] = $dbAdapter->quote($value);
                        }
                        
                        $sql .= "$type {$condition['property']} IN (" . implode(',', $quotedValues) . ')';
                        break;
                    
                    default:
                        throw new Kajoa_Exception('Invalid operator');
                }                
            }
        }
        return rtrim($sql);
    }
}