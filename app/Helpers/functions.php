<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;
use App\Domain\Games\Entities\Games;

function pagination($listItem, $array)
{
    return new LengthAwarePaginator(
        $array,
        $listItem->total(),
        $listItem->perPage(),
        $listItem->currentPage(),
        [
            'path' => Request::url(),
            'query' => [
                'page' => $listItem->currentPage()
            ]
        ]
    );
}

function slug($urlString)
{
    $urlString = preg_replace('/[áàãâä]/ui', 'a', $urlString);
    $urlString = preg_replace('/[éèêë]/ui', 'e', $urlString);
    $urlString = preg_replace('/[íìîï]/ui', 'i', $urlString);
    $urlString = preg_replace('/[óòõôö]/ui', 'o', $urlString);
    $urlString = preg_replace('/[úùûü]/ui', 'u', $urlString);
    $urlString = preg_replace('/[ç]/ui', 'c', $urlString);
    $urlString = preg_replace('/[^a-z0-9]/i', '-', $urlString);
    $urlString = preg_replace('/-+/', '-', $urlString);
    $urlString = strtolower($urlString);
    return $urlString;
}

function generateSlug($urlString, $model)
{
    if (!$urlString) return null;
    $slug = $urlString;
    $urlString = slug($urlString);
    $count = 1;
    $slug = slug($slug);
    
    while (
        $model::where('slug', $slug)
        ->withTrashed()
        ->count() > 0
    ) {
        $slug = $urlString . '-' . $count;
        $count++;
    }
 
    $urlString = $slug;
    return $urlString;
}
