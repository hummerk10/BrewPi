</br>
</br>
<div class="row">
<div class="col-sm-8 text-center">
<H1>Welcome to the TLD Brewery Controller.</H1>

<p> To get started please sign in, or register</p>  

Add news feed! 
</div>

    
		<div class="col-sm-3">
				<div class="" id="loginModal">
              <div class="modal-header">
                <h3>Have an Account?</h3>
              </div>
              <div class="modal-body">
                <div class="well">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
                    <li><a href="#create" data-toggle="tab">Create Account</a></li>
                  </ul>
                  <div id="myTabContent" class="tab-content">
                    <div class="tab-pane active in" id="login">
                      <form class="form-horizontal" action='' method="POST">
                        <fieldset>
                          <div id="legend">
                            <legend class="">Login</legend>
                          </div>    
                          <div class="control-group">
                            <!-- Username -->
								<label for="inputEmail" class="sr-only">Email address</label>
        						<input type="text" id="inputUser" name="username" class="form-control" placeholder="Username"  autofocus>
        
        			        <!-- Password -->
        						<label for="inputPassword" class="sr-only">Password</label>
        						<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" >
        						<div class="checkbox">
          						<label>
            						<input type="checkbox" value="remember-me"> Remember me
          						</label>
        					</div>

                          <div class="control-group">
                            <!-- Button -->
                            <div class="controls">
                              <button type="submit" name="signin" value="login" class="btn btn-primary">Sign In</button> 
                            </div>
                          </div>
                        </fieldset>
                      </form>                
                    </div>
                    <div class="tab-pane fade" id="create">
                      <form id="tab" method="post">
                        <label for="usr">Name:</label>
  						<input type="text" class="form-control" id="Name" name="Name" placeholder="Name">
                        <label for="usr">Email:</label>
  						<input type="text" class="form-control" id="Email" name="Email" placeholder="Email">
  						<label for="usr">Username:</label>
  						<input type="text" class="form-control" id="Username" name="Username" placeholder="Username">
  						<label for="usr">Password:</label>
						<input type="password" class="form-control" id="Password" name="Password" placeholder="Password">
						
                        <div>
                            <button type="submit" name="register" value="register" class="btn btn-primary">Register</button>
                        </div>
                      </form>
                    </div>
                </div>
              </div>
			</div>
			</div>

</div>