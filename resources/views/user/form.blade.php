 <div class="modal-header py-2 bg-secondary text-light">
     <h5 class="modal-title" style="font-weight: bold">
         {{ isset($data) ? 'ユーザー編集' : 'ユーザー新規' }}
     </h5>
 </div>
 <div class="modal-body">
     <form method="POST" id="submitForm" action="{{ url('user/submit') }}">
         @csrf
         @method(isset($data) ? 'PUT' : 'POST')
         <input type="hidden" value="{{ isset($data) ? $data->id : 0 }}" name="id" />
         <div class="row">
             <div class="required mb-3">
                 <label for="autofocus" class="form-label">ユーザー名</label>
                 <input id="autofocus" name="username" type="text" class="form-control"
                     value="{{ isset($data) ? $data->username : '' }}" />
             </div>
             <div class="mb-3">
                 <div class="row">
                     <div class="col-9">
                         <label for="role" class="form-label">役割</label>
                         <select id="role" name="role" class="form-select">
                             <option value="superadmin" @selected(isset($data) && $data->role == 'superadmin')>スーパー管理者</option>
                             <option value="admin" @selected(isset($data) && $data->role == 'admin')>管理者</option>
                             <option value="cashier" @selected(isset($data) && $data->role == 'cashier')>レジ</option>
                         </select>
                     </div>
                     <div class="col-3">
                         <label for="active" class="form-label">有効</label>
                         <div class="form-check form-switch">
                             <input class="form-check-input" type="checkbox" role="switch"
                                 id="active" name="active" @checked(isset($data) && $data->active) />
                         </div>
                     </div>
                 </div>
             </div>
             <div class="required mb-3">
                 <label for="password" class="form-label">パスワード</label>
                 <input id="password" name="password" type="password" class="form-control" />
             </div>
             <div class="mb-3">
                 <label for="password_confirmation" class="form-label">パスワード（確認）</label>
                 <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" />
             </div>
         </div>
     </form>
 </div>
 <div class="modal-footer">
     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
         <i class="bi bi-x-lg"></i> キャンセル
     </button>
     <button type="submit" class="btn btn-primary" form="submitForm">
         <i class="bi bi-floppy" style="padding-right: 3px;"></i>保存
     </button>
 </div>
