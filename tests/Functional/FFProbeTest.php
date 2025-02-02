<?php

namespace Tests\FFMpeg\Functional;

use FFMpeg\FFProbe;

class FFProbeTest extends FunctionalTestCase
{
    public function testProbeOnFile()
    {
        $ffprobe = FFProbe::create();
        $this->assertGreaterThan(0, count($ffprobe->streams(__DIR__ . '/../files/Audio.mp3')));
    }

    public function testValidateExistingFile()
    {
        $ffprobe = FFProbe::create();
        $this->assertTrue($ffprobe->isValid(__DIR__ . '/../files/sample.3gp'));
    }


    public function testValidateNonExistingFile()
    {
        $ffprobe = FFProbe::create();
        $this->assertFalse($ffprobe->isValid(__DIR__ . '/../files/WrongFile.mp4'));
    }

    public function testProbeOnNonExistantFile()
    {
        $this->expectException('\FFMpeg\Exception\RuntimeException');

        $ffprobe = FFProbe::create();
        $ffprobe->streams('/path/to/no/file');
    }

    public function testProbeOnRemoteFile()
    {
        $ffprobe = FFProbe::create();
        $this->assertGreaterThan(0, count($ffprobe->streams('http://vjs.zencdn.net/v/oceans.mp4')));
    }

    public function testLongProbeOnFile()
    {
        $ffprobe = FFProbe::create(array(
            'analyzeduration' => 5000000000,
            'probesize' => 1000000000,
        ));
        $this->assertGreaterThan(0, count($ffprobe->streams(__DIR__ . '/../files/Audio.mp3')));
    }
}
