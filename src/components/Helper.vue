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

// https://stackoverflow.com/a/16233919
function intToIdr(idr: number) {
  const formatter = new Intl.NumberFormat("en-ID", {
    style: "currency",
    currency: "IDR",

    // These options are needed to round to whole numbers if that's what you want.
    //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
  });

  return formatter.format(idr);
}

export { isSession, login, intToIdr };
export default {};
</script>
