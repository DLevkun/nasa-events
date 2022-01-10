<template>
    <div>
        <h1 class="text-center mb-5 fw-bolder">
            <img class="nasa-img" src="img/NASA_logo.svg" width="50">
            EONET: The Earth Observatory Natural Event Tracker
        </h1>
        <Table></Table>
    </div>
</template>

<script>
import Table from "./Table";
export default {
  name: "AppNasa",
  components: {
      Table,
  }
}
</script>

<style scoped>
    .nasa-img{
        position: relative;
        bottom: 4px;
    }
</style>
