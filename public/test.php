<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
<script>
    if(!window.location.href.includes('php')){
        alert('ok');
        alert(window.location.href);

    }
</script>

</body>
</html>

<?php

session_start();
echo $_SESSION['org_id']."<br>";
// echo $_SESSION['recovery_phone']."<br>";
// echo $_SESSION['recovery_user_id']."<br>";
// echo $_SESSION['recovery_name']."<br>";
// echo $_SESSION['recovery_email']."<br>";
// echo $_SESSION['phone_digits'];
// echo substr($_SESSION['recovery_phone'],-4);

$x = '/^(?=.*[a-z_.])(?=.*[A-Z_.])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z_.\d@$!%*?&]{5,20}$/';

echo preg_match($x, 'Ah.med@naser1') ? "sa7" : "la2";
?>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/popper.min.js"></script>
<!-- <script>
    $.ajax(`api.php?section=branch_services&do=get_count_br_services_branch`, {
        method: `POST`,
        data: {},
        success: function(data, textStatus, jqXHR) {
            console.log("Output: data", data)

        }
    })
</script> -->