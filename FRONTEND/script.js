document.getElementById("register-link").addEventListener("click", function () {
    document.getElementById("signin-screen").style.display = "none";
    document.getElementById("signup-screen").style.display = "block";
  });
  
  document.getElementById("signin-link").addEventListener("click", function () {
    document.getElementById("signup-screen").style.display = "none";
    document.getElementById("signin-screen").style.display = "block";
  });
  
  document.getElementById("signin-form").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent form reload
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
  
    fetch("login.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `email=${email}&password=${password}`,
    })
      .then((response) => response.text())
      .then((data) => {
        if (data === "success") {
          alert("Login successful!");
          window.location.href = "home.html"; // Redirect to Home Page
        } else {
          alert("Invalid email or password!");
        }
      })
      .catch((error) => console.error("Error:", error));
  });
  
  document.getElementById("signup-form").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent form reload
    const name = document.getElementById("name").value;
    const email = document.getElementById("signup-email").value;
    const password = document.getElementById("signup-password").value;
  
    fetch("signup.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `name=${name}&email=${email}&password=${password}`,
    })
      .then((response) => response.text())
      .then((data) => {
        if (data === "success") {
          alert("Sign-up successful! Please log in.");
          document.getElementById("signup-screen").style.display = "none";
          document.getElementById("signin-screen").style.display = "block";
        } else {
          alert("Sign-up failed. Try again.");
        }
      })
      .catch((error) => console.error("Error:", error));
  });
  