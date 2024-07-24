<?php
require_once('config.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['count' => 0, 'notifications' => []]);
    exit;
}

$user_id = $_SESSION['user_id'];

$master = new Master();
$notifications = $master->get_notifications($user_id);
$unread_count = array_filter($notifications, function($n) {
    return $n['status'] === 'unread';
});

header('Content-Type: application/json');
echo json_encode([
    'count' => count($unread_count),
    'notifications' => $notifications
]);
?>

<style>
  .user-img {
    position: absolute;
    height: 27px;
    width: 27px;
    object-fit: cover;
    left: -7%;
    top: -12%;
  }
  .btn-rounded {
    border-radius: 50px;
  }
  .notification-icon {
    font-size: 1.2em;
    color: white;
    margin-right: 10px;
    position: relative;
    cursor: pointer;
  }
  .notification-count {
    position: absolute;
    top: -10px;
    right: -10px;
    background-color: red;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8em;
  }
  .notification-dropdown {
    display: none;
    position: absolute;
    right: 0;
    top: 100%;
    background-color: white;
    border: 1px solid #ddd;
    box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
    z-index: 1000;
    width: 300px;
  }
  .notification-dropdown .dropdown-item {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    color: #333;
    text-decoration: none;
    display: block;
  }
  .notification-dropdown .dropdown-item:last-child {
    border-bottom: none;
  }
  .notification-dropdown .dropdown-item:hover {
    background-color: #f1f1f1;
  }
  .notification-dropdown.show {
    display: block;
  }
