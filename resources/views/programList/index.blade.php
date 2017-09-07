
@extends('master')

  @section('content')
    <div class="content-wrapper">
      <div class="container-fluid">



        <div class="well well-lg">
          <button type="button" class="btn btn-primary btn-sm">등록</button>
          <table class="table table-hover">
            <thead>
            <tr>
              <th width="20%">고유번호</th>
              <th width="20%">요일</th>
              <th width="40%">프로그램명</th>
              <th width="20%">수정/삭제</th>
            </tr>
            </thead>
            <tbody>

            @foreach($list as $k => $val)
            <tr>
              <th scope="row">{{ $val->pl_idx }}</th>
              <td>{{ $val->pl_day }}</td>
              <td>{{ $val->pl_title }}</td>
              <td>수정/삭제</td>
            </tr>
            @endforeach

            </tbody>
          </table>
        </div>

      </div>
    </div>
  @stop