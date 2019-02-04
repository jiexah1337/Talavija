<?php

use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Native\Facades\Sentinel as Sentinel;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            $adminPermissions = [
                'name'          =>      'Administrātors',
                'slug'          =>      'admin',
                'permissions'   =>      [
                    'user.create'       =>      true,
                    'user.delete'       =>      true,
                    'user.view'         =>      true,
                    'user.update'       =>      true,

                    'roles.create'      =>      true,
                    'roles.delete'      =>      true,
                    'roles.view'        =>      true,
                    'roles.update'      =>      true,

                    'admin.panel-access'    =>  true,
                ],
            ],
            $senior = [
                'name'  =>  'Seniors',
                'slug'  =>  'senior',
                'permissions'   =>  [
                    'user.create'       =>      true,
                    'user.delete'       =>      true,
                    'user.view'         =>      true,
                    'user.update'       =>      true,

                    'roles.create'      =>      true,
                    'roles.delete'      =>      true,
                    'roles.view'        =>      true,
                    'roles.update'      =>      true,

                    'admin.panel-access'    =>  true,
                    ],
            ],
            $vSenior = [
                'name'  =>  'Vice Seniors',
                'slug'  =>  'vice-senior',
                'permissions'   =>  [],
            ],
            $secretary = [
                'name'  =>  'Sekretārs',
                'slug'  =>  'secretary',
                'permissions'   =>  [
                    'user.create'       =>      true,
                    'user.delete'       =>      true,
                    'user.view'         =>      true,
                    'user.update'       =>      true,

                    'roles.create'      =>      true,
                    'roles.delete'      =>      true,
                    'roles.view'        =>      true,
                    'roles.update'      =>      true,

                    'admin.panel-access'    =>  true,
                    ],
            ],
            $olderman = [
                'name'  =>  'Oldermanis',
                'slug'  =>  'olderman',
                'permissions'   =>  [
                    'user.create'       =>      true,
                    'user.delete'       =>      true,
                    'user.view'         =>      true,
                    'user.update'       =>      true,

                    'roles.create'      =>      true,
                    'roles.delete'      =>      true,
                    'roles.view'        =>      true,
                    'roles.update'      =>      true,

                    'admin.panel-access'    =>  true,
                    ],
            ],
            $magLit = [
                'name'  =>  'Magister Litterarum',
                'slug'  =>  'mag-litterarum',
                'permissions'   =>  [],
            ],
            $magCan = [
                'name'  =>  'Magister Cantandi',
                'slug'  =>  'mag-cantandi',
                'permissions'   =>  [],
            ],
            $magPau = [
                'name'  =>  'Magister Paucandi',
                'slug'  =>  'mag-paucandi',
                'permissions'   =>  [],
            ],
            $cashier = [
                'name'  =>  'Kasieris',
                'slug'  =>  'cashier',
                'permissions'   =>  [
                    'money.view'    => true,
                    'money.update'  => true,
                ],
            ],
            $econom = [
                'name'  =>  'Ekonoms',
                'slug'  =>  'econom',
                'permissions'   =>  [],
            ],
            $librarian = [
                'name'  =>  'Bibliotekārs',
                'slug'  =>  'librarian',
                'permissions'   =>  [],
            ],
            $majDom = [
                'name'  =>  'Major Domus',
                'slug'  =>  'maj-domus',
                'permissions'   =>  [],
            ],
            $archiver = [
                'name'  =>  'Arhivārs',
                'slug'  =>  'archiver',
                'permissions'   =>  [
                    'user.create'       =>      true,
                    'user.delete'       =>      true,
                    'user.view'         =>      true,
                    'user.update'       =>      true,
                    ],
            ],
            $internalCourtRep = [
                'name'  =>  'Internālās tiesas priekšsēdētājs',
                'slug'  =>  'int-court-rep',
                'permissions'   =>  [],
            ],
            $internalCourtJudge = [
                'name'  =>  'Internālās tiesas tiesnesis',
                'slug'  =>  'int-court-judge',
                'permissions'   =>  [],
            ],
            $externalHonorCourtJudge = [
                'name'  =>  'Eksternais goda tiesas tiesnesis',
                'slug'  =>  'ext-hon-court-judge',
                'permissions'   =>  [],
            ],
            $revisionaryCommissionRep = [
                'name'  =>  'Revīzijas komisijas priekšsēdētājs',
                'slug'  =>  'rev-com-rep',
                'permissions'   =>  [],
            ],
            $revisionaryCommissionMember = [
                'name'  =>  'Revīzijas komisijas loceklis',
                'slug'  =>  'rev-com-member',
                'permissions'   =>  [],
            ],
            $ITRep = [
                'name'  =>  'Atbildildīgais par datoru',
                'slug'  =>  'IT-rep',
                'permissions'   =>  [],
            ],
        ];

        foreach ($roles as $key=>$role){
            if (!Sentinel::findRoleBySlug($role['slug'])){
                $newRole = Sentinel::getRoleRepository()->createModel()->create($role);
                $newRole->save();
            } else {
                $updateRole = Sentinel::findRoleBySlug($role['slug']);
                $updateRole->update($role);
            }
        }
    }
}
