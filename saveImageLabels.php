<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

return function ($event) {
    $dynamoDB = new Aws\DynamoDb\DynamoDbClient([
        'region'  => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => getenv('AVS_KEY'),
            'secret' => getenv('AWS_SECRET'),
        ]
    ]);

    $response = $dynamoDB->putItem(array(
        'TableName' => 'dogs_images',
        'Item' => array(
            'name'  => array('S' => $event['result']['name']),
            'labels'  => array('S' => json_encode($event['result']['labels']))
        )
    ));

    return $response;
};