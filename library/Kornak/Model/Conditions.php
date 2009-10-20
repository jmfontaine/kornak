<?php
/**
 * Kornak
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.kornak-framework.org/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@kornak-framework.org so we can send you a copy immediately.
 *
 * @category   Kornak
 * @package    Kornak_Model
 * @copyright  Copyright (c) 2008-2009 Kornak Group (http://www.kornak-framework.org/)
 * @version    $Id$
 */

/**
 * @deprecated Deprecated since version 0.2
 */
class Kornak_Model_Conditions
{
    const TYPE_NONE = 1;
    const TYPE_AND  = 2;
    const TYPE_OR   = 3;

    protected $_conditions = array();

    protected function _add($property, $value, $operator, $type)
    {
        $validOperators = array('=', '>', '>=', '<', '<=', '!=', 'in', 'like');
        if (!in_array($operator, $validOperators)) {
            throw new Kornak_Exception('Invalid operator');
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
        if (null === $dbAdapter) {
            $dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
        }
        $sql = '';
        foreach ($this->_conditions as $condition) {
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
                    throw new Kornak_Exception('Invalid type');
                    break;
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
                    case 'like':
                        $operator = strtoupper($condition['operator']);
                        $clause   = "$type {$condition['property']} $operator ? ";
                        $sql     .= $dbAdapter->quoteInto($clause, $condition['value']);
                        break;

                    case 'in':
                        $quotedValues = array();
                        foreach ($condition['value'] as $value) {
                            $quotedValues[] = $dbAdapter->quote($value);
                        }

                        $sql .= "$type {$condition['property']} IN (" .
                                implode(',', $quotedValues) . ')';
                        break;

                    default:
                        throw new Kornak_Exception('Invalid operator');
                        break;
                }
            }
        }
        return rtrim($sql);
    }
}