<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsApi;
use App\Models\NewsLike;
use Illuminate\Support\Facades\Cache;

class NewsApiController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function displayNews(Request $request)
    {
        $response = $this->determineMethodHandler($request);
        $apiModel = new NewsApi();
        $response['news'] = $apiModel->fetchNewsFromSource($response['sourceId']);
        $response['newsSources'] = $this->fetchAllNewsSources();
        return response()->json($response);
    }
    /**
     * @param $request
     * @return mixed
     */
    protected function determineMethodHandler($request)
    {
        if ($request->isMethod('get')) {
            $response['sourceName'] = config('app.default_news_source');
            $response['sourceId'] = config('app.default_news_source_id');
        } else {
            $request->validate([
                'source' => 'required|string',
            ]);
            $split_input = explode(':', $request->source);
            $response['sourceId'] = trim($split_input[0]);
            $response['sourceName'] = trim($split_input[1]);
        }
        return $response;
    }
    /**
     * @return mixed
     */
    public function fetchAllNewsSources()
    {
        $response = Cache::remember('allNewsSources', 22 * 60, function () {
            $api = new NewsApi;
            return $api->getAllSources();
        });
        return $response;
    }

    /**
     * return then news for API
     */
    public function sendNews(Request $request)
    {
        $response = $this->determineMethodHandler($request);
        $apiModel = new NewsApi();
        $response['news'] = $apiModel->fetchNewsFromSource($response['sourceId']);
        $response['newsSources'] = $this->fetchAllNewsSources();
        return json_encode($response);
    }


     /**
     * Get News from Country
     */
    public function getNewsFromCountry(Request $request)
    {
        $response = $request;
        $apiModel = new NewsApi();
        $response['news'] = $apiModel->fetchNewsFromCountry($response['country']);
        $response['newsSources'] = $this->fetchAllNewsSources();
        return json_encode($response);
    }

    /**
     * Like News
     */
    public function likeNews(Request $request)
    {
        $url = $request->url;
        $get_like = NewsLike::where('news_url', $url)->first();
        if($get_like) {
            $get_like->like_count = $get_like->like_count + 1;
            $get_like->save();
            return response()->json([ 'like_count' => $get_like->like_count ]);
        } else {
            $create_news_like = NewsLike::create([
                'news_url' => $url,
                'like_count' => 1,
                'dislike_count' => 0,
            ]);
            return response()->json([ 'like_count' => $create_news_like->like_count ]);
        }

    }

    /**
     * Dis Like News
     */
    public function dislikeNews(Request $request)
    {
        $url = $request->url;
        $get_like = NewsLike::where('news_url', $url)->first();
        if($get_like) {
            $get_like->dislike_count = $get_like->dislike_count + 1;
            $get_like->save();
            return response()->json([ 'dislike_count' => $get_like->dislike_count ]);
        } else {
            $create_news_like = NewsLike::create([
                'news_url' => $url,
                'like_count' => 0,
                'dislike_count' => 1,
            ]);
            return response()->json([ 'dislike_count' => $create_news_like->dislike_count ]);
        }
    }

    /**
     * Get like and dislike
     */
    public function getNewsDetail(Request $request)
    {
        $url = $request->url;
        $get_like = NewsLike::where('news_url', $url)->first();
        if($get_like){
            return response()->json($get_like);
        }
        return false;
    }
}
