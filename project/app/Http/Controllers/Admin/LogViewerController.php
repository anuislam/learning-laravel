<?php
namespace App\Http\Controllers\Admin;
use Rap2hpoutre\LaravelLogViewer\LaravelLogViewer;
use Illuminate\Http\Request;
use App\UserPermission;
use \Auth;
use \Input;
use App\UserModel;
use App\mediaModel;
use Image;
use Validator;
use App\BlogPost;
use App\notifications;

if (class_exists("\\Illuminate\\Routing\\Controller")) {
    class BaseController extends \Illuminate\Routing\Controller {}
} else if (class_exists("Laravel\\Lumen\\Routing\\Controller")) {
    class BaseController extends \Laravel\Lumen\Routing\Controller {}
}

class LogViewerController extends BaseController
{
    protected $request;

    private $usermodel = '';
    private $permission = '';
    private $mediaModel = '';
    private $postmodel = '';
     private $notification = '';

    public function __construct ()
    {
        $this->middleware('auth');
        $this->request = app('request');
        $this->usermodel    = new UserModel();
        $this->permission   = new UserPermission();  
        $this->mediaModel   = new mediaModel();  
        $this->postmodel    = new BlogPost();  
        $this->notification    = new notifications(); 
    }

    public function index()
    {
        $usermodel      = $this->usermodel;
        $current_user   = $usermodel->current_user();

        if ($this->request->input('l')) {
            LaravelLogViewer::setFile(base64_decode($this->request->input('l')));
        }

        if ($this->request->input('dl')) {
            return $this->download(LaravelLogViewer::pathToLogFile(base64_decode($this->request->input('dl'))));
        } elseif ($this->request->has('del')) {
            app('files')->delete(LaravelLogViewer::pathToLogFile(base64_decode($this->request->input('del'))));
            return $this->redirect($this->request->url());
        } elseif ($this->request->has('delall')) {
            foreach(LaravelLogViewer::getFiles(true) as $file){
                app('files')->delete(LaravelLogViewer::pathToLogFile($file));
            }
            return $this->redirect($this->request->url());
        }

        return app('view')->make('laravel-log-viewer::log', [
            'logs' => LaravelLogViewer::all(),
            'files' => LaravelLogViewer::getFiles(true),
            'current_file' => LaravelLogViewer::getFileName(),
            'current_user'        => $current_user,
            'notification'        => $this->notification->get_header_notification(),
        ]);
    }

    private function redirect($to)
    {
        if (function_exists('redirect')) {
            return redirect($to);
        }

        return app('redirect')->to($to);
    }

    private function download($data)
    {
        if (function_exists('response')) {
            return response()->download($data);
        }

        // For laravel 4.2
        return app('\Illuminate\Support\Facades\Response')->download($data);
    }
}
