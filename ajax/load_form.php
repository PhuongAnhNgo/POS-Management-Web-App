<!-- Form to create new users -->
<form action="manage_users.php" method="post" class="form-container">
                <div class="input-group mb-3">
                <span class="input-group-text">Name</span>
                  <input type="text" class="form-control" name="name" >
                </div>
                <div class="input-group mb-3">
                <span class="input-group-text">Username</span>
                  <input type="text" class="form-control" name="username" >
                </div>
                <div class="input-group mb-3">
                <span class="input-group-text">Password</span>
                  <input type="password" class="form-control" name="password" >
                </div>
                <div class="col form-check form-check-inline mb-3">
                  <input class="form-check-input" type="radio" name="type"  value="1">
                  <label class="form-check-label" for="inlineRadio1">Admin</label>
                </div>
                <div class="form-check form-check-inline mb-3">
                  <input class="form-check-input" type="radio" name="type"  value="2">
                  <label class="form-check-label" for="inlineRadio2">Staff</label>
                </div>
            <br>  
            <button name="user_id" type="submit" class="btn btn-primary" value="<?php echo $_POST['userId'];?>">Go</button>
            <button id="closeForm" type="button" class="btn btn-secondary cancel">Cancel</button>
        </form>