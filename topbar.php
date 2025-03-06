<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-primary navbar-dark ">
    <div class="container">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li>
        <a class="nav-link text-white"  href="./" role="button"> <large><b><?php echo $_SESSION['system']['name'] ?></b></large></a>
      </li>
      <li class="nav-item">
            <a href="./" class="nav-link">Home</a>
        </li>
      <?php 
        $categories = $conn->query("SELECT * FROM categories order by order_by asc");
        $cats = array();
        while($row=$categories->fetch_assoc()){
          $cats[$row['parent_id']][]= $row;
        }
      ?>
      <?php if(count($cats) > 0 ): ?>
              <?php foreach($cats[0] as $k => $row): ?>
               <li class="nav-item position-relative <?php echo isset($cats[$row['id']]) ? 'dropdown-hover' : ''  ?>">
                  <a href="./<?php echo $row['link'] ?>" <?php echo isset($cats[$row['id']]) ? 'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle "' : ' class="nav-link"' ?>><?php echo $row['category'] ?></a>
                  <?php if(isset($cats[$row['id']])): ?>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left: 0px; right: inherit;">
                      <?php foreach($cats[$row['id']] as $k => $rrow): ?>
                       <li><a href="./<?php echo $rrow['link'] ?>" class="dropdown-item"><?php echo $rrow['category'] ?></a></li>
                      <?php endforeach; ?>
                  </ul>
                  <?php endif; ?>
               </li>
        <?php endforeach; ?>
        <?php endif; ?>
        <li class="nav-item">
            <a href="./index.php?page=about" class="nav-link">About Us</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
       <?php if(!isset($_SESSION['login_id'])): ?>
          <li class="nav-item">
            <a class="nav-link nav-login" href="login.php" id="login">
              <b>Signin</b>
            </a>
          </li>
        <?php else: ?>
     <li class="nav-item dropdown">
            <a class="nav-link"  data-toggle="dropdown" aria-expanded="true" href="javascript:void(0)">
              <span>
                <div class="d-felx badge-pill">
                  <span class=""><img src="assets/uploads/<?php echo $_SESSION['login_avatar'] ?>" alt="" class="user-img border "></span>
                  <span><b><?php echo ucwords($_SESSION['login_firstname']) ?></b></span>
                  <span class="fa fa-angle-down ml-2"></span>
                </div>
              </span>
            </a>
            <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
              <a class="dropdown-item" href="javascript:void(0)" id="manage_account"><i class="fa fa-cog"></i> Manage Account</a>
              <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i> Logout</a>
            </div>
      </li>
<?php endif; ?>
    </ul>
    </div>
  </nav>
  <!-- /.navbar -->
  <script>
     $('#manage_account').click(function(){
        uni_modal('Manage Account','manage_user.php?id=<?php echo isset($_SESSION['login_id']) ? $_SESSION['login_id'] : '' ?>')
      })
  </script>
  <style>
    .user-img {
        border-radius: 50%;
        height: 25px;
        width: 25px;
        object-fit: cover;
    }
  </style>
