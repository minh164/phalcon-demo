<?php

namespace Website\Controllers\Api\Admin;

use Website\Controller;
use Website\Repositories\Admin\BlogRepo;
use Website\Request\Blog\StoreRequest;
use Website\Request\Blog\UpdateRequest;
use Spatie\Fractalistic\Fractal;
use Website\Transformers\Admin\BlogTrans;

class BlogController extends Controller
{
    protected $blogs;

    public function onConstruct()
    {
        $this->blogs = new BlogRepo();
    }

    public function listAction()
    {
        $blogs = $this->blogs->getAll();

        $result = Fractal::create()
            ->collection($blogs->toArray())
            ->transformWith(function ($blog) {
                return [
                    'blog_id' => $blog['blog_id'],
                    'title' => $blog['title'],
                    'created_at' => date("d-m H:i", $blog['created_at'])
                ];
            })
            ->toArray();

        return $this->outputSuccess($result);
    }

    public function storeAction()
    {
        $request = $this->request->get();
        $validate = new StoreRequest();

        // Validate
        $messages = $validate->validateForm($request);
        if (count($messages) > 0) {
            // add error
            return $this->outputError($messages);
        }

        // processing store
        $image = $this->uploadFile();
        $author = $this->session->get('admin_info');

        $arrayCreate = [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'category_id' => 1,
            'author' => $author->id == null ? 1 : $author->id,
            'image' => $image,
        ];

        $result = $this->blogs->createAction($arrayCreate);

        if ($result) {
            $message = 'Create successfully';
        }
        return $this->outputSuccess($message);
    }

    public function showAction($id)
    {
        $blog = $this->blogs->getOne($id);

        $result = Fractal::create()
            ->collection($blog->toArray())
            ->transformWith(function ($blog) {
                return [
                    'blog_id' => $blog['blog_id'],
                    'title' => $blog['title'],
                    'created_at' => date("d-m H:i", $blog['created_at'])
                    ];
            })
            ->toArray();

        return $this->outputSuccess($result);
    }

    public function updateAction($id)
    {
        $request = $this->request->get();
        $validate = new UpdateRequest();

        // Validate
        $messages = $validate->validateForm($request);
        if (count($messages) > 0) {
            // add error
            return $this->outputError($messages);
        }

        // processing store
        $image = $this->uploadFile();
        $author = $this->session->get('admin_info');

        $arrayUpdate = [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'category_id' => 1,
            'author' => $author->id == null ? 1 : $author->id,
        ];

        if ($image != null) {
            $arrayUpdate['image'] = $image;
        }

        $result = $this->blogs->updateAction($id, $arrayUpdate);

        if ($result) {
            $message = 'Update successfully';
        }
        return $this->outputSuccess($message);

    }

    public function destroyAction($id)
    {
        $result = $this->blogs->deleteAction($id);
        if ($result) {
            $message = 'Delete successfully';
        }
        return $this->outputSuccess($message);
    }

    public function uploadFile()
    {
        $request = $this->request;
        if ($request->hasFiles('image') != true) {
            return null;
        }

        $file = $request->getUploadedFiles();
        $rand = rand(0, 99) . rand(0, 99) . '.' . $file[0]->getExtension();
        $url = 'images/admin/' . $rand;
        $file[0]->moveTo($url);
        return $url;
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

    public function outputError($result)
    {
        $errorArray = [];
        foreach ($result as $err) {
            $errorArray[] = $err->getMessage();
        }
        $response['code'] = 422;
        $response['msg'] = 'Error!';
        $response['data'] = $errorArray;

        return $this->outputJSON($response, 422);
    }
}