<?php
require(__DIR__ . "/crest/crest.php");

date_default_timezone_set('Asia/Dubai');

function logData($logfile, $data)
{
    date_default_timezone_set('Asia/Kolkata');

    $datePath = date('Y/m/d');
    $logDir = __DIR__ . '/logs/' . $datePath;

    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }

    $logFile = $logDir . '/' . $logfile . '.log';

    file_put_contents($logFile, date('Y-m-d H:i:s') . " - $data\n", FILE_APPEND);
}

function updateItem($entityTypeId, $leadId, $leadData)
{
    $response = CRest::call('crm.item.update', [
        'entityTypeId' => $entityTypeId,
        'id' => $leadId,
        'fields' => $leadData
    ]);

    return $response['result'];
}

function getDownloadUrl($itemId)
{
    return urlencode('https://apps.mondus.group/owners-db-pdf-mapping/download-pdf.php?id=' . $itemId);
}
