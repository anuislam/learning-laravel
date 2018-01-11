<?php

namespace Modules\Comment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Comment\Entities\Comment;

class CommentController extends Controller{

    public function get_all_comment(Request $data) {
        $comment = new Comment();
        return $comment->get_all_comment_table();
    }
}