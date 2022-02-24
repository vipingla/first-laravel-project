<!DOCTYPE html>
<html>
<head>
    <title>Test Project</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <style>
    .w-5{
      display: none;
    }
  </style>
  </head>
<body>
  <div class="container mt-4">
    <div class="row">
      <div class="col-sm-5">
        @if(session('status'))
          <div class="alert alert-success">
              {{ session('status') }}
          </div>
        @endif
        @if(session('error'))
          <div class="alert alert-danger">
              {{ session('error') }}
          </div>
        @endif
        <div class="card">
          <div class="card-header text-center font-weight-bold">
            Save user data
          </div>
          <div class="card-body">
            <form name="add-user-form" id="add-user-form" method="post" action="{{url('store-form')}}">
            @csrf
              <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{old('name')}}">
                @error('name')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Skills</label>
                <textarea name="skills" class="form-control">{{old('skills')}}</textarea>
                @error('skills')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Expertise</label>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="expertise" value="php">PHP
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="expertise"  value="python">Python
                  </label>
                </div>
                <div class="form-check disabled">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="expertise"  value="java">Java
                  </label>
                </div>
                @error('expertise')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
              </div>  

              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-sm-7">
        <div class="card">
          <div class="card-header text-center font-weight-bold">
            User data list
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Skills</th>
                  <th>Expertise</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @if(count($data) > 0)
                @foreach ($data as $item)
                @php $userID= Crypt::encrypt($item->id); @endphp
                <tr>
                  <td>{{ucfirst($item->name)}}</td>
                  <td>
                    @if(strlen($item->skills) > 10)
                    {{substr($item->skills,0,10)}}<a href='javascript:void(0);' title="{{$item->skills}}">...</a>
                    @else
                    {{$item->skills}}
                    @endif
                  </td>
                  <td>{{ucfirst($item->expertise)}}</td>
                  <td>
                    <a href="javascript:void(0)" id="edit-user" data-id="{{ $userID }}" class="btn btn-primary">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="javascript:void(0)" id="delete-user" data-id="{{ $userID }}" class="btn btn-danger">
                      <i class="fa fa-trash-o"></i>
                    </a>
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="4" class="text-danger text-center"><span>No data found!</span></td>
                </tr>
                @endif
              </tbody>
            </table>
            {{$data->links()}}
          </div>
        </div>  
      </div>      
  </div>  
</div>
<div class="modal fade" id="ajax-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="userShowModal">Update User Details</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <div class="modal-body">
          <form name="edit-user-form" id="edit-user-form" method="post" action="{{url('update-form')}}">
          @csrf
          <input type="hidden" name="user_id" id="user_id">
          <input type="hidden" name="oldUserName" id="oldUserName" value="">  
            <div class="form-group">
              <label for="exampleInputEmail1">Name</label>
              <input type="text" id="editname" name="name" class="form-control" value="">
              <div class="alert alert-danger mt-1 mb-1 d-none" id="nameError"></div>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Skills</label>
              <textarea name="skills" id="skills" class="form-control"></textarea>
              <div class="alert alert-danger mt-1 mb-1 d-none" id="skillsError"></div>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Expertise</label>
              <div class="form-check">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input" id="expertise_php" name="expertise" value="php">PHP
                </label>
              </div>
              <div class="form-check">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input" id="expertise_python" name="expertise"  value="python">Python
                </label>
              </div>
              <div class="form-check">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input" id="expertise_java" name="expertise"  value="java">Java
                </label>
              </div>
              @error('expertise')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
            </div>  

            <button type="button" class="btn btn-primary" onclick="return updateuser();">Submit</button>
          </form>        
        </div>
    </div>
  </div>
</div>  
</body>
<!--script src="{{asset('js/jquery-3.6.0.js')}}"></script-->
<script>
$(document).ready(function () {
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
 
   /* When click edit user */
    $('body').on('click', '#edit-user', function () {
      $('#nameError').addClass('d-none');
      $('#skillsError').addClass('d-none');
      var user_id = $(this).data('id');
      $.get('ajax-crud/' + user_id +'/edit', function (data) {
         $('#userShowModal').html("Update User Data");
          $('#ajax-modal').modal('show');
          $('#user_id').val(data.id);
          $('#editname').val(data.name);
          $('#oldUserName').val(data.name);
          $('#skills').val(data.skills);
          if(data.expertise == 'php')
            $("#expertise_php").prop("checked", true);
          else if(data.expertise == 'python')  
            $("#expertise_python").prop("checked", true);
          else
            $("#expertise_java").prop("checked", true);
      })
   });
   /* When click edit user */
   $('body').on('click', '#delete-user', function () {
      var user_id = $(this).data('id');
      if(confirm('Are you sure?'))
      {
        $.get('ajax-crud/' + user_id +'/delete', function (data) {
          window.location.reload();
        })
      }
      
   });
});

function updateuser()
{
  var action = $('#edit-user-form').attr('action');
  var formData = $('#edit-user-form').serialize();
  $.ajax({
      type: 'post',
      url: action,
      data: formData,
      dataType: 'json',
      success: function (data) {
        //alert('form was submitted');
        //console.log(data);
        if(data.status == true)
        {
           alert(data.message);
           window.location.reload();
        }
      },error:function(err)
      {
        console.log(err.responseJSON.errors);
        var myObj = err.responseJSON.errors;
        if(myObj.hasOwnProperty('name'))
        {
            $('#nameError').removeClass('d-none');
            $('#nameError').text(myObj.name);
            //$('#skillsError').addClass('d-none');
        }
        else if(myObj.hasOwnProperty('skills'))
        {
          $('#skillsError').removeClass('d-none');
          $('#skillsError').text(myObj.skills);
          //$('#nameError').addClass('d-none');
        }
      }
    });
}
</script>
</html>