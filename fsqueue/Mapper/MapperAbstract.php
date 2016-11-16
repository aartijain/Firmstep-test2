<?php

namespace Queue\Mapper;

use Queue\Model\ModelAbstract;
use Queue\Mapper\MapperException;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class MapperAbstract
{
    protected $tableGateway;
    protected $excludeList = array();
    protected $db;

    public function __construct(TableGateway $tableGateway)
    {
        $this->setTableGateway($tableGateway);
        $this->getDbConnection();
    }

    public function getDbConnection()
    {
        $dbConnection = new \Queue\Config();
        $this->db = $dbConnection->getConnection();
        //return $this->db;
    }
    /**
     * Set Table Gateway
     * @param TableGateway $tableGateway
     * @return $this
     */
    public function setTableGateway(\Zend\Db\TableGateway\TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
        return $this;
    }

    /**
     * Returns Table Gateway
     * @return TableGateway
     */
    public function getTableGateway()
    {
        return $this->tableGateway;
    }

    /**
     * Returns Count
     * @return count
     */
    public function count($where = null, $group = null)
    {
        $sql = $this->getTableGateway()->getSql();

        if ($where instanceof \Zend\Db\Sql\Select) {
            $select = $where;
        } else {
            $select = $sql->select()->columns(array('count' => new Expression('COUNT(DISTINCT id)')));
            if ($where) {
                $select->where($where);
            }
            if ($group) {
                $select->group($group);
            }
        }
        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute()->current();
        return $results['count'];
    }

    /**
     * Fetch all data using tablegateway
     * @param mixed|null $where Conditions
     * @param string|null $group group by statement
     * @param string|null $order order by statement
     * @param int|null $limit Limit
     * @param int|null $offset Offset
     * @param mixed|null $having Having satement
     * @return ResultSet ResultSet
     */
    public function fetchAll($where = null, $group = null, $order = null, $limit = null, $offset = 0, $having = null)
    {
        if ($where instanceof \Zend\Db\Sql\Select) {
            $select = $where;
        } else {
            $select = $this->tableGateway->getSql()->select();
            if ($where) {
                $select->where($where);
            }
            if ($group) {
                $select->group($group);
            }
            if ($order) {
                $select->order($order);
            }
            if ($limit) {
                $select->limit($limit);
                $select->offset($offset);
            }
            if ($having) {
                $select->having($having);
            }
        }
        $resultSet = $this->tableGateway->selectWith($select);
        //echo "<pre>Resultset "; print_r($resultSet); die;
        return $resultSet;
    }

    /**
     * Find a row by id
     * @param int $id Id
     */
    public function find($id)
    {
        if ($id instanceof \Zend\Db\Sql\Select) {
            $rowset = $this->tableGateway->selectWith($id);
        } else {
            $id = (int) $id;
            $rowset = $this->tableGateway->select(array('id' => $id));
        }
        $row = $rowset->current();
        return $row;
    }

    /**
     * @param array $params Params
     * @param string $order Order
     */
    public function findByParams($params, $order = null)
    {
        if ($params instanceof \Zend\Db\Sql\Select) {
            $select = $params;
        } else {
            $select = $this->tableGateway->getSql()->select();
            $select->where($params);

            if ($order) {
                $select->order($order);
            }
        }
        $rowset = $this->tableGateway->selectWith($select);
        $row = $rowset->current();
        return $row;
    }

    /**
     * Insert or Update data
     * @param ModelAbstract $model
     * @param bool $forceInsert Force insert data
     * @return Last insert id OR affected rows
     */
    public function save(ModelAbstract $model, $forceInsert = false)
    {
        $data = $this->changeData($model->toArray());
        $id = (int) $model->id;
        
        if ($id == 0 || $forceInsert) {
            if (!$forceInsert) {
                unset($data['id']);
            }
            $this->tableGateway->insert($data);
            $result = $this->tableGateway->getLastInsertValue();
            $model->id = $result;
        } else {
            if ($this->find($id)) {
                $result = $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new MapperException('ID does not exist');
            }
        }

        return $result;
    }

    /**
     * Insert/Update data into a table. This method is only for mapper/lookup tables, 
     * when saving data in mappers. Otherwise use save method.
     * @param ModelAbstract $model Data Model
     * @param string $table
     * @param array $excludedList
     * @return int Last inserted/updated id
     */
    public function saveNonTableGateway(ModelAbstract $model, $table, array $excludedList = array(), $forceInsert = false)
    {
        $data = $this->changeDataNonGateway($model->toArray(), $excludedList);
        
        $adapter = $this->getTableGateway()->getAdapter();
        $sql = new Sql($adapter);
        $sql->setTable($table);

        $id = (int) $model->id;
        if ($id == 0 || $forceInsert) {
            if (!$forceInsert) {
                unset($data['id']);
            }
            $query = $sql->insert()->values($data);
        } else {
            $query = $sql->update()->set($data)->where(array('id' => $id));
        }

        $sqlCheck = $query->getSqlString($this->getTableGateway()->getAdapter()->getPlatform());
        $statement = $sql->prepareStatementForSqlObject($query);
        $result = $statement->execute();

        return $result->getGeneratedValue();
    }

    public function delete($id)
    {
        return $this->tableGateway->delete(array('id' => $id));
    }

    public function deleteByParams(array $where)
    {
        if (count($where) < 1) {
            throw new MapperException('Conditions must be specified for deleted records otherwise al', 500);
        }

        return $this->tableGateway->delete($where);
    }
    
    public function deleteByParamsNonGateway($table, array $where)
    {
        if (count($where) < 1) {
            throw new MapperException('Conditions must be specified for deleted records otherwise al', 500);
        }
        
        $adapter = $this->getTableGateway()->getAdapter();
        $sql = new Sql($adapter);
        $sql->setTable($table);
        $query = $sql->delete();
        $query->where($where);
        
//        echo $query->getSqlString($this->tableGateway->adapter->platform) . "\n";
        
        $statement = $sql->prepareStatementForSqlObject($query);
        $result = $statement->execute();
        
        return $result;
    }

    /**
     * @param array $data Data array
     * @return array
     */
    protected function changeData(array $data)
    {
        $newData = array();
        foreach ($data as $key => $value) {
            if ($this->checkInExcludeList($key)) {
                continue;
            }
            $newKey = $this->convertToUnderScore($key);
            $newData[$newKey] = $value;
        }

        return $newData;
    }

    protected function changeDataNonGateway(array $data, array $extraExcludeList = array())
    {
        $newData = array();
        foreach ($data as $key => $value) {
            if (in_array($key, $extraExcludeList)) {
                continue;
            }
            $newKey = $this->convertToUnderScore($key);
            $newData[$newKey] = $value;
        }

        return $newData;
    }

    protected function checkInExcludeList($key)
    {
        return in_array($key, $this->excludeList);
    }

    protected function convertToUnderScore($key)
    {
        $newKey = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $key));
        return $newKey;
    }

    
   
    /**
     * @param string $needle
     * @param array $haystack
     * @return bool
     */
    protected function checkFieldContents($needle, array $haystack)
    {
        $result = false;

        foreach ($haystack as $key => $value) {
            if (is_numeric($key) && is_string($value)) {
                if (strstr($value, $needle)) {
                    $result = true;
                }
            } elseif ($value instanceof \Zend\Db\Sql\Predicate\Predicate) {
                $expressionData = $value->getExpressionData();
                foreach ($expressionData as $data) {
                    if (is_array($data)) {
                        $identifier = $data[1][0];
                        if (strstr($identifier, $needle)) {
                            $result = true;
                        }
                    }
                }
            } else {
                if (strstr($key, $needle)) {
                    $result = true;
                }
            }
        }

        return $result;
    }
}
