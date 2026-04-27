<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:make-admin')]
#[Description('Command description')]
class MakeAdmin extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {

        \App\Models\Product::all()->each(function ($product) {
            if (str_contains($product->main_image, 'storage/')) {
                $product->main_image = str_replace('storage/', '', $product->main_image);
                $product->save();
            }
        });

        $this->info('Database paths cleaned successfully!');


        
        //
        $user = \App\Models\User::where('email', 'admin@gmail.com')->first();
        
        if ($user) {
            $user->is_admin = 1;
            $user->save();
            $this->info('User is now an admin!');
        } else {
            $this->error('User not found.');
        }
    }
}