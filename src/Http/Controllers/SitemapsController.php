<?php
namespace Ably\Sitemap\Http\Controllers;

use Ably\Sitemap\Jobs\GenerateSitemapJob;
use Ably\Sitemap\Jobs\GenerateSitemapsIndexJob;
use Ably\Sitemap\Providers\SitemapFileProvider;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class SitemapsController extends Controller
{
    /**
     * @var SitemapFileProvider
     */
    private $fileProvider;

    /**
     * @param SitemapFileProvider $fileProvider
     */
    public function __construct(SitemapFileProvider $fileProvider)
    {
        $this->fileProvider = $fileProvider;
    }

    public function index(Request $request)
    {
        $sitemap = trim($request->getRequestUri(), '/');
    }

    public function show(Request $request)
    {
//        GenerateSitemapsIndexJob::dispatchNow();
//        GenerateSitemapJob::dispatchNow(Post::class, 2);

        $sitemap = trim($request->getRequestUri(), '/');

        $content = $this->fileProvider->provide($sitemap);

        return response($content, Response::HTTP_OK, [
            'Content-Type' => 'application/xml'
        ]);
    }
}
