<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBlogPostTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER blog_post_insert AFTER INSERT ON blog_posts
            FOR EACH ROW
            BEGIN
                INSERT INTO audit (name, title, content, action, created_at, updated_at)
                SELECT users.name, NEW.title, NEW.content, "INSERT", NOW(), NOW()
                FROM users
                WHERE users.id = NEW.user_id;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER blog_post_update AFTER UPDATE ON blog_posts
            FOR EACH ROW
            BEGIN
                INSERT INTO audit (name, title, content, action, created_at, updated_at)
                SELECT users.name, NEW.title, NEW.content, "UPDATE", NOW(), NOW()
                FROM users
                WHERE users.id = NEW.user_id;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER blog_post_delete AFTER DELETE ON blog_posts
            FOR EACH ROW
            BEGIN
                INSERT INTO audit (name, title, content, action, created_at, updated_at)
                SELECT users.name, OLD.title, OLD.content, "DELETE", NOW(), NOW()
                FROM users
                WHERE users.id = OLD.user_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS blog_post_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS blog_post_update');
        DB::unprepared('DROP TRIGGER IF EXISTS blog_post_delete');
    }
}
