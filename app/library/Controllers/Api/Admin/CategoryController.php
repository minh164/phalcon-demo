<?php

namespace Website\Controllers\Api\Admin;

use Website\Controller;
use Website\Repositories\Admin\CategoryRepo;
use Spatie\Fractalistic\Fractal;
use Website\Transformers\Admin\CategoryTransfomer;

class CategoryController extends Controller
{
    /** @var \Website\Repositories\Admin\CategoryRepo $categories */
    protected $categories;

    protected $array;

    public function onConstruct()
    {
        $this->categories = new CategoryRepo();
    }

    public function listAction()
    {
        $request = $this->request->get();

        $categories = $this->categories->getAll($request);
        // object to array
        $categories = json_decode(json_encode($categories), true);
        // đệ quy categories
        $nestedCategories = $this->nestedList($categories, 0);
        // thêm một mảng bọc $nestedCategories để có thể transform từng phần tử
        $transform[] = $nestedCategories;

        $result = Fractal::create()
            ->collection($transform)
            ->transformWith(new CategoryTransfomer())
            ->toArray();

        return $this->outputSuccess($result);
    }

    private function nestedList($categories, $parent_id)
    {
        $arr = [];
        foreach ($categories as $key => $category) {
            if ($category['parent_id'] == $parent_id) {
                $category['child'] = $this->nestedList($categories, $category['category_id']);
                $arr[] = $category;
            }
        }
        return $arr;
    }

    public function outputJSON($response, $status_code = 200)
    {
        $this->registry->view = null;
        $this->response->setStatusCode($status_code);
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setJsonContent($response);

        return $this->response;
    }

    public function outputSuccess($result)
    {
        $response['code'] = 200;
        $response['msg'] = 'Successfull!';
        $response['data'] = $result;

        return $this->outputJSON($response);
    }
}