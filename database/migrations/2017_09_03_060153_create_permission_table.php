<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTable extends Migration
{
    /**
     * @var string
     */
    protected $usersTable;

    /**
     * @var string
     */
    protected $passwordResetsTable;

    /**
     * @var string
     */
    protected $rolesTable;

    /**
     * @var string
     */
    protected $roleUserTable;

    /**
     * @var string
     */
    protected $permissionsTable;

    /**
     * @var string
     */
    protected $permissionRoleTable;

    public function __construct() {
        $this->usersTable = Config::get('permission.users_table');
        $this->passwordResetsTable = Config::get('permission.password_resets_table');
        $this->rolesTable = Config::get('permission.roles_table');
        $this->roleUserTable = Config::get('permission.role_user_table');
        $this->permissionsTable = Config::get('permission.permissions_table');
        $this->permissionRoleTable = Config::get('permission.permission_role_table');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing admin users
        Schema::create($this->usersTable, function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname', 32);
            $table->string('lastname', 32);
            $table->string('email', 128)->unique();
            $table->string('phone', 11)->nullable()->unique();
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->text('extra')->nullable();
            $table->timestamp('log_date')->nullable();
            $table->string('log_ip', 45)->nullable();
            $table->unsignedInteger('log_num')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        // Create table for storing admin user password resets
        Schema::create($this->passwordResetsTable, function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at')->nullable();
        });

        // Create table for storing roles
        Schema::create($this->rolesTable, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create($this->roleUserTable, function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            // $table->foreign('user_id')->references('id')->on($this->usersTable)
            //     ->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('role_id')->references('id')->on($this->rolesTable)
            //     ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });

        // Create table for storing permissions
        Schema::create($this->permissionsTable, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create($this->permissionRoleTable, function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            // $table->foreign('permission_id')->references('id')->on($this->permissionsTable)
            //     ->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('role_id')->references('id')->on($this->rolesTable)
            //     ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->usersTable);
        Schema::dropIfExists($this->passwordResetsTable);
        Schema::dropIfExists($this->rolesTable);
        Schema::dropIfExists($this->roleUserTable);
        Schema::dropIfExists($this->permissionsTable);
        Schema::dropIfExists($this->permissionRoleTable);
    }
}