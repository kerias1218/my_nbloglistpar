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
		$list = DB::table($this->program_list_table)->orderBy('pl_order','asc')->paginate(20);		//쿼리 빌더 사용

		// 블레이드 파일 , 변수
		return view('programList/index', [
			'list' => $list,
		]);
	}


	// 순서 업데이트
	public function ajaxSortUpdate(Request $request) {
		$input = $request->input();

		$temp =  $this->dbFieldArr($input, 'pl_');
		$data = array_flip($temp['pl_order']);

		print_r($data);

		foreach($data as $k=>$val) {
			DB::table($this->program_list_table)->where('pl_idx',$k)->update(array('pl_order'=>$val));
		}
		exit;
	}

	// 새로 저장 (refresh)
	public function insert(Request $request) {

		$input = $request->input();

		$data = $this->dbFieldArr($input, 'pl_');
		unset($input['_token']);

		$isrs = DB::table($this->program_list_table)->where('pl_title', $input['pl_title'])->first();

		if ($isrs !== null) {
			echo "<script>alert('이미존재합니다.')</script>";
		} else {
			DB::table($this->program_list_table)->insert($data);
		}


		return redirect('programList');

	}

	public function ajaxUpdate(Request $request) {
		$result = null;
		$input = $request->input();

		$data = $this->dbFieldArr($input, 'pl_');

		unset($data['pl_idx']);
		$res = DB::table($this->program_list_table)->where('pl_idx', $input['pl_idx'])->update($data);

		if( $res ) {
			$result['status'] = $res;
			$result['msg'] = 'ok';
			$result['pl_idx'] = $input['pl_idx'];

		}

		echo json_encode($result);
	}

	// 아래 2개 비슷한 함수임 리팩토링 해야될것.
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
		echo json_encode($result);
	}


	public function dbFieldArr($input, $prefix) {
		$data = array();
		foreach($input as $k => $val) {
			if( preg_match("!^".$prefix."!is", $k) ) $data[$k] = $val;
		}

		return $data;
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
