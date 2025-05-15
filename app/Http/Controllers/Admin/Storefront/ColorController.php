<?php

namespace App\Http\Controllers\Admin\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class ColorController extends Controller
{
    public function index(){
        $data['heading_title'] = "Color";

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => URL::to('/admin/dashboard')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Color',
            'href' => URL::to('/admin/storefront/color')
        ];

        $data['add'] = URL::to('/admin/storefront/color-form');

        $data['colors'] = Color::all();

        return view('admin.storefront.color', $data);
    }

    public function form(){
        $data['heading_title'] = "Add Color";

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => URL::to('/admin/dashboard')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Add Color',
            'href' => URL::to('/admin/storefront/color')
        ];

        $data['action'] = Route('save-color');
        $data['back'] = URL::to('/admin/storefront/color');

        return view('admin.storefront.color_form', $data);
    }

    public function save(Request $request){

        $validated = $request->validate([
            'color_name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'hex_code' => 'nullable'
        ]);

        $color = Color::create([
            'color_name' =>$validated['color_name'],
            'code' =>$validated['hex_code'],
            'sort' =>$validated['sort_order']
        ]);

        if($color){
            return redirect('admin/storefront/color')->with('success', 'Color added successfully.');
        }

        return redirect('admin/storefront/color')->with('error', 'Color not added successfully.');
    }

    public function edit($color_id){
        $data['heading_title'] = "Color";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => URL::to('/admin/dashboard')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Edit Color',
            'href' => URL::to('/admin/storefront/color-form')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Edit Color',
            'href' => URL::to('/admin/storefront/color-edit/color_id='.$color_id)
        ];

        $data['color'] = Color::where('id', $color_id)->first();
        $data['action'] = Route('update-color', $color_id);
        $data['back'] = URL::to('/admin/storefront/color-form');

        return view('admin.storefront.color_form', $data);
    }

    public function update(Request $request, $color_id){
        $validated = $request->validate([
            'color_name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'hex_code' => 'nullable'
        ]);

        $color = Color::find($color_id);

        if (!$color) {
            return redirect('admin/storefront/color')->with('error', 'Color not found.');
        }

        $color->color_name = $validated['color_name'];
        $color->sort = $validated['sort_order'];
        $color->save();

        return redirect('admin/storefront/color')->with('success', 'Color updated successfully.');
    }

    public function delete($color_id){
        try {
            Color::where('id', $color_id)->delete();
            return redirect('admin/storefront/color')->with('success', 'Color deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }
}
