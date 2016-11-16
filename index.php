<?php 
namespace Queue;
use Queue\Controller\CustomerController;

include './vendor/autoload.php';

$controller = new CustomerController();
$data = $controller->listAction();

if(isset($_POST['submit'])) {
    echo "post"; die;
}
include './fsqueue/view/layout.php';
?>