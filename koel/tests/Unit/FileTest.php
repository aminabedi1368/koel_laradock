<?php

namespace Tests\Unit;

use App\Models\File;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use SplFileInfo;
use Tests\TestCase;

class FileTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_be_instantiated()
    {
        $file = new File(__DIR__.'/../songs/full.mp3');
        $this->assertInstanceOf(File::class, $file);
        $file = new File(new SplFileInfo(__DIR__.'/../songs/full.mp3'));
        $this->assertInstanceOf(File::class, $file);
    }

    /** @test */
    public function file_info_is_retrieved_correctly()
    {
        $file = new File(__DIR__.'/../songs/full.mp3');
        $info = $file->getInfo();

        $expectedData = [
            'artist' => 'Gramatune',
            'album' => 'Gramatune Testing Vol. 1',
            'compilation' => false,
            'title' => 'Amet',
            'track' => 5,
            'disc' => 3,
            'lyrics' => "Foo\rbar",
            'cover' => [
                'data' => file_get_contents(__DIR__.'/../blobs/cover.png'),
                'image_mime' => 'image/png',
                'image_width' => 512,
                'image_height' => 512,
                'imagetype' => 'PNG',
                'picturetype' => 'Other',
                'description' => '',
                'datalength' => 7627,
            ],
            'path' => __DIR__.'/../songs/full.mp3',
            'mtime' => filemtime(__DIR__.'/../songs/full.mp3'),
            'albumartist' => '',
        ];

        $this->assertArraySubset($expectedData, $info);
        $this->assertEquals(10.083, $info['length'], '', 0.001);
    }

    /** @test */
    public function song_without_a_title_tag_has_file_name_as_the_title()
    {
        $file = new File(__DIR__.'/../songs/blank.mp3');
        $this->assertSame('blank', $file->getInfo()['title']);
    }
}
