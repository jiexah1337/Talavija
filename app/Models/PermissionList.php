<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 09-Mar-18
 * Time: 4:42 PM
 */

namespace App\Models;
class PermissionList {
    public $list = array();

    public function __construct()
    {
        $this->list = [
            ["name" => "user.view",             "desc" => "Lietotāju apskate"],
            ["name" => "user.create",           "desc" => "Lietotāju reģistrēšana"],
            ["name" => "user.delete",           "desc" => "Lietotāju dzēšana"],
            ["name" => "user.update",           "desc" => "Lietotāju rediģēšana"],
            ["name" => "user.history",          "desc" => "Lietotāju korporācijas vēstures rediģēšana"],
            ["name" => "user.notes",            "desc" => "Biedrziņa piezīmju rediģēšana"],
            ["name" => "user.assoc",            "desc" => "Lietotāju Oldermaņa, K!Tēva un K!Mātes rediģēšana"],
            ["name" => "user.edit-birthdata",   "desc" => "Lietotāju dzimšanas un nāves datu rediģēšana"],


            ["name" => "admin.panel-access",    "desc" => "Piekļuve administrācijas panelim"],

            ["name" => "roles.view",            "desc" => "Amatu apskate"],
            ["name" => "roles.create",          "desc" => "Amatu veidošana"],
            ["name" => "roles.delete",          "desc" => "Amatu dzēšana"],
            ["name" => "roles.update",          "desc" => "Amatu rediģēšana"],
            ["name" => "roles.attach",          "desc" => "Amatu piešķiršana"],

            ["name" => "statuses.view",         "desc" => "Statusu apskate"],
            ["name" => "statuses.create",       "desc" => "Statusu veidošana"],
            ["name" => "statuses.delete",       "desc" => "Statusu dzēšana"],
            ["name" => "statuses.update",       "desc" => "Statusu rediģēšana"],
            ["name" => "statuses.attach",       "desc" => "Statusu piešķiršana"],

            ["name" => "money.view",            "desc" => "Repartīciju apskate"],
            ["name" => "money.update",          "desc" => "Repartīciju rediģēšana"],

            ["name" =>  "news.post",            "desc" => "Ziņojumu rakstīšana"],
        ];
    }
}

