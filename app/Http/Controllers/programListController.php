<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;


class programListController extends Controller
{

	/*
	protected $tasks;

	public function __construct(TaskRepository $tasks) {
		$this->middleware('auth');
		$this->tasks = $tasks;
	}
	*/


	public function index(Request $request) {

		/*
		 * http://l5.appkr.kr/lessons/09-query-builder.html
		 */

		//$list = DB::select('select * from program_list where 1=1');	//날쿼리 사용
		$list = DB::table('program_list')->get()->toArray();		//쿼리 빌더 사용

		// 블레이드 파일 , 변수
		return view('programList/index', [
			'list' => $list,

		]);


	}

	/*

	public function show(Task $task) {

		$tasks = Auth::user()->tasks()->get();

		return view('tasks', ['task'=>$task, 'tasks'=>$tasks]);
	}

	public function store(Request $request) {

		$this->validate($request, [
			'name' => 'required|max:255',
		]);

		$request->user()->tasks()->create([
			'name' => $request->name,
		]);

		return redirect('/tasks');
	}

	public function destroy(Request $request, Task $task) {

		$this->authorize('destroy', $task);
		$task->delete();
		return redirect('/tasks');

	}

	public function update(Request $request, $id) {

		//분석 해야 할것.

		$task = Task::find($id);

		$task->name = $request->input('name');

		$task->save();

		return redirect('/tasks/'.$id);
	}

	*/


}
