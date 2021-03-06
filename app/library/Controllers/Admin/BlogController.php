<?php

namespace Website\Controllers\Admin;

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

        $response = Fractal::create()
            ->collection($blogs->toArray())
            ->transformWith(BlogTrans::class)
            ->toArray();

        return $this->response->setJsonContent($response);
    }

    public function createAction()
    {
        $this->registry->view = 'admin/blog/create';
    }

    public function storeAction()
    {
        $request = $this->request->get();
        $validate = new StoreRequest();

        // Validate
        $messages = $validate->validateForm($request);
        if (count($messages) > 0) {
            // add error
            foreach ($messages as $message) {
                $this->flash->error($message);
            }
        } else {
            // processing store
            $image = $this->uploadFile();
            $author = $this->session->get('admin_info');

            $arrayCreate = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'category_id' => 1,
                'author' => $author->id,
                'image' => $image,
            ];

            $result = $this->blogs->createAction($arrayCreate);
            if ($result) {
                $this->flash->success('Create blog success!');
            }
        }

        $redirectRoute = $this->getDI()->get('namedRoute', ['admin.blog.create']);

        return $this->response->redirect($redirectRoute);
    }

    public function editAction($id)
    {
        $blog = $this->blogs->getOne($id);
        $this->viewSimple->setVars(['blog_info' => $blog]);

        return $this->registry->view = 'admin/blog/edit';
    }

    public function updateAction($id)
    {
        $request = $this->request->get();
        $validate = new UpdateRequest();

        // Validate
        $messages = $validate->validateForm($request);
        if (count($messages) > 0) {
            // add error
            foreach ($messages as $message) {
                $this->flash->error($message);
            }
        } else {
            // processing store
            $image = $this->uploadFile();
            $author = $this->session->get('admin_info');

            $arrayUpdate = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'category_id' => 1,
                'author' => $author->id,
            ];

            if ($image != null) {
                $arrayUpdate['image'] = $image;
            }

            $result = $this->blogs->updateAction($id, $arrayUpdate);
            if ($result) {
                $this->flash->success('Update blog success!');
            }
        }

        $redirectRoute = $this->getDI()->get('namedRoute', ['admin.blog.edit', ['id'=>$id]]);

        return $this->response->redirect($redirectRoute);
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
}