<!-- Modal Window -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Member Login</h4>
      </div>
      <div class="modal-body">
        <form action="index.php" method="post" name="loginform">
                <p>Username: <input type="text" size="20" maxlength="60" value="" name="loginuser" required></p>
                <p>Password: <input type="password" size="20" maxlength="255" value="" name="loginpass" required></p>
                <p><input type="submit" name="login_submit" value="Login"></p>
            </form>
      </div>
    </div>
  </div>
</div>
<!-- end modal window -->

 