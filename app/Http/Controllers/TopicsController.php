<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\Auth;
use App\Handlers\ImageUploadHandler;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Topic $topic,Request $request)
	{
		$topics = $topic->withOrder($request->order)->paginate(20);
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request,Topic $topic)
	{
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();
        return redirect()->route('topics.show',$topic->id)->with('message','成功创建话题');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', '更新成功');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', '删除成功');
	}
	public function uploadImage(Request $request,ImageUploadHandler $uploader)
	{
		//初始化数据，默认返回失败
		$data = [
			'success'   => false,
			'msg'	    => '上传失败',
			'file_path' => ''
		];
		//判读是否有文件上传，赋值给file
		if( $request->upload_file ){
			//将图片保存本地
			$res = $uploader->save($request->upload_file,'topics',\Auth::id(),1024);
			if( $res ){
				$data = [
					'success'	=> true,
					'msg'		=> '上传成功',
					'file_path' => $res['path']
				];
			}
		}
		return $data;
	}
}