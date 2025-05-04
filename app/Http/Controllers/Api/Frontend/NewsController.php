<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Models\CMS;
use App\Models\News;
use App\Enums\PageEnum;
use App\Helpers\Helper;
use App\Models\Setting;
use App\Enums\SectionEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class NewsController extends Controller
{
    public function index(Request $request)
    {
        $details = $request->input('details');
    
        if ($details === 'live') {
            $news = News::where('status', 'active')
                        ->where('news_type', 'live')
                        ->get();
        } elseif ($details === 'normal') {
            $news = News::where('status', 'active')
                        ->where('news_type', 'normal')
                        ->get();
        } else {
            // No details param – get both live and normal
            $news = News::where('status', 'active')
                        ->whereIn('news_type', ['live', 'normal'])
                        ->get();
        }

        $data = [
            'news' => $news
        ];
    
        return Helper::jsonResponse(true, 'Successfully', 200, $data);
    }
    
}
