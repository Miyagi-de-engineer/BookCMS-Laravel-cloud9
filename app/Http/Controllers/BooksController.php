<?php

namespace App\Http\Controllers;

use App\Book;
use Validator;
use Auth;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }
    
    //　更新
    public function update(Request $request){
    //バリデーション
    $validator = Validator::make($request->all(), [
            'id' => 'required',
            'item_name' => 'required|min:3|max:255',
            'item_number' => 'required|min:1|max:3',
            'item_amount' => 'required|max:6',
            'published' => 'required',
    ]);
    //バリデーション:エラー
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
    }
    
    //データ更新
    $books = Book::find($request->id);
    $books->item_name   = $request->item_name;
    $books->item_number = $request->item_number;
    $books->item_amount = $request->item_amount;
    $books->published   = $request->published;
    $books->save();
    return redirect('/');
    }
    
    // 登録
    public function store(Request $request){
        //バリデーション
         $validator = Validator::make($request->all(), [
        'item_name' => 'required|min:3|max:255',
        'item_number' => 'required | min:1 | max:3',
        'item_amount' => 'required | max:6',
         'published'   => 'required',
    ]);
    //バリデーション:エラー 
    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }
    
    $file = $request->file('item_img');
    if(!empty($file)){
        $filename = $file->getClientOriginalName();
        $move = $file->move('./upload/',$filename);
    } else {
        $filename = "";
    }
    
    // Eloquentモデル（登録処理）
    $books = new Book;
    $books->user_id = Auth::user()->id;
    $books->item_name =    $request->item_name;
    $books->item_number =  $request->item_number;
    $books->item_amount =  $request->item_amount;
    $books->item_img = $filename;
    $books->published =    $request->published;
    $books->save(); 
    return redirect('/')->with('message','本登録が完了しました');
    }
    
    // 一覧表示
    public function index(){
        $books = Book::where('user_id',Auth::user()->id)->orderBy('created_at', 'asc')->paginate(3);
        
        // ddd($books);
        
        return view('books', [
        'books' => $books
        ]);
    }
    
    // 編集画面表示
    public function edit($book_id){
        $books = Book::where('user_id',Auth::user()->id)->find($book_id);
        return view('booksedit',['book' => $books]);
    }
    
    // 削除処理
    public function destroy(Book $book){
        $book->delete();
        return redirect('/');
    }
}
