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

    $pict = new Picture(array('data' => $b64));

    if (!empty($pict->error))
    {
            $_SESSION['alert'] = $pict->error;
            $success = -2;
    }
    else
    {
        $success = 1;
        $uploadedFile = $b64;
    }
}
?>
<script type="text/javascript">window.top.window.stopUpload(<?php echo $success; ?>,"<?php echo $uploadedFile; ?>");</script>