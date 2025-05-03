<?php

namespace App\Enums;

enum SectionEnum: string
{
    const BG = 'bg_image';

    case HOME_BANNER = 'home_banner';
    case HOME_BANNERS = 'home_banners';
    
    case HERO = 'hero';
    case HEROS = 'heros';




    case CUSTOMER_SECTION = 'customer_section';
    case CUSTOMER_SECTIONS = 'customer_sections';

    case CONTRIBUTE_SECTION = 'contribute_section';
    case CONTRIBUTE_SECTIONS = 'contribute_sections';

    
    case HOME_ABOUT = 'home_about';
    case HOME_ABOUTS = 'home_abouts';

    case NEWS_SECTION = 'news_section';
    case NEWS_SECTIONS = 'news_sections';


    case FAQ_ITEM = 'faq_item';
    case FAQ_ITEMS = 'faq_items';
    case FAQ = 'faq';


    //Footer
    case FOOTER = 'footer';
    case SOLUTION = "solution";
    
}
