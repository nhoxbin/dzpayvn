<?php

/*Route::get('/', function() {
    return redirect(env('APP_URL', null));
});*/

Route::get('sms', 'UnlockLinkController@sms')->name('link.sms');
Route::get('{token}', 'UnlockLinkController@show')->name('link.show');
Route::post('{token}', 'UnlockLinkController@unlock')->name('link.unlock');