<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Towns;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getTown(Request $request)
    {
        $request->validate([
            'region_code' => 'required|exists:regions,code',
        ]);
        $towns = Towns::where('region_code', $request->get('region_code'))->get()->toArray();
        return [
            'status' => 200,
            'message' => 'successful',
            'data'=> $towns
        ];
    }

    public function getArea(Request $request)
    {
        $request->validate([
            'town_code' => 'required|exists:towns,code',
        ]);
        $towns = Area::where('town_code', $request->get('town_code'))->get()->toArray();
        return [
            'status' => 200,
            'message' => 'successful',
            'data'=> $towns
        ];
    }
}
