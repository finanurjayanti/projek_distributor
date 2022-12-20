<script lang="ts">
import axios from "axios";

async function isSession(sessionid: string) {
  const res = await axios.post(
    "http://localhost/api/session.php",
    `sessionid=${sessionid}`,
    {
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
    }
  );

  return res.data == 0 ? false : true;
}

async function login(username: string, password: string) {
  const res = await axios.post(
    "http://localhost/api/login.php",
    `username=${encodeURIComponent(username)}&password=${encodeURIComponent(
      password
    )}`,
    {
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
    }
  );

  return res.data == 0 ? false : res.data;
}

export { isSession, login };
export default {};
</script>
