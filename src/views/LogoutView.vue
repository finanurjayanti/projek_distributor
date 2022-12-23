<script lang="ts">
export default {
  created() {
    this.$cookies.remove("sessionid");
    location.href = "/";
  },
};
</script>
