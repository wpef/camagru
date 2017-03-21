<?php

include_once("../config/inc.php");

define('DIR', ROOT . "photos/");

$success = 0;
$file = $_FILES['uploaded_file'];

if (empty($file))
{
    $success = -1;
    $_SESSION['alert'] = "File not found";
}
else
{
    $b64 = "data:".$file['type'].';base64,';
    $b64 .= base64_encode(file_get_contents($file['tmp_name']));
}
?>
<script type="text/javascript">window.top.window.stopUpload(<?php echo $success; ?>,"<?php echo $b64; ?>");</script>