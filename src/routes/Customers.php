<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'C:/xampp/htdocs/slimapp/vendor/autoload.php';
$app= new \Slim\App;



//GEt All  Custmores
$app->get('/api/customers',function(Request $require,Response $response){
//echo "CUSTOMER ROUTE WRKING";
$sql="SELECT* FROM customers";



     $servername='localhost';
     $username='root';
     $password='';
     $dbname='slimapp';


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT* FROM customers"); 
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($result); 
    
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;

//Create object




}); 
//GET CUSTOMER BY NAME
$app->get('/api/customers/{name}',function(Request $require,Response $response){
//echo "CUSTOMER ROUTE WRKING";
$name=$require->getAttribute('name');
$sql="SELECT* FROM customers WHERE first_name='".$name."'";



     $servername='localhost';
     $username='root';
     $password='';
     $dbname='slimapp';


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare($sql); 
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($result); 
    
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;

//Create object




}); 

//GET CUSTOMER BY CITY
$app->get('/api/city/{city}',function(Request $require,Response $response){
//echo "CUSTOMER ROUTE WRKING";
$city=$require->getAttribute('city');
$sql="SELECT* FROM customers WHERE city='".$city."'";



     $servername='localhost';
     $username='root';
     $password='';
     $dbname='slimapp';


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare($sql); 
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($result); 
    
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
}); 



//INSERt CUSTOMER DETAIL
$app->post('/api/customer/add',function(Request $request,Response $response){
 //Escape mysqli string   
$first_name=$request->getParam('first_name');
$last_name=$request->getParam('last_name');
$phone=$request->getParam('phone');
$email1=$request->getParam('email');
$email = filter_var($email1, FILTER_SANITIZE_EMAIL);
$address=$request->getParam('address');
$city=$request->getParam('city');
$state=$request->getParam('state');
$image=$request->getParam('image');

//API POST VALIDATION
if($first_name===""){

$Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"first_name is empty",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);
}
else if($last_name===""){
$Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"last_name is empty",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);   

}
else if($phone===""){
$Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"phone number is empty",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);  

}
else if($email===""){
$Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"email field is empty",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);  

}
else if($address===""){
    $Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"address field is empty",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);  


} 
else if($city===""){
    $Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"city number is empty",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);  


} 
else if($image===""){
    $Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"Image field is empty",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);  

}     
else if(is_string($first_name)!=true||is_string($last_name)!=true||is_string($address)!=true||is_string($city)!=true||is_string($image)!=true){
    $Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"Please enter a valid string value",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);

}
else if(is_numeric($phone)!=true){
    $Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"Please enter a valid interger",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);

}
else if(filter_var($email,FILTER_VALIDATE_EMAIL)!=true){
     $Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"Please enter a valid email",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);


}
else{
    try {


     $servername='localhost';
     $username='root';
     $password='';
     $dbname='slimapp';
  
     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // use exec() because no results are returned
    $sql="INSERT INTO customers (first_name,last_name,phone,email,address,city,state,image)VALUES ('$first_name','$last_name','$phone','$email','$address','$city','$state','$image')";
    $conn->exec($sql);

     $Message= array('Success' =>'Data Enterd','Status'=>'201','Client'=>array('first_name'=>$first_name,'last_name'=>$last_name,'phone'=>$phone,'email'=>$email,'address'=>$address,'city'=>$city,'state'=>$state,'image'=>$image ));
   echo json_encode($Message); 

   
    }
catch(PDOException $e) {
     $Message= array('Error' =>'Error Posting Data','Error Report'=>array('Server error Meassge'=>$e->getMessage(),'Status'=>'409','Status message'=>'Bad Request'));
   echo json_encode($Message); 
}
$conn = null;

}

}); 

