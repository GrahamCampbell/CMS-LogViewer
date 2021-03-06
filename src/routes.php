<?php

/**
 * This file is part of CMS LogViewer by Graham Campbell.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 */

$filters = array('before' => array(), 'after' => array());
$filters['before'][] = 'logviewer.messages';

Route::group(array('before' => $filters['before'], 'after' => $filters['after']), function () {
    Route::get('logviewer', array('as' => 'logviewer.index', 'uses' => 'GrahamCampbell\CMSLogViewer\Controllers\LogViewerController@getIndex'));

    $filters = array('before' => array(), 'after' => array());

    Route::group(array('before' => $filters['before'], 'after' => $filters['after']), function () {
        Route::get('logviewer/{path}/{sapi}/{date}/delete', array('as' => 'logviewer.delete', 'uses' => 'GrahamCampbell\CMSLogViewer\Controllers\LogViewerController@getDelete'));
    });

    $filters['before'][] = 'logviewer.logs';

    Route::group(array('before' => $filters['before'], 'after' => $filters['after']), function () {
        Route::get('logviewer/{path}/{sapi}/{date}/{level?}', array('as' => 'logviewer.show', 'uses' => 'GrahamCampbell\CMSLogViewer\Controllers\LogViewerController@getShow'));
    });

    Route::group(array('before' => $filters['before'], 'after' => $filters['after']), function () {
        Route::get('logviewer/data/{path}/{sapi}/{date}/{level?}', array('as' => 'logviewer.data', 'uses' => 'GrahamCampbell\CMSLogViewer\Controllers\LogViewerController@getData'));
    });
});
