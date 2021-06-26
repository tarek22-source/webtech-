<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>


  </head>
  <body>

<?php
$email=$emailErr= "";
$msg=$msg1=$msg2="";

 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
      $emailErr = "Email is required";

    }

     else {
      $email = test_input($_POST["email"]);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";

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


  <?php
    include("head.php");
    ?>

    <form style="border:3px; border-style:solid; border-color:gray; padding: 1em;" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

  Enter your E-mail: <input type="text" name="email" value="<?php echo $email;?>">

   <span class="error">* <?php echo $emailErr;?></span>

  <table align="center">

        <?php if(isset($msg1)){?>
          <tr>
           <td colspan="2" align="center" valign="top"><?php  echo $msg2;?> </td>
          </tr>

         <?php } ?>

         </table>

         

   <br><br>
   <input type="submit" name="submit" value="Submit" class="btn btn-info" />
 </form>

 <?php
 include("foot.php");
  ?>
  </body>
</html>