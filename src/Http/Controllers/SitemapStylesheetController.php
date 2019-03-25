<?php

namespace Ably\Sitemap\Http\Controllers;

use Illuminate\Routing\Controller;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class SitemapStylesheetController extends Controller
{
    public function show()
    {
        return view('sitemap::stylesheet');
    }
}
