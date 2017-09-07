
@extends('master')

  @section('content')
    <div class="content-wrapper">
      <div class="container-fluid">



        <div class="well well-lg">
          <button type="button" class="btn btn-primary btn-sm" data-target="#layerpop" data-toggle="modal">등록</button>
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
              <td>
                <button type="button" class="btn btn-info btn-xs programMod" data-pl_idx="{{ $val->pl_idx }}" data-toggle="modal">수정</button>
                <button type="button" class="btn btn-danger btn-xs">삭제</button>
              </td>
            </tr>
            @endforeach

            </tbody>
          </table>
        </div>



        <!-- 모달 -->
        <div class="modal fade" id="layerpop" >
          <div class="modal-dialog">
            <div class="modal-content">
              <!-- header -->
              <div class="modal-header">
                <!-- header title -->
                <h4 class="modal-title">프로그램 정보 등록</h4>

                <!-- 닫기(x) 버튼 -->
                <button type="button" id="modal_close" class="close" data-dismiss="modal">×</button>
              </div>
              <!-- body -->
              <div class="modal-body">



                <!--
                <div class="card-header">
                  Register an Account
                </div>
                -->
                <div class="card-body">
                  <form id="_form" method="POST" action="/programListSave">
                    <input name="check_title" id="check_title" value="N" type="hidden">
                    <input name="mod" id="mod" value="N" type="hidden">

                    {{ csrf_field() }}

                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-3">
                          <label for="pl_day">요일</label>
                          <!--<input type="text" class="form-control" id="exampleInputName" aria-describedby="nameHelp" placeholder="요일">
                          -->
                          <select class="form-control" name="pl_day" id="pl_day">
                            <option value="매일">매일</option>
                            <option value="월">월</option>
                            <option value="화">화</option>
                            <option value="수">수</option>
                            <option value="목">목</option>
                            <option value="금">금</option>
                            <option value="토">토</option>
                            <option value="일">일</option>
                          </select>

                        </div>
                        <div class="col-md-9">
                          <label for="pl_title">방송 프로그램명</label>
                          <input required type="text" class="form-control" id="pl_title" name="pl_title"  placeholder="프로그램명">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="pl_url">방송 URL</label>
                      <input required type="text" class="form-control" id="pl_url" name="pl_url"  placeholder="방송 URL">
                    </div>

                    <div class="form-group">
                      <label for="pl_img_url">이미지 URL</label>
                      <input required type="text" class="form-control" id="pl_img_url" name="pl_img_url" aria-describedby="emailHelp" placeholder="이미지 URL">
                    </div>

                    <div class="form-group">
                      <label for="pl_explain">방송 설명</label>
                      <textarea required class="form-control" id="pl_explain" name="pl_explain" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                      <label for="pl_production_crew">제작진</label>
                      <textarea class="form-control" name="pl_production_crew" id="pl_production_crew" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                      <label for="pl_thetime">편성</label>
                      <textarea required class="form-control" name="pl_thetime" id="pl_thetime" rows="3"></textarea>
                    </div>


                    <!--
                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-6">
                          <label for="exampleInputPassword1">Password</label>
                          <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <div class="col-md-6">
                          <label for="exampleConfirmPassword">Confirm password</label>
                          <input type="password" class="form-control" id="exampleConfirmPassword" placeholder="Confirm password">
                        </div>
                      </div>
                    </div>
                    -->

                    <a class="btn btn-primary btn-lg btn-block" id="btnProgramInsert">등 록</a>
                  </form>

                  <!--
                  <div class="text-center">
                    <a class="d-block small mt-3" href="login.html">Login Page</a>
                    <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
                  </div>
                  -->

                </div>

              </div>

              <!-- Footer -->
              <!--
              <div class="modal-footer">
                Footer
                <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
              </div>
              -->

            </div>
          </div>
        </div>



      </div>
    </div>


    <script>

      // 수정 클릭
      $(".programMod").on("click", function() {
        var pl_idx = $(this).attr("data-pl_idx");
        var params = 'field=pl_idx&value='+pl_idx+'&_token={{ csrf_token() }}';
        var url = '/ajaxList';

        $.ajax({
          url: url
          , type: 'POST'
          , data: params
          , cache: false
          , dataType: 'json'
          , async: false
          , success: function (rdata) {
              $("#pl_title").val(rdata.pl_title);
              $("#pl_url").val(rdata.pl_url);
              $("#pl_img_url").val(rdata.pl_img_url);
              $("#pl_explain").val(rdata.pl_explain);
              $("#pl_thetime").val(rdata.pl_thetime);
              $('#pl_day option[value="'+rdata.pl_day+'"]').attr('selected','selected');

              $('#mod').val('Y');
          }
          , error: function (result) {
            alert("작업 실패 : " + result);
          }
        });

        //기존 정보 ajax 로 get
        $("#layerpop").modal();
      });

      // 저장 클릭
      $("#btnProgramInsert").on("click",function() {
        var data = $("#_form").serialize();

        if( $('#mod').val() == 'N' && $("#check_title").val() == 'N' ) {
          alert('이미 등록되어있는 방송입니다.');
          return false;
        }

        $("#_form").submit();

        //$("#modal_close").click();
      });


      // 제목 중복검사
      $("#pl_title").on("blur", function() {
        var pl_title = $(this).val();
        var params = 'field=pl_title&value='+pl_title+'&_token={{ csrf_token() }}';
        var url = '/ajaxCheck';

        $.ajax({
          url: url
          , type: 'POST'
          , data: params
          , cache: false
          , dataType: 'json'
          , async: false
          , success: function (rdata) {

            //data = JSON.parse(rdata);
            console.log(rdata);
            if( rdata.status == 1) {

              //alert('아직 등록 안됬습니다.');

              /*
               $("#idCheckResult").empty();
               $("#idCheckResult").append('[아직 등록안됬습니다.]').fadeIn(2000).fadeOut(3000);
               */

              $("#check_title").val("Y");
            }
            else {
              alert('이미 등록된 방송 입니다.');


            }
          }
          , error: function (result) {
            alert("작업 실패 : " + result);
          }
        });


      });






    </script>




  @stop