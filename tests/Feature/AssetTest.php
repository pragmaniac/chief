<?php

namespace Tests\Feature;

use Chief\Models\Article;
use Chief\Models\Asset;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AssetTest extends TestCase
{

    use DatabaseMigrations, DatabaseTransactions;

    public function tearDown()
    {
        Artisan::call('medialibrary:clear');
    }

    /**
     * @group testing
     * @test
     */
    public function it_can_upload_an_image()
    {
        //upload a single image
        $asset = Asset::upload(UploadedFile::fake()->image('image.png'));

        $this->assertEquals($asset->getFilename(), 'image.png');
        $this->assertEquals($asset->getPath(), '/media/1/image.png');

        //upload a single image
        $asset = Asset::upload(UploadedFile::fake()->image('image2.png'));

        $this->assertEquals($asset->getFilename(), 'image2.png');
        $this->assertEquals($asset->getPath(), '/media/2/image2.png');
    }

    /**
     * @group testing
     * @test
     */
    public function it_can_upload_an_image_to_a_model()
    {
        $article = factory(Article::class)->create();

        //upload a single image
        $asset = Asset::upload(UploadedFile::fake()->image('image.png'))->attachToModel($article);

        $this->assertEquals($asset->getFilename(), 'image.png');
        $this->assertEquals($asset->getPath(), '/media/1/image.png');
        $this->assertEquals($article->asset()->first()->getFilename(), $asset->getFilename());

        //upload a single image
        $asset = Asset::upload(UploadedFile::fake()->image('image.png'));

        $this->assertEquals($asset->getFilename(), 'image.png');
        $this->assertEquals($asset->getPath(), '/media/2/image.png');
    }

    /**
     * @group testing
     * @test
     */
    public function it_can_get_all_the_media_files()
    {
        //upload a single image
        $asset = Asset::upload(UploadedFile::fake()->image('image.png'));

        $this->assertEquals($asset->getFilename(), 'image.png');
        $this->assertEquals($asset->getPath(), '/media/1/image.png');

        //upload a single image
        $asset = Asset::upload(UploadedFile::fake()->image('image2.png'));

        $this->assertEquals($asset->getFilename(), 'image2.png');
        $this->assertEquals($asset->getPath(), '/media/2/image2.png');

        $this->assertEquals(2, Asset::getAllMedia()->count());
    }

    /**
     * @group testing
     * @test
     */
    public function it_can_remove_an_image()
    {
        //upload a single image
        $asset = Asset::upload(UploadedFile::fake()->image('image.png'));

        $this->assertEquals($asset->getFilename(), 'image.png');
        $this->assertEquals($asset->getPath(), '/media/1/image.png');

        Asset::remove($asset->id);

        $this->assertEquals(0, Asset::getAllMedia()->count());
    }

//    /**
//     * @test
//     */
//    public function it_can_upload_multiple_images()
//    {
//        //upload multiple images
//        Asset::upload($request->file('images'));
//    }
//
//    /**
//     * @test
//     */
//    public function it_can_crop_an_image()
//    {
//        Asset::upload($request->file('image'))->crop(x,y,w,h);
//    }
}
