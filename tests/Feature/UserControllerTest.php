<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    //cara mengecek halaman login
   public function testLoginPage()
   {
        $this->get('/login')
            ->assertSeetext("Login");
   }

   public function testLoginPageForMember()
   {
        $this->withSession([
            "user" => "Ichsan"
        ])->get('/login')
            ->assertRedirect("/");
   }

   public function testLoginSucces()
   {
        $this->post('/login', [
            "user" => "Ichsan",
            "password" => "rahasia"
        ])->assertRedirect('/')
            ->assertSessionhas("user", "Ichsan");
   }

     public function testLoginForUserAlreadyLogin()
   {    
        $this->withSession([
            "user" => "Ichsan"
        ])->post('/login', [
            "user" => "Ichsan",
            "password" => "rahasia"
        ])->assertRedirect('/');
   }


   public function testLoginValidationError()
   {
        $this->post("/login", [])
        ->assertSeeText("User or password is required"); 
   }

   public function testLoginFailed()
   {
        $this->post('/login', [
            'user' => "wrong",
            "password" => "wrong"
        ])->assertSeeText("User or password is wrong"); 
   }

   public function testLogout()
   {
        $this->withSession([
            "user" => "Ichsan"
        ])->post('/logout')
            ->assertRedirect("/")
            ->assertSessionMissing("user");
   }

    public function testLogoutGuest()
   {
        $this->post('/logout')
            ->assertRedirect("/");
           
   }
}
