<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/dashboard', 'Admin\DashboardController@index')->name('home');

//
Route::prefix('inquiry')->group(function() {
	Route::get('/create', 'Admin\InquiryController@create')->name('create_inquiry');
});

// Supplier
Route::prefix('supplier')->group(function() {
	Route::get('/create', 'Admin\SupplierController@create')->name('create_supplier');
	Route::post('/save', 'Admin\SupplierController@save')->name('save_supplier');
	Route::get('/list', 'Admin\SupplierController@list')->name('supplier_list');
	Route::get('/data', 'Admin\SupplierController@getData')->name('supplier_data');
	Route::get('approve/data', 'Admin\SupplierController@getApproveData')->name('supplier_approve_data');
	Route::get('/delete/{id}', 'Admin\SupplierController@delete')->name('delete_supplier');
	Route::get('/view/{id}', 'Admin\SupplierController@view')->name('view_supplier');
	Route::post('/update', 'Admin\SupplierController@update')->name('update_supplier');
	Route::get('/supplier/approve', 'Admin\SupplierController@approve')->name('supplier_approve');
	Route::get('/supplier/approve/status/{id}/{status}', 'Admin\SupplierController@approveStatus')->name('supplier_approve_status_approve');
	Route::post('/supplier/reject/status', 'Admin\SupplierController@approveStatus')->name('supplier_approve_status');
});

// Rfq
Route::prefix('rfq')->group(function() {
	Route::get('/create', 'Admin\RfqController@create')->name('create_rfq');
	Route::post('/save', 'Admin\RfqController@save')->name('save_rfq');
	Route::get('/list', 'Admin\RfqController@list')->name('rfq_list');
	Route::get('/data', 'Admin\RfqController@getData')->name('rfq_data');
  Route::get('/itemdata', 'Admin\RfqController@getDataItem')->name('itemdata');
  Route::post('/save_additem', 'Admin\RfqController@saveItemData')->name('save_additem');
  Route::post('/save_additem_update', 'Admin\RfqController@saveItemDataUpdate')->name('save_additem_update');
  Route::get('/itemdatadelete', 'Admin\RfqController@deleteItemData')->name('itemdatadelete');
  Route::get('/itemdatadeletetable/{id}', 'Admin\RfqController@deleteItemDataTable')->name('itemdatadeletetable');
  Route::get('/itemdatadeletetable2/{id}', 'Admin\RfqController@deleteItemDataTable2')->name('itemdatadeletetable2');
	Route::get('/delete/{id}', 'Admin\RfqController@delete')->name('delete_rfq');
	Route::get('/view/{id}', 'Admin\RfqController@view')->name('view_rfq');
	Route::post('/update', 'Admin\RfqController@update')->name('update_rfq');
});

// Supplier Contact
Route::prefix('supplier/contact')->group(function() {
	Route::get('/create', 'Admin\SupplierContactController@create')->name('create_supplier_contact');
	Route::post('/save', 'Admin\SupplierContactController@save')->name('save_supplier_contact');
	Route::get('/list', 'Admin\SupplierContactController@list')->name('supplier_contact_list');
	Route::get('/data', 'Admin\SupplierContactController@getData')->name('supplier_contact_data');
	Route::get('/delete/{id}', 'Admin\SupplierContactController@delete')->name('delete_supplier_contact');
	Route::get('/view/{id}', 'Admin\SupplierContactController@view')->name('view_supplier_contact');
	Route::post('/update', 'Admin\SupplierContactController@update')->name('update_supplier_contact');
	Route::any('/get/{id}', 'Admin\SupplierContactController@getSupplierContact')->name('get-supplier-contact');
});

// Supplier Contact
Route::prefix('quotation')->group(function() {
	Route::get('/create', 'Admin\QuotationController@create')->name('create_quotation');
	Route::post('/save', 'Admin\QuotationController@save')->name('save_quotation');
	Route::get('/list', 'Admin\QuotationController@list')->name('quotation_list');
	Route::get('/data', 'Admin\QuotationController@getData')->name('quotation_data');
  Route::get('approve/data/{id}', 'Admin\QuotationController@getApproveData')->name('quotation_approve_data');
  Route::get('approve/data2', 'Admin\QuotationController@getApproveData2')->name('quotation_approve_data2');
	Route::get('/delete/{id}', 'Admin\QuotationController@delete')->name('delete_quotation');
	Route::get('/view/{id}', 'Admin\QuotationController@view')->name('view_quotation');
	Route::post('/update', 'Admin\QuotationController@update')->name('update_quotation');
  Route::get('/view/approve/{id}', 'Admin\QuotationController@viewApprove')->name('view_quotation_approve');
  Route::get('/quotation/approve', 'Admin\QuotationController@approve')->name('quotation_approve');
	Route::get('/quotation/approve/status/{id}/{status}', 'Admin\QuotationController@approveStatus')->name('quotation_approve_status_approve');
  Route::post('/quotation/reject/status', 'Admin\QuotationController@approveStatus')->name('quotation_approve_status');
});

