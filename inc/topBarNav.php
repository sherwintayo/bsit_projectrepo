<style>
  .user-img{
        position: absolute;
        height: 27px;
        width: 27px;
        object-fit: cover;
        left: -7%;
        top: -12%;
  }
  .btn-rounded{
        border-radius: 50px;
  }
  .notification-icon {
    position: relative;
    display: inline-block;
  }
  .notification-icon .badge {
        position: absolute;
    top: -10px;
    right: -10px;
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
  }
  .notification-dropdown {
    display: none;
    position: absolute;
    top: 60px; 
    right: 10%;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
    z-index: 1050;
    max-height: 300px;
    overflow-y: auto;
    min-width: 300px;
    max-width: 400px;
    max-height: 400px;
    margin-top: 40px;
  }
  .notification-dropdown .dropdown-item {
    padding: 10px;
    border-bottom: 1px solid #ddd;
  }
  .notification-dropdown .dropdown-item:last-child {
    border-bottom: none;
  }
  .notification-dropdown .dropdown-item.read {
    background-color: #f5f5f5;
  }
  .notification-dropdown .dropdown-item .mark-read {
    font-size: 12px;
    color: #007bff;
    cursor: pointer;
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
<nav class="bg-danger w-100 px-2 py-1 position-fixed top-0" id="login-nav">
  <div class="d-flex justify-content-between w-100">
    <div>
      <span class="mr-2 text-white"><i class="fa fa-phone mr-1"></i> <?= $_settings->info('contact') ?></span>
    </div>
    <div>
      <?php if ($_settings->userdata('id') > 0) : ?>
        <!-- Notification Icon -->
        <span class="notification-icon mx-2" id="notificationIcon">
          <a href="javascript:void(0)"><i class="fa fa-bell text-white"></i></a>
          <?php
          $user_id = $_settings->userdata('id');
          $notifications_query = $conn->query("SELECT COUNT(*) as unread_count FROM notifications WHERE student_id = $user_id AND status = 'unread'");
          $unread_notifications = $notifications_query->fetch_assoc()['unread_count'];
          ?>
          <?php if ($unread_notifications > 0) : ?>
            <span class="badge"><?= $unread_notifications ?></span>
          <?php endif; ?>
        </span>
        <!-- Notification Dropdown -->
        <div class="notification-dropdown" id="notificationDropdown">
          <?php
          // Fetch only unread notifications
          $notifications_query = $conn->query("SELECT * FROM notifications WHERE student_id = $user_id AND status = 'unread' ORDER BY date_created DESC");
          while ($notification = $notifications_query->fetch_assoc()) :
          ?>
            <div class="dropdown-item" data-id="<?= $notification['id'] ?>">
              <div><?= htmlspecialchars($notification['message']) ?></div>
              <div class="mark-read" data-id="<?= $notification['id'] ?>">Click to Mark as read</div>
            </div>
          <?php endwhile; ?>
        </div>
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
                    $programs = $conn->query("SELECT * FROM program_list where status = 1 order by name asc");
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
                    $curriculums = $conn->query("SELECT * FROM curriculum_list where status = 1 order by name asc");
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
              <!-- <li class="nav-item">
                <a href="#" class="nav-link">Contact</a>
              </li> -->
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
      <script>
  $(function(){
    $('#search-form').submit(function(e){
      e.preventDefault();
      location.href = './?page=projects&q='+$('#search-input').val();
    });
    $('#search_icon').click(function(){
      $('#search-field').toggleClass('show');
    });
    $('#search-field').mouseleave(function(){
        $('#search-field').removeClass('show');
    });
    $('#notificationIcon').click(function() {
      $('#notificationDropdown').toggle();
    });

    // Mark notification as read
    $('#notificationDropdown').on('click', '.mark-read', function (e) {
      e.preventDefault(); // Prevent the default action
      const notificationId = $(this).data('id');
      $.ajax({
        url: 'update_notification_status.php',
        method: 'POST',
        data: { id: notificationId, status: 'read' },
        success: function () {
          $(`#notificationDropdown .dropdown-item[data-id="${notificationId}"]`).remove();
          // Update badge count
          let badge = $('#notificationIcon .badge');
          let currentCount = parseInt(badge.text());
          if (currentCount > 1) {
            badge.text(currentCount - 1);
          } else {
            badge.remove(); // Remove badge if count is 0
          }
        },
        error: function (xhr, status, error) {
          console.error('Error marking notification as read:', error);
        }
      });
    });
  });
</script>