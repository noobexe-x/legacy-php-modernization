 <div class="modal-header py-2 bg-secondary text-light">
     <h5 class="modal-title" style="font-weight: bold">
         パスワード変更
     </h5>
 </div>
 <div class="modal-body">
     <form method="POST" id="submitForm" action="{{ url('user/change-password') }}">
         @csrf
         @method('POST')
         <div class="row">
             <div class="required mb-3">
                 <label class="form-label">ユーザー名</label>
                 <input type="text" class="form-control" disabled value="{{ request()->user()?->username }}" />
             </div>
             <div class="required mb-3">
                 <label for="autofocus" class="form-label">現在のパスワード</label>
                 <input id="autofocus" name="old_password" type="password" class="form-control" />
             </div>
             <div class="required mb-3">
                 <label for="new_password" class="form-label">新しいパスワード</label>
                 <input id="new_password" name="new_password" type="password" class="form-control" />
             </div>
             <div class="required mb-3">
                 <label for="new_password_confirmation" class="form-label">新しいパスワード（確認）</label>
                 <input id="new_password_confirmation" name="new_password_confirmation" type="password"
                     class="form-control" />
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
