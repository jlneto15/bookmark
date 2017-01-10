<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookmarkControllerTest extends TestCase {

	use DatabaseMigrations;

//	use WithoutMiddleware;

	public function setUp() {
		parent::setUp();
		
		$this->seed('BookmarkTableSeeder');
	}
	
	public function testIndex() {
		$user = factory(App\Models\User::class)->create(['password' => bcrypt('foo')]);
		$r = $this->get('api/bookmark', $this->headers($user));
		$r->seeJsonStructure([
			'response' => [
				'code',
				'data' => [["id", "user_id", "title", "url"]]
			]
		]);
	}

	public function testShow() {
		$user = factory(App\Models\User::class)->create(['password' => bcrypt('foo')]);
		$r = $this->get('api/bookmark/1', $this->headers($user));
		$r->seeJsonStructure([
			'response' => [
				'code',
				'data' => [
					"id", "user_id", "title", "url"
				]
			]
		]);
	}

	public function testShow400Error() {
		$r = $this->get('api/bookmark/1');
		$r->seeStatusCode(400)->seeJson([
			'error' => "token_not_provided"
		]);
	}

}
