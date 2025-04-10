<?php
require(__DIR__ . "/utils.php");

header('Content-Type: application/json');

define('OWNERS_DATA_ENTITY_TYPE_ID', 1058);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;

    logData('event', "Received POST Data: " . print_r($data, true));

    $itemId = $data['data']['FIELDS']['ID'] ?? null;
    $entityTypeId = $data['data']['ENTITY_TYPE_ID'] ?? null;

    if ($entityTypeId != OWNERS_DATA_ENTITY_TYPE_ID) {
        exit;
    }

    if (!$itemId) {
        logData('error', "Missing Lead ID in POST data.");
        echo json_encode(['error' => 'Missing Lead ID']);
        exit;
    }

    try {
        $downloadUrl = getDownloadUrl($itemId);

        $fields = [
            'ufCrm7_1744276933601' => $downloadUrl
        ];

        updateItem($entityTypeId, $itemId, $fields);

        logData('event', "Successfully generated URL and prepared fields for item $itemId");

        echo json_encode(['success' => true, 'itemId' => $itemId, 'fields' => $fields]);
    } catch (Exception $e) {
        logData('error', "Error Fetching Lead Data: " . $e->getMessage());
        echo json_encode(['error' => 'Lead Fetch Error', 'details' => $e->getMessage()]);
        exit;
    }
} else {
    logData('error', "Invalid Request Method. Expected POST, received: " . $_SERVER['REQUEST_METHOD']);
    echo json_encode(['error' => 'Invalid Request Method', 'details' => 'Use POST']);
    exit;
}
