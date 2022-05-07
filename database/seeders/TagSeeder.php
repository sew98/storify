<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        $tags = ['PHP', 'Laravel', 'Bootstrap', 'CSS', 'Html', 'Javascript', 'Vue'];
        $tags = ['All', 'Crime', 'Fantasy', 'Romance', 'Sci-Fi', 'Comedy', 'Mystery'];

        foreach( $tags as $tag) {
            DB::table('tags')->insert(['name' => $tag]);
        }

    }
}