</style>
<!-- Navbar -->
      <style>
        #login-nav{
          position:fixed !important;
          top: 0 !important;
          z-index: 1037;
          padding: 1em 1.5em !important;
        }
        #top-Nav{
          top: 4em;
        }
        .text-sm .layout-navbar-fixed .wrapper .main-header ~ .content-wrapper, .layout-navbar-fixed .wrapper .main-header.text-sm ~ .content-wrapper {
          margin-top: calc(3.6) !important;
          padding-top: calc(5em) !important;
      }
      </style>
   <nav class="bg-navy w-100 px-2 py-1 position-fixed top-0" id="login-nav">
  <div class="d-flex justify-content-between w-100">
    <div>
      <span class="mr-2 text-white"><i class="fa fa-phone mr-1"></i> <?= $_settings->info('contact') ?></span>
    </div>
    <div>
      <?php if($_settings->userdata('id') > 0): ?>
        <span class="mx-2">
          <!-- Notification Icon -->
          <span class="notification-icon" id="notification-icon">
            <i class="fa fa-bell"></i>
            <span class="notification-count" id="notification-count">0</span> <!-- Dynamic number -->
        </span>
          <!-- Dropdown Menu -->
          <div class="notification-dropdown" id="notification-dropdown">
            <?php if ($notification_count > 0): ?>
              <?php foreach ($notifications as $notification): ?>
                <a href="<?= base_url ?>notifications.php?id=<?= $notification['id'] ?>" class="dropdown-item">
                  <?= htmlspecialchars($notification['message']) ?>
                </a>
              <?php endforeach; ?>
            <?php else: ?>
              <a href="#" class="dropdown-item">No new notifications</a>
            <?php endif; ?>
          </div>
        </span>
        <span class="mx-2"><img src="<?= validate_image($_settings->userdata('avatar')) ?>" alt="User Avatar" id="student-img-avatar"></span>
        <span class="mx-2">Howdy, <?= !empty($_settings->userdata('email')) ? $_settings->userdata('email') : $_settings->userdata('username') ?></span>
        <span class="mx-1"><a href="<?= base_url.'classes/Login.php?f=student_logout' ?>"><i class="fa fa-power-off"></i></a></span>
      <?php else: ?>
        <a href="./register.php" class="mx-2 text-light me-2">Register</a>
        <a href="./login.php" class="mx-2 text-light me-2">Student Login</a>
        <a href="./admin" class="mx-2 text-light">Admin login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<nav class="main-header navbar navbar-expand navbar-light border-0 navbar-light text-sm" id='top-Nav'>
  <div class="container">
    <a href="./" class="navbar-brand">
      <img src="<?php echo validate_image($_settings->info('logo'))?>" alt="Site Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span><?= $_settings->info('short_name') ?></span>
    </a>
    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="./" class="nav-link <?= isset($page) && $page =='home' ? "active" : "" ?>">Home</a>
        </li>
        <li class="nav-item">
          <a href="./?page=projects" class="nav-link <?= isset($page) && $page =='projects' ? "active" : "" ?>">Projects</a>
        </li>
        <li class="nav-item dropdown">
          <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle  <?= isset($page) && $page =='projects_per_program' ? "active" : "" ?>">Program</a>
          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left: 0px; right: inherit;">
            <?php 
              $programs = $conn->query("SELECT * FROM program_list where status = 1 order by `name` asc");
              $dI =  $programs->num_rows;
              while($row = $programs->fetch_assoc()):
                $dI--;
            ?>
            <li>
              <a href="./?page=projects_per_program&id=<?= $row['id'] ?>" class="dropdown-item"><?= ucwords($row['name']) ?></a>
              <?php if($dI != 0): ?>
              <li class="dropdown-divider"></li>
              <?php endif; ?>
            </li>
            <?php endwhile; ?>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle  <?= isset($page) && $page =='projects_per_curriculum' ? "active" : "" ?>">Curriculum</a>
          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left: 0px; right: inherit;">
            <?php 
              $curriculums = $conn->query("SELECT * FROM curriculum_list where status = 1 order by `name` asc");
              $cI =  $curriculums->num_rows;
              while($row = $curriculums->fetch_assoc()):
                $cI--;
            ?>
            <li>
              <a href="./?page=projects_per_curriculum&id=<?= $row['id'] ?>" class="dropdown-item"><?= ucwords($row['name']) ?></a>
              <?php if($cI != 0): ?>
              <li class="dropdown-divider"></li>
              <?php endif; ?>
            </li>
            <?php endwhile; ?>
          </ul>
        </li>
        <li class="nav-item">
          <a href="./?page=about" class="nav-link <?= isset($page) && $page =='about' ? "active" : "" ?>">About Us</a>
        </li>
        <?php if($_settings->userdata('id') > 0): ?>
        <li class="nav-item">
          <a href="./?page=profile" class="nav-link <?= isset($page) && $page =='profile' ? "active" : "" ?>">Profile</a>
        </li>
        <li class="nav-item">
          <a href="./?page=submit-archive" class="nav-link <?= isset($page) && $page =='submit-archive' ? "active" : "" ?>">Submit Thesis/Capstone</a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
    <!-- Right navbar links -->
    <div class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
      <a href="javascript:void(0)" class="text-navy" id="search_icon"><i class="fa fa-search"></i></a>
      <div class="position-relative">
        <div id="search-field" class="position-absolute">
          <input type="search" id="search-input" class="form-control rounded-0" required placeholder="Search..." value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
        </div>
      </div>
    </div>
  </div>
</nav>
<!-- /.navbar -->
      <!-- /.navbar -->
      <script>
  $(function(){
    $('#search-form').submit(function(e){
      e.preventDefault()
      if($('[name="q"]').val().length == 0)
        location.href = './';
      else
        location.href = './?'+$(this).serialize();
    })
    $('#search_icon').click(function(){
      $('#search-field').addClass('show')
      $('#search-input').focus();
    })
    $('#search-input').focusout(function(e){
      $('#search-field').removeClass('show')
    })
    $('#search-input').keydown(function(e){
      if(e.which == 13){
        location.href = "./?page=projects&q="+encodeURI($(this).val());
      }
    })
    
    // Fetch notifications
    function loadNotifications() {
        $.ajax({
            url: 'fetch_notifications.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                let notificationsHtml = '';
                $('#notification-count').text(data.count);

                data.notifications.forEach(notification => {
                    notificationsHtml += `<a href="#" class="dropdown-item">${notification.message}</a>`;
                });

                $('#notification-dropdown').html(notificationsHtml);
            }
        });
    }

    // Initial load
    loadNotifications();

    // Reload notifications every minute
    setInterval(loadNotifications, 60000);

    // Toggle notification dropdown
    $('#notification-icon').click(function() {
        $('#notification-dropdown').toggleClass('show');
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('#notification-icon, #notification-dropdown').length) {
            $('#notification-dropdown').removeClass('show');
        }
    });
});
</script>