//API UPDATE firstname
$app->put('/api/Update/firstname/{name}',function(Request $require,Response $response){
//echo "CUSTOMER ROUTE WRKING";
$firstname=$require->getAttribute('name');
$first_name=$require->getParam('first_name');

if($first_name===""){

$Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"first_name is empty",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);
}

else{
        $sql="UPDATE customers SET first_name='$first_name' WHERE first_name='$first_name'";



     $servername='localhost';
     $username='root';
     $password='';
     $dbname='slimapp';


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Prepare statement
    $stmt = $conn->prepare($sql);

    // execute the query
    $stmt->execute();

    // echo a message to say the UPDATE succeeded
    //echo $stmt->rowCount() . " records UPDATED successfully";
    $Message= array('Success' =>'Record Updated succesfully','Status'=>'201','Upated To'=>array('first_name'=>$first_name ));
   echo json_encode($Message);  
    
}
catch(PDOException $e) {
   $Message= array('Error' =>'Error Posting Data','Error Report'=>array('Server error Meassge'=>$e->getMessage(),'Status'=>'409','Status message'=>'Bad Request'));
   echo json_encode($Message); 
}
$conn = null;

}



}); 
//API UPDATE NAME 
$app->put('/api/Update/lastname/{name}',function(Request $require,Response $response){
//echo "CUSTOMER ROUTE WRKING";
$lasttname=$require->getAttribute('name');
$last_name=$require->getParam('last_name');

if($last_name===""){

$Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"last_name is empty",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);
}

else{
        $sql="UPDATE customers SET last_name='$last_name' WHERE last_name='$last_name'";



     $servername='localhost';
     $username='root';
     $password='';
     $dbname='slimapp';


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Prepare statement
    $stmt = $conn->prepare($sql);

    // execute the query
    $stmt->execute();

    // echo a message to say the UPDATE succeeded
    //echo $stmt->rowCount() . " records UPDATED successfully";
    $Message= array('Success' =>'Record Updated succesfully','Status'=>'201','Upated To'=>array('last_name'=>$last_name ));
   echo json_encode($Message);  
    
}
catch(PDOException $e) {
   $Message= array('Error' =>'Error Posting Data','Error Report'=>array('Server error Meassge'=>$e->getMessage(),'Status'=>'409','Status message'=>'Bad Request'));
   echo json_encode($Message); 
}
$conn = null;

}



}); 
//API UPDATE PHONE
$app->put('/api/Update/Phone/{email}',function(Request $require,Response $response){
//echo "CUSTOMER ROUTE WRKING";
$email=$require->getAttribute('email');
$phone=$require->getParam('phone');

if($phone===""){

$Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"last_name is empty",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);
}else if(filter_var($email,FILTER_VALIDATE_EMAIL)!=true){
     $Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"Please enter a valid email",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);


}

else{
        $sql="UPDATE customers SET phone='$phone' WHERE email='$email'";



     $servername='localhost';
     $username='root';
     $password='';
     $dbname='slimapp';


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Prepare statement
    $stmt = $conn->prepare($sql);

    // execute the query
    $stmt->execute();

    // echo a message to say the UPDATE succeeded
    //echo $stmt->rowCount() . " records UPDATED successfully";
    $Message= array('Success' =>'Record Updated succesfully','Status'=>'201','Upated To'=>array('phone'=>$phone ));
   echo json_encode($Message);  
    
}
catch(PDOException $e) {
   $Message= array('Error' =>'Error Posting Data','Error Report'=>array('Server error Meassge'=>$e->getMessage(),'Status'=>'409','Status message'=>'Bad Request'));
   echo json_encode($Message); 
}
$conn = null;

}



}); 
//API UPDATE EMAIL
$app->put('/api/Update/Email/{email}',function(Request $require,Response $response){
//echo "CUSTOMER ROUTE WRKING";
$mail=$require->getAttribute('email');
$email=$require->getParam('email');

if($email===""||$mail===""){

$Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"Email is empty",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);
}else if(filter_var($email,FILTER_VALIDATE_EMAIL)!=true){
     $Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"Please enter a valid email",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);


}

else{
        $sql="UPDATE customers SET email='$email' WHERE email='$mail'";



     $servername='localhost';
     $username='root';
     $password='';
     $dbname='slimapp';


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Prepare statement
    $stmt = $conn->prepare($sql);

    // execute the query
    $stmt->execute();

    // echo a message to say the UPDATE succeeded
    //echo $stmt->rowCount() . " records UPDATED successfully";
    $Message= array('Success' =>'Record Updated succesfully','Status'=>'201','Upated To'=>array('Email'=>$email ));
   echo json_encode($Message);  
    
}
catch(PDOException $e) {
   $Message= array('Error' =>'Error Posting Data','Error Report'=>array('Server error Meassge'=>$e->getMessage(),'Status'=>'409','Status message'=>'Bad Request'));
   echo json_encode($Message); 
}
$conn = null;

}



}); 
//API UPDATE ADDRESS
$app->put('/api/Update/address/{email}',function(Request $require,Response $response){
//echo "CUSTOMER ROUTE WRKING";
$mail=$require->getAttribute('email');
$address=$require->getParam('address');

if($address===""||$mail===""){

$Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"address is empty",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);
}else if(filter_var($email,FILTER_VALIDATE_EMAIL)!=true){
     $Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"Please enter a valid email",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);


}

