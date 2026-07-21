<?php

use App\Models\System\Permission;
use App\Models\System\Role;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $permissions = [
            ['name' => 'Delete Contact Messages', 'slug' => 'delete-contact-messages', 'group' => 'Support'],
            ['name' => 'Delete Support Tickets', 'slug' => 'delete-support-tickets', 'group' => 'Support'],
        ];

        $superAdmin = Role::where('slug', 'super-admin')->first();

        foreach ($permissions as $data) {
            $permission = Permission::firstOrCreate(['slug' => $data['slug']], $data);

            if ($superAdmin && !$superAdmin->permissions->contains('id', $permission->id)) {
                $superAdmin->permissions()->attach($permission->id);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permissions = Permission::whereIn('slug', ['delete-contact-messages', 'delete-support-tickets'])->get();

        foreach ($permissions as $permission) {
            $permission->roles()->detach();
            $permission->delete();
        }
    }
};
