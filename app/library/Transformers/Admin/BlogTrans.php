<?php

namespace Website\Transformers\Admin;

use League\Fractal\TransformerAbstract;

class BlogTrans extends TransformerAbstract
{
    public function transform($item)
    {
        return [
            'blog_id' => $item['blog_id'],
            'title' => $item['title'],
            'created_at' => date("d-m H:i", $item['created_at'])
        ];
    }
}