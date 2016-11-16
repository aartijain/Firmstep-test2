<?php 
namespace Queue;
use Queue\Controller\CustomerController;

include '../../vendor/autoload.php';

if(filter_input(INPUT_POST, 'service_id')) {
    //echo "post"; die;
    $customerModel = new \Queue\Model\Customer($_POST);
    $customerModel->setDateArrived(date('Y-m-d H:i:s'));
    $customerMapper = new \Queue\Mapper\Customer();
    $data = $customerMapper->save($customerModel); 
}
header('Location:index.php');
?>