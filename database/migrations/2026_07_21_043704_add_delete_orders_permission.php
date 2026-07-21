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
        $permission = Permission::firstOrCreate(
            ['slug' => 'delete-orders'],
            ['name' => 'Delete Orders', 'group' => 'Orders']
        );

        $superAdmin = Role::where('slug', 'super-admin')->first();
        if ($superAdmin && !$superAdmin->permissions->contains('id', $permission->id)) {
            $superAdmin->permissions()->attach($permission->id);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permission = Permission::where('slug', 'delete-orders')->first();
        $permission?->roles()->detach();
        $permission?->delete();
    }
};
