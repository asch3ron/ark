<?php

namespace Ark\Http\Controllers;

use Ark\Http\Controllers\Controller;
use DB;

class ConfigurationController extends Controller {

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function all( $id_server = null )
    {
        $all = DB::table('ark_configurations')
            ->leftJoin('ark_server_configuration', 'ark_server_configuration.id_configuration', '=', 'ark_configurations.id')
            ->select('ark_configurations.*', 'ark_server_configuration.value')
            ->where('id_server',  (int) $id_server)
            ->get();

        return view('configuration', ['configurations' => $all, 'id_server' => $id_server]);
    }

    public function save($id_server, $id_configuration, $value)
    {
        $update = DB::table('ark_server_configuration')
            ->where('id_server',  (int) $id_server)
            ->where('id_configuration', (int) $id_configuration)
            ->update(['value' => (string) $value]);

        return ['success' => ($update > 0)];
    }
}
