
<?php
// require_once '../Model/mysqli-model.php';
$error = $success =  "";
$uname = $password = "";

session_start();

if (isset($_POST['submit']))
{
    if (empty($_POST["uname"]) && empty($_POST["password"])) 
    {
        $error = "Both username and password required";
    } 
    else 
    {
        $uname = $_POST["uname"];
        $password = $_POST["password"]; 
        
        if(login($uname, md5($password)))
        {
            $success = "Login successful";
                $_SESSION['uname'] = $uname;
                $_SESSION['password'] = $password;
                $_SESSION['name'] = $_SESSION['row']['name'];
                header("location:home-customer.php");
                if(empty($success))
                {
                    $error = "Invalid username/password";
                }
                else
                {
                    $error = "";
                }
        }else
        {
            $error = "Invalid Username/Password";
        }

        
        $data = file_get_contents("data.json");  
        $data = json_decode($data, true);  
                
        foreach($data as $row)  
        {  
            if ($row["username"] == $uname && $row["password"] == $password) 
            {

                $success = "Login successful";
                $_SESSION['uname'] = $uname;
                $_SESSION['password'] = $password;
                $_SESSION['name'] = $row['name'];
                header("location:home.php");
                if(empty($success))
                {
                    $error = "Invalid username/password";
                }
                else
                {
                    $error = "";
                }
            }
            else
            {
                $error = "Invalid Username/Password";
            }
            
        }
        
    }

    if(empty($_POST["remindMe"]))
    {
    setcookie("username","");
    setcookie("password","");
    }
    else
    {
        setcookie ("uname",$_POST["uname"],time()+ 100);
        setcookie ("password",$_POST["password"],time()+ 100);
    } 
}

?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    
    
    <title>Login</title>
   
       
</style>
</head>
<body>
   
    <fieldset>
     <legend> <b>Log-in </b></legend>
    <form method="post" id= "form"  >
        
           <label for="uname">  User Name :  </label> 
              <input type="text" name="uname" id="uname" value="<?php if(isset($_COOKIE["uname"])){ echo $_COOKIE["uname"];} ?>">  <br> <br>
               
                    <label for="password"> Password : </label>
                 <input type="password" name="password" id ="password" value="<?php if(isset($_COOKIE["password"])){ echo $_COOKIE["password"];} ?>"> <hr>
              
            <span class="error"><?php echo $error;?></span><span class="success"><?php echo $success;?></span>      
            <br>
               
       <input type="checkbox" name="remindMe" <?php if(isset($remindMe) && $remindMe=="Remind Me") echo "checked";?> value="Remind Me">   Remind Me
       <br><br>
            <input type="submit" name="submit" value="Submit">
            <br><br>
             <a href="change-pass.php">Forget Password?</a>
            <br><br>
            Not a member yet?
            <span>
             <a href="Registrations-form.php">Sign up</a></span>
           <br><br>
       </fieldset>
    
    </form>



</body>
</html>