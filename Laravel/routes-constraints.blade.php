<?php 

    //for custom constraints
    Route::get('/post/{id?}',function($id=null){
    if($id){
        return "<h1>POST ID: $id</h1>";
    }
    else{
        return "<h1>No POST ID</h1>";
    }
})->whereIn('id',['on1','chain','Hello']);

//only numeric values
Route::get('/post/{id?}',function($id=null){
    if($id){
        return "<h1>POST ID: $id</h1>";
    }
    else{
        return "<h1>No POST ID</h1>";
    }
})->whereNumeric('id');

// alpha values
Route::get('/post/{id?}',function($id=null){
    if($id){
        return "<h1>POST ID: $id</h1>";
    }
    else{
        return "<h1>No POST ID</h1>";
    }
})->whereAlpha('id');

//for alpha numeric values
Route::get('/post/{id?}',function($id=null){
    if($id){
        return "<h1>POST ID: $id</h1>";
    }
    else{
        return "<h1>No POST ID</h1>";
    }
})->whereAlphaNumeric('id');

?>