// Items
Route::prefix('items')->group(function() {
	Route::get('/create', 'Admin\ItemsController@create')->name('create_item');
	Route::post('/save', 'Admin\ItemsController@save')->name('save_item');
	Route::get('/list', 'Admin\ItemsController@list')->name('items_list');
	Route::get('/data', 'Admin\ItemsController@getData')->name('item_data');
	Route::get('/table/{productIds}/{rfiId}', 'Admin\ItemsController@itemTable')->name('item_table');
  Route::get('/table2/{productIds}/{id}', 'Admin\ItemsController@itemTable2')->name('item_table2');
  Route::get('/table3/{productIds}/{id}', 'Admin\ItemsController@itemTable3')->name('item_table3');
  Route::get('/tablerfq/{productIds}/{rfqId}', 'Admin\ItemsController@itemTableRfq')->name('item_table_rfq');
  Route::get('/tableqs/{productIds}/{qsId}', 'Admin\ItemsController@itemTableQs')->name('item_table_qs');
	Route::get('/delete/{id}', 'Admin\ItemsController@delete')->name('delete_item');
	Route::get('/view/{id}', 'Admin\ItemsController@view')->name('view_item');
	Route::post('/update', 'Admin\ItemsController@update')->name('update_item');
	Route::any('/inquirycustomer/get/{id}', 'Admin\ItemsController@getItemsByCustomer')->name('get-items-by-customer');
  Route::any('/inquirycustomer2/get', 'Admin\ItemsController@getItemsByCustomer2')->name('get-items-by-customer2');
  Route::any('/inquirycustomer3/get/{id}', 'Admin\ItemsController@getItemsByCustomer3')->name('get-items-by-customer3');
  Route::any('/rfqnumber/get/{id}', 'Admin\ItemsController@getItemsByRfq')->name('get-items-by-rfq');
  Route::any('/qsnumber/get/{id}', 'Admin\ItemsController@getItemsByQs')->name('get-items-by-qs');

});

// Item Price
Route::prefix('item/price')->group(function() {
	Route::get('/create', 'Admin\ItemPriceController@create')->name('create_price');
	Route::post('/save', 'Admin\ItemPriceController@save')->name('save_price');
	Route::get('/list', 'Admin\ItemPriceController@list')->name('price_list');
	Route::get('/data', 'Admin\ItemPriceController@getData')->name('price_data');
	Route::get('/delete/{id}', 'Admin\ItemPriceController@delete')->name('delete_price');
	Route::get('/view/{id}', 'Admin\ItemPriceController@view')->name('view_price');
	Route::post('/update', 'Admin\ItemPriceController@update')->name('update_price');
});

// Item Quote
Route::prefix('items_quote')->group(function() {
	Route::get('/create', 'Admin\ItemsQuoteController@create')->name('create_item_quote');
	Route::post('/save', 'Admin\ItemsQuoteController@save')->name('save_item_quote');
	Route::get('/list', 'Admin\ItemsQuoteController@list')->name('item_quote_list');
	Route::get('/data', 'Admin\ItemsQuoteController@getData')->name('item_quote_data');
	Route::get('/delete/{id}', 'Admin\ItemsQuoteController@delete')->name('delete_item_quote');
	Route::get('/view/{id}', 'Admin\ItemsQuoteController@view')->name('view_item_quote');
	Route::post('/update', 'Admin\ItemsQuoteController@update')->name('update_item_quote');
});

// Item Quote Price
Route::prefix('item_quote/price')->group(function() {
	Route::get('/create', 'Admin\ItemPriceQuoteController@create')->name('create_price_quote');
	Route::post('/save', 'Admin\ItemPriceQuoteController@save')->name('save_price_quote');
	Route::get('/list', 'Admin\ItemPriceQuoteController@list')->name('price_quote_list');
	Route::get('/data', 'Admin\ItemPriceQuoteController@getData')->name('price_quote_data');
	Route::get('/delete/{id}', 'Admin\ItemPriceQuoteController@delete')->name('delete_price_quote');
	Route::get('/view/{id}', 'Admin\ItemPriceQuoteController@view')->name('view_price_quote');
	Route::post('/update', 'Admin\ItemPriceQuoteController@update')->name('update_price_quote');
});

