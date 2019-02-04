<?php

namespace App\Http\Controllers;

use App\Models\PermissionList;
use Illuminate\Http\Request;
use Sentinel;

use DB;


class AdministrationController extends Controller
{
    public $permissionList;

    function __construct(){
        $this->permissionList = new PermissionList();
    }


    /**
     * Method for accessing Administration Panel
     * Requires the 'admin.panel-access' permission
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function AdministrationPanel(){

        if(Sentinel::getUser()->hasAccess('admin.panel-access')){
            return view('pages.administration.main');
        }
        return redirect(route('accessDenied'));
    }

    /**
     * Show the list of roles in the admin panel
     * requires permission 'roles.view'
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws \Throwable
     */
    public function RoleManager(Request $request){
        if($request->isMethod('get')){
             if(Sentinel::getUser()->hasAccess('roles.view')){
                $roles = Sentinel::getRoleRepository()->get();
                $returnHTML = view('fragments.admin.role-list', compact(['roles']))->render();
                return response()->json(array('success' => true, 'html' => $returnHTML));
             } else {
                 $returnHTML = view('fragments.access-denied')->render();
                 return response()->json(array('success' => true, 'html' => $returnHTML));
             }
        }
        return '';
    }

    /**
     * Handles the editing of existing roles in the admin panel
     * requires permission 'roles.update'
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function RoleEditor(Request $request){
        if(Sentinel::getUser()->hasAccess('roles.update')){
            if($request->isMethod('get')){
                $roles = Sentinel::getRoleRepository()->get()->toArray();

                //Hardcoded permission list
                $permList = $this->permissionList->list;
                $returnHTML = view('fragments.admin.role-editor', compact(['roles', 'permList']))->render();
                return response()->json(array('success' => true, 'html' => $returnHTML));
            } else if ($request->isMethod('post')){

                //This area handles the input of serialized checkboxes and iterates through them to determine what needs to be updated, what - deleted.
                $data = $request->get("data");
                $deletable = $request->get("deleted");
                $processed = [];
                $processedDeletables = [];

                //This cycles through the update-able fields. AKA permission list changes for each role.
                foreach($data as $key=>$entry){
                    $split = explode('|', $entry);
                    array_push($processed, ["role" => $split[0], "perm" => $split[1], "value" => $split[2]]);
                }

                //This cycles through action checkboxes. AKA every checkbox that is needed to determine if you should delete a role.
                foreach($deletable as $key=>$deletableEntry){
                    $split = explode('|', $deletableEntry);
                    array_push($processedDeletables, ["role" => $split[0], "action" => $split[1], "value" => $split[2]]);
                }

                $this->savePermissions($processed);
                $this->deleteRoles($processedDeletables);

                $roles = Sentinel::getRoleRepository()->get();

                $listHtml = view('fragments.admin.role-list', compact(['roles']))->render();
                return response()->json(array('success' => true, 'msg' => 'Stuff Received', 'list' => $listHtml));
            }
        }
        $returnHTML = view('fragments.access-denied')->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    /**
     * Handles the Role Creator modal
     * requires permission 'roles.create'
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function RoleCreator(Request $request){
        if(Sentinel::getUser()->hasAccess('roles.create')){
            if($request->isMethod('get')){
                $permList = $this->permissionList->list;
                $actionurl = '/admin/roles/add';
                $returnHTML = view('fragments.admin.modals.role-creator', compact(['permList', 'actionurl']))->render();
                return response()->json(array('success' => true, 'html' => $returnHTML));
            } else if ($request->isMethod('post')){

                //Hold the request parameters in variables to make working with it easier.
                $data = $request->get("data");
                $name = $request->get("name");
                $slug = $request->get("slug");

                //Cycles through the checkbox data and separates the state and name
                $processed = [];
                foreach($data as $key=>$entry){
                    $split = explode('|', $entry);
                    array_push($processed, ["perm" => $split[0], "value" => $split[1]]);
                }

                $this->newRole($name, $slug, $processed);
                return response()->json(array('success' => true, 'msg' => 'Stuff Received'));
            }
        }
        $returnHTML = view('fragments.access-denied')->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    /**
     * Function that actually deals with the creation of a role
     * requires permission 'roles.create'
     * @param $name - Name of role
     * @param $slug - Slug/Abbreviation for the name
     * @param $perms - List of permissions
     */
    public function newRole($name, $slug, $perms){
        if (Sentinel::getUser()->hasAccess('roles.create')){
            $role = Sentinel::getRoleRepository()->createModel()->create([
                'name'  =>  $name,
                'slug'  =>  $slug,
            ]);

            $permissions = [];

            //Check which permissions are supposed to be granted. Filter has to be used for some reason. I don't know. It doesn't work with a simple check.
            foreach ($perms as $entry){
                if(filter_var($entry["value"], FILTER_VALIDATE_BOOLEAN) == true){
                    $permissions[$entry["perm"]] = true;
                }
            }
            try {
                DB::Transaction(function () use ($role, $permissions) {
                    $role->permissions = $permissions;
                    $role->save();
                });
            } catch (\Exception $e) {
            } catch (\Throwable $e) {
            }
        }
    }

    /**
     * Updates permissions for roles
     * requires permission 'roles.update'
     * @param $data
     */
    public function savePermissions($data){
        if(Sentinel::getUser()->hasAccess('roles.update')){
            $roles = Sentinel::getRoleRepository()->get();

            //filter through the data and make sure that the correct permissions go with their respective roles
            foreach($roles as $role){
                $permissions = [];
                foreach ($data as $entry){
                    if($entry["role"] == $role["slug"] && filter_var($entry["value"], FILTER_VALIDATE_BOOLEAN) == true){
                        $permissions[$entry["perm"]] = true;
                    }
                }
                try {
                    DB::Transaction(function () use ($role, $permissions) {
                        $role->permissions = $permissions;
                        $role->save();
                    });
                } catch (\Exception $e) {
                } catch (\Throwable $e) {
                }
            }
        }
    }

    /**
     * Handles deletion of roles
     * requires permission 'roles.delete'
     * @param $data
     */
    public function deleteRoles($data){
        if(Sentinel::getUser()->hasAccess('roles.delete')){
            foreach ($data as $key=>$entry){
                if($entry['action'] == 'delete-mark' && filter_var($entry["value"], FILTER_VALIDATE_BOOLEAN) == true){
                    Sentinel::getRoleRepository()->findBySlug($entry['role'])->delete();
                }
            }
        }
    }
}