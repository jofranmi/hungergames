<template>
    <div class="card">
        <div class="card-body mx-auto">
            <div class="container-fluid">
                <div class="row">
                    <div v-for="tribute in result.tributes.alive" class="col-sm">
                        <img :src="'/img/icon.jpg'" alt="..." class="img-thumbnail rounded-circle mx-auto d-block"
                             style="max-width: 100px">
                    </div>
                    <div v-for="tribute in result.tributes.dead" class="col-sm">
                        <img :src="'/img/icon.jpg'" alt="..." class="img-thumbnail rounded-circle mx-auto d-block"
                             style="max-width: 100px">
                    </div>
                </div>
                <div class="row">{{ result.description }}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        result: {type: Object}
    }
}
</script>

<style>
.customer-card:hover {
    background-color: #576068 !important;
    cursor: pointer;
}
</style>
