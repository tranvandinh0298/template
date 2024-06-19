<script setup>
defineProps({
    status: Boolean
})
</script>


<template>
    <span v-if="status" class="badge badge-pill badge-success">Đã thanh toán</span>
    <span v-else class="badge badge-pill badge-danger">Chưa thanh toán</span>
</template>

<style>
.badge.badge-pill {
    border-radius: 24px;
    padding: 4px 15px;
}

.badge.badge-danger {
    background: var(--danger-label-color);
    color: var(--danger-color);
}

.badge.badge-success {
    background: var(--success-label-color);
    color: var(--success-color);
}

</style>
