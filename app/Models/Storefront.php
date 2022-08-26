<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Storefront extends Model {
    use UsesUuid;
    protected $table = "storefront";
    protected $guarded = [];
    protected $casts = [
        'working_time' => 'array',
        'vacation_time' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function getState()
    {
        return $this->belongsTo(Shipstate::class, 'state');
    }           
    public function getCity()
    {
        return $this->belongsTo(Shipcity::class, 'city');
    }    
    public function getMenus()
    {
        return Menu::wherestore_id($this->id)->first();
    }
       
    public static function themes()
    {
        $arr = [           
            '1' => [
                'img_path' => asset('asset/themes/1/preview.jpg'),
            ],  
            '2' => [
                'img_path' => asset('asset/themes/2/preview2.png'),
            ],          
        ];
        return $arr;
    }
    public static function StoreFrontThemes()
    {
        $arr = [           
            '1' => [
                'img_path' => asset('asset/themes/storefront/1/preview.png'),
            ],  
            '2' => [
                'img_path' => asset('asset/themes/storefront/2/preview.png'),
            ], 
            '3' => [
                'img_path' => asset('asset/themes/storefront/3/preview.png'),
            ],
            '5' => [
                'img_path' => asset('asset/themes/storefront/5/preview.png'),
            ],
            '6' => [
                'img_path' => asset('asset/themes/storefront/6/preview.png'),
            ],           
        ];
        return $arr;
    }  
    public static function template($id)
    {
        if($id==1){
            $arr = [           
                'home_page' => [
                    'slider' => [
                        'status' => 1,
                        'limit' => 4,
                    ],
                    'blog' => [
                        'status' => 1,
                        'limit' => 3,
                        'title' => "Latest Blog Posts",
                        'body' => "Get latest news",
                    ],
                    'review' => [
                        'status' => 1,
                        'limit' => 3,
                        'title' => "Our Clients Testimonials",
                        'body' => "What our customers are saying about us",
                    ],
                    'services' => [
                        'status' => 1,
                        'limit' => 3,
                        'title' => "Our Services",
                        'body' => "Learn about what we offer",
                    ],
                ],
                'config' => [
                    'sliders' => 1,
                    'features' => 0,
                    'statistics' => 0,
                    'menu' => 1,
                    'footer' => [
                        'quick_links' => 0,
                        'show_brands' => 0,
                        'other_pages' => 0,
                        'copy_right' => 0,
                    ]
                ]        
            ];
        }else if($id==2){
            $arr = [           
                'home_page' => [
                    'slider' => [
                        'status' => 1,
                        'limit' => 4,
                    ],
                    'blog' => [
                        'status' => 1,
                        'limit' => 3,
                        'title' => "Latest Blog Posts",
                        'body' => "Get latest news",
                    ],
                    'review' => [
                        'status' => 1,
                        'limit' => 3,
                        'title' => "Our Clients Testimonials",
                        'body' => "What our customers are saying about us",
                    ],
                    'services' => [
                        'status' => 1,
                        'limit' => 3,
                        'title' => "Our Services",
                        'body' => "Learn about what we offer",
                    ],
                    'team' => [
                        'status' => 0,
                        'limit' => 3,
                        'title' => "Our Team",
                        'body' => "Professionals to get the job done",
                    ],
                    'statistics' => [
                        'status' => 0,
                        'limit' => 4,
                        'title' => "Our statistics",
                        'body' => "Our work experience",
                    ],
                    'header' => [
                        'title' => null,
                        'body' => null,
                        'button_status' => 0,
                        'button_link' => null,
                        'button_text' => null,
                    ]
                ],
                'config' => [
                    'sliders' => 0,
                    'features' => 1,
                    'statistics' => 1,
                    'menu' => 1,
                ],          
            ];
        }
        return $arr;
    }  
    public static function working_hour()
    {
        $arr = [
            'mon' => [
                'start' => '12:00AM',
                'end' => '11:00PM',
                'status' => 0,
            ],            
            'tue' => [
                'start' => '12:00AM',
                'end' => '11:00PM',
                'status' => 0,
            ],            
            'wed' => [
                'start' => '12:00AM',
                'end' => '11:00PM',
                'status' => 0,
            ],                       
            'thu' => [
                'start' => '12:00AM',
                'end' => '11:00PM',
                'status' => 0,
            ],            
            'fri' => [
                'start' => '12:00AM',
                'end' => '11:00PM',
                'status' => 0,
            ],              
            'sat' => [
                'start' => '12:00AM',
                'end' => '11:00PM',
                'status' => 0,
            ],             
            'sun' => [
                'start' => '12:00AM',
                'end' => '11:00PM',
                'status' => 0,
            ],            
        ];
        return $arr;
    }    
    public static function menu()
    {
        $arr = [
            [
                "text"=>"Home",
                "href"=>"",
                "icon"=>"empty",
                "target"=>"_self",
                "title"=>"",
                "type"=>"home"
            ],  
            [
                "text"=>"Blog",
                "href"=>"",
                "icon"=>"empty",
                "target"=>"_self",
                "title"=>"",
                "type"=>"blog"
            ], 
            [
                "text"=>"Our Team",
                "href"=>"",
                "icon"=>"empty",
                "target"=>"_self",
                "title"=>"",
                "type"=>"our_team"
            ], 
            [
                "text"=>"Testimonials",
                "href"=>"",
                "icon"=>"empty",
                "target"=>"_self",
                "title"=>"",
                "type"=>"testimonials"
            ], 
            [
                "text"=>"FAQ",
                "href"=>"",
                "icon"=>"empty",
                "target"=>"_self",
                "title"=>"",
                "type"=>"faq"
            ], 
            [
                "text"=>"Products",
                "href"=>"",
                "icon"=>"empty",
                "target"=>"_self",
                "title"=>"",
                "type"=>"products"
            ], 
            [
                "text"=>"Services",
                "href"=>"",
                "icon"=>"empty",
                "target"=>"_self",
                "title"=>"",
                "type"=>"services"
            ]
        ];
        return $arr;
    }

}
