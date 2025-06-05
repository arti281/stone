<?php

namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class Pagination extends Controller
{
    public static function pagination($results, $perPage){
        $currentPage = request()->query('page', 1);
        $products = collect($results);
        $totalCount = $products->count();
        $paginator = new LengthAwarePaginator(
            $products->forPage($currentPage, $perPage),
            $totalCount,
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        $data['pagination'] = [
            'total' => $paginator->total(),
            'perPage' => $paginator->perPage(),
            'currentPage' => $paginator->currentPage(),
            'nextPageUrl' => $paginator->nextPageUrl(),
            'lastPage' => $paginator->lastPage(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'previousPageUrl'=> $paginator->previousPageUrl(),
            'url' => function ($page) use ($paginator) {
                return $paginator->url($page);
            },
        ];

        $data['items'] = $paginator->items();

        return $data;
    }
}
