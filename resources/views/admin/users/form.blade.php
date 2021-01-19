@csrf
<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" id="name"
           class="form-control @error('name') is-invalid @enderror"
           placeholder="Name"
           minlength="3"
           required
           value="{{ old('name', $user->name) }}">
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input type="text" name="email" id="email"
           class="form-control @error('email') is-invalid @enderror"
           placeholder="Email"
           minlength="3"
           required
           value="{{ old('email', $user->email) }}">
    @error('email')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
    <input type="checkbox" name="active" class="" id="active" value=1
           <?php
           if (old('active',$user->active) == 1) {
               echo "checked ";
           }
           ?>
           >
    <label class="form-check-label" for="active">Active</label>
    <input type="checkbox" name="admin" class=""  id="admin" value=1
           <?php
           if (old('admin',$user->admin) == 1) {
               echo "checked ";
           }
           ?>
           >

    <label class="form-check-label" for="admin">Admin</label>

<div class="form-group">
    <button type="submit" class="btn btn-success">Save user</button>
</div>