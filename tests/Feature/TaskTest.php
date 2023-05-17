<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;

class TaskTest extends TestCase
{
    // public function setUp(): void
    // {
    //     parent::setUp();
    //     $this->seed('FoldersTableSeeder');
    // }

    public function testSum()
    {
        $result = 2 + 2;
        $this->assertEquals(4, $result);
    }

    public function testDueDateShouldBeDate()
    {
        $response = $this->post('/folders/1/tasks/create', [
            'title' => 'sample task',
            'due_date' => 123,
        ]);

        $response->assertSessionHasErrors([
            'due_date' => '期限日には有効な日付を指定してください。',
        ]);
    }

    public function test_due_date_should_not_be_past()
    {
        $response = $this->post('/folders/1/tasks/create', [
            'title' => 'sample task',
            'due_date' => Carbon::yesterday()->format('Y/m/d'),
        ]);

        $response->assertSessionHasErrors([
            'due_date' => '期限日 には今日以降の日付を入力してください',
        ]);
    }
}
