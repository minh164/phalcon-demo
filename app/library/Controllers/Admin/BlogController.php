<?php

namespace Website\Controllers\Admin;

use Website\Controller;
use Website\Models\Admin\Blogs;
use Website\Request\Blog\StoreRequest;

class BlogController extends Controller
{
    protected $blogs;

    public function onConstruct()
    {
        $this->blogs = new Blogs();
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
            try {
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

            } catch (\Exception $exception) {
                echo $exception->getMessage(); die();
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
            try {
                $image = $this->uploadFile();
                $author = $this->session->get('admin_info');

                $arrayCreate = [
                    'title' => $_POST['title'],
                    'content' => $_POST['content'],
                    'category_id' => 1,
                    'author' => $author->id,
                ];

                if ($image != null) {
                    $arrayCreate['image'] = $image;
                }

                $result = $this->blogs->updateAction($arrayCreate);
                if ($result) {
                    $this->flash->success('Update blog success!');
                }

            } catch (\Exception $exception) {
                echo $exception->getMessage(); die();
            }
        }

        $redirectRoute = $this->getDI()->get('namedRoute', ['admin.blog.create']);

        return $this->response->redirect($redirectRoute);
    }

    public function uploadFile()
    {
        $request = $this->request;

        if ($request->hasFiles() == true) {
            $file = $request->getUploadedFiles();
            $rand = rand(0,99).rand(0,99).'.'.$file[0]->getExtension();
            $url = 'images/admin/'.$rand;
            $file[0]->moveTo($url);

            return $url;
        } else {
            return null;
        }
    }


}