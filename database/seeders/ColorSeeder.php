<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=array(
            array('id'=>1, 'name'=>'Red', 'val'=>'#f90000', 'status'=>1,),
            array('id'=>2, 'name'=>'Green', 'val'=>'#1cc88a', 'status'=>1,),
            array('id'=>3, 'name'=>'Blue', 'val'=>'#4e73df', 'status'=>1,),
            array('id'=>4, 'name'=>'Yellow', 'val'=>'#f6c23e', 'status'=>1,),
            array('id'=>5, 'name'=>'Orange', 'val'=>'#ff5a08', 'status'=>1,),
            array('id'=>6, 'name'=>'Purple', 'val'=>'#c75ad9', 'status'=>1,),
            array('id'=>7, 'name'=>'Pink', 'val'=>'#f91b47', 'status'=>1,),
            array('id'=>8, 'name'=>'Brown', 'val'=>'#cc4336', 'status'=>1,),
            array('id'=>9, 'name'=>'Cyan', 'val'=>'#36b9cc', 'status'=>1,),
            array('id'=>10, 'name'=>'Gray', 'val'=>'#858796', 'status'=>1,),
            array('id'=>11, 'name'=>'Black', 'val'=>'#000000', 'status'=>1,),
        );

        DB::table('colors')->insert($data);
    }
}
