<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('HomeController');
$routes->setDefaultMethod('home');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// $routes->match(['get', 'post'], 'form', 'FormController::index');
//$routes->match(['get', 'post'], '/tag/(:num)/edit', 'TagsController::updateTag');


$routes->post('/tag/edit','TagsController::updateTag');
$routes->get('/tag/(:num)/edit', 'TagsController::editTag/$1');

$routes->post('/tag/delete', 'TagsController::deleteTag');

$routes->get('/tag/(:num)', 'TagsController::readTag/$1');

$routes->get('/tag/create', 'TagsController::createTag');
$routes->post('/tag/create','TagsController::createATag');

$routes->get('/tag/search', 'TagsController::searchTag');
$routes->get('tags', 'TagsController::index');
$routes->get('home', 'HomeController::home');
$routes->get('about', 'Pages::about');

$routes->post('/recipes/tagged', 'AjaxController::recipesTagged');
$routes->get('recipes', 'RecipeController::recipes');
$routes->get('recipe/(:num)', 'RecipeController::recipe/$1');
$routes->post('recipe/addgrade', 'AjaxController::addgrade');
$routes->post('recipe/addcomment', 'AjaxController::addcomment');
$routes->get('recipes/(:num)', 'RecipeController::recipesByTag/$1');

$routes->get('market', 'ArticleController::articles');
$routes->get('article/(:num)', 'ArticleController::article/$1');

$routes->get('login', 'LoginController::login');
$routes->post('dashboard', 'ConnectionController::checkLogin');
$routes->get('dashboard', 'ConnectionController::index');
$routes->get('register', 'LoginController::register');
$routes->post('register', 'UserController::createUser');
$routes->get('disconnect', 'ConnectionController::disconnect');

$routes->get('cart', 'CartController::cart');
$routes->get('pay', 'CartController::pay');
$routes->post('pay', 'AjaxController::payCart');

$routes->post('search', 'SearchController::search');

$routes->get('suggestions', 'SuggestionsController::suggestions');
$routes->post('/recipes/suggestions', 'SuggestionsController::recipesSuggestions');
// $routes->get('/recipes/tagged', 'RecipeController::recipesTagged');

$routes->get('/api',"ApiController::index");
$routes->get('/(:any)/api/recipes',"ApiController::recipes/$1");
$routes->get('/(:any)/api/recipe/(:num)',"ApiController::recipe/$1/$2");
$routes->get('/(:any)/api/category/(:any)',"ApiController::category/$1/$2");
$routes->get('/(:any)/api/categories',"ApiController::categories/$1");
$routes->get('/(:any)/api/search/(:alpha)',"ApiController::searchRecipe/$1/$2");

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
