<?php
namespace App;
use Hootlex\Moderation\Moderatable;
use Illuminate\Database\Eloquent\Model;
class Post extends Model
{
    use Moderatable;
    
}