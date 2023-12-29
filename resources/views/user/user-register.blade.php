@extends('layouts.app')

@section('content')
<style>
    *,
*:before,
*:after{
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}
body{
  background-color: #080710;
}
.background{
  width: 430px;
  height: 550px;
  position: absolute;
  transform: translate(-50%,-50%);
  left: 50%;
  top: 50%;
}
.background .shape{
  height: 200px;
  width: 200px;
  position: absolute;
  border-radius: 50%;
}
.shape:first-child{
  background: linear-gradient(
      #1845ad,
      #23a2f6
  );
  left: -80px;
  top: -80px;
}
.shape:last-child{
  background: linear-gradient(
      to right,
      #ff512f,
      #f09819
  );
  right: -30px;
  bottom: -80px;
}
form{
  height: 580px;
  width: 400px;
  background-color: rgba(255,255,255,0.13);
  position: absolute;
  transform: translate(-50%,-50%);
  top: 50%;
  left: 50%;
  border-radius: 10px;
  backdrop-filter: blur(10px);
  border: 2px solid rgba(255,255,255,0.1);
  box-shadow: 0 0 40px rgba(8,7,16,0.6);
  padding: 50px 35px;
  margin-top: calc(10vh - 60px) !important;
}
form *{
  font-family: 'Poppins',sans-serif;
  color: #ffffff;
  letter-spacing: 0.5px;
  outline: none;
  border: none;
}
form h3{
  font-size: 32px;
  font-weight: 500;
  line-height: 42px;
  text-align: center;
}

label{
  display: block;
  margin-top: 30px;
  font-size: 16px;
  font-weight: 500;
}
input{
  display: block;
  height: 50px;
  width: 100%;
  background-color: rgba(255,255,255,0.07);
  border-radius: 3px;
  padding: 0 10px;
  margin-top: 8px;
  font-size: 14px;
  font-weight: 300;
}
::placeholder{
  color: #e5e5e5;
}
button{
  margin-top: 30px;
  width: 100%;
  background-color: #ffffff;
  color: #080710;
  padding: 15px 0;
  font-size: 18px;
  font-weight: 600;
  border-radius: 5px;
  cursor: pointer;
}
.social{
margin-top: 10px;
display: flex;
}
.social div{
background: red;
width: 150px;
border-radius: 3px;
padding: 5px 10px 10px 5px;
background-color: rgba(255,255,255,0.27);
color: #eaf0fb;
text-align: center;
}
.social div:hover{
background-color: rgba(255,255,255,0.47);
}
.social .fb{
margin-left: 25px;
}
.social i{
margin-right: 4px;
}

</style>

<div class="background">
    <div class="shape"></div>
    <div class="shape"></div>
</div>
    <form action="{{ route('store.user') }}" method="post" class="form">
        @csrf
        <h3>Register Here</h3>
        <div class="form-group">
            <label for="name">Full name</label>
            <input type="text" name="name" placeholder="Full name" id="name" class="input" required>
            @if($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" placeholder="Email" id="email" class="input" required>
            @if($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" id="password" class="input" required>
            @if($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
            @endif
        </div>
        <button type="submit">Register</button>
        <div class="text-center" style="margin-top: 10px;">
            <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
        </div>
    </form>
</div>
@endsection
