<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testRegisterSuccess()
    {
        $this->post('/api/v1/users', [
            'name' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ])->assertStatus(201)
        ->assertJson([
            "data"=>[
            "name"=>"John Doe",
            "email"=>"john.doe@gmail.com"
            ]
            ]);
        
    }

    public function testRegisterFailed()
    {
        $this->post('/api/v1/users',[
            'name' =>'',
            'email' =>'',
            'password' =>'',
            'password_confirmation' =>''
        ])->assertstatus(400)
        ->assertJson([
            "errors"=>[
                "name"=>[
                    "The name field is required."
                ],
                "email"=>[
                    "The email field is required."
                ],
                "password"=>[
                    "The password field is required."
                ]
            ]
                ]);
    }
    public function testRegisterFailedValidation()
    { 
        $this->post('/api/v1/users', [
            'name' => 'Mitchell Admin',
            'email' => 'john.doe@gmail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ])->assertStatus(400)
        ->assertJson([
            "errors"=>[
                "email"=>[
                    "The email has already been taken."
                ]
            ]
                ]);

    }
}
