<!-- Modal Window -->
<div class="modal fade" id="myRegModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Member Registration</h4>
      </div>
      <div class="modal-body">
        <form action="index.php" method="post" name="loginform">
          
                <p>First Name: <input type="text" size="20" maxlength="50" value="" name="firstname" required></p>
                <p>Last Name: <input type="text" size="20" maxlength="50" value="" name="lastname" required></p>
                <p>Email: <input type="text" size="20" maxlength="150" value="" name="email" required></p>
            
                <p>Display Name: <input type="text" size="20" maxlength="50" value="" name="displayname" required></p>
                <p>Primary Phone: <input type="text" size="20" maxlength="50" value="" name="primaryphone" required></p>
                <p>Alt Phone: <input type="text" size="20" maxlength="50" value="" name="displayname" required></p>
           
          <p><input type="submit" name="login_submit" value="Register"></p>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- end modal window -->

 