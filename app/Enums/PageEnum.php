<?php

namespace App\Enums;

enum PageEnum: string
{
    const AUTH  = 'login';
    case HOME   = 'home';
    case COMMON = 'common';


    case FAQ = 'faq';

    case NEWS = 'news';
}
