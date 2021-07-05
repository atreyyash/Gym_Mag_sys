<?php
$name = $_POST['Name'];
$age = $_POST['Age'];
$gender = $_POST['Gender'];
$locality = $_POST['Locality'];
$mobileno = $_POST['Mobileno'];
$email = $_POST['Email'];

if (!empty($name) || !empty($age) || !empty($gender) || !empty($locality) || !empty($mobileno) || !empty($email)) {
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "dbms";

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if($mysqli_connect_error()){
        die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
    }
    else{
        $SELECT = "SELECT Email from register where = ? Limit 1";
        $INSERT = "INSERT into register (name, age, gender, locality, mobileno, email) value (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum==0) {
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sissis", $name, $age, $gender, $locality, $mobileno, $email);
            $stmt->execute();
            echo "New Record Successfully Inserted";
        }
        else{
            echo "Email Already Registered";
        }
        $stmt->close();
        $conn->close();
    }
}
else
{
    echo "All Fields Are Required";
    die();
}
?>