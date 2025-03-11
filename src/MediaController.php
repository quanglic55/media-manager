<?php

namespace OpenAdmin\Admin\Media;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use OpenAdmin\Admin\Facades\Admin;
use OpenAdmin\Admin\Layout\Content;
use OpenAdmin\Admin\Auth\Database\Permission;
use OpenAdmin\Admin\Auth\Permission as PermissionUtils;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        // $permission = Permission::where("slug",  "auth.setting")->first();
        // PermissionUtils::check('auth.setting');
        // echo Admin::user()->can('auth.setting')." ".$request->get('path', '/');

        // check permission, only the roles with permission `create-page` can visit this action 
        return Admin::content(function (Content $content) use ($request) {
            $path = $request->get('path', '/');
            $view = $request->get('view', 'table');
            $select = $request->get('select', false);
            $close = $request->get('close', false);
            $fn = $request->get('fn', 'selectFile');

            $manager = new MediaManager($path);
            $manager->select_fn = $fn;

            $content->header('Media manager');
            $content->body(view("open-admin-media::$view", [
                'list'      => $manager->ls(),
                'view'      => $view,
                'nav'       => $manager->navigation(),
                'url'       => $manager->urls(),
                'close'     => $close,
                'select'    => $select,
                'fn'        => $fn,
            ]));

            if ($select) {
                $content->addBodyClass('hide-nav');
            }
        });
    }
    
    public function picker(Request $request, Content $content)
    {
        // check permission, only the roles with permission `create-page` can visit this action 
        // return Admin::content(function (Content $content) use ($request) {
            $path = $request->get('path', '/');
            $view = $request->get('view', 'table');
            $select = $request->get('select', false);
            $close = $request->get('close', false);
            $fn = $request->get('fn', 'selectFile');

            $manager = new MediaManager($path);
            $manager->select_fn = $fn;

            // $content->header('Media manager');
            // $content->view("open-admin-media::picker", [
            //     'list'      => $manager->ls(),
            //     'view'      => $view,
            //     'nav'       => $manager->navigation(),
            //     'url'       => $manager->urls(),
            //     'close'     => $close,
            //     'select'    => $select,
            //     'fn'        => $fn,
            // ]);
            
        return view('open-admin-media::picker2', ['list' => $manager->ls('media-picker', false)]);

            // if ($select) {
            //     $content->addBodyClass('hide-nav');
            // }
        // });
    }

    public function download(Request $request)
    {
        $file = $request->get('file');

        $manager = new MediaManager($file);

        return $manager->download();
    }

    public function upload(Request $request)
    {
        $files = $request->file('files');
        $dir = $request->get('dir', '/');

        $manager = new MediaManager($dir);

        try {
            if ($manager->upload($files)) {
                admin_toastr(trans('admin.upload_succeeded'));
            }
        } catch (\Exception $e) {
            admin_toastr($e->getMessage(), 'error');
        }

        return back();
    }

    public function delete(Request $request)
    {
        $files = $request->json('files');
        $manager = new MediaManager();

        try {
            if ($manager->delete($files)) {

                // Xóa permission 
                foreach ($files as $file) {
                    $permission = Permission::where('slug', "documents.".str_replace("/",  ".", $file))->first();
                    
                    if ($permission) {
                        $permission->delete();
                    }
                }
                
                return response()->json([
                    'status'  => true,
                    'message' => trans('admin.delete_succeeded'),
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status'  => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function move(Request $request)
    {
        $path = $request->get('path');
        $new = $request->get('new');

        $manager = new MediaManager($path);
        
        // Cập nhật permission 
        $slug = "documents.".str_replace("/", ".", $path);
        $slug_new = "documents.".str_replace("/", ".", $new);
        $permission = Permission::where('slug', $slug)->first();
        $permission->slug = $slug_new;
        $permission->name = $slug_new;

        try {
            if ($manager->move($new) && $permission->save()) {
                return response()->json([
                    'status'  => true,
                    'message' => trans('admin.move_succeeded'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function newFolder(Request $request)
    {
        $dir = $request->get('dir');
        $name = $request->get('name');

        $manager = new MediaManager($dir);

        // Quản lý permission 
        if ($dir != "/" && $dir != null) {
            $slug = "documents".str_replace("/", ".", $dir."/".$name);
        }
        else {
            $slug = "documents".str_replace("/", ".", "/".$name);
        }
        $permission = new Permission(['name' => $slug, 'slug' => $slug]);

        try {
            if ($manager->newFolder($name) && $permission->save()) {
                return response()->json([
                    'status'  => true,
                    'message' => trans('admin.move_succeeded'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
