<?php

namespace Ark\Http\Controllers;

use Ark\Http\Controllers\Controller;

class ChangelogController extends Controller {

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function all()
    {
        $all = \Ark\Models\Changelog::all();

        return view('changelog', ['changelogs' => $all]);
    }

}
