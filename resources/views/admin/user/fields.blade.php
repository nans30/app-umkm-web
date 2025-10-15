@use('App\Enums\RoleEnum')

<div class="row">
    <div class="col-sm-6">
        <div class="mb-3">
            <label>Username<span class="text-danger">*</span></label>
            <input class="form-control" type="text" name="username"
                value="{{ isset($user->username) ? $user->username : old('username') }}"
                placeholder="Enter Username">
            @error('username')
                <span class="text-danger d-block"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="col-sm-6">
        <div class="mb-3">
            <label>Email<span class="text-danger">*</span></label>
            <input class="form-control" type="email" name="email"
                value="{{ isset($user->email) ? $user->email : old('email') }}"
                placeholder="Enter Email">
            @error('email')
                <span class="text-danger d-block"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="mb-3">
            <label>Password<span class="text-danger">*</span></label>
            <input class="form-control" type="password" name="password" placeholder="Enter Password">
            @error('password')
                <span class="text-danger d-block"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="col-sm-6">
        <div class="mb-3">
            <label>Confirm Password<span class="text-danger">*</span></label>
            <input class="form-control" type="password" name="confirm_password" placeholder="Confirm Password">
            @error('confirm_password')
                <span class="text-danger d-block"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="mb-3">
            <label>Phone</label>
            <input class="form-control" type="number" name="phone"
                value="{{ isset($user->phone) ? $user->phone : old('phone') }}"
                placeholder="Enter Phone Number">
            @error('phone')
                <span class="text-danger d-block"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="mb-3">
            <label>Date of Birth</label>
            <input class="form-control" type="date" name="dob"
                value="{{ isset($user->dob) ? $user->dob : old('dob') }}">
            @error('dob')
                <span class="text-danger d-block"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="mb-3">
            <label>Gender</label>
            <select class="form-select" name="gender">
                <option value="" disabled hidden selected>Select Gender</option>
                <option value="male" @selected(old('gender', $user->gender ?? '') == 'male')>Male</option>
                <option value="female" @selected(old('gender', $user->gender ?? '') == 'female')>Female</option>
            </select>
            @error('gender')
                <span class="text-danger d-block"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        @php
            $image = $user->getFirstMedia('image');
        @endphp
        <label>Avatar</label>
        <input class="form-control mb-3" type="file" name="image">
        @if ($image)
            <div class="mt-3">
                <img src="{{ $image->getUrl() }}" alt="Image" class="img-thumbnail" width="100">
                <div class="mt-2">
                    <a href="{{ route('admin.user.removeImage', $user->id) }}" class="text-danger">Remove</a>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="mb-3">
            <label>Role<span class="text-danger">*</span></label>
            <select class="form-control" name="role_id">
                <option value="" disabled hidden selected>Select Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @selected(old('role_id', $user->roles->pluck('id')->first() ?? '') == $role->id)>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <span class="text-danger d-block"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="mb-3">
            <label>Status<span class="text-danger">*</span></label>
            <select class="form-select" name="status">
                <option value="" disabled hidden selected>Select Status</option>
                <option value="1" @selected(old('status', $user->status ?? '') == 1)>Active</option>
                <option value="0" @selected(old('status', $user->status ?? '') == 0)>Inactive</option>
            </select>
            @error('status')
                <span class="text-danger d-block"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="mb-3">
            <label>Location</label>
            <input class="form-control" type="text" name="location"
                value="{{ isset($user->location) ? $user->location : old('location') }}"
                placeholder="Enter Location">
            @error('location')
                <span class="text-danger d-block"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="mb-3">
            <label>About Me</label>
            <textarea class="form-control" rows="3" name="about_me" placeholder="Tell something about yourself">{{ isset($user->about_me) ? $user->about_me : old('about_me') }}</textarea>
            @error('about_me')
                <span class="text-danger d-block"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="mb-3">
            <label>Bio</label>
            <textarea class="form-control" rows="4" name="bio" placeholder="Enter Bio">{{ isset($user->bio) ? $user->bio : old('bio') }}</textarea>
            @error('bio')
                <span class="text-danger d-block"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>

<div class="text-end">
    <a href="{{ route('admin.user.index') }}" class="btn btn-danger">
        <i class="ti ti-cancel me-1"></i>Cancel
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="ti ti-device-floppy me-1"></i>Save
    </button>
</div>
