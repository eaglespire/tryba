<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use App\Models\ThemeSliders;
use App\Models\ThemeFeature;
use App\Models\Storefront;
use Image;
use Str;

class importDemo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $theme;
    public function __construct($theme)
    {
        $this->theme=$theme;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = Storefront::findOrFail($this->theme);
        if($data->theme_id==1){
            $data->color = "#ffd877";
            $data->text_color = "#001e57";
            $data->welcome_status = 1;
            $data->welcome_title = "Find products for your Shop Store";
            $data->welcome_message = "Tryba enables you to easily set up your storefront";
            $data->save();
        }elseif($data->theme_id==2){
            $welcome_filename='welcome'.time().'.jpg';
            $data->welcome_title = "100%";
            $data->welcome_title2 = "Origin Coffee";
            $data->welcome_message = "Welcome to Coffee Stores";
            File::copy('asset/themes/2/sliders/coffee-01.jpg', 'asset/profile/'.$welcome_filename);
            $data->welcome_image=$welcome_filename;
            $data->save();
            foreach(getThemeSliders($this->theme) as $val){
                $val->status=0;
                $val->save();
            }
            $slide = new ThemeSliders();
            $slide1_filename='slide'.time().'.jpg';
            $slide->title1 = 'Lavazza 100% Arabica coffee beans';
            $slide->title2 = 'Lavazza 100% Arabica coffee beans is a blend of beans with the highest quality. The beans has been carefully selected and evenly roasted to produce a coffee with a smooth flavor and a tempting aroma.';
            $slide->slug = Str::random(16);
            $slide->store_id = $this->theme;
            File::copy('asset/themes/2/sliders/coffee-02.jpg', 'asset/profile/'.$slide1_filename);
            $slide->image=$slide1_filename;
            $slide->save();

            $slide = new ThemeSliders();
            $slide2_filename='slide'.time().'.jpg';
            $slide->title1 = 'Lavazza 100% Arabica coffee beans';
            $slide->title2 = 'Lavazza 100% Arabica coffee beans is a blend of beans with the highest quality. The beans has been carefully selected and evenly roasted to produce a coffee with a smooth flavor and a tempting aroma.';
            $slide->slug = Str::random(16);
            $slide->store_id = $this->theme;
            File::copy('asset/themes/2/sliders/coffee-03.jpg', 'asset/profile/'.$slide2_filename);
            $slide->image=$slide2_filename;
            $slide->save();
        }
    }
}
