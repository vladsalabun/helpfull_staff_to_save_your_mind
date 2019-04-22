<?php

    Schema::create('table', function (Blueprint $table) {
        $table->increments('id');
        $table->string('field')->nullable();
        $table->integer('field')->default(0); 
    });
    
    Schema::table('table', function($table)
    {
        $table->string('field')->nullable();
        $table->integer('field')->default(0); 
        $table->float('field');
        $table->decimal('field', 5, 2);
        $table->smallInteger('field');
        $table->tinyInteger('field');
        $table->date('field');
        $table->dateTime('field');
    });

    
    $table->renameColumn('from', 'to');
    $table->string('name')->after('email');
    
    $table->unique('email');
    $table->dropUnique('users_email_unique');
    
    $table->dropColumn('votes');
    $table->dropColumn(array('votes', 'avatar', 'location'));

    if (Schema::hasTable('users')) {} // // Проверка существования таблицы
    if (Schema::hasColumn('users', 'email')) {} // Проверка существования поля