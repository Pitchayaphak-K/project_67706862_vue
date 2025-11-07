<template>
<nav class="navbar navbar-expand-lg" style="background-color: #e3f2fd;">
  <div class="container">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
         <!-- แสดงเฉพาะเมื่อเข้าสู่ระบบแล้ว -->
          <template v-if="isLoggedIn">  
        <li class="nav-item">
          <a class="nav-link" href="/showproduct">Show Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/product">Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/student">Student</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="/customer" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Customer
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/customer">Customer</a></li>
            <li><a class="dropdown-item" href="/customer_edit">Customer edit</a></li>
          </ul>
        </li>
          <li class="nav-item">
          <a class="nav-link" href="#" @click="logout">Logout</a>
        </li>
        </template>

 <!--ยังไม่ได้ ้ Login เข้าสู้่ระบบ-->
 <template v-else> 
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
         <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Login
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/login_customer">Login</a></li>
            <li><a class="dropdown-item" href="#" @click="logout">Logout</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/add_customer">Register</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/about">About</a>
        </li>
          <li class="nav-item">
          <a class="nav-link" href="/add_customer">Customer</a>
        </li>
           <li class="nav-item">
          <a class="nav-link" href="/employee">Employee</a>
        </li>
  </template>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

  <router-view/>

</template>

<script>
export default {
  name: "Navbar",
  data() {
    return {
      isLoggedIn: false,
    };
  },
  mounted() {
    // ตรวจสอบสถานะเมื่อโหลดหน้า
    this.checkLogin();
  },
  methods: {
    checkLogin() {
      this.isLoggedIn = localStorage.getItem("customerLogin") === "true";
    },
    logout() {
      if (confirm("ต้องการออกจากระบบหรือไม่?")) {
        // เคลียร์ข้อมูลทั้งหมดที่เกี่ยวข้องกับการล็อกอิน
        localStorage.removeItem("customerLogin");
        localStorage.removeItem("username");
        localStorage.removeItem("token");
        this.isLoggedIn = false;

        // กลับไปหน้าเมนูหลัก
        this.$router.push("/");
      }
    },
  },
  watch: {
    // เมื่อเปลี่ยนเส้นทาง ให้ตรวจสอบสถานะการล็อกอินใหม่
    $route() {
      this.checkLogin();
    },
  },
};
</script>


<style scoped>
.navbar {
  background-color: #86bfe7ff !important;
}
.nav-link {
  color: white !important;
  font-weight: 500;
}
.nav-link:hover {
  text-decoration: underline;
}
</style>