<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Product;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('admin.products',['products' => $products]);
    }

    public function destroy($id){
        Product::destroy($id);
        return redirect('/admin/product');
    }

    public function show(){
        return view('admin.new');
    }

    public function store(Request $request) {

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));

        $entry = new \App\File();
        $entry->mime = $file->getClientMimeType();
        $entry->original_filename = $file->getClientOriginalName();
        $entry->filename = $file->getFilename().'.'.$extension;

        $entry->save();

        $product  = new Product();
        $product->file_id= $entry->id;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->imageurl = $request->input('imageurl');

        $product->save();

        return redirect('/admin/product');

    }
   /* public function index()
    {
        return view('admin/Product/index')->withProducts(Product::orderBy('id','desc')->get());
    }
    //create view
    public function create()
    {
        return view('admin/Product/create');
    }
    //update view
    public function edit($id) {
        $article = Product::find($id);
        return view('admin/Product/edit')->with('Product', $article);
    }

    public function store(Request $request) // Laravel 的依赖注入系统会自动初始化我们需要的 Request 类
    {
        // 数据验证
        $this->validate($request, [
            'title' => 'required|unique:articles|max:255', // 必填、在 articles 表中唯一、最大长度 255
            'body' => 'required', // 必填
        ]);

        // 通过 Product Model 插入一条数据进 articles 表
        $article = new Product; // 初始化 Product 对象
        $article->title = $request->get('title'); // 将 POST 提交过了的 title 字段的值赋给 Product 的 title 属性
        $article->body = $request->get('body'); // 同上
        $article->user_id = $request->user()->id; // 获取当前 Auth 系统中注册的用户，并将其 id 赋给 Product 的 user_id 属性

        // 将数据保存到数据库，通过判断保存结果，控制页面进行不同跳转
        if ($article->save()) {
            return redirect('admin/Product'); // 保存成功，跳转到 文章管理 页
        } else {
            // 保存失败，跳回来路页面，保留用户的输入，并给出提示
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }
    //更新
    public function update($id, Request $request)
    {
        $this->validate($request, [ // 排除掉当前编辑的数据
            'title' => 'required|unique:articles,title,' . $id . '|max:255',
            'body' => 'required',
        ]);
        $article          = Product::findOrFail($id);
        $article->title   = $request->get('title');
        $article->body    = $request->get('body');
        $article->user_id = $request->user()->id;

        if ($article->save()) {
            return redirect('admin/Product');
        } else {
            return redirect()->back()->withInput()->withErrors('保存信息失败！');
        }
    }
    //删除
    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect()->back()->withInput()->withErrors('删除成功！');
    }*/
}
