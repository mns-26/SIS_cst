<?php
include_once('../common/include.php');
include_once('../common/encipher.php');
//$user = json_decode(file_get_contents("php://input"));
$username=$_POST["username"];
$password=$_POST["password"];
if($username==''){
    sendResponse(400, [] , 'Username Required !');  
}else if($password==''){
    sendResponse(400, [] , 'Password Required !');        
}else{
    $conn=getConnection();
    if($conn==null){
        sendResponse(500,$conn,'Server Connection Error !');
    }else{
      //  $password=doEncrypt($password);
        $sql = "SELECT lid,username FROM login WHERE username='";
        $sql.=$username."' AND password = '".$password."'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $users=array();
            while($row = $result->fetch_assoc()) {
                $user=array(
                    "id" =>  $row["lid"],
                    "username" => $row["username"],
                   
                );
                array_push($users,$user);
            }
            sendResponse(200,$users,'User Details');
        } else {
            sendResponse(404,[],'User not available');
        }
        $conn->close();
    }
}
