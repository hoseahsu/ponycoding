<?php

$rowData = file_get_contents('php://input', 'r');
$rowData = json_decode($rowData, true);

$output = '';
$type = $_GET['type'];
$branch = $_GET['branch'];
$source = $_GET['source'];

logg($source . ':' . $rowData['user_name'] . " commit to branch:" . $rowData['ref'], $source);
if ($rowData['ref'] == 'refs/heads/' . $branch) {
    if ('gitlab' == $type) {
        if ($source == 'www') {
            exec('bash pull.sh', $output);
        }
        // $output = str_replace("|", "    \n    ", $output);
    }
    logg($type . ' ' . $source . " output:\n\t\t" . implode("\n\t\t", $output) . "\n\n", $source);
}

function logg($data, $name)
{
    $text = '[' . date('Y-m-d H:i:s') . '] ' . $data . "\n";
    file_put_contents('../log/' . $name . '_' . date('ym') . '.log', $text, FILE_APPEND);
}
