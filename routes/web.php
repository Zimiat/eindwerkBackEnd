<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AvailabilityController;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// home/dashboard
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// friend routes
Route::get('/friends', [App\Http\Controllers\HomeController::class, 'friends'])->name('friends');

// add friend routes
Route::get('/searchFriends', [App\Http\Controllers\HomeController::class, 'searchFriends'])->name('searchFriends');
Route::post('/searchFriends', [App\Http\Controllers\HomeController::class, 'searchFriends'])->name('searchFriends');
Route::post('/showAdd', [App\Http\Controllers\HomeController::class, 'AddFriends'])->name('AddFriends');

// delete friend routes
Route::get('/findFriends', [App\Http\Controllers\HomeController::class, 'findFriends'])->name('findFriends');
Route::post('/showDelete', [App\Http\Controllers\HomeController::class, 'DeleteFriends'])->name('DeleteFriends');

// map
Route::get('/map', [MapController::class, 'index'])->name('map_events');

// calendar
Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
Route::post('/calendar-event', [CalendarController::class, 'calendarEvents'])->name('calendar.events');
// Route::get('/calendar-event', [CalendarController::class, 'calendarEvents']);

// profile page
Route::get('/profile', 'App\Http\Controllers\ProfileController@show')->name('profile.show');
Route::put('/profile/update-username', 'App\Http\Controllers\ProfileController@updateUsername')->name('profile.update.username');
Route::put('/profile/update-password', 'App\Http\Controllers\ProfileController@updatePassword')->name('profile.update.password');
Route::delete('/profile/delete-account', 'App\Http\Controllers\ProfileController@deleteAccount')->name('profile.delete');

// create activity/event
Route::get('/event', [CalendarController::class, 'showCal'])->name('event.create');

//events display page
Route::get('/currentEvents', [App\Http\Controllers\EventController::class, 'index'])->name('eventsPage');
Route::get('/events/{id}', [App\Http\Controllers\EventController::class, 'show'] )->name('Event');
Route::get('/event', [App\Http\Controllers\HomeController::class, 'createEvent'])->name('event.create');
Route::post('/event', [App\Http\Controllers\HomeController::class, 'createEvent'])->name('event.create');
Route::post('/event/updatePivot', 'App\Http\Controllers\CalendarController@updatePivot')->name('event.updatePivot');


//availabilities
Route::resource('availabilities', AvailabilityController::class);
Route::post('availabilities/store', [AvailabilityController::class, 'store'])->name('store');

// MAIL
Route::get('/send-test-email', function () {
    $details = [
        'title' => 'Invitation',
        'body' => 'You have been invited to an event created by ${name}. Please let ${name} know when you are available.',
    ];

    \Mail::to('goodoltrickyvik@gmail.com')->send(new \App\Mail\TestEmail($details));

    return 'Test email sent successfully!';
});