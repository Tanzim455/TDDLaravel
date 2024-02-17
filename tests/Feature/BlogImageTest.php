<?php

namespace Tests\Feature;

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogImageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    // public function test_user_can_publish_a_image(){
        
    //     $this->withoutExceptionHandling();
    //     Storage::fake('photos');
    //     $blog = Blog::factory()->make()->toArray(); 
         
    //     $response = $this->post(route('blog.store'),$blog);
    //     //Name of the image
    //      dd($blog)
    //     // $response->assertSessionHasNoErrors();
    //     // Storage::disk('photos')->assertExists('photos/' . $blog['blog_image']->hasName());
    
        
    // }
    public function test_user_can_publish_a_image()
{
    $this->withoutExceptionHandling();
    Storage::fake('photos');

    $blog = Blog::factory()->raw();

    $response = $this->post(route('blog.store'), $blog);

    $response->assertSessionHasNoErrors();
     Storage::assertExists('photo.jpg');
    // Storage::disk('photos')->assertExists('photo1.jpg');
}

}
