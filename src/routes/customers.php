<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


$app = new \Slim\App;

//GET
$app ->get('/api/customers', function(Request $request, Response $response){
    $sql = "SELECT * FROM customers";
    try {
        //Get DB Object
        $db = new db();

        //connect
        $db = $db->connect();

        //statement
        $stmt = $db->query($sql);
        $customers= $stmt->fetchAll(PDO::FETCH_OBJ);
        $db= null;
        echo json_encode($customers);

    } catch (PDOException $e) {
        echo '{"error": {"text":'.$e->getMessage().'}';
    }
});

//GET
$app ->get('/api/customers/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM customers WHERE id= $id";
    try {
        //Get DB Object
        $db = new db();

        //connect
        $db = $db->connect();

        //statement
        $stmt = $db->query($sql);
        $customer= $stmt->fetchAll(PDO::FETCH_OBJ);
        $db= null;
        echo json_encode($customer);

    } catch (PDOException $e) {
        echo '{"error": {"text":'.$e->getMessage().'}';
    }
});

//POST
$app ->post('/api/customers/add', function(Request $request, Response $response){
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    //query
    $sql = "INSERT INTO customers(first_name, last_name, phone, email, address, city, state) VALUES(:first_name, :last_name, :phone, :email, :address, :city, :state)";
    try {
        //Get DB Object
        $db = new db();

        //connect
        $db = $db->connect();

        //statement
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();
        echo '{"notice": {"text":"Customer added"}';

    } catch (PDOException $e) {
        echo '{"error": {"text":'.$e->getMessage().'}';
    }
});

//PUT update customer
$app ->put('/api/customers/update/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    //query
    $sql = "UPDATE customers SET
                    first_name = :first_name, 
                    last_name  = :last_name,
                    phone      = :phone, 
                    email      = :email,
                    address    = :address, 
                    city       = :city, 
                    state      = :state
            WHERE   id         = $id";
    try {
        //Get DB Object
        $db = new db();

        //connect
        $db = $db->connect();

        //statement
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();
        echo '{"notice": "text":"Customer updated"}';

    } catch (PDOException $e) {
        echo '{"error": {"text":'.$e->getMessage().'}';
    }
});
//DELETE
$app ->delete('/api/customers/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
   

    //query
    $sql = "DELETE FROM customers  WHERE id  = $id";
    try {
        //Get DB Object
        $db = new db();

        //connect
        $db = $db->connect();
        
        //create statement
        $stmt =$db->prepare($sql);

        //excute
        $stmt->execute();
        $db = null;
        echo '{"notice": "text":"Customer deleted"}';

    } catch (PDOException $e) {
        echo '{"error": {"text":'.$e->getMessage().'}';
    }
});