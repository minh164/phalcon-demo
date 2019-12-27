<?php

namespace Website\Transformers\Admin;

use League\Fractal\TransformerAbstract;

class CategoryTransfomer extends TransformerAbstract
{
    public function transform($items)
    {
        $arr = [];
        foreach ($items as $item) {
            if (count($item) > 0) {
                $arr[] = [
                    'category_id' => $item['category_id'],
                    'name' => $item['name'],
                    'created_at' => date("d-m H:i", $item['created_at']),
                    'child' => $this->transform($item['child'])
                ];
            }
        }
        return $arr;
    }
}