
<?php
require_once '../private/class/CookiesHistory.php';

setcookie("data", '', time() - 3600, '/');

session_start();
$user = new CookiesHistory();
$user->setUserID(trim($_SESSION['user_id']));
$user->DeleteByUserID();


unset($_SESSION['logged']);
unset($_SESSION['user_id']);
unset($_SESSION["user_type"]);
unset($_SESSION['org_id']);
session_destroy();
ob_end_clean();

echo ("<script>
sessionStorage.clear();
localStorage.removeItem('user_type');
localStorage.clear();
location.href = 'index.php'
</script>");


?>