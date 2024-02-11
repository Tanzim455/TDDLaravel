<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    // public function setUp(): void
    // {
    //     parent::setUp();

    //     $this->withoutExceptionHandling();
    // }
    public function test_register_route_has_a_view(){
        $response=$this->get('/register')
        ->assertViewIs('auth.register');
        $response->assertOk();
    }
    
    public function test_user_cannot_register_with_any_fields_blanks(){
        
        $response = $this->post(route('registeruser'),[
            'name'=>'',
             'username'=>'',
             'email'=>'',
             'password'=>''
        ]);

        $response->assertInvalid(['name','username','email','password']);
    }
    public function test_registration_must_be_done_with_unique_email(){
        
        $user=User::factory()->create()->toArray();
       $response=$this->post(route('registeruser'),$user);
     
     $response->assertInvalid(['email']);

    }
    public function test_registration_validation(){
        
        $response = $this->post(route('registeruser'),[
            'name'=>'Tanzim Ibthesam',
             'username'=>'',
             'email'=>'tanzim5gmail.com',
             'password'=>''
        ]);

        $response->assertValid(['name'])
        ->assertInvalid(['username', 'password','email']);;
    }

    public function test_user_can_register(){
        $this->withoutExceptionHandling();
    $user=User::factory()->make([
        'password'=>'password'
    ])->toArray();
    $user['password']='password';
    
     $response = $this->post(route('registeruser'),$user);
     $this->assertDatabaseHas('users',[
        'name'=>$user['name'],
         'username'=>$user['username'],
         'email'=>$user['email']
     ]);
     
     $this->assertEquals(1, User::count());
 }


}
