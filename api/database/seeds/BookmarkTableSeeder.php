<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BookmarkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		
        Model::unguard();
        DB::table('bookmarks')->delete();
		
		DB::table('bookmarks')->insert([
			'user_id' => 1,
			'title' => 'Teste de Titulo',
			'url' => 'http://www.urlteste.com.br/'
		]);
		
		Model::reguard();
    }
}
