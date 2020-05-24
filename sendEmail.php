<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

return function () {

    $SesClient = new Aws\Ses\SesClient([
        'version' => 'latest',
        'region'  => 'us-east-1',
        'credentials' => [
            'key' => getenv('AVS_KEY'),
            'secret' => getenv('AWS_SECRET'),
        ]
    ]);

    $result = $SesClient->sendEmail([
        'Destination' => [
            'ToAddresses' => ['artem.koval@seniordev.com'],
        ],
        'Source' => 'artem.koval.web@gmail.com',
        'Message' => [
            'Body' => [
                'Text' => [
                    'Charset' => 'UTF-8',
                    'Data' => 'Dog not found',
                ],
            ],
            'Subject' => [
                'Charset' => 'UTF-8',
                'Data' => 'Notification from aws step function',
            ],
        ]
    ]);

    return $result;
};