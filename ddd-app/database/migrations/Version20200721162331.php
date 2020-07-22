<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use Illuminate\Database\Schema\Blueprint;

class Version20200721162331 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        \Illuminate\Support\Facades\Schema::create('failed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        \Illuminate\Support\Facades\Schema::dropIfExists('failed_jobs');
    }
}
