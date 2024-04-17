<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'company','location','website','email','description','tags','logo','user_id'];

    public function scopeFilter($query, array $filters)
    {
        if($filters['tag'] ?? false)
        {
            $query->where('tags', 'like', '%'.request("tag").'%');
        }
        if($filters["search"] ?? false)
        {
            $query->where("title", "like", '%'.request("search")."%")
            ->orWhere("description", "like", '%'.request("search")."%") 
            ->orWhere("tags", "like", '%'.request("search")."%"); 
        }
    }

    public function  user()
    {
        return $this->belongsTo(User::class);
    }
    // public static function all1()
    // {
    //     return [
    //             [
    //                 "id" => 1,
    //                 "title" => "Listing One",
    //                 "description" => "Listing one testing" 
    //             ],
    //             [
    //                 "id" => 2,
    //                 "title" => "Listing Two",
    //                 "description" => "Listing two testing"
    //             ]
    //          ];
    // }

    // public static function find1($id)
    // {
    //     $listings = self::all();

    //     foreach($listings as $listing)
    //     {
    //         if($listing['id'] == $id)
    //         {
    //             return $listing;
    //         }
    //     }
    // }
}
