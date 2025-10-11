<?php

namespace App\Database\Eloquent;

use App\Support\Facades\DB;

abstract class Model
{
    protected static $primaryKey = 'id';
    protected static $table = '';
    protected static $incrementing = true;
    protected static $timestamps = true;

    public static function all()
    {
        return DB::table(static::$table)->get();
    }

    public static function find($id)
    {
        return DB::table(static::$table)->where(static::$primaryKey, $id)->first();
    }

    public static function create(array $data)
    {
        if (static::$timestamps) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        return DB::table(static::$table)->insert($data);
    }

    public static function update($id, array $data)
    {
        if (static::$timestamps) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        return DB::table(static::$table)
            ->where(static::$primaryKey, $id)
            ->update($data);
    }

    public static function delete($id)
    {
        return DB::table(static::$table)
            ->where(static::$primaryKey, $id)
            ->delete();
    }
}