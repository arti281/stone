<?php

namespace App\Http\Controllers\Admin\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class SizeController extends Controller
{
    public function index(){
        $data['heading_title'] = "Size";

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => URL::to('/admin/dashboard')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Size',
            'href' => URL::to('/admin/storefront/size')
        ];

        $data['add'] = URL::to('/admin/storefront/size-form');

        $data['Sizes'] = Size::all();

        return view('admin.storefront.size', $data);
    }

    public function form(){
        $data['heading_title'] = "Size";

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => URL::to('/admin/dashboard')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Add Size',
            'href' => URL::to('/admin/storefront/size-form')
        ];

        $data['action'] = Route('save-size');
        $data['back'] = URL::to('/admin/storefront/size-form');

        return view('admin.storefront.size_form', $data);
    }

    public function save(Request $request){

        $validated = $request->validate([
            'size_name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer'
        ]);
        
        $size = Size::create([
            'size_name' => $validated['size_name'],
            'sort' => $validated['sort_order']
        ]);

        if($size){
            return redirect('admin/storefront/size')->with('success', 'Size added successfully.');
        }

        return redirect('admin/storefront/size')->with('error', 'Size not added successfully.');
    }

    public function edit($size_id){
        $data['heading_title'] = "Size";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => URL::to('/admin/dashboard')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Edit Size',
            'href' => URL::to('/admin/storefront/size-form')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Edit Size',
            'href' => URL::to('/admin/storefront/size-edit/size_id='.$size_id)
        ];

        $data['size'] = Size::where('id', $size_id)->first();
        $data['action'] = Route('update-size', $size_id);
        $data['back'] = URL::to('/admin/storefront/size-form');

        return view('admin.storefront.size_form', $data);
    }

    public function update(Request $request, $size_id){
        $validated = $request->validate([
            'size_name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer'
        ]);

        $size = Size::find($size_id);

        if (!$size) {
            return redirect('admin/storefront/size')->with('error', 'Size not found.');
        }

        $size->size_name = $validated['size_name'];
        $size->sort = $validated['sort_order'];
        $size->save();

        return redirect('admin/storefront/size')->with('success', 'Size updated successfully.');
    }

    public function delete($size_id){
        try {
            Size::where('id', $size_id)->delete();
            return redirect('admin/storefront/size')->with('success', 'Size deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }
}
