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
    // public function index(Request $request)
    // {
    //     $details = $request->input('details');

    //     if ($details === 'live') {
    //         $news = News::where('status', 'active')
    //                     ->where('news_type', 'live')
    //                     ->get();
    //     } elseif ($details === 'normal') {
    //         $news = News::where('status', 'active')
    //                     ->where('news_type', 'normal')
    //                     ->get();
    //     } else {
    //         // No details param – get both live and normal
    //         $news = News::where('status', 'active')
    //                     ->whereIn('news_type', ['live', 'normal'])
    //                     ->get();
    //     }

    //     $data = [
    //         'news' => $news
    //     ];

    //     return Helper::jsonResponse(true, 'Successfully', 200, $data);
    // }





    public function index(Request $request)
    {
        $details = $request->input('details'); // e.g., "live/2" or "normal/1"

        $query = News::where('status', 'active');

        if ($details) {
            $parts = explode('/', $details);
            $type = $parts[0] ?? null;
            $limit = isset($parts[1]) ? (int)$parts[1] : null;

            if (in_array($type, ['live', 'normal'])) {
                $query->where('news_type', $type);
            }

            if ($limit) {
                $query->limit($limit);
            }
        } else {
            $query->whereIn('news_type', ['live', 'normal']); // default: all active
        }

        $news = $query->get();

        return Helper::jsonResponse(true, 'Successfully', 200, ['news' => $news]);
    }
}
