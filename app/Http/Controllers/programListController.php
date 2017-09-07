<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;


class programListController extends Controller
{


	public $program_list_table;

	public function __construct() {
		//$this->middleware('auth');
		//$this->tasks = $tasks;
		$this->program_list_table = 'program_list';
	}



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

	// update (ajax)
	public function update(Request $request) {

	}


	// 새로 저장
	public function insert(Request $request) {

		$input = $request->input();


		unset($input['_token']);

		$isrs = DB::table($this->program_list_table)->where('pl_title', $input['pl_title'])->first();

		if( $isrs !== null ) {
			echo "<script>alert('이미존재합니다.')</script>";
		}
		else {
			DB::table($this->program_list_table)->insert($input);
		}


		return redirect('programList');
	}


	// 아래 2개 비슷한 함수임 리팩ㅌ링 해야될것.
	public function ajaxCheck(Request $request) {
		$result = null;

		$input = $request->input();

		$isrs = DB::table($this->program_list_table)->where($input['field'], $input['value'])->first();
		if( $isrs !== null ) {
			$result['status'] = '10';
			$result['msg'] = '이미 존재합니다.';
		}
		else {
			$result['status'] = '1';
			$result['msg'] = 'ok';
		}

		echo json_encode($result);
	}

	public function ajaxList(Request $request) {
		$result = null;

		$input = $request->input();
		$result = DB::table($this->program_list_table)->where($input['field'], $input['value'])->first();
		//print_r($result);
		//exit;
		echo json_encode($result);
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