// Item Buffer
Route::prefix('items_buffer')->group(function() {
	Route::get('/create', 'Admin\ItemsBufferController@create')->name('create_item_buffer');
	Route::post('/save', 'Admin\ItemsBufferController@save')->name('save_item_buffer');
	Route::get('/list', 'Admin\ItemsBufferController@list')->name('item_buffer_list');
	Route::get('/data', 'Admin\ItemsBufferController@getData')->name('item_buffer_data');
	Route::get('/delete/{id}', 'Admin\ItemsBufferController@delete')->name('delete_item_buffer');
	Route::get('/view/{id}', 'Admin\ItemsBufferController@view')->name('view_item_buffer');
	Route::post('/update', 'Admin\ItemsBufferController@update')->name('update_item_buffer');
});

// Item Buffer Price
Route::prefix('item_buffer/price')->group(function() {
	Route::get('/create', 'Admin\ItemBufferPriceController@create')->name('create_buffer_price');
	Route::post('/save', 'Admin\ItemBufferPriceController@save')->name('save_buffer_price');
	Route::get('/list', 'Admin\ItemBufferPriceController@list')->name('buffer_price_list');
	Route::get('/data', 'Admin\ItemBufferPriceController@getData')->name('buffer_price_data');
	Route::get('/delete/{id}', 'Admin\ItemBufferPriceController@delete')->name('delete_buffer_price');
	Route::get('/view/{id}', 'Admin\ItemBufferPriceController@view')->name('view_buffer_price');
	Route::post('/update', 'Admin\ItemBufferPriceController@update')->name('update_buffer_price');
});

// Purchase Request
Route::prefix('purchase_request')->group(function() {
	Route::get('/create', 'Admin\PrController@create')->name('create_purchase_request');
	Route::post('/save', 'Admin\PrController@save')->name('save_purchase_request');
	Route::get('/list', 'Admin\PrController@list')->name('purchase_request_list');
	Route::get('/data', 'Admin\PrController@getData')->name('purchase_request_data');
	Route::get('/delete/{id}', 'Admin\PrController@delete')->name('delete_purchase_request');
	Route::get('/view/{id}', 'Admin\PrController@view')->name('view_purchase_request');
	Route::post('/update', 'Admin\PrController@update')->name('update_purchase_request');
	Route::get('/detail/{id}', 'Admin\PrController@detail')->name('detail_purchase_request');
	Route::post('/save/detail', 'Admin\PrController@saveDetail')->name('save_purchase_request_detail');
  Route::get('approve/data', 'Admin\PrController@getApproveData')->name('purchase_request_approve_data');
  Route::get('approve/data2', 'Admin\PrController@getApproveData2')->name('purchase_request_approve_data2');
  Route::get('/purchase_request/approve', 'Admin\PrController@approve')->name('purchase_request_approve');
  Route::get('/view/approve/{id}', 'Admin\PrController@viewApprove')->name('view_purchase_request_approve');
	Route::get('/purchase_request/approve/status/{id}/{status}', 'Admin\PrController@approveStatus')->name('purchase_request_approve_status_approve');
  Route::post('/purchase_request/reject/status', 'Admin\PrController@approveStatus')->name('purchase_request_approve_status');
});

// Purchase Order Supplier
Route::prefix('purchase_order')->group(function() {
	Route::get('/create', 'Admin\poSupplierController@create')->name('create_purchase_order');
	Route::post('/save', 'Admin\poSupplierController@save')->name('save_purchase_order');
	Route::get('/list', 'Admin\poSupplierController@list')->name('purchase_order_list');
	Route::get('/data', 'Admin\poSupplierController@getData')->name('purchase_order_data');
	Route::get('/delete/{id}', 'Admin\poSupplierController@delete')->name('delete_purchase_order');
	Route::get('/view/{id}', 'Admin\poSupplierController@view')->name('view_purchase_order');
	Route::post('/update', 'Admin\poSupplierController@update')->name('update_purchase_order');
	Route::get('/detail/{id}', 'Admin\poSupplierController@detail')->name('detail_purchase_order');
	Route::post('/save/detail', 'Admin\poSupplierController@saveDetail')->name('save_purchase_order_detail');
  Route::get('approve/data', 'Admin\poSupplierController@getApproveData')->name('purchase_order_approve_data');
  Route::get('approve/data2', 'Admin\poSupplierController@getApproveData2')->name('purchase_order_approve_data2');
  Route::get('/purchase_order/approve', 'Admin\poSupplierController@approve')->name('purchase_order_approve');
  Route::get('/view/approve/{id}', 'Admin\poSupplierController@viewApprove')->name('view_purchase_order_approve');
	Route::get('/purchase_order/approve/status/{id}/{status}', 'Admin\poSupplierController@approveStatus')->name('purchase_order_approve_status_approve');
  Route::post('/purchase_order/reject/status', 'Admin\poSupplierController@approveStatus')->name('purchase_order_approve_status');
});
