
<?php
phpinfo();

$printer = "\\\\192.168.2.252\\Moja305B";
$handle = printer_open($printer);
printer_set_option($handle, PRINTER_MODE, "raw");
printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_A4);
$output = "Print Contents";
printer_write($handle,$output);
printer_close($handle);
?>