<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Queue\Mapper;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;
//use Zend\Db\Sql\Select;
use Queue\Mapper\MapperAbstract;
use Queue\Model;
use Queue\ResultSet;
 

/**
 * Description of Customer
 *
 * @author A.Jain
 */
class Customer extends MapperAbstract{
    //put your code here
    
    protected $excludeList = array('serviceName', 'typeName');
    
    public function __construct() {
        $config = new \Queue\Config();
        $adapter = $config->getConnection();
        
        $sampleTable = new TableGateway('customers', $adapter, null,null, null);
        $this->setTableGateway($sampleTable);
    }
    
    public function getList($where = null) {

        $rowset = $this->fetchAll();
        
        $sql = $this->getTableGateway()->getSql();
        $adapter = $this->getTableGateway()->getAdapter();
        
        $select = $sql->select();
        $select->join(
            'services', 'customers.service_id = services.id',
            array('service_name' => 'name'),
            Select::JOIN_LEFT
        );
        
        $select->join(
            'types',
            'customers.type_id = types.id',
            array('type_name' => 'name'),
            Select::JOIN_LEFT
        );
        
        if ($where) {
            $select->where($where);
        }

        $statement = $sql->prepareStatementForSqlObject($select);
        $data = $statement->execute();
        
        $customerResultSet = new ResultSet\Customer();
        $customerResultSet->initialize($data);
        
        //echo "<pre>";        print_r($customerResultSet->toArray());
        return $customerResultSet;

    }
}
