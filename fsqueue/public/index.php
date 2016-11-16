<?php 
namespace Queue;
use Queue\Controller\CustomerController;

include '../../vendor/autoload.php';

$controller = new CustomerController();
$data = $controller->listAction();

if(isset($_POST['service_id'])) {
    $customerModel = new \Queue\Model\Customer($_POST);
    $customerModel->setDateArrived(date('Y-m-d H:i:s'));
    $customerMapper = new \Queue\Mapper\Customer();
    $data = $customerMapper->save($customerModel); 
}

include '../view/layout.php';
?>