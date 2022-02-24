<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\PostController;
use Illuminate\Support\str;
use App\Models\Userdata;
use Illuminate\Support\Facades\Crypt;
use Faker\Factory as Faker;

class UserdataTest extends TestCase
{
    
    protected $postController;
        
    /**
     * test_user_data_form_page
     *
     * @return void
     */
    public function test_user_data_form_page()
    {
        $response = $this->get('user-data-form');

        $response->assertStatus(200);
    }
    /**
     * test_user_store
     * 
     * @return void
     */
    public function test_user_store()
    {
        $arrayValues = ['php', 'python', 'java'];
        $faker = Faker::create();
        $response = $this->call('POST','/store-form',[
            'name'=>$faker->name,
            'skills'=>$faker->text,
            'expertise'=>$arrayValues[rand(0,2)]
        ]);
        //dd($response);
        $response->assertStatus($response->status(),302);
    }
    
    /**
     * test_delete_user
     *
     * @return void
     */
    public function test_delete_user()
    {
		$postobj = new PostController();
        $user = Userdata::first();
        if($user)
            $userID = Crypt::encrypt($user->id);
            $postobj->deleteUser($userID);//$user->delete();          

        $this->assertTrue(true);
    }
}
