<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Membuat stored function untuk gender
        DB::unprepared('
            DROP FUNCTION IF EXISTS get_gender_name;
            
            CREATE FUNCTION get_gender_name(gender_code VARCHAR(1))
            RETURNS VARCHAR(10)
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE gender_name VARCHAR(10);
                
                CASE gender_code
                    WHEN "L" THEN SET gender_name = "Laki-laki";
                    WHEN "P" THEN SET gender_name = "Perempuan";
                    ELSE SET gender_name = "Unknown";
                END CASE;
                
                RETURN gender_name;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS get_gender_name');
    }
};
