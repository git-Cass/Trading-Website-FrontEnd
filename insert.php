<?php
$Name = $_POST['Name'];
$Phone_Number = $_POST['Phone_Number'];
$Email = $_POST['Email'];
$Message = $_POST['Message'];

$host ="localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "trweb";

//connection
$conn = new \mysqli($host,$dbUsername,$dbPassword,$dbname);
if (mysqli_connect_error()){
    die('Connect Error('. mysqli_connect_errno().')'.msqli_connect_error());
}else{
    $SELECT = "SELECT Email From contact Where Email=? Limit 1";
    $INSERT = "INSERT Into contact (Name, Phone_Number, Email, Message) values(?,?,?,?)";

   //Prepare statement
   $stmt = $conn ->prepare($SELECT);
   $stmt->bind_param("s", $Email);
   $stmt->execute();
   $stmt->bind_result($Email);
   $stmt->store_result();
   $rnum = $stmt->num_rows;

   if($rnum==0){
    $stmt->close();

    $stmt = $conn->prepare($INSERT);
    $stmt->bind_param("ssss", $Name, $Phone_Number, $Email, $Message);
    $stmt->execute();
    echo '<script>alert("Message successfully sent"); window.location.href="/tradingwebsite"</script>';
   } else {
    echo '<script>alert("Message not sent: You have already sent a message earlier, We will get back to you as soon as possible"); window.location.href="/tradingwebsite"</script>';
   }

   $stmt->close();
   $conn->close();
    
}

?>