@extends('auth.app')

@section('content')
<div class="login-content">
	<form action="<?= route('custom.login') ?>" method="POST" autocomplete="off">
        @csrf
	    <h2 class="title">Login</h2>
        <h5>Email</h5>
        @error('email')
        <div class="invalid-feedback" style="color:red;">
            {{ $message }}
        </div>
        @enderror
   		<div class="input-div one">
   		   <div class="i">
   		   		<i class="fas fa-user"></i>
   		   </div>
         <div class="div">
            <input type="email" name="email" class="input @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukan email">
   		   </div>
   		</div>
        <h5>Password</h5>
   		<div class="input-div one">
   		   <div class="i"> 
   		    	<i class="fas fa-lock"></i>
   		   </div>
   		   <div class="div">
   		    	<input type="password" name="password" class="input @error('password') is-invalid @enderror" placeholder="Masukkan password">
    	   </div>
    	</div>
    	<input type="submit" name="Submit" class="btn" value="Login">
    </form>
</div>
@endsection