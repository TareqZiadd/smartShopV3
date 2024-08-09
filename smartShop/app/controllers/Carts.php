<?php

class Carts extends Controller
{





    public function __construct()
    {

    }


  

    public function index()
    {
        header('Location: ' . URLROOT . '/carts/cart_view');

    }
    public function cart_view(){
        if (isset($_SESSION['user_id'])) {
            $obj = $this->model('Cart');
            $total = $obj->totalPrice($_SESSION['user_id']);
            $id= $_SESSION['user_id'];
            $result = $obj->getAllBYSessionId($id);
            $data = [
                'carts' => $result,
                'product_id' => $_POST['product_id'],
                'user_id' => $_SESSION['user_id'],
                'total'=>$total->total_amount
            ];    
            var_dump($result);
            //$data = ['carts' => $result];
    
            $this->view('pages/cart', $data);
        } else {
   
            $this->view('users/login',$data=[]);
        }
    }
 
    
function quantityNum() {
    // Check if POST data and session data exist
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
        $data = [
            'product_id' => $_POST['product_id'],
            'user_id' => $_SESSION['user_id']
        ];
        var_dump($data);
        echo "/////////";
        // Create a single instance of Cart
        $obj = $this->model('Cart');
        $quantity_count = $obj->countQuantity($data);
        var_dump($quantity_count);
        if($quantity_count == 0) {

            // Add product to cart if not already present
            $data['quantity'] = 1; // Update quantity
            $obj->insertData($data);
        } else {

            $obj = $this->model('Cart');
            $obj->updateQuantity($data);
        }
    }
}

    




public function checkOut() {
    $obj = $this->model('Cart');
    $total = $obj->totalPrice($_SESSION['user_id']);
    
  $data=['total'=>$total->total_amount];
      echo $data['total'];
$this->view('pages/checkout',$data);
       
}







        public function addCart() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
                $data=[
                'product_id'=> $_POST['product_id'],
                'user_id'=>$_SESSION['user_id'],
                
                ];

                //$data = 

                echo '<pre>';
                print_r ($_POST);
                echo '</pre>';

            } 
        }
    
    






}