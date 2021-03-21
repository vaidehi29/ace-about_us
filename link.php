<?php 

$username=$_POST['username'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$msg=$_POST['msg'];

if(!empty($username) || !empty($email) || !empty($phone) || !empty($msg)){
    $host="localhost";
    $dbUsername="root";
    $dbPassword="";
    $dbname="ace_try1";

    //create connection
    $conn=new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if(mysqli_connect_error()) {
        die('Connect Error ('. mysqli_connect_error(). ')' . mysqli_connect_error());
    }
    else{
        $SELECT= "SELECT email from contact form Where email = ? Limit 1";
        $INSERT=" INSERT Into contact form (username, email, phone, msg) values (?,?,?,?)";

        //prepare statement
        $stmt=$conn->prepare($SELECT);
        $stmt->blind_param("s", $email);
        $stmt->execute();
        $stmt->blind_result($email);
        $stmt->store_result();
        $rnum=$stmt->num_rows;

        if($rnum==0){
            $stmt->close();

            $stmt=$conn->prepare($INSERT);
            $stmt->blind_param("ssis", $username, $email, $phone, $msg);
            $stmt->execute();
            echo "Thank You for your response :)"
        } else{
            echo "Email already registered"
        }
        $stmt->close();
        $conn->close();
    }
}

else{
    echo"All fields are required";
    die();
}



?>