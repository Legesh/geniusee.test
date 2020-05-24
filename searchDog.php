<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

return function ($event) {

    $recognition = new Aws\Rekognition\RekognitionClient([
        'version' => 'latest',
        'region' => 'us-east-1',
        'credentials' => [
            'key' => getenv('AVS_KEY'),
            'secret' => getenv('AWS_SECRET'),
        ]
    ]);

    $result = $recognition->detectLabels([
        'Image' => [
            'S3Object' => [
                'version' => 'latest',
                'region' => 'us-east-1',
                'Bucket' => 'images-for-test-task',
                'Name' => $event['file'],
            ]
        ],
        'MaxLabels' => 10,
        'MinConfidence' => 50
    ]);

    $labels = $result->get('Labels');
    $labelsArr = array_map(function($label){
        return $label['Name'];
    }, $labels);
    if(in_array('Dog', $labelsArr)) {
        return [
            'status' => 200,
            'result' => [
                'name' => $event['file'],
                'labels' => implode(', ', $labelsArr)
            ]
        ];
    }

    return [
        'status' => 404,
        'result' => false
    ];
};