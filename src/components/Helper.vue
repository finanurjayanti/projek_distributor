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

export { isSession };
</script>
