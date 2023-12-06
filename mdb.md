<div class="card">
  <img src="https://mdbcdn.b-cdn.net/img/new/standard/nature/184.webp" class="card-img-top" alt="Fissure in Sandstone"/>
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#!" class="btn btn-primary">Button</a>
  </div>
</div>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white">
  <!-- Container wrapper -->
  <div class="container-fluid">
    <!-- Toggle button -->
    <button
      class="navbar-toggler"
      type="button"
      data-mdb-toggle="collapse"
      data-mdb-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Navbar brand -->
      <a class="navbar-brand mt-2 mt-lg-0" href="#">
        <img
          src="https://mdbcdn.b-cdn.net/img/logo/mdb-transaprent-noshadows.webp"
          height="15"
          alt="MDB Logo"
          loading="lazy"
        />
      </a>
      <!-- Left links -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="#">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Team</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Projects</a>
        </li>
      </ul>
      <!-- Left links -->
    </div>
    <!-- Collapsible wrapper -->

    <!-- Right elements -->
    <div class="d-flex align-items-center">
      <!-- Icon -->
      <a class="link-secondary me-3" href="#">
        <i class="fas fa-shopping-cart"></i>
      </a>

      <!-- Notifications -->
      <div class="dropdown">
        <a
          class="link-secondary me-3 dropdown-toggle hidden-arrow"
          href="#"
          id="navbarDropdownMenuLink"
          role="button"
          data-mdb-toggle="dropdown"
          aria-expanded="false"
        >
          <i class="fas fa-bell"></i>
          <span class="badge rounded-pill badge-notification bg-danger">1</span>
        </a>
        <ul
          class="dropdown-menu dropdown-menu-end"
          aria-labelledby="navbarDropdownMenuLink"
        >
          <li>
            <a class="dropdown-item" href="#">Some news</a>
          </li>
          <li>
            <a class="dropdown-item" href="#">Another news</a>
          </li>
          <li>
            <a class="dropdown-item" href="#">Something else here</a>
          </li>
        </ul>
      </div>
      <!-- Avatar -->
      <div class="dropdown">
        <a
          class="dropdown-toggle d-flex align-items-center hidden-arrow"
          href="#"
          id="navbarDropdownMenuAvatar"
          role="button"
          data-mdb-toggle="dropdown"
          aria-expanded="false"
        >
          <img
            src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp"
            class="rounded-circle"
            height="25"
            alt="Black and White Portrait of a Man"
            loading="lazy"
          />
        </a>
        <ul
          class="dropdown-menu dropdown-menu-end"
          aria-labelledby="navbarDropdownMenuAvatar"
        >
          <li>
            <a class="dropdown-item" href="#">My profile</a>
          </li>
          <li>
            <a class="dropdown-item" href="#">Settings</a>
          </li>
          <li>
            <a class="dropdown-item" href="#">Logout</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Right elements -->
  </div>
  <!-- Container wrapper -->
</nav>
<!-- Navbar -->

<!-- SIDE NAV -->
<!-- Sidenav -->
<div id="sidenav-1" class="sidenav" role="navigation">
  <ul class="sidenav-menu">
    <li class="sidenav-item">
      <a class="sidenav-link">
        <i class="far fa-smile pe-3"></i><span>Link 1</span></a>
    </li>
    <li class="sidenav-item">
      <a class="sidenav-link"><i class="fas fa-grin pe-3"></i><span>Category 1</span></a>
      <ul class="sidenav-collapse show">
        <li class="sidenav-item">
          <a class="sidenav-link">Link 2</a>
        </li>
        <li class="sidenav-item">
          <a class="sidenav-link">Link 3</a>
        </li>
      </ul>
    </li>
    <li class="sidenav-item">
      <a class="sidenav-link"><i class="fas fa-grin-wink pe-3"></i><span>Category 2</span></a>
      <ul class="sidenav-collapse">
        <li class="sidenav-item">
          <a class="sidenav-link">Link 4</a>
        </li>
        <li class="sidenav-item">
          <a class="sidenav-link">Link 5</a>
        </li>
      </ul>
    </li>
  </ul>
</div>
<!-- Sidenav -->

<!-- Toggler -->
<button data-mdb-toggle="sidenav" data-mdb-target="#sidenav-1" class="btn btn-primary" aria-controls="#sidenav-1" aria-haspopup="true">
  <i class="fas fa-bars"></i>
</button>
<!-- Toggler -->

//Make sidenav instantly visible

const instance = mdb.Sidenav.getInstance(document.getElementById('sidenav-1'));
instance.show();

//form-grid
<div class="row">
  <div class="col">
    <!-- Name input -->
    <div class="form-outline">
      <input type="text" id="form8Example1" class="form-control" />
      <label class="form-label" for="form8Example1">Name</label>
    </div>
  </div>
  <div class="col">
    <!-- Email input -->
    <div class="form-outline">
      <input type="email" id="form8Example2" class="form-control" />
      <label class="form-label" for="form8Example2">Email address</label>
    </div>
  </div>
</div>

<hr />

<div class="row">
  <div class="col">
    <!-- Name input -->
    <div class="form-outline">
      <input type="text" id="form8Example3" class="form-control" />
      <label class="form-label" for="form8Example3">First name</label>
    </div>
  </div>
  <div class="col">
    <!-- Name input -->
    <div class="form-outline">
      <input type="text" id="form8Example4" class="form-control" />
      <label class="form-label" for="form8Example4">Last name</label>
    </div>
  </div>
  <div class="col">
    <!-- Email input -->
    <div class="form-outline">
      <input type="email" id="form8Example5" class="form-control" />
      <label class="form-label" for="form8Example5">Email address</label>
    </div>
  </div>
</div>

<!-- Default switch -->
<div class="form-check form-switch">
  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
  <label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label>
</div>

//
//


<form>
  <!-- Email input -->
  <div class="form-outline mb-4">
    <input type="email" id="form1Example1" class="form-control" />
    <label class="form-label" for="form1Example1">Email address</label>
  </div>

  <!-- Password input -->
  <div class="form-outline mb-4">
    <input type="password" id="form1Example2" class="form-control" />
    <label class="form-label" for="form1Example2">Password</label>
  </div>

  <!-- 2 column grid layout for inline styling -->
  <div class="row mb-4">
    <div class="col d-flex justify-content-center">
      <!-- Checkbox -->
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
        <label class="form-check-label" for="form1Example3"> Remember me </label>
      </div>
    </div>

    <div class="col">
      <!-- Simple link -->
      <a href="#!">Forgot password?</a>
    </div>
  </div>

  <!-- Submit button -->
  <button type="submit" class="btn btn-primary btn-block">Sign in</button>
</form>