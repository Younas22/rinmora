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
            ['slug' => 'delete-customers'],
            ['name' => 'Delete Customers', 'group' => 'Customers']
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
        $permission = Permission::where('slug', 'delete-customers')->first();
        $permission?->roles()->detach();
        $permission?->delete();
    }
};
