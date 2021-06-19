<!DOCTYPE HTML>
<html>
<head>
<style>
</style>
</head>
<body>


  <?php

 $birthErr = $nameErr = $emailErr = $genderErr = $websiteErr =$error= "";
 $birthDate = $birthMonth = $birthYear = $name = $email = $gender = $comment = $website = "";
 $username=$password="";
 $usernameErr=$passwordErr="";
$confirmpassword="";
$confirmpasswordErr="";
$flag=1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
    $flag=0;
  } else {

       $name = test_input($_POST["name"]);

      if (!preg_match("/^[a-zA-Z-. ]*$/",$name)) {
         $nameErr = "Only letters and white space allowed";
         $flag=0;
       }
    else  {
             if(str_word_count($name)<2)
          {
           $nameErr = "Name must contains at least two words ";
           $flag=0;

          }
      else {
        $name = test_input($_POST["name"]);
      }
    }
  }


  if (empty($_POST["birthDate"]) || empty($_POST["birthMonth"]) || empty($_POST["birthYear"])) {
    $birthErr = "Date Month and Year is required";
    $flag=0;
  } else {

    $birthDate=test_input($_POST["birthDate"]);
    $birthMonth=test_input($_POST["birthMonth"]);
    $birthYear=test_input($_POST["birthYear"]);

    if(!is_numeric($birthDate))
    {
      $birthErr="Please input Numeric Date";
      $flag=0;
    }
    else {

      if(!is_numeric($birthMonth))
      {
          $birthErr="Please input Numeric month";
          $flag=0;
      }
      else {
        if(!is_numeric($birthYear))
        {
          $birthErr="Please input Numeric Year";
          $flag=0;
        }
        else {
          if($birthDate>31 || $birthDate<1)
          {
              $birthErr=" Input Date between 1 to 31";
              $flag=0;
          }
          }
        }

        
      }
    }



    if (empty($_POST["username"])) {
      $usernameErr = "User Name is required";
      $flag=0;
    }
    else {
     $username = test_input($_POST["username"]);

      if (!preg_match("/^[a-zA-Z-. ]*$/",$username)) {
         $usernameErr = "Only letters and white space allowed";
         $flag=0;
       }
       else {
         if(strlen($username)<2)
         {
            $usernameErr = "Name must contains at least two character ";
            $flag=0;
         }
       }
    }

    if(!empty($_POST["password"]) && ($_POST["password"] == $_POST["confirmpassword"])) 
    {
    $password = test_input($_POST["password"]);
    $confirmpassword = test_input($_POST["confirmpassword"]);
    if (strlen($_POST["password"]) < '8') 
    {
        $passwordErr = "Your Password Must Contain At Least 8 Characters!";
    }
    elseif(!preg_match("#[0-9]+#",$password)) 
    {
        $passwordErr = "Your Password Must Contain At Least 1 Number!";
   
else 
{
     $passwordErr = "Please enter password   ";
}


    if (empty($_POST["gender"])) {
      $genderErr = "Gender is required";
      $flag=0;
    } else {
      $gender = test_input($_POST["gender"]);
    }




    }

    if(isset($_POST["submit"]))
    {
      if(file_exists('data.json') && $flag==1)
      {

           $current_data = file_get_contents('data.json');
           $array_data = json_decode($current_data, true);
           $extra = array(
                'name'               =>     $name,
                'email'           =>     $email,
                'username'       =>    $username,
                'password'       =>    $password,
                'confirmpassword'       =>    $confirmpassword,
                'birthday'       =>    $birthDate . '/' . $birthMonth . '/' . $birthYear,
                'gender'       =>    $gender,
           );
           $array_data[] = $extra;
           $final_data = json_encode($array_data);
           if(file_put_contents('data.json', $final_data))
           {
                $message = "<label class='text-success'>File Appended Success fully</p>";
           }
      }
      else
      {
           $error = 'JSON File not exits';
      }
     }










}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>LAB TASK 3</h2>
<p><span class="error">* required field</span></p>
<form style="border:3px; border-style:solid; border-color:gray; padding: 1em;" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
   E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
  User Name: <input type="text" name="username" value="<?php echo $username;?>">
  <span class="error">* <?php echo $usernameErr;?></span>
  <br><br>
  Password: <input type="text" name="password" value="<?php echo $password;?>">
  <span class="error">* <?php echo $passwordErr;?></span>
  <br><br>

  Comfirm Password: <input type="text" name="confirmpassword" value="<?php echo $confirmpassword;?>">
  <span class="error">* <?php echo $confirmpasswordErr;?></span>
  <br><br>


  Date of Birth: <input type="text" size="1" placeholder="dd" name="birthDate" value="<?php echo $birthDate; ?>"> /
  <input type="text" size="1" placeholder="mm" name="birthMonth" value="<?php echo $birthMonth; ?>"> /
  <input type="text" size="2" placeholder="yyyy" name="birthYear" value="<?php echo $birthYear; ?>">
  <span class="error">* <?php echo $birthErr;?></span>

  <br><br>
  Gender:
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">Male
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="other") echo "checked";?> value="other">Other
  <span class="error">* <?php echo $genderErr;?></span>
  <br><br>
  



  <input type="submit" name="submit" value="Submit" class="btn btn-info" />
  <input type="reset" value="Reset">
</form>