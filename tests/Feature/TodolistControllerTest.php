<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
  public function testTodolist()
  {
    $this->withSession([
        "user" => "Ichsan",
        "todolist" => [
            [
                "id" => "1",
                "todo" => "Ichsan"
            ],
             [
                "id" => "2",
                "todo" => "Josjis"
            ]
        ]
    ])->get('/todolist')
        ->assertSeeText("1")
        ->assertSeeText("Ichsan")
        ->assertSeeText("2")
        ->assertSeeText("Josjis");
  }

  public function testAddTodoFailed()
  {
    $this->withSession([
        "user" => "Ichsan"
    ])->post("/todolist", [])
        ->assertSeeText("Todo is required");
  }

  public function testAddTodoSuccess()
  {
    $this->withSession([
        "user" => "Ichsan"
    ])->post("/todolist", [
        "todo" => "Josjis"
    ])->assertRedirect("/todolist");
  }

  public function testRemoveTodolist()
  {
      $this->withSession([
        "user" => "Ichsan",
        "todolist" => [
            [
                "id" => "1",
                "todo" => "Ichsan"
            ],
             [
                "id" => "2",
                "todo" => "Josjis"
            ]
        ]
    ])->post("/todolist/1/delete")
        ->assertRedirect("/todolist");
  }
}