else{
        $sql="UPDATE customers SET address='$address' WHERE email='$mail'";



     $servername='localhost';
     $username='root';
     $password='';
     $dbname='slimapp';


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Prepare statement
    $stmt = $conn->prepare($sql);

    // execute the query
    $stmt->execute();

    // echo a message to say the UPDATE succeeded
    //echo $stmt->rowCount() . " records UPDATED successfully";
    $Message= array('Success' =>'Record Updated succesfully','Status'=>'201','Upated To'=>array('Email'=>$email ));
   echo json_encode($Message);  
    
}
catch(PDOException $e) {
   $Message= array('Error' =>'Error Posting Data','Error Report'=>array('Server error Meassge'=>$e->getMessage(),'Status'=>'409','Status message'=>'Bad Request'));
   echo json_encode($Message); 
}
$conn = null;

}



});
//API UPDATE STATE
$app->put('/api/Update/state/{email}',function(Request $require,Response $response){
//echo "CUSTOMER ROUTE WRKING";
$mail=$require->getAttribute('email');
$state=$require->getParam('state');

if($email===""||$mail===""){

$Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"Email is empty",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);
}else if(filter_var($email,FILTER_VALIDATE_EMAIL)!=true){
     $Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"Please enter a valid email",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);


}

else{
        $sql="UPDATE customers SET email='$email' WHERE state='$state'";



     $servername='localhost';
     $username='root';
     $password='';
     $dbname='slimapp';


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Prepare statement
    $stmt = $conn->prepare($sql);

    // execute the query
    $stmt->execute();

    // echo a message to say the UPDATE succeeded
    //echo $stmt->rowCount() . " records UPDATED successfully";
    $Message= array('Success' =>'Record Updated succesfully','Status'=>'201','Upated To'=>array('Email'=>$email ));
   echo json_encode($Message);  
    
}
catch(PDOException $e) {
   $Message= array('Error' =>'Error Posting Data','Error Report'=>array('Server error Meassge'=>$e->getMessage(),'Status'=>'409','Status message'=>'Bad Request'));
   echo json_encode($Message); 
}
$conn = null;

}



});
//API UPDATE IMAGE
$app->put('/api/Update/image/{email}',function(Request $require,Response $response){
//echo "CUSTOMER ROUTE WRKING";
$mail=$require->getAttribute('email');
$Image=$require->getParam('Image');

if($Image===""||$mail===""){

$Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"image is empty",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);
}else if(filter_var($email,FILTER_VALIDATE_EMAIL)!=true){
     $Message= array('Error'=>'Post Validation Data Error','Error Report'=>array('Server error Meassge'=>"Please enter a valid email",'Status'=>'400','Status message'=>'Bad Request'));
echo json_encode($Message);


}

else{
        $sql="UPDATE customers SET email='$Image' WHERE email='$mail'";



     $servername='localhost';
     $username='root';
     $password='';
     $dbname='slimapp';


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Prepare statement
    $stmt = $conn->prepare($sql);

    // execute the query
    $stmt->execute();

    // echo a message to say the UPDATE succeeded
    //echo $stmt->rowCount() . " records UPDATED successfully";
    $Message= array('Success' =>'Record Updated succesfully','Status'=>'201','Upated To'=>array('Image'=>$email ));
   echo json_encode($Message);  
    
}
catch(PDOException $e) {
   $Message= array('Error' =>'Error Posting Data','Error Report'=>array('Server error Meassge'=>$e->getMessage(),'Status'=>'409','Status message'=>'Bad Request'));
   echo json_encode($Message); 
}
$conn = null;

}



});



?>