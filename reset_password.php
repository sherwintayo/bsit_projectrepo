<?php require_once('./config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>
<body class="hold-transition ">
<script>
    start_loader()
</script>
<style>
    html, body{
      height:calc(100%) !important;
      width:calc(100%) !important;
    }
    body{
      background-size:cover;
      background-repeat:no-repeat;
    }
</style>
<div class="h-100 d-flex align-items-center w-100" id="reset-password">
    <div class="col-12 d-flex justify-content-center align-items-center">
        <div class="card card-outline card-primary rounded-0 shadow col-lg-4 col-md-6 col-sm-12">
            <div class="card-header">
                <h5 class="card-title text-center text-dark"><b>Reset Password</b></h5>
            </div>
            <div class="card-body">
                <form action="" id="reset-password-form">
                    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                    <div class="form-group">
                        <input type="password" name="password" id="password" placeholder="New Password" class="form-control form-control-border" required>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-default bg-black btn-flat">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script>
  $(document).ready(function(){
    end_loader();
    $('#reset-password-form').submit(function(e){
        e.preventDefault();
        var _this = $(this);
        $(".pop-msg").remove();
        var el = $("<div>").addClass("alert pop-msg my-2").hide();
        start_loader();
        $.ajax({
            url: "classes/Users.php?f=reset_password",
            method: 'POST',
            data: _this.serialize(),
            dataType: 'json',
            error: err => {
                console.log(err);
                el.html("An error occurred while processing your request: " + err.responseText);
                el.addClass("alert-danger");
                _this.prepend(el);
                el.show('slow');
                end_loader();
            },
            success: function(resp) {
                if (resp.status == 'success') {
                    alert_toast("Password has been reset successfully.", 'success');
                    setTimeout(() => {
                        location.href = 'login.php';
                    }, 2000);
                } else if (resp.msg) {
                    el.text(resp.msg);
                    el.addClass("alert-danger");
                    _this.prepend(el);
                    el.show('show');
                } else {
                    el.text("An error occurred while processing your request");
                    el.addClass("alert-danger");
                    _this.prepend(el);
                    el.show('show');
                }
                end_loader();
                $('html, body').animate({scrollTop: 0}, 'fast');
            }
        })
    })
})
</script>
</body>
</html>
