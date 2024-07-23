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
<div class="h-100 d-flex align-items-center w-100" id="forgot-password">
    <div class="col-12 d-flex justify-content-center align-items-center">
        <div class="card card-outline card-primary rounded-0 shadow col-lg-4 col-md-6 col-sm-12">
            <div class="card-header">
                <h5 class="card-title text-center text-dark"><b>Forgot Password</b></h5>
            </div>
            <div class="card-body">
                <form action="" id="forgot-password-form">
                    <div class="form-group">
                        <input type="email" name="email" id="email" placeholder="Email" class="form-control form-control-border" required>
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
    $('#forgot-password-form').submit(function(e){
        e.preventDefault();
        console.log($('#email').val()); // Log the email value for debugging
        var _this = $(this);
        $(".pop-msg").remove();
        var el = $("<div>").addClass("alert pop-msg my-2").hide();
        start_loader();
        $.ajax({
            url: "classes/Users.php?f=forgot_password",
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
    console.log(resp); // Log the response for debugging
    if (resp.status === 'success') {
        alert_toast("Password reset link sent to your email.", 'success');
        _this[0].reset();
    } else {
        el.text(resp.msg || "An error occurred while processing your request");
        el.addClass("alert-danger");
        _this.prepend(el);
        el.show('slow');
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
