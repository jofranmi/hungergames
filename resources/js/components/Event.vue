<template>
  <div class="card customer-card bg-secondary text-light">
    <div class="card-body">
      <p class="card-text text-center"><i class="fas fa-asterisk"></i></p>
    </div>
  </div>
</template>

<script>
export default {
  data: {
    message: 'Hello Vue!'
  }
}
</script>

<style>
.customer-card:hover {
  background-color: #576068 !important;
  cursor: pointer;
}
</style>