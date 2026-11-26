<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp():void
    {
        parent::setUp();

        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo("1", "Ichsan");

        $todolist = Session::get("todolist");
        foreach ($todolist as $value){
            self::assertEquals("1", $value['id']);
            self::assertEquals("Ichsan", $value['todo']);

        }
    }

    public function testGetTodolistEmpty()
    {
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testGetTodolistNotEmpty()
    {
        $expeted = [
            [
                "id" => "1",
                "todo" => "Ichsan"
            ],

            [
                "id" => "2",
                "todo" => "Josjis"
            ]
        ];

        $this->todolistService->saveTodo("1", "Ichsan");
        $this->todolistService->saveTodo("2", "Josjis");

        self::assertEquals($expeted, $this->todolistService->getTodolist());
    }

    public function testRemoveTodo()
    {
        $this->todolistService->savetodo("1", "Ichsan");
        $this->todolistService->savetodo("2", "Josjis");

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("3");

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("1");

        self::assertEquals(1, sizeof($this->todolistService->getTodolist()));

         $this->todolistService->removeTodo("2");

        self::assertEquals(0, sizeof($this->todolistService->getTodolist()));
        

    }
}
