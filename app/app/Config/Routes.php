<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    // Index    
    $routes->get('/', 'IndexController::index');

    // Event routes
    $routes->get('events', 'EventController::index');
    $routes->match(['get', 'post'], 'events/create', 'EventController::create');
    $routes->match(['get', 'patch'], 'events/edit/(:num)', 'EventController::edit/$1');
    $routes->get('events/delete/(:num)', 'EventController::delete/$1');

    // Event Occurrences routes
    $routes->get('event-occurrences', 'EventOccurrenceController::index');
    $routes->get('event-occurrences/by-event/(:num)', 'EventOccurrenceController::listByEvent/$1');
    $routes->match(['get', 'post'], 'event-occurrences/create/(:num)', 'EventOccurrenceController::create/$1');
    $routes->match(['get', 'patch'], 'event-occurrences/edit/(:num)', 'EventOccurrenceController::edit/$1');
    $routes->get('event-occurrences/delete/(:num)', 'EventOccurrenceController::delete/$1');

    // Pages routes
    $routes->get('pages', 'PageController::index');
    $routes->match(['get', 'post'], 'pages/create', 'PageController::create');
    $routes->match(['get', 'patch'], 'pages/edit/(:num)', 'PageController::edit/$1');
    $routes->get('pages/delete/(:num)', 'PageController::delete/$1');

    // Page Content routes
    $routes->get('page-contents/(:num)', 'PageContentController::index/$1');
    $routes->match(['get', 'post'], 'page-contents/create/(:num)', 'PageContentController::create/$1');
    $routes->match(['get', 'patch'], 'page-contents/edit/(:num)', 'PageContentController::edit/$1');
    $routes->get('page-contents/delete/(:num)', 'PageContentController::delete/$1');

    // Galleries routes
    $routes->get('galleries', 'GalleryController::index');
    $routes->match(['get', 'post'], 'galleries/create/(:num)/(:num)', 'GalleryController::create/$1/$2');
    $routes->get('galleries/events/(:num)', 'GalleryController::getGalleryEvent/$1');
    $routes->get('galleries/occurrences/(:num)', 'GalleryController::getGalleryOccurrence/$1');
});

