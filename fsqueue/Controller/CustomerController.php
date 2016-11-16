<?php
namespace Queue\Controller;

use Queue\Mapper\Customer;

class CustomerController {

    public function listAction()
    {
        $mapper = new Customer();       
        $data = $mapper->getList(); 
        
        $serviceMapper = new \Queue\Mapper\Service();
        $serviceList = $serviceMapper->fetchAll('status = 1');
        
        $typeMapper = new \Queue\Mapper\Type();
        
        $customerTypes = $typeMapper->fetchAll('status = 1');
        
        return array('typeList' => $customerTypes, 'serviceList' => $serviceList, 'customerList' => $data);
    }
    
    public function saveAction()
    {
        $mapper = new Customer();  
        $customerModel = new \Queue\Model\Customer();
        $customerModel->setTitle($title)
                      ->setFirstName($firstName);
        
        $data = $mapper->save($customerModel); 
        
        
    }
}
?>