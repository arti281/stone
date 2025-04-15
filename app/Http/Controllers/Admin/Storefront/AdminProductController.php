<?php

namespace App\Http\Controllers\Admin\Storefront;

use Exception;
use App\Models\Size;
use App\Models\Color;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use App\Models\Admin\Storefront\Product\Product;
use App\Http\Controllers\Admin\Common\Pagination;
use App\Models\Admin\Storefront\Category\Category;
use App\Models\Admin\Storefront\Product\ProductImage;
use App\Models\Admin\Storefront\Product\ProductPrice;
use App\Models\Admin\Storefront\Product\ProductFilter;
use App\Models\Admin\Storefront\Product\ProductReward;
use App\Models\Admin\Storefront\Product\ProductSpecial;
use App\Models\Admin\Storefront\Product\ProductCategory;

// create new manager instance with desired driver
use App\Models\Admin\Storefront\Product\ProductDiscount;
use App\Models\Admin\Storefront\Product\ProductDownload;
use App\Models\Admin\Storefront\Product\ProductOtherLink;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {

        $data['heading_title'] = "Products";

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => URL::to('/admin/dashboard')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Products',
            'href' => URL::to('/admin/storefront/product')
        ];

        $data['add'] = URL::to('/admin/storefront/product-form');

        // Filter
        $data['product_name'] = $request->query('product_name') ?? null;
        $data['model'] = $request->query('model') ?? null;
        $data['price'] = $request->query('price') ?? null;
        $data['quantity'] = $request->query('quantity') ?? null;
        $data['status'] = $request->query('status') ?? 1;

        // Pagination
        $results = Product::getProducts($request);
        $perPage = 20;
        $paginator = Pagination::pagination($results, $perPage);
        $data['products'] = $paginator['items'];
        $data['pagination'] =  $paginator['pagination'];

        $data['colors'] = Color::all();
        $data['sizes'] = Size::all();
        $data['product_variation_route'] = route('admin-addVariation');
        $data['page_url'] = URL::to('/admin/storefront/product');

        return view('admin.storefront.product', $data);
    }

    public function form()
    {

        $data['heading_title'] = "Products";

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => URL::to('/admin/dashboard')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Products',
            'href' => URL::to('/admin/storefront/product')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Add Product',
            'href' => URL::to('/admin/storefront/product-form')
        ];

        $data['categories'] = Category::getCategory();
        $data['stock_status'] = DB::table('stock_status')->get();

        $data['action'] = route('admin-product-save');
        $data['back'] = URL::to('/admin/storefront/product');
        $data['save'] = URL::to('/admin/storefront/product-save');

        return view('admin.storefront.product_form', $data);
    }

    public function save(Request $request)
    {
        $data = $request->request;

        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'tag' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keyword' => 'nullable|string|max:255',
            'model' => 'required|nullable|string|max:255',
            'quantity' => 'required|integer',
            'minimum' => 'nullable|integer',
            'subtract' => 'nullable|integer',
            'stock_status_id' => 'nullable|integer',
            'date_available' => 'nullable|date',
            'shipping' => 'nullable|boolean',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'length_class_id' => 'nullable|integer',
            'weight' => 'nullable|numeric',
            'weight_class_id' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'retail_price' => 'required|nullable|numeric',
            'mrp' => 'required|nullable|numeric'
        ]);

        try {
            // Inserting a new product using the save method
            if (null !== $data->get('product_name') || null !== $data->get('model')) {

                $product = new Product();
                $product->product_name = $data->get('product_name') ?? '';
                $product->product_description = $data->get('description') ?? '';
                $product->tag = $data->get('product_tag') ?? '';
                $product->meta_title = $data->get('meta_tag_title') ?? '';
                $product->meta_description = $data->get('meta_description') ?? '';
                $product->meta_keyword = $data->get('meta_tag_keyword') ?? '';
                $product->model = $data->get('model') ?? '';
                $product->quantity = (int)$data->get('quantity') ?? '';
                $product->minimum = (int)$data->get('minimum') ?? '';
                $product->subtract = (int)$data->get('subtract') ?? '';
                $product->stock_status_id = $data->get('stock_status_id') ?? null;
                $product->date_available = now();
                $product->shipping = true;
                $product->length = $data->get('length') ?? '';
                $product->width = $data->get('width') ?? '';
                $product->height = $data->get('height') ?? '';
                $product->length_class_id = $data->get('length_class_id') ?? null;
                $product->weight = $data->get('weight') ?? '';
                $product->weight_class_id = $data->get('weight_class_id') ?? null;
                $product->image = $imageName ?? null;
                $product->slug = Str::slug($data->get('product_name'));
                $product->status = $data->get('status');
                $product->sort_order = (int)$data->get('sort_order') ?? '';
                $product->save();
            }

            // last product id
            $product_id = $product->id;

            if (isset($product_id)) {

                // Upload product image
                $file = $request->file('image'); // get files
                if(null !== $file){
                    $folderPath = public_path('image/products');
                    if (!file_exists($folderPath)) {
                        mkdir($folderPath, 0777, true);
                    }
                    if(!file_exists($folderPath.'/'.$product_id)){
                        mkdir($folderPath.'/'.$product_id, 0777, true);
                    }
                    $imageName = time() . '_' . Str::uuid();
                    $mimeType = '.jpg';
                    $imagePath = public_path('image/products/'.$product_id.'/') . $imageName . $mimeType;
                    if (!file_exists($imagePath)) {
                        $file->move(public_path('image/products/'.$product_id.'/'), $imageName . $mimeType);
                    }
                    
                    // image cache
                    $cachePath = public_path('image/cache/products');
                    if(!file_exists($cachePath.'/'.$product_id)){
                        mkdir($cachePath.'/'.$product_id, 0777, true);
                    }
                    $imageManager = ImageManager::imagick()->read($imagePath);
                    $imageCachePath = public_path('image/cache/products/'.$product_id.'/') . $imageName . $mimeType;
                    if(!file_exists($imageCachePath)){
                        $size = [700,500,300,100];
                        for ($i=0; $i < count($size); $i++) { 
                            // resize to 300 x 200 pixel
                            $imageManager->scaleDown(height:$size[$i]);
                            $imageManager->save(public_path('image/cache/products/'.$product_id.'/'. $imageName .'_'. $size[$i] .'x'. $size[$i] . $mimeType));
                        }
                    }
                    // upload product image
                    $product_update = Product::where('id', $product_id)->first();
                    $product_update->image = $imageName . $mimeType ?? null;
                    $product_update->update();
                    // End Upload product image
                }

                // product to category
                if (null !== $request->input('category_ids')) {
                    foreach($request->input('category_ids', []) as $category_id) {
                        $category = new ProductCategory();
                        $category->product_id = (int)$product_id;
                        $category->category_id = (int)$category_id;
                        $category->save();
                    }
                }

                // product price 
                if (!empty($validatedData['retail_price']) && !empty($validatedData['mrp'])) {
                    $price = new ProductPrice();
                    $price->product_id = $product_id;
                    $price->price = $data->get('retail_price') ?? '';;
                    $price->mrp = $data->get('mrp') ?? '';;
                    $price->save();
                }

                // product discount
                if (null !== $data->get('discount_price') || null !== $data->get('discount_price')) {
                    $discount = new ProductDiscount();
                    $discount->product_id = $product_id;
                    $discount->customer_group_id = null;
                    $discount->quantity = null;
                    $discount->priority = null;
                    $discount->price = null;
                    $discount->start_date = null;
                    $discount->close_date = null;
                    $discount->save();
                }

                // product special
                if (null !== $data->get('special_price') || null !== $data->get('special_price')) {
                    $special = new ProductSpecial();
                    $special->product_id = $product_id;
                    $special->customer_group_id = null;
                    $special->priority = null;
                    $special->price = 0.0000;
                    $special->start_date = null;
                    $special->close_date = null;
                    $special->save();
                }

                // product downloads
                if (null !== $data->get('download_id') || null !== $data->get('download_id')) {
                    $download = new ProductDownload();
                    $download->product_id = $product_id;
                    $download->download_id = 0;
                    $download->save();
                }

                // Product Reward
                if (null !== $data->get('point') || null !== $data->get('point')) {
                    $reward = new ProductReward();
                    $reward->product_id = $product_id;
                    $reward->point = 0;
                    $reward->save();
                }

                // Product Reward
                if (null !== $data->get('filter_id') || null !== $data->get('filter_id')) {
                    $filter = new ProductFilter();
                    $filter->product_id = $product_id;
                    $filter->filter_id = 0;
                    $filter->save();
                }

                // Product additional Image
                if ($request->file('product_image') != null) {

                    $folderPath = public_path('image/products');
                    if (!file_exists($folderPath)) {
                        mkdir($folderPath, 0777, true);
                    }
                    if(!file_exists($folderPath.'/'.$product_id)){
                        mkdir($folderPath.'/'.$product_id, 0777, true);
                    }

                    $files = $request->file('product_image'); // get files
                    foreach ($files as $key => $file) {
                        $imageName = time() . '_' . Str::uuid();
                        $mimeType = '.jpg';
                        $imagePath = public_path('image/products/'.$product_id.'/') . $imageName . $mimeType;
                        // sort
                        $sort = $request->input('product_image_sort')[$key]['sort'];
                        if (!file_exists($imagePath)) {
                            $file['image']->move(public_path('image/products/'.$product_id.'/'), $imageName . $mimeType);
                            $image = new ProductImage();
                            $image->product_id = $product_id;
                            $image->image = $imageName . $mimeType;
                            $image->sort = $sort;
                            $image->save();
                        }

                        // image cache
                        $cachePath = public_path('image/cache/products');
                        if(!file_exists($cachePath.'/'.$product_id)){
                            mkdir($cachePath.'/'.$product_id, 0777, true);
                        }
                        $imageManager = ImageManager::imagick()->read($imagePath);
                        $imageCachePath = public_path('image/cache/products/'.$product_id.'/') . $imageName . $mimeType;
                        if(!file_exists($imageCachePath)){
                            $size = [700,500,300,100];
                            for ($i=0; $i < count($size); $i++) { 
                                // resize to 300 x 200 pixel
                                $imageManager->scaleDown(height:$size[$i]);
                                $imageManager->save(public_path('image/cache/products/'.$product_id.'/'. $imageName .'_'. $size[$i] .'x'. $size[$i] . $mimeType));
                            }

                        }
                    }
                }

                // Product other links
                if ($data->get('amazon_url') != '' || $data->get('flipkart_url') != '' || $data->get('myntra_url') != '' || $data->get('ajio_url') != '' || $data->get('meesho_url') != '' || $data->get('other_url_status') != '') {
                    $otherLink = new ProductOtherLink();
                    $otherLink->product_id = $product_id;;
                    $otherLink->amazon = $data->get('amazon_url') ?? '';
                        $otherLink->flipkart = $data->get('flipkart_url') ?? '';
                        $otherLink->myntra = $data->get('myntra_url') ?? '';
                        $otherLink->ajio = $data->get('ajio_url') ?? '';
                        $otherLink->meesho = $data->get('meesho_url') ?? '';
                        $otherLink->status = $data->get('other_url_status') ? 1 : 0;
                    $otherLink->save();
                }
            }
            return redirect('admin/storefront/product')->with('success', 'Product created successfully.');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function editProduct(Request $request, int $product_id)
    {
        $data['heading_title'] = "Edit Product";

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => URL::to('/admin/dashboard')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Products',
            'href' => URL::to('/admin/storefront/product')
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Edit Product',
            'href' => URL::to('/admin/storefront/product-form')
        ];

        $data['action'] = route('admin-product-update', ['product_id' => $product_id]);
        $data['back'] = URL::to('/admin/storefront/product');
        $data['save'] = URL::to('/admin/storefront/product-save');       

        $data['product'] = Product::getProduct($product_id);

        $data['categories'] = Category::getCategory(); 

        $data['getProductCategory'] = ProductCategory::getProductCategory($product_id);

        $data['stock_status'] = DB::table('stock_status')->get();

        $data['other_links'] = DB::table('product_other_links')->where('product_id', $product_id)->first();

        return view('admin/storefront/product_form', $data);
    }

    public function updateProduct(Request $request, $product_id)
    {
        $data = $request->request;
        // dd($data);

        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'tag' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keyword' => 'nullable|string|max:255',
            'model' => 'required|nullable|string|max:255',
            'quantity' => 'required|integer',
            'minimum' => 'nullable|integer',
            'subtract' => 'nullable|integer',
            'stock_status_id' => 'nullable|integer',
            'date_available' => 'nullable|date',
            'shipping' => 'nullable|boolean',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'length_class_id' => 'nullable|integer',
            'weight' => 'nullable|numeric',
            'weight_class_id' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'retail_price' => 'required|nullable|numeric',
            'mrp' => 'required|nullable|numeric'
        ]);

        try {
            if (!empty($product_id)) {
                if (null !== $data->get('product_name') || null !== $data->get('model')) {

                    $product = Product::where('id', $product_id)->first();

                    // Upload product image
                    $file = $request->file('image'); // get files
                    if(null !== $file){
                        $folderPath = public_path('image/products');
                        if (!file_exists($folderPath)) {
                            mkdir($folderPath, 0777, true);
                        }
                        if(!file_exists($folderPath.'/'.$product_id)){
                            mkdir($folderPath.'/'.$product_id, 0777, true);
                        }
                        $imageName = time() . '_' . Str::uuid();
                        $mimeType = '.jpg';

                        // remove image before update
                        $image_name = isset($product->image) ? $product->image : null;
                        if($image_name){
                            if(file_exists(public_path('image/products/'.$product_id.'/') . $image_name)){
                                unlink(public_path('image/products/'.$product_id.'/') . $image_name);
                                $image_replace = str_replace(".jpg",'',$image_name);
                                $size = [700,500,300,100];
                                for ($i=0; $i < count($size); $i++) {
                                    if(file_exists(public_path('image/cache/products/'.$product_id.'/') . $image_replace .'_'. $size[$i] .'x'. $size[$i] . $mimeType)){
                                        unlink(public_path('image/cache/products/'.$product_id.'/') . $image_replace .'_'. $size[$i] .'x'. $size[$i] . $mimeType);
                                    }
                                }
                            }
                        }

                        $imagePath = public_path('image/products/'.$product_id.'/') . $imageName . $mimeType;
                        if (!file_exists($imagePath)) {
                            $file->move(public_path('image/products/'.$product_id.'/'), $imageName . $mimeType);
                        }

                        // image cache
                        $cachePath = public_path('image/cache/products');
                        if(!file_exists($cachePath.'/'.$product_id)){
                            mkdir($cachePath.'/'.$product_id, 0777, true);
                        }
                        $imageManager = ImageManager::imagick()->read($imagePath);
                        $imageCachePath = public_path('image/cache/products/'.$product_id.'/') . $imageName . $mimeType;
                        if(!file_exists($imageCachePath)){
                            $size = [700,500,300,100];
                            for ($i=0; $i < count($size); $i++) { 
                                // resize to 300 x 200 pixel
                                $imageManager->scaleDown(height:$size[$i]);
                                $imageManager->save(public_path('image/cache/products/'.$product_id.'/'. $imageName .'_'. $size[$i] .'x'. $size[$i] . $mimeType));
                            }

                        }
                    }
                    // end Upload product image

                    $product->product_name = $data->get('product_name') ?? '';
                    $product->product_description = $data->get('description') ?? '';
                    $product->tag = $data->get('product_tag') ?? '';
                    $product->meta_title = $data->get('meta_tag_title') ?? '';
                    $product->meta_description = $data->get('meta_description') ?? '';
                    $product->meta_keyword = $data->get('meta_tag_keyword') ?? '';
                    $product->model = $data->get('model') ?? '';
                    $product->quantity = (int)$data->get('quantity') ?? '';
                    $product->minimum = (int)$data->get('minimum') ?? '';
                    $product->subtract = (int)$data->get('subtract') ?? '';
                    $product->stock_status_id = $data->get('stock_status_id') ?? null;
                    $product->date_available = now();
                    $product->shipping = true;
                    $product->length = $data->get('length') ?? '';
                    $product->width = $data->get('width') ?? '';
                    $product->height = $data->get('height') ?? '';
                    $product->length_class_id = $data->get('length_class_id') ?? null;
                    $product->weight = $data->get('weight') ?? '';
                    $product->weight_class_id = $data->get('weight_class_id') ?? null;
                    isset($imageName) ? $product->image = $imageName . $mimeType : null;
                    $product->slug = Str::slug($data->get('product_name'));
                    $product->status = $data->get('status');
                    $product->sort_order = (int)$data->get('sort_order') ?? '';
                    $product->update();
                }

                // product to category
                if (null !== $request->input('category_ids')) {
                    ProductCategory::deleteProductCategory($product_id);
                    foreach($request->input('category_ids', []) as $category_id) {
                        $category = new ProductCategory();
                        $category->product_id = (int)$product_id;
                        $category->category_id = (int)$category_id;
                        $category->save();
                    }
                }else{
                    ProductCategory::where('product_id', $product_id)->delete();
                }

                // Product price
                if (!empty($validatedData['retail_price']) && !empty($validatedData['mrp'])) {
                    $price = ProductPrice::where('product_id', $product_id)->first();
                    if ($price) {
                        $price->price = $data->get('retail_price') ?? '';
                        $price->mrp = $data->get('mrp') ?? '';
                        $price->update();
                    }else{
                        $price = new ProductPrice();
                        $price->product_id = (int) $product_id;
                        $price->price = $data->get('retail_price') ?? '';
                        $price->mrp = $data->get('mrp') ?? '';
                        $price->save();
                    }
                }

                // product discount
                if (null !== $data->get('discount_price') || null !== $data->get('discount_price')) {
                    $discount = ProductDiscount::where('product_id', $product_id)->first();
                    $discount->product_id = $product_id;
                    $discount->customer_group_id = null;
                    $discount->quantity = null;
                    $discount->priority = null;
                    $discount->price = null;
                    $discount->start_date = null;
                    $discount->close_date = null;
                    $discount->update();
                }

                // product special
                if (null !== $data->get('special_price') || null !== $data->get('special_price')) {
                    $special = ProductSpecial::where('product_id', $product_id)->first();
                    $special->product_id = $product_id;
                    $special->customer_group_id = null;
                    $special->priority = null;
                    $special->price = 0.0000;
                    $special->start_date = null;
                    $special->close_date = null;
                    $special->update();
                }

                // product downloads
                if (null !== $data->get('download_id') || null !== $data->get('download_id')) {
                    $download = ProductDownload::where('product_id', $product_id)->first();
                    $download->product_id = $product_id;
                    $download->download_id = 0;
                    $download->update();
                }

                // Product Reward
                if (null !== $data->get('point') || null !== $data->get('point')) {
                    $reward = ProductReward::where('product_id', $product_id)->first();
                    $reward->product_id = $product_id;
                    $reward->point = 0;
                    $reward->update();
                }

                // Product Reward
                if (null !== $data->get('filter_id') || null !== $data->get('filter_id')) {
                    $filter = ProductFilter::where('product_id', $product_id)->first();
                    $filter->product_id = $product_id;
                    $filter->filter_id = 0;
                    $filter->update();
                }

                 // Product additional Image
                 if ($request->file('product_image') != null) {

                    $folderPath = public_path('image/products');
                    if (!file_exists($folderPath)) {
                        mkdir($folderPath, 0777, true);
                    }
                    if(!file_exists($folderPath.'/'.$product_id)){
                        mkdir($folderPath.'/'.$product_id, 0777, true);
                    }

                    $files = $request->file('product_image'); // get files
                    foreach ($files as $key => $file) {
                        $imageName = time() . '_' . Str::uuid();
                        $mimeType = '.jpg';
                        $imagePath = public_path('image/products/'.$product_id.'/') . $imageName . $mimeType;
                        // sort
                        $sort = $request->input('product_image_sort')[$key]['sort'];
                        $image_id = $request->input('product_image_id')[$key]['image_id'];
                        if (!file_exists($imagePath)) {
                            $file['image']->move(public_path('image/products/'.$product_id.'/'), $imageName . $mimeType);
                            $image = ProductImage::where('id', $image_id)->where('product_id', $product_id)->first();
                            if($image){
                                $image->image = $imageName . $mimeType;
                                $image->sort = $sort;
                                $image->save();
                            }else{
                                $image = new ProductImage();
                                $image->product_id = $product_id;
                                $image->image = $imageName . $mimeType;
                                $image->sort = $sort;
                                $image->save();
                            }
                        }

                        // image cache
                        $cachePath = public_path('image/cache/products');
                        if(!file_exists($cachePath.'/'.$product_id)){
                            mkdir($cachePath.'/'.$product_id, 0777, true);
                        }
                        $imageManager = ImageManager::imagick()->read($imagePath);
                        $imageCachePath = public_path('image/cache/products/'.$product_id.'/') . $imageName . $mimeType;
                        if(!file_exists($imageCachePath)){
                            $size = [700,500,300,100];
                            for ($i=0; $i < count($size); $i++) { 
                                // resize to 300 x 200 pixel
                                $imageManager->scaleDown(height:$size[$i]);
                                $imageManager->save(public_path('image/cache/products/'.$product_id.'/'. $imageName .'_'. $size[$i] .'x'. $size[$i] . $mimeType));
                            }

                        }
                    }
                }

                // Product other links
                if ($data->get('amazon_url') != '' || $data->get('flipkart_url') != '' || $data->get('myntra_url') != '' || $data->get('ajio_url') != '' || $data->get('meesho_url') != '' || $data->get('other_url_status') != '') {
                    $otherLink = ProductOtherLink::where('product_id', $product_id)->first();
                    if($otherLink){
                        $otherLink->product_id = $product_id;;
                        $otherLink->amazon = $data->get('amazon_url') ?? '';
                        $otherLink->flipkart = $data->get('flipkart_url') ?? '';
                        $otherLink->myntra = $data->get('myntra_url') ?? '';
                        $otherLink->ajio = $data->get('ajio_url') ?? '';
                        $otherLink->meesho = $data->get('meesho_url') ?? '';
                        $otherLink->status = $data->get('other_url_status') ? 1 : 0;
                        $otherLink->update();
                    }else{
                        $otherLink = new ProductOtherLink();
                        $otherLink->product_id = $product_id;;
                        $otherLink->amazon = $data->get('amazon_url') ?? '';
                        $otherLink->flipkart = $data->get('flipkart_url') ?? '';
                        $otherLink->myntra = $data->get('myntra_url') ?? '';
                        $otherLink->ajio = $data->get('ajio_url') ?? '';
                        $otherLink->meesho = $data->get('meesho_url') ?? '';
                        $otherLink->status = $data->get('other_url_status') ? 1 : 0;
                        $otherLink->save();
                    }
                }
                return redirect('admin/storefront/product')->with('success', 'Product updated successfully.');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function delete($product_id)
    {
        try {
            Product::deleteProduct($product_id);
            return redirect('admin/storefront/product')->with('success', 'Product deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function deleteMultiSelection(Request $request){
        $productList = $request->input('productList');
        if($productList){
            foreach ($productList as $value) {
                $product_id = (int)$value;
                Product::deleteProduct($product_id);
            }
            $json = [
                'success' => 1,
                'message' => "Product deleted successfully"
            ];
            return response()->json($json);
        }else{
            $json = [
                'error' => 1,
                'message' => "You must select a product to delete."
            ];
            return response()->json($json);
        }
    }
}
