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
class Type extends MapperAbstract{
    //put your code here
    
    protected $excludeList = array();
    
    public function __construct() {
        $config = new \Queue\Config();
        $adapter = $config->getConnection();
        
        $sampleTable = new TableGateway('types', $adapter, null,null, null);
        $this->setTableGateway($sampleTable);
    }
    
   }
