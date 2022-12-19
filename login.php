<html>
  <head>
    <title>distribusi ikan hasil laut</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script defer>
      function kirim_data() {
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;
        $.post(
          "api/login.php",
          {
            username,
            password,
          },
          (data) => {
            if (data == 0) {
              alert("Username/Password salah!");
            } else {
              document.location.href = "home.php";
            }
          }
        );
      }
    </script>
  </head>
  <body>
    <h1>distribusi ikan hasil laut</h1>
    <h3>Halaman Form Login</h3>
    <form>
      <table>
        <tr>
          <td>Username</td>
          <td><input type="text" name="username" id="username" /></td>
        </tr>
        <tr>
          <td>Password</td>
          <td><input type="password" name="password" id="password" /></td>
        </tr>
        <tr>
          <td></td>
          <td>
            <input
              type="button"
              name="login"
              value="Log In"
              onclick="kirim_data()"
            />
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
