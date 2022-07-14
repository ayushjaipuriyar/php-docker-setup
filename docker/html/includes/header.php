<style>
  ul {
    list-style: none;
  }
  header {
    height: 50vh;
  }
  .nav {
    padding: 0 4rem;
    background-color: #fff;
    /*   background-color: #1976d2; */
    width: 100%;
    height: 7rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02), 0 1px 7px rgba(0, 0, 0, 0.1);
  }
  .nav__brand {
    font-size: 2rem;
    margin-left: 2%;
  }
  .nav,
  .nav__content,
  .list {
    align-items: center;
    display: flex;
  }

  .list.list--inline {
    flex-direction: row;
  }

  .nav__content {
    margin-left: auto;
  }

  .list__item {
    padding: 1rem;
    /*   background-color: red; */
  }
  .list__item:not(:last-child) {
    margin-right: 2rem;
  }
  .list__link {
    text-decoration: none;
    color: grey;
    font-size: 1.7rem;
  }
  .logout{
    color: red;
  }
</style>
<header>
		<nav class="nav">
      <img src="assets/logo.png" height="48px" width="48px"/>
      <span class="nav__brand">
                Archivist
      </span>
			<div class="nav__content">
				<ul class="list list--inline">
        <?php if($_SESSION['login']){?>
					<li class="list__item">
            <a href="dashboard.php" class="list__link">
              Dashboard
            </a>
          </li>
				<?php }?>
					<li class="list__item"><a href="index.php" class="list__link">Login</a></li>
					<li class="list__item">
						<a href="adminlogin.php" class="list__link">Admin Login</a>
					</li>
					<li class="list__item">
						<a href="signup.php" class="list__link active">Sign Up</a>
					</li>
					<?php if($_SESSION['login']){?>
					<li class="list__item">
            <a href="logout.php" class="list__link logout">
              Log Out
            </a>
          </li>
				<?php }?>
				</ul>
			</div>
		</nav>
	</header>