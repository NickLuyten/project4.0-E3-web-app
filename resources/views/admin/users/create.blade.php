@csrf
<div class="form-group">
    <label for="firstName">Voornaam</label>
    <input type="text" name="firstName" id="firstName"
           class="form-control @error('firstName') is-invalid @enderror"
           placeholder="firstName"
           minlength="3"
           required
           value="{{ old('firstName', $user->firstName) }}">
    @error('firstName')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="lastName">Achternaam</label>
    <input type="text" name="lastName" id="lastName"
           class="form-control @error('lastName') is-invalid @enderror"
           placeholder="firstName"
           minlength="3"
           required
           value="{{ old('lastName', $user->lastName) }}">
    @error('firstName')
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
