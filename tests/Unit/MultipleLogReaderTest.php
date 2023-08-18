<?php

use Opcodes\LogViewer\Facades\LogViewer;

it('continues reading when one file cannot be read', function () {
    $files = [
        generateLogFile(randomContent: true),
        generateLogFile(randomContent: true),
        generateLogFile(randomContent: true),
    ];

    $filesFound = LogViewer::getFiles();
    expect($filesFound->count())->toBe(3);

    chmod($files[1]->path, 0333); // prevent reading

    try {
        $filesFound->logs()->scan();

        $this->assertTrue(true);
    } catch (\Exception $exception) {
        $this->fail('Exception thrown: '.$exception->getMessage());
    }
})->skipOnWindows();
