<template>
  <div class="card">
    <div class="card-body mx-auto">
      <i class="fas fa-user"></i> {{ message }} <i class="fas fa-user"></i>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      message: 'killed ->'
    };
  },
}
</script>

<style>
.customer-card:hover {
  background-color: #576068 !important;
  cursor: pointer;
}
</style>