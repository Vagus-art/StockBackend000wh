<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix'=>'api','middleware' => 'allow.cors'], function () use ($router) {
    
$router->post('/login', 'AuthController@authenticate');

$router->group(['prefix' => 'users'], function () use ($router) {
    $router->get('/', ['middleware' => 'jwt.auth', 'uses' => 'UsersController@getUsers']);
    $router->get('/{id}', ['middleware' => 'jwt.auth', 'uses' => 'UsersController@getUserByID']);
    $router->post('/', 'UsersController@addUser');
    $router->post('/updatename', ['middleware' => 'jwt.auth', 'uses' => 'UsersController@updateUserName']);
    $router->post('/updatepassword', ['middleware' => 'jwt.auth', 'uses' => 'UsersController@updateUserPassword']);
    $router->post('/delete', 'UsersController@deleteUser');
});

$router->group(['prefix' => 'contacts', 'middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('/', 'ContactsController@getContacts');
    $router->get('/menu', 'ContactsController@getContactsMinified');
    $router->get('/search/{search}', 'ContactsController@searchContacts');
    $router->get('/id/{id:[0-9]+}', 'ContactsController@getContactById');
    $router->post('/delete', 'ContactsController@deleteContactById');
    $router->post('/', 'ContactsController@postContact');
    $router->post('/update', 'ContactsController@updateContact');
});

$router->group(['prefix' => 'expenses', 'middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('/', 'ExpensesController@getExpenses');
    $router->get('/categories', 'ExpensesController@getExpenseCategories');
    $router->get('/search/{search}', 'ExpensesController@searchExpenses');
    $router->get('/id/{id:[0-9]+}', 'ExpensesController@getExpenseById');
    $router->post('/delete', 'ExpensesController@deleteExpenseById');
    $router->post('/', 'ExpensesController@postExpense');
    $router->post('/update', 'ExpensesController@updateExpense');
    $router->post('/categories', 'ExpensesController@postExpenseCategory');
    $router->post('/categories/update', 'ExpensesController@updateExpenseCategory');
    $router->post('/categories/delete', 'ExpensesController@deleteExpenseCategoryById');
});

$router->group(['prefix' => 'products', 'middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('/', 'ProductsController@getProducts');
    $router->get('/categories', 'ProductsController@getProductCategories');
    $router->get('/list', 'ProductsController@getProductsList');
    $router->get('/search/{search}', 'ProductsController@searchProducts');
    $router->get('/id/{id:[0-9]+}', 'ProductsController@getProductById');
    $router->post('/delete', 'ProductsController@deleteProductById');
    $router->post('/', 'ProductsController@postProduct');
    $router->post('/update', 'ProductsController@updateProduct');
    $router->post('/stock', 'ProductsController@updateProductStock');
    $router->post('/categories/post', 'ProductsController@postProductCategory');
    $router->post('/categories/update', 'ProductsController@updateProductCategory');
    $router->post('/categories/delete', 'ProductsController@deleteProductCategoryById');
});


$router->group(['prefix' => 'orders', 'middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('/', 'OrdersController@getOrders');
    $router->post('/delete', 'OrdersController@deleteOrderById');
    $router->get('/id', 'OrdersController@getOrderById');
    $router->get('/id/products', 'OrdersController@getOrderProductsByOrderId');
    $router->post('/', 'OrdersController@postOrder');
    $router->post('/update', 'OrdersController@updateOrder');
    $router->post('/products', 'OrdersController@addOrderProduct');
    $router->post('/products/update', 'OrdersController@modifyOrderProduct');
    $router->post('/products/delete', 'OrdersController@removeOrderProduct');
    $router->post('/products/delivered', 'OrdersController@markDeliveredMultiple');
    $router->get('/transactions', 'OrdersController@getTransactions');
    $router->post('/transactions', 'OrdersController@addTransaction');
    $router->post('/transactions/update', 'OrdersController@modifyTransaction');
    $router->post('/transactions/delete', 'OrdersController@deleteTransaction');
    $router->post('/completed', 'OrdersController@markCompleted');
});

$router->group(['prefix' => 'transactions', 'middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('/', 'TransactionsController@getTransactions');
    $router->get('/menu', 'TransactionsController@getTransactionsMinified');
    $router->get('/search/{search}', 'TransactionsController@searchTransactions');
    $router->get('/id/{id:[0-9]+}', 'TransactionsController@getTransactionById');
    $router->post('/id/delete/{id:[0-9]+}', 'TransactionsController@deleteTransactionById');
    $router->post('/', 'TransactionsController@postTransaction');
    $router->post('/update', 'TransactionsController@updateTransaction');
});

$router->options('/{route:.*}/', function () { return response(['status' => 'success']); });

});

