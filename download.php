<?php
session_start();
if(isset ($_SESSION["username"])) {
    sendfile("./download/bones.png");
} else {
	header("HTTP/1.1 401 Unauthorized");
    echo 'Доступ к файлу запрещен';
}

function sendfile($file) {
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
    }
}
// sdsdfdfssd =asdasd ;
// $.ajax(
//   'request_ajax_data.php',
//   {
//       success: function(data) {
//         alert('AJAX call was successful!');
//         alert('Data from the server' + data);
//       },
//       error: function() {
//         alert('There was some error performing the AJAX call!');
//       }
//    }
// );

// sdsdfdfssd =asdasd ;
// sdasd
?>