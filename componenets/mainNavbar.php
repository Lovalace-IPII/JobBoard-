<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="index.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
        <img src="img/jobsConnect.svg" style="width:33px;" alt="">
        <h1 class="m-0 text-primary">JobBoard</h1>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="index.php" class="nav-item nav-link active">Home</a>
            <a href="index.php#category" class="nav-item nav-link">Category</a>
            <a href="index.php#about" class="nav-item nav-link">About</a>
            <a href="contact.php" class="nav-item nav-link">Contact</a>
        </div>
        <?php

        // if (session_status() == PHP_SESSION_NONE) {
        //     session_start();
        // }
        // if (isset($_SESSION['login_admin'])) {
        //     $myusername = $_SESSION['login_admin'];
        //     echo '<a href="adminAccount.php" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block">VIEW ACCOUNT<i class="fa fa-arrow-right ms-3"></i></a>';
        // } elseif (isset($_SESSION['login_user'])) {
        //     $myusername = $_SESSION['login_user'];
        //     echo '<a href="jobs.php" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block">VIEW JOBS<i class="fa fa-arrow-right ms-3"></i></a>';
        // } else {
        //     echo '<a href="jobs.php" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block">GO TO PORTAL<i class="fa fa-arrow-right ms-3"></i></a>';
        // }

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
          }
          if (isset($_SESSION['login_user']))   // Checking whether the session is already there or not if 
          // true then header redirect it to the home page directly 
          {
            $myusername = $_SESSION['login_user'];
            echo ' <li><a href="jobs.php">JOBS</a></li>
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">' . $myusername . '<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="seekerAccount.php">My Profile</a></li>
               <li><a href="AppliedJobs.php">Jobs Applied</a></li>
               <li><a href="logout.php">Logout</a></li>
         
            </ul>
          </li>';
          }
          if (isset($_SESSION['login_employer']))   // Checking whether the employer session is already there or not if 
          // true then header redirect it to the home page directly 
          {
            $myusername = $_SESSION['login_employer'];
            echo ' <li><a href="postjob.php">Post a job</a></li>
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">' . $myusername . '<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="employerAccount.php">My Account</a></li>
                <li><a href="ViewApplicants.php">View Applications</a></li>
              <li><a href="logout.php">Logout</a></li>
         
            </ul>
          </li>';
          } elseif (isset($_SESSION['login_admin']))   // Checking whether the admin session is already there or not if 
          // true then header redirect it to the home page directly 
          {
            $myusername = $_SESSION['login_admin'];
            echo ' <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">' . $myusername . '<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="adminAccount.php">My Account</a></li>
                <li><a href="ViewApplicantsAdmin.php">View All Applications</a></li>
              <li><a href="logout.php">Logout</a></li>
         
            </ul>
          </li>';
          } elseif (!isset($_SESSION['login_employer']) && !isset($_SESSION['login_user'])) {
  
            echo '<li class="list-unstyled pe-3">
            <a id="loginAnchor" href="./componenets/signinPage.php">SIGN IN</a>
          </li>';
    
          }
        ?>
    </div>
</nav>
<!-- Navbar End -->